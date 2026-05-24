<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Fields;
use PHPUnit\Framework\Attributes\Test;

class ReservationValidationTest extends TestCase
{
    use RefreshDatabase;

    protected $field;

    protected function setUp(): void
    {
        parent::setUp();
        // Setup data lapangan agar tidak perlu diulang-ulang di setiap test
        $this->field = Fields::create([
            'nama_lapangan' => 'Lapangan Test',
            'tipe_lapangan' => 'Sintetis',
            'ukuran_lapangan' => 'Sedang',
            'harga_per_jam' => 50000,
        ]);
    }

    #[Test]
    public function test_booking_validation_rules()
    {
        $this->withoutMiddleware();

        // 1. Tes semua kosong
        $response = $this->post('/customer/booking/store', []);
        $response->assertSessionHasErrors(['field_id', 'tanggal_main', 'jam_mulai', 'jam_selesai', 'metode_bayar']);

        // 2. Tes tanggal masa lalu
        $response = $this->post('/customer/booking/store', [
            'field_id' => $this->field->id,
            'tanggal_main' => now()->subDay()->format('Y-m-d'),
            'jam_mulai' => '10:00',
            'jam_selesai' => '12:00',
            'metode_bayar' => 'Cash'
        ]);
        $response->assertSessionHasErrors(['tanggal_main']);

        // 3. Tes jam selesai sebelum jam mulai
        $response = $this->post('/customer/booking/store', [
            'field_id' => $this->field->id,
            'tanggal_main' => now()->format('Y-m-d'),
            'jam_mulai' => '14:00',
            'jam_selesai' => '13:00',
            'metode_bayar' => 'Cash'
        ]);

        $response->assertSessionHas('error', 'Jam selesai harus lebih besar dari jam mulai.');

        // 4. Tes metode bayar tidak valid
        $response = $this->post('/customer/booking/store', [
            'field_id' => $this->field->id,
            'tanggal_main' => now()->format('Y-m-d'),
            'jam_mulai' => '10:00',
            'jam_selesai' => '12:00',
            'metode_bayar' => 'Crypto'
        ]);
        $response->assertSessionHasErrors(['metode_bayar']);

        // 5. Tes bukti transfer wajib diisi jika metode bayar adalah Transfer
        $response = $this->post('/customer/booking/store', [
            'field_id' => $this->field->id,
            'tanggal_main' => now()->format('Y-m-d'),
            'jam_mulai' => '10:00',
            'jam_selesai' => '12:00',
            'metode_bayar' => 'Transfer'
        ]);
        $response->assertSessionHasErrors(['bukti_transfer']);
    }
}

<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

// Simulasi Model Lapangan & Penyimpanan Fake di Memory RAM
class ReservasiModel {
    public $namaPemesan;
    public $tanggal;
}

class FakeReservasiRepository {
    protected $databaseTiruan = [];

    public function simpanKeDatabaseFake($nama, $tanggal) {
        $reservasi = new ReservasiModel();
        $reservasi->namaPemesan = $nama;
        $reservasi->tanggal = $tanggal;

        // Data hanya disimpan ke dalam array RAM, tidak menembus MySQL asli
        $this->databaseTiruan[] = $reservasi;
        return true;
    }

    public function hitungTotalDataDiFake() {
        return count($this->databaseTiruan);
    }
}

class SimpanReservasiTest extends TestCase
{
    public function test_sistem_berhasil_menyimpan_data_reservasi_ke_penyimpanan_fake()
    {
        // 1. Siapkan Fake Repository
        $fakeRepository = new FakeReservasiRepository();

        // 2. Jalankan fungsi simpan data
        $suksesSimpan = $fakeRepository->simpanKeDatabaseFake('Anggota Empat', '2026-05-30');

        // 3. Pembuktian 1: Harus mengembalikan nilai TRUE (berhasil)
        $this->assertTrue($suksesSimpan);

        // 4. Pembuktian 2: Pastikan jumlah data di dalam penyimpanan fake bertambah menjadi 1
        $totalData = $fakeRepository->hitungTotalDataDiFake();
        $this->assertEquals(1, $totalData);
    }
}

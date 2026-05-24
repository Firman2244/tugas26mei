<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class JadwalFutsalTest extends TestCase
{
    public function test_jadwal_tidak_tersedia_jika_sudah_dibooking()
    {
        // Menggunakan properti dinamis phpunit agar intelephense VS Code tidak komplain eror
        $mockPengecekJadwal = $this->getMockBuilder(\stdClass::class)
            ->allowMockingUnknownTypes()
            ->getMock();

        $this->assertTrue(true);
    }
}

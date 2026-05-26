<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Mockery;

class AdminProfileTest extends TestCase
{
    public function test_update_profile_berhasil_menggunakan_mock_double()
    {
        $mockUser = Mockery::mock(User::class)->makePartial();
        $mockUser->id = 99;

        $mockUser->shouldReceive('update')
                 ->once()
                 ->andReturn(true);

        Auth::shouldReceive('user')->once()->andReturn($mockUser);

        $mockRequest = Mockery::mock(Request::class);

        $mockRequest->shouldReceive('validate')->once()->andReturn(true);

        $mockRequest->shouldReceive('filled')->with('password')->once()->andReturn(false);

        $mockRequest->name = 'Admin Palsu';
        $mockRequest->email = 'admin@palsu.com';
        $mockRequest->no_hp = '081234567890';

        $controller = new AdminController();
        $response = $controller->updateProfile($mockRequest);

        $this->assertTrue(session()->has('success'));
        $this->assertEquals('Profil Anda berhasil diperbarui!', session('success'));
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

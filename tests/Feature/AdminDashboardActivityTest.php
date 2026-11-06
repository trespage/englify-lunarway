<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AdminDashboardActivityTest extends TestCase
{
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::where('id_role', 2)->first() ?? User::where('id_role', 1)->first();
    }

    public function test_dashboard_admin_menampilkan_aktivitas_bulan_ini_tanpa_target(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response->assertOk();

        // Judul card baru
        $response->assertSee('Aktivitas Bulan Ini');
        $response->assertSee('Ringkasan aktivitas materi, kuis, dan interaksi pembelajaran siswa');

        // Label aktivitas riil
        $response->assertSee('Upload Materi Baru');
        $response->assertSee('Buat Quiz Baru');
        $response->assertSee('Siswa Aktif Belajar');
        $response->assertSee('Rata-rata Nilai Kelas');

        // Pastikan tidak ada teks target buatan lama
        $response->assertDontSee('Target Bulan Ini');
        $response->assertDontSee('Target tercapai');
        $response->assertDontSee('% tercapai');
    }
}

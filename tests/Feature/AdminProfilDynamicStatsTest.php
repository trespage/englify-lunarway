<?php

namespace Tests\Feature;

use App\Models\Bab;
use App\Models\Kategori;
use App\Models\Materi;
use App\Models\Quiz;
use App\Models\User;
use Tests\TestCase;

class AdminProfilDynamicStatsTest extends TestCase
{
    public function test_admin_profil_renders_dynamic_curriculum_stats(): void
    {
        $admin = User::where('id_role', 2)->first() ?? User::factory()->create(['id_role' => 2]);
        $kategori = Kategori::first() ?? Kategori::create(['nama_kategori' => 'Speaking', 'deskripsi' => 'Test']);

        // Case 1: General admin without specific division
        $admin->forceFill(['id_kategori' => null])->saveQuietly();
        $response = $this->actingAs($admin)->get(route('admin.profil'));
        $response->assertOk();
        $response->assertSee('Statistik Kurikulum');
        $response->assertSee('Platform Englify');
        $response->assertSee('Total Siswa Terdaftar');

        // Case 2: Division admin assigned to specific division
        $admin->forceFill(['id_kategori' => $kategori->id_kategori])->saveQuietly();
        $resDivisi = $this->actingAs($admin)->get(route('admin.profil'));
        $resDivisi->assertOk();
        $resDivisi->assertSee('Divisi ' . $kategori->nama_kategori);
        $resDivisi->assertSee('Total Bab Kurikulum');
        $resDivisi->assertSee('Total Materi Pelajaran');
    }
}


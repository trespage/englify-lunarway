<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Bab;
use App\Models\Materi;
use App\Models\Quiz;
use App\Models\HasilQuiz;
use App\Models\ProgressMateri;
use App\Models\PesanAdmin;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SiswaDashboardEssentialTest extends TestCase
{
    public function test_siswa_dashboard_displays_essential_sections_only()
    {
        $siswa = User::where('id_role', 3)->first();
        if (!$siswa) {
            $siswa = User::factory()->create(['id_role' => 3, 'nama' => 'Student Test', 'email' => 'studenttest@englify.com']);
        }

        $kategori = Kategori::first() ?? Kategori::create(['nama_kategori' => 'Speaking', 'deskripsi' => 'Speaking']);
        $bab = Bab::where('id_kategori', $kategori->id_kategori)->first();
        if (!$bab) {
            $bab = Bab::create(['judul' => 'Bab Essential Test', 'id_kategori' => $kategori->id_kategori, 'urutan' => 1, 'is_active' => true]);
        }

        $admin = User::where('id_role', 2)->first() ?? User::factory()->create(['id_role' => 2]);
        $materi = Materi::where('id_bab', $bab->id)->first();
        if (!$materi) {
            $materi = Materi::create([
                'id_admin' => $admin->id_user,
                'id_bab' => $bab->id,
                'id_kategori' => $kategori->id_kategori,
                'bab' => $bab->judul,
                'judul' => 'Essential Materi Test',
                'isi_materi' => 'Konten materi test',
                'urutan' => 1,
                'status' => 'Published',
            ]);
        }

        $response = $this->actingAs($siswa)->get(route('siswa.dashboard'));

        $response->assertStatus(200);
        // Memastikan header sapaan esensial ada
        $response->assertSee('Halo,');
        $response->assertSee($siswa->nama);

        // Memastikan 4 kartu statistik esensial ada
        $response->assertSee('Materi Selesai');
        $response->assertSee('Quiz Selesai');
        $response->assertSee('Rata-rata Nilai');
        $response->assertSee('Total Poin');

        // Memastikan bagian Lanjutkan Belajar / Rekomendasi ada
        $response->assertSee('Rekomendasi Belajar');
        $response->assertSee('Lanjutkan Membaca');

        // Memastikan bagian Progres Pembelajaran per Kategori ada
        $response->assertSee('Progres Pembelajaran per Kategori');

        // Memastikan Riwayat Quiz Terakhir dan Reminder Admin ada
        $response->assertSee('Riwayat Pengerjaan Quiz Terakhir');
        $response->assertSee('Reminder Admin');

        // Memastikan TIDAK ADA duplikasi "Daftar Quiz per Bab" bubble chain yang berat
        $response->assertDontSee('Daftar Quiz per Bab');
    }
}


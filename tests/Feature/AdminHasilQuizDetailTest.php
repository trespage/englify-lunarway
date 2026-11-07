<?php

namespace Tests\Feature;

use App\Models\HasilQuiz;
use App\Models\JawabanUser;
use App\Models\Quiz;
use App\Models\User;
use Tests\TestCase;

class AdminHasilQuizDetailTest extends TestCase
{
    protected User $admin;
    protected User $siswa;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::where('id_role', 2)->first() ?? User::where('id_role', 1)->first();
        $this->siswa = User::where('id_role', 3)->first();
    }

    public function test_halaman_hasil_quiz_menampilkan_kolom_sesuai_urutan(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.hasil-quiz'));
        $response->assertOk();

        // Cek header tabel baru
        $response->assertSee('Siswa');
        $response->assertSee('Kategori');
        $response->assertSee('Bab');
        $response->assertSee('Materi Ke-');
        $response->assertSee('Skor');
        $response->assertSee('Waktu');
        $response->assertSee('Aksi');
    }

    public function test_detail_hasil_quiz_menampilkan_detail_materi_dan_quiz(): void
    {
        $hasil = HasilQuiz::first();
        if (!$hasil) {
            $this->markTestSkipped('Belum ada data HasilQuiz.');
        }

        $response = $this->actingAs($this->admin)->get(route('admin.hasil-quiz.detail', $hasil->id_hasil));
        $response->assertOk();

        $response->assertSee('Detail Hasil Quiz');
        $response->assertSee('Informasi Siswa');
        $response->assertSee('Kurikulum & Materi');
        $response->assertSee('Detail Materi Pembelajaran');
        $response->assertSee('Rincian Jawaban Soal Quiz');
    }
}

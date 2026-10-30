<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PerformanceAndUsabilityS307Test extends TestCase
{
    /**
     * Uji 1: Verifikasi bahwa Indeks Basis Data (S3-07) terpasang di tabel-tabel utama
     */
    public function test_database_indexes_exist(): void
    {
        $materiIndexes = collect(DB::select("SHOW INDEX FROM `materi`"))->pluck('Key_name')->all();
        $this->assertContains('idx_materi_status', $materiIndexes);
        $this->assertContains('idx_materi_bab_status', $materiIndexes);
        $this->assertContains('idx_materi_kategori_status', $materiIndexes);

        $progressIndexes = collect(DB::select("SHOW INDEX FROM `progress_materi`"))->pluck('Key_name')->all();
        $this->assertContains('idx_progress_status', $progressIndexes);
        $this->assertContains('idx_progress_user_status', $progressIndexes);

        $quizIndexes = collect(DB::select("SHOW INDEX FROM `quiz`"))->pluck('Key_name')->all();
        $this->assertContains('idx_quiz_status', $quizIndexes);
        $this->assertContains('idx_quiz_bab_status', $quizIndexes);

        $hasilIndexes = collect(DB::select("SHOW INDEX FROM `hasil_quiz`"))->pluck('Key_name')->all();
        $this->assertContains('idx_hasil_user_quiz', $hasilIndexes);
        $this->assertContains('idx_hasil_created_at', $hasilIndexes);

        $jawabanIndexes = collect(DB::select("SHOW INDEX FROM `jawaban_user`"))->pluck('Key_name')->all();
        $this->assertContains('idx_jawaban_hasil_benar', $jawabanIndexes);

        $usersIndexes = collect(DB::select("SHOW INDEX FROM `users`"))->pluck('Key_name')->all();
        $this->assertContains('idx_users_status', $usersIndexes);
        $this->assertContains('idx_users_role_status', $usersIndexes);
    }

    /**
     * Uji 2: Verifikasi Navigasi Rekam Jejak (Breadcrumbs) muncul di halaman publik & admin
     */
    public function test_breadcrumbs_rendered_on_pages(): void
    {
        // 2a. Halaman publik (Login)
        $responseLogin = $this->get('/login');
        $responseLogin->assertStatus(200);
        $responseLogin->assertSee('aria-label="Breadcrumb"', false);
        $responseLogin->assertSee('Beranda Publik');
        $responseLogin->assertSee('Masuk Akun');

        // 2b. Halaman Admin (Materi & Quiz)
        $admin = User::whereHas('role', fn($q) => $q->where('nama_role', 'admin'))->first();
        if ($admin) {
            $responseAdmin = $this->actingAs($admin)->get(route('admin.materi'));
            $responseAdmin->assertStatus(200);
            $responseAdmin->assertSee('aria-label="Breadcrumb"', false);
            $responseAdmin->assertSee('Dashboard');
            $responseAdmin->assertSee('Manajemen Materi');
        }

        // 2c. Halaman Siswa (Modul Belajar)
        $siswa = User::whereHas('role', fn($q) => $q->where('nama_role', 'siswa'))->first();
        if ($siswa) {
            $responseSiswa = $this->actingAs($siswa)->get(route('siswa.materi'));
            $responseSiswa->assertStatus(200);
            $responseSiswa->assertSee('aria-label="Breadcrumb"', false);
            $responseSiswa->assertSee('Beranda');
            $responseSiswa->assertSee('Modul Belajar');
        }
    }

    /**
     * Uji 3: Verifikasi Script Anti-Spam Click (Memproses... spinner) terpasang di layout
     */
    public function test_anti_spam_double_submit_script_present(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('GLOBAL FORM ANTI-SPAM CLICK & "MEMPROSES..." BUTTON SPINNER', false);
        $response->assertSee('Memproses...');
        $response->assertSee('animate-spin');
    }
}

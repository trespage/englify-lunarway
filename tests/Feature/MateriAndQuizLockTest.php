<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Bab;
use App\Models\Materi;
use App\Models\Quiz;
use App\Models\HasilQuiz;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MateriAndQuizLockTest extends TestCase
{
    /**
     * Memastikan halaman materi terkunci dan menyembunyikan navbar serta tombol keluar
     */
    public function test_halaman_materi_terkunci_dan_sembunyikan_navbar_dan_tombol_keluar()
    {
        session()->flush();
        $siswa = User::where('id_role', 3)->first();
        if (!$siswa) {
            $siswa = User::factory()->create(['id_role' => 3]);
        }

        $kategori = Kategori::firstOrCreate(['nama_kategori' => 'Listening']);
        $bab = Bab::create([
            'judul'       => 'Bab Lock Test ' . uniqid(),
            'id_kategori' => $kategori->id_kategori,
            'urutan'      => 99,
            'is_active'   => true
        ]);

        $admin = User::where('id_role', 2)->first() ?? User::factory()->create(['id_role' => 2]);

        $materi = Materi::create([
            'id_admin'    => $admin->id_user,
            'id_bab'      => $bab->id,
            'id_kategori' => $kategori->id_kategori,
            'bab'         => $bab->judul,
            'isi_materi'  => 'Konten materi test.',
            'judul'       => 'Materi Lock Test ' . uniqid(),
            'urutan'      => 1,
            'status'      => 'Published',
        ]);

        $quiz = Quiz::create([
            'id_materi'      => $materi->id_materi,
            'id_bab'         => $bab->id_bab,
            'pertanyaan'     => 'Soal test lock?',
            'pilihan_a'      => 'A',
            'pilihan_b'      => 'B',
            'pilihan_c'      => 'C',
            'pilihan_d'      => 'D',
            'kunci_jawaban'  => 'A',
            'poin'           => 10,
            'status'         => 'Aktif',
            'urutan'         => 1,
        ]);

        // 1. Buka halaman materi
        $response = $this->actingAs($siswa)->get(route('siswa.materi.baca', $materi->id_materi));
        $response->assertStatus(200);

        // Memastikan tombol keluar `<` tidak ada
        $response->assertDontSee('title="Kembali ke Daftar Materi"', false);
        // Memastikan tombol kembali ke daftar materi tidak ada saat belum selesai quiz
        $response->assertDontSee('Kembali ke Daftar Materi');

        // Memastikan banner mode belajar terkunci dan CSS pengunci ada
        $response->assertSee('Mode Belajar Terkunci');
        $response->assertSee('#sidebar,');
        $response->assertSee('header,');

        // Memastikan session lock terpasang
        $this->assertEquals($materi->id_materi, session('active_materi_lock'));
        $this->assertEquals($quiz->id_quiz, session('active_quiz_lock'));

        // 2. Coba akses dashboard saat lock aktif -> harus diredirect kembali ke halaman kuis / materi
        $attemptDashboard = $this->actingAs($siswa)->get(route('siswa.dashboard'));
        $attemptDashboard->assertRedirect(route('siswa.quiz.kerjakan', $quiz->id_quiz));
    }

    /**
     * Memastikan halaman kuis terkunci dan menyembunyikan navbar serta tombol kembali ke materi
     */
    public function test_halaman_quiz_terkunci_dan_sembunyikan_navbar_dan_tombol_keluar()
    {
        session()->flush();
        $siswa = User::where('id_role', 3)->first();
        if (!$siswa) {
            $siswa = User::factory()->create(['id_role' => 3]);
        }

        $kategori = Kategori::firstOrCreate(['nama_kategori' => 'Listening']);
        $bab = Bab::create([
            'judul'       => 'Bab Lock Quiz ' . uniqid(),
            'id_kategori' => $kategori->id_kategori,
            'urutan'      => 98,
            'is_active'   => true
        ]);

        $admin = User::where('id_role', 2)->first() ?? User::factory()->create(['id_role' => 2]);

        $materi = Materi::create([
            'id_admin'    => $admin->id_user,
            'id_bab'      => $bab->id,
            'id_kategori' => $kategori->id_kategori,
            'bab'         => $bab->judul,
            'isi_materi'  => 'Konten materi test.',
            'judul'       => 'Materi Lock Quiz ' . uniqid(),
            'urutan'      => 1,
            'status'      => 'Published',
        ]);

        // Buat progress materi agar syarat buka kuis terpenuhi
        \App\Models\ProgressMateri::firstOrCreate([
            'id_user'   => $siswa->id_user,
            'id_materi' => $materi->id_materi,
            'status'    => 'Completed'
        ]);

        $quiz = Quiz::create([
            'id_materi'      => $materi->id_materi,
            'id_bab'         => $bab->id_bab,
            'pertanyaan'     => 'Soal test lock kuis?',
            'pilihan_a'      => 'A',
            'pilihan_b'      => 'B',
            'pilihan_c'      => 'C',
            'pilihan_d'      => 'D',
            'kunci_jawaban'  => 'A',
            'poin'           => 10,
            'status'         => 'Aktif',
            'urutan'         => 1,
        ]);

        // 1. Masuk ke halaman kerjakan quiz
        $response = $this->actingAs($siswa)->get(route('siswa.quiz.kerjakan', $quiz->id_quiz));
        $response->assertStatus(200);

        // Memastikan tombol kembali ke materi tidak ada
        $response->assertDontSee('Kembali ke Materi');

        // Memastikan banner mode kuis terkunci dan CSS pengunci ada
        $response->assertSee('Halaman Kuis Sedang Terkunci');
        $response->assertSee('#sidebar,');
        $response->assertSee('header,');

        // 2. Coba ganti page ke peta quiz saat sedang mengerjakan kuis -> harus dicegah dan diredirect kembali ke kuis
        $attemptPetaQuiz = $this->actingAs($siswa)->get(route('siswa.peta-quiz'));
        $attemptPetaQuiz->assertRedirect(route('siswa.quiz.kerjakan', $quiz->id_quiz));

        // 3. Selesaikan kuis dengan submit
        $submit = $this->actingAs($siswa)->post(route('siswa.quiz.submit', $quiz->id_quiz), [
            'jawaban_' . $quiz->id_quiz => 'A',
        ]);
        $submit->assertRedirect(route('siswa.quiz.hasil', $quiz->id_quiz));

        // 4. Setelah submit kuis selesai, session lock terlepas dan siswa bebas membuka dashboard
        $this->assertNull(session('active_quiz_lock'));
        $freeAccess = $this->actingAs($siswa)->get(route('siswa.dashboard'));
        $freeAccess->assertStatus(200);
    }
}

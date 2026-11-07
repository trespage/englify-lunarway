<?php

namespace Tests\Feature;

use App\Models\Bab;
use App\Models\Kategori;
use App\Models\User;
use Tests\TestCase;

class AdminKategoriBabIntegrationTest extends TestCase
{
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::where('id_role', 2)->first() ?? User::where('id_role', 1)->first();
    }

    public function test_halaman_kelola_kategori_bertema_biru_tanpa_aksen_amber(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.kategori'));
        $response->assertOk();

        // Cek elemen tema biru pada tombol dan icon kategori
        $response->assertSee('bg-blue-600');
        $response->assertSee('text-blue-600');
        $response->assertSee('bg-blue-100');
        $response->assertSee('Tambah Kategori');

        // Pastikan tidak ada class aksen amber / oranye lama pada tombol dan modal kategori
        $response->assertDontSee('bg-amber-500');
        $response->assertDontSee('shadow-amber-500/30');
    }

    public function test_tambah_kategori_otomatis_menambah_card_di_kelola_bab_dan_hapus_menghilangkannya(): void
    {
        $namaKatTest = 'Vocabulary ' . uniqid();

        // 1. Simpan kategori baru via controller
        $storeRes = $this->actingAs($this->admin)->post(route('admin.kategori.store'), [
            'nama_kategori' => $namaKatTest,
            'deskripsi'     => 'Kumpulan kosakata bahasa Inggris',
        ]);
        $storeRes->assertRedirect(route('admin.kategori'));

        $kategori = Kategori::where('nama_kategori', $namaKatTest)->first();
        $this->assertNotNull($kategori);

        // 2. Akses halaman Kelola Bab: Card kategori baru harus muncul secara dinamis!
        $babRes = $this->actingAs($this->admin)->get(route('admin.bab'));
        $babRes->assertOk();
        $babRes->assertSee($namaKatTest);
        $babRes->assertSee('Kumpulan kosakata bahasa Inggris');

        // 3. Tambah 1 Bab untuk kategori baru ini
        $bab = Bab::create([
            'id_kategori'  => $kategori->id_kategori,
            'judul'        => 'Bab 1: Kosakata Dasar',
            'urutan'       => 1,
            'durasi_menit' => 15,
            'is_active'    => true,
        ]);

        // Cek halaman Kelola Bab lagi: card kategori harus tetap ada dan menampilkan datanya
        $babRes2 = $this->actingAs($this->admin)->get(route('admin.bab'));
        $babRes2->assertOk();
        $babRes2->assertSee($namaKatTest);

        // 4. Hapus kategori via controller
        $delRes = $this->actingAs($this->admin)->delete(route('admin.kategori.destroy', $kategori->id_kategori));
        $delRes->assertRedirect(route('admin.kategori'));

        // 5. Verifikasi di database: kategori dan bab terkait sudah bersih
        $this->assertDatabaseMissing('kategori', ['id_kategori' => $kategori->id_kategori]);
        $this->assertDatabaseMissing('bab', ['id' => $bab->id]);

        // 6. Card kategori tersebut harus hilang dari Kelola Bab
        session()->forget('success');
        $babResAfterDel = $this->actingAs($this->admin)->get(route('admin.bab'));
        $babResAfterDel->assertOk();
        $babResAfterDel->assertDontSee($namaKatTest);
    }

    public function test_hapus_kategori_menghapus_seluruh_bab_materi_dan_kuis_di_dalamnya(): void
    {
        // 1. Buat Kategori baru
        $kategori = Kategori::create([
            'nama_kategori' => 'Pronunciation ' . uniqid(),
            'deskripsi'     => 'Kategori latihan pengucapan',
        ]);

        // 2. Buat Bab di dalam kategori
        $bab = \App\Models\Bab::create([
            'id_kategori'  => $kategori->id_kategori,
            'judul'        => 'Bab 1: Vowels and Consonants',
            'urutan'       => 1,
            'durasi_menit' => 20,
            'is_active'    => true,
        ]);

        // 3. Buat Materi di dalam kategori & bab
        $materi = \App\Models\Materi::create([
            'id_kategori'  => $kategori->id_kategori,
            'id_bab'       => $bab->id,
            'id_admin'     => $this->admin->id_user,
            'judul'        => 'Short and Long Vowels',
            'bab'          => $bab->judul,
            'urutan'       => 1,
            'durasi_menit' => 10,
            'status'       => 'Published',
            'isi_materi'   => 'Penjelasan vokal pendek dan panjang.',
        ]);

        // 4. Buat Quiz di dalam materi & bab
        $quiz = \App\Models\Quiz::create([
            'id_bab'        => $bab->id,
            'id_materi'     => $materi->id_materi,
            'pertanyaan'    => 'Which word contains a long vowel?',
            'pilihan_a'     => 'Cat',
            'pilihan_b'     => 'Cake',
            'pilihan_c'     => 'Sit',
            'pilihan_d'     => 'Dog',
            'kunci_jawaban' => 'B',
            'poin'          => 10,
            'status'        => 'Aktif',
            'urutan'        => 1,
        ]);

        $this->assertDatabaseHas('kategori', ['id_kategori' => $kategori->id_kategori]);
        $this->assertDatabaseHas('bab', ['id' => $bab->id]);
        $this->assertDatabaseHas('materi', ['id_materi' => $materi->id_materi]);
        $this->assertDatabaseHas('quiz', ['id_quiz' => $quiz->id_quiz]);

        // 5. Hapus Kategori via controller
        $response = $this->actingAs($this->admin)->delete(route('admin.kategori.destroy', $kategori->id_kategori));
        $response->assertRedirect(route('admin.kategori'));

        // 6. Verifikasi database: Kategori, Bab, Materi, dan Quiz semuanya ikut terhapus!
        $this->assertDatabaseMissing('kategori', ['id_kategori' => $kategori->id_kategori]);
        $this->assertDatabaseMissing('bab', ['id' => $bab->id]);
        $this->assertDatabaseMissing('materi', ['id_materi' => $materi->id_materi]);
        $this->assertDatabaseMissing('quiz', ['id_quiz' => $quiz->id_quiz]);
    }
}

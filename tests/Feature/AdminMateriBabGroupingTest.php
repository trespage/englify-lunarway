<?php

namespace Tests\Feature;

use App\Models\Bab;
use App\Models\Kategori;
use App\Models\Materi;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminMateriBabGroupingTest extends TestCase
{
    private array $createdUsers = [];
    private array $createdMateris = [];
    private array $createdBabs = [];
    private array $createdKategoris = [];

    protected function tearDown(): void
    {
        foreach ($this->createdMateris as $m) {
            Materi::where('id_materi', $m->id_materi)->delete();
        }
        foreach ($this->createdBabs as $b) {
            Bab::where('id', $b->id)->delete();
        }
        foreach ($this->createdKategoris as $k) {
            Kategori::where('id_kategori', $k->id_kategori)->delete();
        }
        foreach ($this->createdUsers as $u) {
            User::where('id_user', $u->id_user)->delete();
        }

        parent::tearDown();
    }

    public function test_admin_materi_displays_grouped_by_bab()
    {
        $admin = User::create([
            'nama'                 => 'Admin Test QA',
            'username'             => 'admin-qa-' . uniqid(),
            'email'                => 'admin-qa-' . uniqid() . '@example.com',
            'password'             => Hash::make('password123'),
            'id_role'              => 2,
            'status'               => 'aktif',
            'must_change_password' => false,
        ]);
        $this->createdUsers[] = $admin;

        $katSpeaking = Kategori::firstOrCreate(
            ['nama_kategori' => 'Speaking'],
            ['deskripsi' => 'Kategori Speaking']
        );

        $katWriting = Kategori::firstOrCreate(
            ['nama_kategori' => 'Writing'],
            ['deskripsi' => 'Kategori Writing']
        );

        $bab1 = Bab::create([
            'id_kategori' => $katSpeaking->id_kategori,
            'judul'       => 'Percobaan Bab Speaking ' . uniqid(),
            'urutan'      => 10,
            'is_active'   => true,
        ]);
        $this->createdBabs[] = $bab1;

        $bab2 = Bab::create([
            'id_kategori' => $katWriting->id_kategori,
            'judul'       => 'Percobaan Bab Writing ' . uniqid(),
            'urutan'      => 11,
            'is_active'   => true,
        ]);
        $this->createdBabs[] = $bab2;

        $materi1 = Materi::create([
            'id_admin'    => $admin->id_user,
            'id_kategori' => $katSpeaking->id_kategori,
            'id_bab'      => $bab1->id,
            'bab'         => $bab1->judul,
            'judul'       => 'Materi Percobaan 1 ' . uniqid(),
            'isi_materi'  => 'Konten materi 1',
            'urutan'      => 1,
            'status'      => 'Published',
        ]);
        $this->createdMateris[] = $materi1;

        $materi2 = Materi::create([
            'id_admin'    => $admin->id_user,
            'id_kategori' => $katWriting->id_kategori,
            'id_bab'      => $bab2->id,
            'bab'         => $bab2->judul,
            'judul'       => 'Materi Percobaan 2 ' . uniqid(),
            'isi_materi'  => 'Konten materi 2',
            'urutan'      => 1,
            'status'      => 'Published',
        ]);
        $this->createdMateris[] = $materi2;

        $response = $this->actingAs($admin)->get(route('admin.materi'));

        $response->assertStatus(200);
        $response->assertSee('Bab 10: ' . $bab1->judul);
        $response->assertSee('Bab 11: ' . $bab2->judul);
        $response->assertSee($materi1->judul);
        $response->assertSee($materi2->judul);
        $response->assertSee('Materi ke Bab Ini');
    }

    public function test_admin_materi_filters_by_kategori_and_bab()
    {
        $admin = User::create([
            'nama'                 => 'Admin Test Filter',
            'username'             => 'admin-filter-' . uniqid(),
            'email'                => 'admin-filter-' . uniqid() . '@example.com',
            'password'             => Hash::make('password123'),
            'id_role'              => 2,
            'status'               => 'aktif',
            'must_change_password' => false,
        ]);
        $this->createdUsers[] = $admin;

        $katSpeaking = Kategori::firstOrCreate(
            ['nama_kategori' => 'Speaking'],
            ['deskripsi' => 'Kategori Speaking']
        );

        $katWriting = Kategori::firstOrCreate(
            ['nama_kategori' => 'Writing'],
            ['deskripsi' => 'Kategori Writing']
        );

        $uniqueBabSpeaking = 'Bab Unique Speaking ' . uniqid();
        $uniqueBabWriting = 'Bab Unique Writing ' . uniqid();

        $bab1 = Bab::create([
            'id_kategori' => $katSpeaking->id_kategori,
            'judul'       => $uniqueBabSpeaking,
            'urutan'      => 20,
            'is_active'   => true,
        ]);
        $this->createdBabs[] = $bab1;

        $bab2 = Bab::create([
            'id_kategori' => $katWriting->id_kategori,
            'judul'       => $uniqueBabWriting,
            'urutan'      => 21,
            'is_active'   => true,
        ]);
        $this->createdBabs[] = $bab2;

        $materi1 = Materi::create([
            'id_admin'    => $admin->id_user,
            'id_kategori' => $katSpeaking->id_kategori,
            'id_bab'      => $bab1->id,
            'bab'         => $bab1->judul,
            'judul'       => 'Materi Unik Speaking ' . uniqid(),
            'isi_materi'  => 'Konten',
            'urutan'      => 1,
            'status'      => 'Published',
        ]);
        $this->createdMateris[] = $materi1;

        $materi2 = Materi::create([
            'id_admin'    => $admin->id_user,
            'id_kategori' => $katWriting->id_kategori,
            'id_bab'      => $bab2->id,
            'bab'         => $bab2->judul,
            'judul'       => 'Materi Unik Writing ' . uniqid(),
            'isi_materi'  => 'Konten',
            'urutan'      => 1,
            'status'      => 'Published',
        ]);
        $this->createdMateris[] = $materi2;

        // Filter by Kategori Speaking
        $response = $this->actingAs($admin)->get(route('admin.materi', ['kategori' => $katSpeaking->id_kategori]));
        $response->assertStatus(200);
        $response->assertSee('Bab 20: ' . $uniqueBabSpeaking);
        $response->assertDontSee('Bab 21: ' . $uniqueBabWriting);

        $grouped1 = $response->viewData('babsGrouped');
        $this->assertTrue($grouped1->contains('judul', $uniqueBabSpeaking));
        $this->assertFalse($grouped1->contains('judul', $uniqueBabWriting));

        // Filter by Bab Writing
        $responseBab = $this->actingAs($admin)->get(route('admin.materi', ['bab' => $bab2->id]));
        $responseBab->assertStatus(200);
        $responseBab->assertSee('Bab 21: ' . $uniqueBabWriting);
        $responseBab->assertDontSee('Bab 20: ' . $uniqueBabSpeaking);

        $grouped2 = $responseBab->viewData('babsGrouped');
        $this->assertTrue($grouped2->contains('judul', $uniqueBabWriting));
        $this->assertFalse($grouped2->contains('judul', $uniqueBabSpeaking));
        $this->assertTrue($grouped2->first()['materi']->contains('id', $materi2->id_materi));
    }

    public function test_materi_cannot_be_created_without_bab()
    {
        $admin = User::create([
            'nama'                 => 'Admin Test Validation',
            'username'             => 'admin-val-' . uniqid(),
            'email'                => 'admin-val-' . uniqid() . '@example.com',
            'password'             => Hash::make('password123'),
            'id_role'              => 2,
            'status'               => 'aktif',
            'must_change_password' => false,
        ]);
        $this->createdUsers[] = $admin;

        $katSpeaking = Kategori::firstOrCreate(
            ['nama_kategori' => 'Speaking'],
            ['deskripsi' => 'Kategori Speaking']
        );

        // Attempt to create materi without id_bab -> MUST FAIL validation
        $response = $this->actingAs($admin)->from(route('admin.materi'))->post(route('admin.materi.store'), [
            'judul'       => 'Materi Tanpa Bab Test',
            'id_kategori' => $katSpeaking->id_kategori,
            'isi_materi'  => 'Konten test',
            // id_bab intentionally omitted
        ]);

        $response->assertSessionHasErrors('id_bab');

        // Now create a Bab and attempt to create materi with that Bab -> MUST SUCCEED
        $bab = Bab::create([
            'id_kategori' => $katSpeaking->id_kategori,
            'judul'       => 'Bab Valid Test ' . uniqid(),
            'urutan'      => 1,
            'is_active'   => true,
        ]);
        $this->createdBabs[] = $bab;

        $responseValid = $this->actingAs($admin)->post(route('admin.materi.store'), [
            'judul'       => 'Materi Dengan Bab Valid',
            'id_kategori' => $katSpeaking->id_kategori,
            'id_bab'      => $bab->id,
            'isi_materi'  => 'Konten test valid',
            'status'      => 'Published',
        ]);

        $responseValid->assertRedirect(route('admin.materi'));
        $created = Materi::where('judul', 'Materi Dengan Bab Valid')->first();
        $this->assertNotNull($created);
        $this->assertEquals($bab->id, $created->id_bab);
        $this->assertEquals($bab->judul, $created->bab);
        $this->createdMateris[] = $created;
    }

    public function test_admin_can_upload_inline_image_for_materi()
    {
        $admin = User::create([
            'nama'                 => 'Admin Test Upload',
            'username'             => 'admin-upload-' . uniqid(),
            'email'                => 'admin-upload-' . uniqid() . '@example.com',
            'password'             => Hash::make('password123'),
            'id_role'              => 2,
            'status'               => 'aktif',
            'must_change_password' => false,
        ]);
        $this->createdUsers[] = $admin;

        $file = \Illuminate\Http\UploadedFile::fake()->create('test_inline.png', 50, 'image/png');

        $response = $this->actingAs($admin)->postJson(route('admin.materi.upload-image'), [
            'image' => $file,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'url', 'path']);
        $this->assertTrue($response->json('success'));

        $savedPath = public_path($response->json('path'));
        if (file_exists($savedPath)) {
            @unlink($savedPath);
        }
    }

    public function test_admin_materi_page_contains_alphabetical_and_roman_list_controls_and_css()
    {
        $admin = User::create([
            'nama'                 => 'Admin Test List',
            'username'             => 'admin-list-' . uniqid(),
            'email'                => 'admin-list-' . uniqid() . '@example.com',
            'password'             => Hash::make('password123'),
            'id_role'              => 2,
            'status'               => 'aktif',
            'must_change_password' => false,
        ]);
        $this->createdUsers[] = $admin;

        $response = $this->actingAs($admin)->get(route('admin.materi'));
        $response->assertStatus(200);

        // Memastikan tombol A.B.C dan dropdown format penomoran tersedia
        $response->assertSee('A.B.C');
        $response->assertSee('data-list-type="A"', false);
        $response->assertSee('data-list-type="1"', false);
        $response->assertSee('applyListStyle', false);
        $response->assertSee('continueListNumbering', false);
        $response->assertSee('restartListNumbering', false);
        $response->assertSee('setListCustomStart', false);
        $response->assertSee('Lanjutkan Penomoran', false);
        $response->assertSee('Mulai Ulang', false);
        $response->assertSee('upper-alpha', false);
        $response->assertSee('lower-alpha', false);
        $response->assertSee('upper-roman', false);

        // Memastikan dukungan marker tebal otomatis pada anak judul (A., 1., dsb)
        $response->assertSee('li:has(strong)::marker', false);
        $response->assertSee('li.li-marker-bold::marker', false);
        $response->assertSee('syncListMarkerBoldState', false);

        // Memastikan tersedianya dua mode pembuatan materi (Standar & Mode Luas Word)
        $response->assertSee('btnModeCompact', false);
        $response->assertSee('btnModeLarge', false);
        $response->assertSee('setMateriModalMode', false);
        $response->assertSee('Mode Luas', false);
    }
}

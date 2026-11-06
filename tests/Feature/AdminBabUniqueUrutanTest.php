<?php

namespace Tests\Feature;

use App\Models\Bab;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBabUniqueUrutanTest extends TestCase
{
    protected User $admin;
    protected Kategori $katWriting;
    protected Kategori $katSpeaking;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::firstOrCreate(
            ['email' => 'admin_test_bab@englify.test'],
            [
                'nama'     => 'Admin Test Bab',
                'username' => 'admintestbab',
                'password' => bcrypt('password123'),
                'id_role'  => 2,
            ]
        );

        $this->katWriting = Kategori::firstOrCreate(
            ['nama_kategori' => 'Writing Test Unik'],
            ['deskripsi' => 'Writing Test Unik']
        );

        $this->katSpeaking = Kategori::firstOrCreate(
            ['nama_kategori' => 'Speaking Test Unik'],
            ['deskripsi' => 'Speaking Test Unik']
        );
    }

    protected function tearDown(): void
    {
        Bab::whereIn('id_kategori', [$this->katWriting->id_kategori, $this->katSpeaking->id_kategori])->delete();
        $this->katWriting->delete();
        $this->katSpeaking->delete();
        $this->admin->delete();

        parent::tearDown();
    }

    /**
     * Uji 1: Membuat Bab 1 di Kategori Writing berhasil
     */
    public function test_can_create_bab_1_in_category(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.bab.store'), [
            'id_kategori' => $this->katWriting->id_kategori,
            'judul'       => 'Bab 1 Writing Dasar',
            'urutan'      => 1,
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('bab', [
            'id_kategori' => $this->katWriting->id_kategori,
            'judul'       => 'Bab 1 Writing Dasar',
            'urutan'      => 1,
        ]);
    }

    /**
     * Uji 2: Membuat Bab 1 LAGI di Kategori Writing HARUS GAGAL (Validasi Duplikat)
     */
    public function test_cannot_create_duplicate_bab_number_in_same_category(): void
    {
        Bab::create([
            'id_kategori' => $this->katWriting->id_kategori,
            'judul'       => 'Bab 1 Writing Pertama',
            'urutan'      => 1,
            'durasi_menit'=> 15,
            'is_active'   => true,
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.bab.store'), [
            'id_kategori' => $this->katWriting->id_kategori,
            'judul'       => 'Bab 1 Writing Duplikat',
            'urutan'      => 1,
        ]);

        $response->assertSessionHasErrors('urutan');
        $this->assertDatabaseMissing('bab', [
            'id_kategori' => $this->katWriting->id_kategori,
            'judul'       => 'Bab 1 Writing Duplikat',
        ]);
    }

    /**
     * Uji 3: Nomor Bab yang sama di KATEGORI BERBEDA diperbolehkan (misal Bab 1 Writing & Bab 1 Speaking)
     */
    public function test_same_bab_number_allowed_in_different_categories(): void
    {
        Bab::create([
            'id_kategori' => $this->katWriting->id_kategori,
            'judul'       => 'Bab 1 Writing',
            'urutan'      => 1,
            'durasi_menit'=> 15,
            'is_active'   => true,
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.bab.store'), [
            'id_kategori' => $this->katSpeaking->id_kategori,
            'judul'       => 'Bab 1 Speaking',
            'urutan'      => 1,
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('bab', [
            'id_kategori' => $this->katSpeaking->id_kategori,
            'judul'       => 'Bab 1 Speaking',
            'urutan'      => 1,
        ]);
    }

    /**
     * Uji 4: Jika urutan tidak diisi, otomatis bersusun (next max urutan + 1)
     */
    public function test_omitted_urutan_auto_increments_sequentially(): void
    {
        Bab::create([
            'id_kategori' => $this->katWriting->id_kategori,
            'judul'       => 'Bab 1 Auto',
            'urutan'      => 1,
            'durasi_menit'=> 15,
            'is_active'   => true,
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.bab.store'), [
            'id_kategori' => $this->katWriting->id_kategori,
            'judul'       => 'Bab 2 Auto Next',
            // urutan dikosongkan
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('bab', [
            'id_kategori' => $this->katWriting->id_kategori,
            'judul'       => 'Bab 2 Auto Next',
            'urutan'      => 2,
        ]);
    }

    /**
     * Uji 5: Update bab ke urutan bab lain di kategori sama harus gagal
     */
    public function test_update_to_existing_urutan_in_same_category_fails(): void
    {
        $bab1 = Bab::create([
            'id_kategori' => $this->katWriting->id_kategori,
            'judul'       => 'Bab 1 Asli',
            'urutan'      => 1,
            'durasi_menit'=> 15,
            'is_active'   => true,
        ]);

        $bab2 = Bab::create([
            'id_kategori' => $this->katWriting->id_kategori,
            'judul'       => 'Bab 2 Asli',
            'urutan'      => 2,
            'durasi_menit'=> 15,
            'is_active'   => true,
        ]);

        // Coba ganti urutan bab 2 menjadi 1
        $response = $this->actingAs($this->admin)->put(route('admin.bab.update', $bab2->id), [
            'id_kategori' => $this->katWriting->id_kategori,
            'judul'       => 'Bab 2 Diubah Menjadi 1',
            'urutan'      => 1,
        ]);

        $response->assertSessionHasErrors('urutan');
    }

    /**
     * Uji 6: Endpoint next-urutan mengembalikan nomor bab bersusun berikutnya
     */
    public function test_next_urutan_endpoint_returns_correct_number(): void
    {
        Bab::create([
            'id_kategori' => $this->katWriting->id_kategori,
            'judul'       => 'Bab 1 Writing',
            'urutan'      => 1,
            'durasi_menit'=> 15,
            'is_active'   => true,
        ]);

        Bab::create([
            'id_kategori' => $this->katWriting->id_kategori,
            'judul'       => 'Bab 2 Writing',
            'urutan'      => 2,
            'durasi_menit'=> 15,
            'is_active'   => true,
        ]);

        $response = $this->actingAs($this->admin)->getJson(route('admin.bab.next-urutan', $this->katWriting->id_kategori));

        $response->assertOk()
            ->assertJson([
                'status'           => 'success',
                'next_urutan'      => 3,
                'existing_urutans' => [1, 2],
            ]);
    }
}

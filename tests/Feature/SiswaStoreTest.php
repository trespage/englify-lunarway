<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class SiswaStoreTest extends TestCase
{
    public function test_superadmin_dapat_menambah_siswa_dan_muncul_di_daftar(): void
    {
        $superadmin = User::where('email', 'superadmin@englify.com')->first()
            ?? User::where('id_role', 1)->first();
        $this->assertNotNull($superadmin, 'Butuh akun superadmin (id_role=1)');

        $email = 'qatest-siswa-' . uniqid() . '@example.com';

        // 1. Simpan via route superadmin.siswa.store
        $res = $this->actingAs($superadmin)->post(route('superadmin.siswa.store'), [
            'nama' => 'QA Siswa Testing',
            'email' => $email,
            'password' => 'password123',
            'status' => 'aktif',
        ]);
        $res->assertRedirect(route('superadmin.siswa'));

        // 2. Tersimpan di database dengan role siswa (id_role = 3) dan status aktif
        $this->assertDatabaseHas('users', [
            'email' => $email,
            'id_role' => 3,
            'status' => 'aktif',
            'must_change_password' => 1,
        ]);

        // 3. Muncul di halaman daftar akun siswa
        $list = $this->actingAs($superadmin)->get(route('superadmin.siswa'));
        $list->assertOk();
        $list->assertSee($email);
        $list->assertSee('QA Siswa Testing');

        // 4. Validasi email duplikat ditolak
        $this->actingAs($superadmin)->post(route('superadmin.siswa.store'), [
            'nama' => 'Duplikat Siswa',
            'email' => $email,
            'password' => 'password123',
        ])->assertSessionHasErrors('email');

        // 5. Update data siswa (nama, status)
        $created = User::where('email', $email)->first();
        $this->actingAs($superadmin)->put(
            route('superadmin.siswa.update', ['id' => $created->id_user]),
            ['nama' => 'QA Siswa Updated', 'email' => $email, 'status' => 'nonaktif']
        )->assertRedirect(route('superadmin.siswa'));

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'nama' => 'QA Siswa Updated',
            'status' => 'nonaktif',
        ]);

        // 6. Hapus siswa
        $this->actingAs($superadmin)->delete(
            route('superadmin.siswa.destroy', ['id' => $created->id_user])
        )->assertRedirect(route('superadmin.siswa'));

        $this->assertDatabaseMissing('users', ['email' => $email]);
    }

    public function test_hapus_siswa_membersihkan_pesan_admin_terkait(): void
    {
        $superadmin = User::where('id_role', 1)->first();
        $admin = User::where('id_role', 2)->first() ?? $superadmin;

        $siswa = User::create([
            'nama' => 'QA Siswa Reminder Cascade',
            'username' => 'qa-cascade-' . uniqid(),
            'email' => 'qa-cascade-' . uniqid() . '@example.com',
            'password' => bcrypt('password123'),
            'id_role' => 3,
            'status' => 'aktif',
            'must_change_password' => false,
        ]);

        $pesan = \App\Models\PesanAdmin::create([
            'id_user' => $siswa->id_user,
            'id_admin' => $admin->id_user,
            'pesan' => 'Pesan pengingat untuk testing cascade delete',
            'is_read' => false,
        ]);

        $this->assertDatabaseHas('pesan_admin', ['id' => $pesan->id]);

        // Hapus siswa via route destroy
        $this->actingAs($superadmin)->delete(route('superadmin.siswa.destroy', $siswa->id_user));

        // Pesan admin harus otomatis terhapus (cascade)
        $this->assertDatabaseMissing('pesan_admin', ['id' => $pesan->id]);
    }

    public function test_superadmin_tidak_dapat_dihapus_atau_diedit_sembarangan_via_generic_route(): void
    {
        $superadmin = User::where('id_role', 1)->first();

        // Coba hapus superadmin via users.destroy
        $resDelete = $this->actingAs($superadmin)->delete(route('superadmin.users.destroy', $superadmin->id_user));
        $resDelete->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id_user' => $superadmin->id_user]);

        // Coba edit superadmin via users.update
        $resUpdate = $this->actingAs($superadmin)->put(route('superadmin.users.update', $superadmin->id_user), [
            'nama' => 'Hacker Name',
        ]);
        $resUpdate->assertSessionHas('error');
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfileAvatarTest extends TestCase
{
    public function test_user_default_avatar_by_role()
    {
        $siswa = new User(['id_role' => 3]);
        $admin = new User(['id_role' => 2]);
        $superadmin = new User(['id_role' => 1]);

        $this->assertStringContainsString('avatar-cat-reading.png', $siswa->avatar_url);
        $this->assertStringContainsString('avatar-cat-laptop.png', $admin->avatar_url);
        $this->assertStringContainsString('avatar-cat-laptop.png', $superadmin->avatar_url);
    }

    public function test_siswa_can_update_avatar_via_endpoint()
    {
        $siswa = User::where('id_role', 3)->first();
        if (!$siswa) {
            $this->markTestSkipped('No siswa found');
        }

        $response = $this->actingAs($siswa)->postJson(route('siswa.profil.avatar'), [
            'avatar' => 'avatar-cat-trophy.png',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'avatar' => 'avatar-cat-trophy.png',
            ]);

        $this->assertEquals('avatar-cat-trophy.png', $siswa->fresh()->avatar);
        $this->assertStringContainsString('avatar-cat-trophy.png', $siswa->fresh()->avatar_url);
    }

    public function test_admin_can_update_avatar_via_endpoint()
    {
        $admin = User::where('id_role', 2)->first();
        if (!$admin) {
            $this->markTestSkipped('No admin found');
        }

        $response = $this->actingAs($admin)->postJson(route('admin.profil.avatar'), [
            'avatar' => 'avatar-cat-laptop.png',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'avatar' => 'avatar-cat-laptop.png',
            ]);

        $this->assertEquals('avatar-cat-laptop.png', $admin->fresh()->avatar);
    }

    public function test_avatar_validation_rejects_invalid_file()
    {
        $siswa = User::where('id_role', 3)->first();
        if (!$siswa) {
            $this->markTestSkipped('No siswa found');
        }

        $response = $this->actingAs($siswa)->postJson(route('siswa.profil.avatar'), [
            'avatar' => 'hacker_cat.exe',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['avatar']);
    }
}

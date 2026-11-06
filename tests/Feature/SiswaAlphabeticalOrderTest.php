<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiswaAlphabeticalOrderTest extends TestCase
{
    public function test_superadmin_siswa_dan_admin_divisi_diurutkan_berdasarkan_nama_asc(): void
    {
        $superadmin = User::factory()->create([
            'id_role' => 1,
            'status' => 'aktif',
        ]);

        // Create students with unordered names
        User::factory()->create(['nama' => 'Zack Snyder', 'id_role' => 3]);
        User::factory()->create(['nama' => 'Alice Wonder', 'id_role' => 3]);
        User::factory()->create(['nama' => 'Bob Marley', 'id_role' => 3]);

        $resSiswa = $this->actingAs($superadmin)->get(route('superadmin.siswa'));
        $resSiswa->assertOk();

        /** @var \Illuminate\Pagination\LengthAwarePaginator $students */
        $students = $resSiswa->viewData('students');
        $this->assertNotNull($students);
        
        $names = $students->pluck('nama')->toArray();
        $sortedNames = $names;
        natcasesort($sortedNames);
        $this->assertSame(array_values($sortedNames), array_values($names));

        // Create admins with unordered names
        User::factory()->create(['nama' => 'Zoe Saldana', 'id_role' => 2]);
        User::factory()->create(['nama' => 'Adam Smith', 'id_role' => 2]);
        User::factory()->create(['nama' => 'Charlie Chaplin', 'id_role' => 2]);

        $resAdmin = $this->actingAs($superadmin)->get(route('superadmin.adminDivisi'));
        $resAdmin->assertOk();

        /** @var \Illuminate\Pagination\LengthAwarePaginator $admins */
        $admins = $resAdmin->viewData('admins');
        $this->assertNotNull($admins);

        $adminNames = $admins->pluck('nama')->toArray();
        $sortedAdminNames = $adminNames;
        natcasesort($sortedAdminNames);
        $this->assertSame(array_values($sortedAdminNames), array_values($adminNames));

        // Cleanup
        User::whereIn('nama', [
            'Zack Snyder', 'Alice Wonder', 'Bob Marley',
            'Zoe Saldana', 'Adam Smith', 'Charlie Chaplin'
        ])->delete();
        $superadmin->delete();
    }
}

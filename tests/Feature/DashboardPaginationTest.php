<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class DashboardPaginationTest extends TestCase
{
    public function test_superadmin_dashboard_renders_all_students_for_client_pagination(): void
    {
        $superadmin = User::where('id_role', 1)->first() ?? User::factory()->create(['id_role' => 1]);

        $response = $this->actingAs($superadmin)->get(route('superadmin.dashboard'));
        $response->assertOk();

        $students = $response->viewData('students');
        $this->assertNotNull($students);
        $this->assertGreaterThanOrEqual(1, $students->count());

        // View includes pagination containers and row classes
        $response->assertSee('id="table-container-siswa"', false);
        $response->assertSee('id="pagination-siswa"', false);
        $response->assertSee('id="table-container-admin"', false);
        $response->assertSee('id="pagination-admin"', false);
        $response->assertSee('row-siswa', false);
    }
}

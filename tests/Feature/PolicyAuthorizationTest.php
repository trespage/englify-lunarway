<?php

namespace Tests\Feature;

use App\Models\HasilQuiz;
use App\Models\PesanAdmin;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PolicyAuthorizationTest extends TestCase
{
    private array $cleanupUsers = [];

    protected function tearDown(): void
    {
        foreach ($this->cleanupUsers as $u) {
            User::where('id_user', $u->id_user)->delete();
        }
        $this->cleanupUsers = [];

        parent::tearDown();
    }

    private function makeUser(int $role, string $prefix = 'user'): User
    {
        $user = User::create([
            'nama'                 => 'QA ' . ucfirst($prefix),
            'username'             => 'qa-' . $prefix . '-' . uniqid(),
            'email'                => 'qa-' . $prefix . '-' . uniqid() . '@example.com',
            'password'             => Hash::make('password123'),
            'id_role'              => $role,
            'status'               => 'aktif',
            'must_change_password' => false,
        ]);

        $this->cleanupUsers[] = $user;

        return $user;
    }

    /**
     * Siswa hanya bisa melihat hasil quiz miliknya sendiri via HasilQuizPolicy.
     * Siswa lain yang mencoba mengakses akan ditolak dengan 403 Forbidden.
     */
    public function test_siswa_hanya_bisa_melihat_hasil_quiz_milik_sendiri(): void
    {
        $siswaA = $this->makeUser(3, 'siswa-a');
        $siswaB = $this->makeUser(3, 'siswa-b');
        $admin  = $this->makeUser(2, 'admin');

        $quiz = Quiz::first();
        $this->assertNotNull($quiz, 'Harus ada data kuis');

        $hasilA = HasilQuiz::create([
            'id_user'        => $siswaA->id_user,
            'id_quiz'        => $quiz->id_quiz,
            'skor_diperoleh' => 85,
        ]);

        // 1. Siswa A dapat melihat hasil miliknya sendiri
        $resA = $this->actingAs($siswaA)->get(route('siswa.quiz.hasil', $quiz->id_quiz));
        $resA->assertOk();

        // 2. Admin dapat melihat hasil kuis Siswa A via detail hasil quiz
        $resAdmin = $this->actingAs($admin)->get(route('admin.hasil-quiz.detail', $hasilA->id_hasil));
        $resAdmin->assertOk();

        // 3. Kebijakan Policy menolak Siswa B melihat HasilQuiz Siswa A
        $policy = new \App\Policies\HasilQuizPolicy();
        $this->assertTrue($policy->view($siswaA, $hasilA));
        $this->assertFalse($policy->view($siswaB, $hasilA));
        $this->assertTrue($policy->view($admin, $hasilA));
    }

    /**
     * Siswa hanya bisa mengupdate (baca) dan menghapus reminder miliknya sendiri via PesanAdminPolicy.
     * Siswa lain yang mencoba menghapus/mengubah pesan orang lain akan ditolak 403 Forbidden.
     */
    public function test_siswa_hanya_bisa_mengelola_pesan_reminder_milik_sendiri(): void
    {
        $siswaA = $this->makeUser(3, 'siswa-a');
        $siswaB = $this->makeUser(3, 'siswa-b');
        $admin  = $this->makeUser(2, 'admin');

        $pesanA = PesanAdmin::create([
            'id_user'  => $siswaA->id_user,
            'id_admin' => $admin->id_user,
            'pesan'    => 'Pesan rahasia untuk Siswa A',
            'is_read'  => false,
        ]);

        // 1. Siswa B mencoba menandai sudah dibaca pesan milik Siswa A -> Ditolak 403 Forbidden
        $resReadForbidden = $this->actingAs($siswaB)->post(route('siswa.reminder.read', $pesanA->id));
        $resReadForbidden->assertForbidden();

        // 2. Siswa B mencoba menghapus pesan milik Siswa A -> Ditolak 403 Forbidden
        $resDeleteForbidden = $this->actingAs($siswaB)->delete(route('siswa.reminder.destroy', $pesanA->id));
        $resDeleteForbidden->assertForbidden();

        // Pesan masih utuh dan belum dibaca
        $pesanA->refresh();
        $this->assertFalse($pesanA->is_read);

        // 3. Siswa A menandai pesan miliknya sendiri -> Berhasil
        $resReadOk = $this->actingAs($siswaA)->post(route('siswa.reminder.read', $pesanA->id));
        $resReadOk->assertRedirect();
        $pesanA->refresh();
        $this->assertTrue($pesanA->is_read);

        // 4. Siswa A menghapus pesan miliknya sendiri -> Berhasil
        $resDeleteOk = $this->actingAs($siswaA)->delete(route('siswa.reminder.destroy', $pesanA->id));
        $resDeleteOk->assertRedirect();
        $this->assertDatabaseMissing('pesan_admin', ['id' => $pesanA->id]);
    }
}

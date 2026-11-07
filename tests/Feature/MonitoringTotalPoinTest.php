<?php

namespace Tests\Feature;

use App\Models\HasilQuiz;
use App\Models\Quiz;
use App\Models\User;
use Tests\TestCase;

class MonitoringTotalPoinTest extends TestCase
{
    protected User $admin;
    protected User $siswa;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::where('id_role', 2)->first() ?? User::where('id_role', 1)->first();
        $this->siswa = User::where('id_role', 3)->first();
    }

    public function test_halaman_monitoring_menampilkan_kolom_dan_kartu_total_poin(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.monitoring-siswa'));
        $response->assertOk();
        $response->assertSee('Total Poin');
        $response->assertSee('semua siswa');
        $response->assertSee('0 Poin');
    }

    public function test_detail_monitoring_menampilkan_kartu_total_poin(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.monitoring-siswa.detail', $this->siswa->id_user));
        $response->assertOk();
        $response->assertSee('Total Poin');
        $response->assertSee('Akumulasi skor quiz');
    }

    public function test_monitoring_menghitung_akumulasi_poin_siswa_dengan_benar(): void
    {
        $quiz = Quiz::first();
        if (!$quiz) {
            $this->markTestSkipped('Quiz tidak ditemukan.');
        }

        // Buat probe hasil quiz sementara
        $probe = HasilQuiz::create([
            'id_user'        => $this->siswa->id_user,
            'id_quiz'        => $quiz->id_quiz,
            'skor_diperoleh' => 95,
        ]);

        try {
            $response = $this->actingAs($this->admin)->get(route('admin.monitoring-siswa', ['q' => $this->siswa->email]));
            $response->assertOk();
            $response->assertSee('95 Poin');

            $detailResponse = $this->actingAs($this->admin)->get(route('admin.monitoring-siswa.detail', $this->siswa->id_user));
            $detailResponse->assertOk();
            $detailResponse->assertSee('95');
        } finally {
            // Hapus probe agar database tetap bersih
            $probe->delete();
        }
    }
}

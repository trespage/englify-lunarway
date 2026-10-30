<?php

namespace Tests\Feature;

use App\Models\Bab;
use App\Models\Kategori;
use App\Models\Materi;
use App\Models\Quiz;
use App\Models\User;
use Tests\TestCase;

class ApiTest extends TestCase
{
    public function test_endpoint_publik_tidak_gagal(): void
    {
        $routes = [
            'api.kategori',
            'api.bab',
            'api.materi',
            'api.quiz',
            'api.reviews',
            'api.monitoring',
            'api.users',
        ];

        foreach ($routes as $route) {
            $res = $this->getJson(route($route));
            $res->assertOk();
            $res->assertJsonStructure(['status', 'message', 'data']);
        }
    }

    public function test_endpoint_detail_berfungsi(): void
    {
        $kategori = Kategori::first();
        if ($kategori) {
            $res = $this->getJson(route('api.kategori.detail', $kategori->id_kategori));
            $res->assertOk();
            $res->assertJsonStructure(['status', 'message', 'data']);
        }

        $bab = Bab::first();
        if ($bab) {
            $res = $this->getJson(route('api.bab.detail', $bab->id));
            $res->assertOk();
            $res->assertJsonStructure(['status', 'message', 'data']);
        }

        $materi = Materi::first();
        if ($materi) {
            $res = $this->getJson(route('api.materi.detail', $materi->id_materi));
            $res->assertOk();
            $res->assertJsonStructure(['status', 'message', 'data']);
        }

        $quiz = Quiz::first();
        if ($quiz) {
            $res = $this->getJson(route('api.quiz.detail', $quiz->id_quiz));
            $res->assertOk();
            $res->assertJsonStructure(['status', 'message', 'data']);
        }

        $siswa = User::where('id_role', 3)->first();
        if ($siswa) {
            $res = $this->getJson(route('api.monitoring.detail', $siswa->id_user));
            $res->assertOk();
            $res->assertJsonStructure(['status', 'message', 'data']);
        }

        $user = User::first();
        if ($user) {
            $res = $this->getJson(route('api.users.detail', $user->id_user));
            $res->assertOk();
            $res->assertJsonStructure(['status', 'message', 'data']);
        }
    }

    public function test_kunci_jawaban_quiz_tidak_bocor_ke_publik_atau_siswa(): void
    {
        // 1. Akses publik ke /api/quiz
        $resPublik = $this->getJson(route('api.quiz'));
        $resPublik->assertOk();
        $dataPublik = $resPublik->json('data');
        if (!empty($dataPublik)) {
            foreach ($dataPublik as $item) {
                $this->assertArrayNotHasKey('kunci_jawaban', $item, 'Kunci jawaban tidak boleh bocor ke publik!');
            }
        }

        // 2. Akses siswa ke /api/quiz
        $siswa = User::where('id_role', 3)->first();
        if ($siswa) {
            $resSiswa = $this->actingAs($siswa)->getJson(route('api.quiz'));
            $resSiswa->assertOk();
            $dataSiswa = $resSiswa->json('data');
            if (!empty($dataSiswa)) {
                foreach ($dataSiswa as $item) {
                    $this->assertArrayNotHasKey('kunci_jawaban', $item, 'Kunci jawaban tidak boleh bocor ke siswa!');
                }
            }
        }
    }

    public function test_api_progress_siswa_mengembalikan_json_tanpa_kunci_jawaban(): void
    {
        $siswa = User::where('id_role', 3)->first();
        $this->assertNotNull($siswa);

        $res = $this->actingAs($siswa)->getJson(route('api.siswa.progress'));
        $res->assertOk();
        $res->assertJsonStructure(['status', 'message', 'data']);

        $riwayat = $res->json('data.riwayat');
        if (!empty($riwayat)) {
            foreach ($riwayat as $r) {
                if (isset($r['quiz'])) {
                    $this->assertArrayNotHasKey('kunci_jawaban', $r['quiz'], 'Kunci jawaban tidak boleh tampil di riwayat progress siswa');
                }
            }
        }
    }

    public function test_api_progress_siswa_tidak_bisa_diakses_tanpa_login(): void
    {
        $this->getJson(route('api.siswa.progress'))->assertUnauthorized();
    }

    public function test_filter_pencarian_pada_api(): void
    {
        // Filter materi by q
        $resMateri = $this->getJson(route('api.materi', ['q' => 'English']));
        $resMateri->assertOk();
        $resMateri->assertJsonStructure(['status', 'message', 'data']);

        // Filter bab by id_kategori
        $kategori = Kategori::first();
        if ($kategori) {
            $resBab = $this->getJson(route('api.bab', ['id_kategori' => $kategori->id_kategori]));
            $resBab->assertOk();
            $resBab->assertJsonStructure(['status', 'message', 'data']);
        }
    }
}

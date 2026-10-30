<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Materi;
use App\Models\Kategori;
use App\Models\HasilQuiz;
use App\Models\ProgressMateri;
use Carbon\Carbon;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $totalMateri = Materi::count();

        $query = User::where('id_role', 3)
            ->withCount(['hasilQuiz as total_quiz_dikerjakan'])
            ->withSum('hasilQuiz as total_skor', 'skor_diperoleh')
            ->withCount(['progressMateri as materi_dibaca' => function ($query) {
                $query->where('status', 'Completed');
            }]);

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->q . '%')
                    ->orWhere('email', 'like', '%' . $request->q . '%');
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $paginator = $query->orderBy('nama')->paginate(10)->withQueryString();

        $students = $paginator->getCollection()->map(function ($user) use ($totalMateri) {
            $progress = $totalMateri > 0 ? (int) round($user->materi_dibaca / $totalMateri * 100) : 0;

            return [
                'id'         => $user->id_user,
                'nama'       => $user->nama,
                'email'      => $user->email,
                'status'     => $user->status,
                'progress'   => $progress,
                'quiz'       => (int) $user->total_quiz_dikerjakan,
                'poin'       => (int) ($user->total_skor ?? 0),
                'total_skor' => (int) ($user->total_skor ?? 0),
                'lastActive' => $user->last_login_at ? Carbon::parse($user->last_login_at)->diffForHumans() : '-',
            ];
        })->values();

        // Statistik global (tidak dipengaruhi filter, agar kartu ringkasan konsisten)
        $totalSiswa          = User::where('id_role', 3)->count();
        $siswaAktif          = User::where('id_role', 3)->where('status', 'aktif')->count();
        $siswaNonaktif       = $totalSiswa - $siswaAktif;
        $totalPoinTerkumpul  = (int) HasilQuiz::sum('skor_diperoleh');
        $averageProgress     = $totalMateri > 0
            ? (int) round(
                User::where('id_role', 3)
                    ->withCount(['progressMateri as materi_dibaca' => function ($q) {
                        $q->where('status', 'Completed');
                    }])
                    ->get()
                    ->avg(fn ($user) => $user->materi_dibaca / $totalMateri * 100)
            )
            : 0;

        return view('admin.monitoring', compact(
            'students', 'paginator', 'totalSiswa', 'siswaAktif', 'siswaNonaktif', 'averageProgress', 'totalPoinTerkumpul'
        ));
    }

    public function apiIndex(Request $request)
    {
        $query = User::where('id_role', 3)
            ->with('role')
            ->withCount(['hasilQuiz as total_quiz_dikerjakan'])
            ->withSum('hasilQuiz as total_skor', 'skor_diperoleh')
            ->withCount(['progressMateri as materi_dibaca' => function ($sub) {
                $sub->where('status', 'Completed');
            }])
            ->latest();

        if ($request->filled('q')) {
            $q = '%' . $request->q . '%';
            $query->where(function ($sub) use ($q) {
                $sub->where('nama', 'like', $q)
                    ->orWhere('email', 'like', $q);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $siswa = $query->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil dimuat',
            'data'    => $siswa,
        ]);
    }

    public function apiShow($id)
    {
        $student = User::where('id_role', 3)
            ->with(['role', 'kategori'])
            ->find($id);

        if (!$student) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data monitoring siswa tidak ditemukan',
                'data'    => null,
            ], 404);
        }

        $riwayat_quiz = HasilQuiz::where('id_user', $student->id_user)
            ->with('quiz.materi')
            ->latest()
            ->get();

        $isAdmin = auth()->check() && in_array((int) auth()->user()->id_role, [1, 2]);
        if (!$isAdmin) {
            $riwayat_quiz->each(function ($item) {
                if ($item->quiz) {
                    $item->quiz->makeHidden(['kunci_jawaban']);
                }
            });
        }

        $progress_materi = ProgressMateri::where('id_user', $student->id_user)
            ->with('materi.babModel')
            ->get();

        $totalQuizDikerjakan = $riwayat_quiz->count();
        $totalPoin = (int) $riwayat_quiz->sum('skor_diperoleh');
        $rataRataNilai = $totalQuizDikerjakan > 0 ? round($riwayat_quiz->avg('skor_diperoleh'), 1) : 0;
        $totalMateriDibaca = $progress_materi->where('status', 'Completed')->count();

        return response()->json([
            'status'  => 'success',
            'message' => 'Detail monitoring siswa berhasil dimuat',
            'data'    => [
                'siswa'                 => $student,
                'total_quiz_dikerjakan' => $totalQuizDikerjakan,
                'total_poin'            => $totalPoin,
                'rata_rata_nilai'       => $rataRataNilai,
                'total_materi_dibaca'   => $totalMateriDibaca,
                'riwayat_quiz'          => $riwayat_quiz,
                'progress_materi'       => $progress_materi,
            ],
        ]);
    }

    public function detail($id)
    {
        $student = User::findOrFail($id);

        $riwayat_quiz = HasilQuiz::where('id_user', $student->id_user)
            ->with('quiz.materi')
            ->latest()
            ->get();

        $progress_materi = ProgressMateri::where('id_user', $student->id_user)
            ->with('materi.babModel')
            ->get();

        $totalQuizDikerjakan = $riwayat_quiz->count();
        $totalPoin = (int) $riwayat_quiz->sum('skor_diperoleh');
        $rataRataNilai = $totalQuizDikerjakan > 0 ? round($riwayat_quiz->avg('skor_diperoleh'), 1) : 0;
        $totalMateriDibaca = $progress_materi->where('status', 'Completed')->count();
        $lastActive = $student->last_login_at ? Carbon::parse($student->last_login_at) : null;

        // Aktivitas gabungan dari quiz & materi yang benar-benar dikerjakan
        $aktivitas = collect();

        foreach ($riwayat_quiz as $hasil) {
            $aktivitas->push([
                'type'   => 'quiz',
                'judul'  => 'Menyelesaikan Quiz: ' . ($hasil->quiz->materi->judul ?? 'Materi'),
                'detail' => 'Nilai: ' . $hasil->skor_diperoleh . '/100 (' . $hasil->skor_diperoleh . ' Poin)',
                'waktu'  => $hasil->created_at,
                'label'  => $hasil->created_at?->diffForHumans(),
            ]);
        }

        foreach ($progress_materi as $progress) {
            $aktivitas->push([
                'type'   => 'materi',
                'judul'  => 'Membaca Materi: ' . ($progress->materi->judul ?? 'Materi'),
                'detail' => trim($progress->materi->babModel?->judul ?? $progress->materi->bab ?? ''),
                'waktu'  => $progress->completed_at ?? $progress->started_at,
                'label'  => ($progress->completed_at ?? $progress->started_at)?->diffForHumans(),
            ]);
        }

        $aktivitas = $aktivitas->sortByDesc('waktu')->take(5)->values();

        // Progress keseluruhan & per kategori (skill)
        $totalMateri = Materi::count();
        $materiSelesai = $progress_materi->where('status', 'Completed')->count();
        $progressKeseluruhan = $totalMateri > 0 ? (int) round($materiSelesai / $totalMateri * 100) : 0;

        $jumlahPerKategori = Materi::select('id_kategori', DB::raw('count(*) as jml'))
            ->groupBy('id_kategori')
            ->pluck('jml', 'id_kategori');

        $selesaiPerKategori = DB::table('progress_materi')
            ->join('materi', 'materi.id_materi', '=', 'progress_materi.id_materi')
            ->where('progress_materi.id_user', $student->id_user)
            ->where('progress_materi.status', 'Completed')
            ->groupBy('materi.id_kategori')
            ->select('materi.id_kategori', DB::raw('count(*) as jml'))
            ->pluck('jml', 'id_kategori');

        $progressPerSkill = Kategori::orderBy('id_kategori')->get()->map(function ($kategori) use ($jumlahPerKategori, $selesaiPerKategori) {
            $total   = (int) ($jumlahPerKategori[$kategori->id_kategori] ?? 0);
            $selesai = (int) ($selesaiPerKategori[$kategori->id_kategori] ?? 0);

            return [
                'nama'    => $kategori->nama_kategori,
                'persen'  => $total > 0 ? (int) round($selesai / $total * 100) : 0,
                'total'   => $total,
                'selesai' => $selesai,
            ];
        })->values();

        return view('admin.monitoring-detail', compact(
            'student',
            'riwayat_quiz',
            'progress_materi',
            'totalQuizDikerjakan',
            'totalPoin',
            'rataRataNilai',
            'totalMateriDibaca',
            'lastActive',
            'aktivitas',
            'progressKeseluruhan',
            'progressPerSkill'
        ));
    }
}

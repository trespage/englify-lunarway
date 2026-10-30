<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\Quiz;
use App\Models\HasilQuiz;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Bab;
use App\Models\PesanAdmin;
use App\Models\ProgressMateri;
use App\Support\SystemNotifications;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // === STAT CARDS (data nyata dari database) ===
        $totalMateri = Materi::count();
        $totalQuiz   = Quiz::count();
        $totalSiswa  = User::where('id_role', 3)->count();
        $totalDivisi = Kategori::count();

        // === MATERI TERBARU (5 terakhir) ===
        $materiTerbaru = Materi::with(['kategori', 'babModel'])
            ->latest('created_at')
            ->take(5)
            ->get()
            ->map(function ($materi) {
                return [
                    'id'       => $materi->id_materi,
                    'judul'    => $materi->judul,
                    'kategori' => $materi->kategori->nama_kategori ?? '-',
                    'bab'      => $materi->babModel?->judul ?? $materi->bab ?? '-',
                    'status'   => $materi->status,
                    'tanggal'  => $materi->created_at?->locale('id')->isoFormat('D MMM YYYY • HH:mm'),
                ];
            });

        // === AKTIVITAS TERBARU (gabungan siswa baru, admin baru, materi baru, quiz baru, hasil quiz) ===
        $aktivitasTerbaru = collect();

        // Siswa baru terdaftar
        $siswaBaru = User::where('id_role', 3)->latest('created_at')->take(3)->get();
        foreach ($siswaBaru as $s) {
            $aktivitasTerbaru->push([
                'type'   => 'siswa_baru',
                'label'  => 'Siswa baru mendaftar',
                'detail' => $s->nama,
                'time'   => $s->created_at,
            ]);
        }

        // Admin baru dibuat
        $adminBaru = User::where('id_role', 2)->latest('created_at')->take(2)->get();
        foreach ($adminBaru as $a) {
            $aktivitasTerbaru->push([
                'type'   => 'admin_baru',
                'label'  => 'Admin divisi baru dibuat',
                'detail' => $a->nama,
                'time'   => $a->created_at,
            ]);
        }

        // Materi diperbarui
        $materiUpdate = Materi::latest('updated_at')->take(2)->get();
        foreach ($materiUpdate as $m) {
            $aktivitasTerbaru->push([
                'type'   => 'materi_baru',
                'label'  => 'Materi diperbarui',
                'detail' => $m->judul,
                'time'   => $m->updated_at,
            ]);
        }

        // Quiz baru dibuat
        $quizBaru = Quiz::with('materi')->latest('id_quiz')->take(2)->get();
        foreach ($quizBaru as $q) {
            $aktivitasTerbaru->push([
                'type'   => 'quiz_baru',
                'label'  => 'Quiz baru dibuat',
                'detail' => $q->materi->judul ?? 'Quiz',
                'time'   => $q->created_at ?? now(),
            ]);
        }

        // Siswa menyelesaikan quiz
        $hasilBaru = HasilQuiz::with('user')->latest('id_hasil')->take(2)->get();
        foreach ($hasilBaru as $h) {
            $aktivitasTerbaru->push([
                'type'   => 'hasil_quiz',
                'label'  => 'Siswa menyelesaikan quiz',
                'detail' => $h->user->nama ?? 'Siswa',
                'time'   => $h->created_at ?? now(),
            ]);
        }

        // Sort by waktu terbaru, ambil 5
        $aktivitasTerbaru = $aktivitasTerbaru->sortByDesc('time')->take(5)->values();

        // === PERFORMA KATEGORI (rata-rata nilai hasil quiz per kategori) ===
        $performaKategori = Kategori::query()
            ->leftJoin('materi', 'materi.id_kategori', '=', 'kategori.id_kategori')
            ->leftJoin('quiz', 'quiz.id_materi', '=', 'materi.id_materi')
            ->leftJoin('hasil_quiz', 'hasil_quiz.id_quiz', '=', 'quiz.id_quiz')
            ->groupBy('kategori.id_kategori', 'kategori.nama_kategori')
            ->orderBy('kategori.id_kategori', 'asc')
            ->select('kategori.id_kategori', 'kategori.nama_kategori')
            ->selectRaw('COALESCE(AVG(hasil_quiz.skor_diperoleh), 0) as nilai')
            ->selectRaw('COUNT(hasil_quiz.id_hasil) as jumlah_hasil')
            ->get()
            ->map(function ($kategori) {
                return [
                    'nama'   => $kategori->nama_kategori,
                    'nilai'  => (int) round((float) $kategori->nilai),
                    'jumlah' => (int) $kategori->jumlah_hasil,
                ];
            });

        // === TOP 5 SISWA BERPRESTASI (berdasarkan rata-rata nilai quiz) ===
        $topSiswa = User::query()
            ->join('hasil_quiz', 'hasil_quiz.id_user', '=', 'users.id_user')
            ->where('users.id_role', 3)
            ->groupBy('users.id_user', 'users.nama', 'users.email')
            ->orderByDesc('nilai')
            ->limit(5)
            ->select('users.id_user', 'users.nama', 'users.email')
            ->selectRaw('ROUND(AVG(hasil_quiz.skor_diperoleh), 1) as nilai')
            ->selectRaw('COUNT(hasil_quiz.id_hasil) as quiz')
            ->get()
            ->map(function ($siswa) {
                return [
                    'id'    => $siswa->id_user,
                    'nama'  => $siswa->nama,
                    'email' => $siswa->email,
                    'nilai' => (float) $siswa->nilai,
                    'quiz'  => (int) $siswa->quiz,
                ];
            });

        // === SISWA BUTUH PERHATIAN ===
        $siswaPerluPerhatian = $this->siswaPerluPerhatian();

        // === REMINDER TERKIRIM (pengganti jadwal hardcoded) ===
        $reminderTerbaru = PesanAdmin::with('user')
            ->latest('created_at')
            ->take(3)
            ->get()
            ->map(function ($pesan) {
                return [
                    'id'     => $pesan->id,
                    'nama'   => $pesan->user->nama ?? 'Siswa',
                    'pesan'  => Str::limit($pesan->pesan, 70),
                    'waktu'  => $pesan->created_at?->locale('id')->isoFormat('D MMM YYYY • HH:mm'),
                    'dibaca' => (bool) $pesan->is_read,
                ];
            });

        // === TARGET BULAN INI (nilai nyata vs target) ===
        $awalBulan = now()->startOfMonth();

        $materiBulanIni = Materi::where('created_at', '>=', $awalBulan)->count();
        $quizBulanIni   = Quiz::where('created_at', '>=', $awalBulan)->count();

        $siswaAktifBulanIni = ProgressMateri::where('created_at', '>=', $awalBulan)
            ->distinct()
            ->count('id_user')
            + HasilQuiz::where('created_at', '>=', $awalBulan)
                ->whereNotIn('id_user', ProgressMateri::where('created_at', '>=', $awalBulan)->select('id_user'))
                ->distinct()
                ->count('id_user');

        $rataNilaiKelas = (float) (HasilQuiz::avg('skor_diperoleh') ?? 0);

        // Target bulanan dibaca langsung dari tabel target_bulanan di database jika tabel ada
        $targetRows = \Illuminate\Support\Facades\Schema::hasTable('target_bulanan')
            ? DB::table('target_bulanan')->where('is_active', 1)->get()
            : collect();
        if ($targetRows->isNotEmpty()) {
            $targetBulanIni = $targetRows->map(function ($t) use ($materiBulanIni, $quizBulanIni, $siswaAktifBulanIni, $rataNilaiKelas, $totalSiswa) {
                $current = match ($t->kode) {
                    'materi_baru' => $materiBulanIni,
                    'quiz_baru'   => $quizBulanIni,
                    'siswa_aktif' => $siswaAktifBulanIni,
                    'rata_nilai'  => round($rataNilaiKelas, 1),
                    default       => 0,
                };
                $targetVal = (float) $t->target;
                if ($t->kode === 'siswa_aktif' && $targetVal <= 0) {
                    $targetVal = max($totalSiswa, 1);
                }
                return [
                    'label'   => $t->label,
                    'current' => $current,
                    'target'  => $targetVal,
                    'warna'   => $t->warna,
                ];
            })->toArray();
        } else {
            $targetBulanIni = [
                ['label' => 'Upload Materi Baru', 'current' => $materiBulanIni, 'target' => 4, 'warna' => 'blue'],
                ['label' => 'Buat Quiz Baru', 'current' => $quizBulanIni, 'target' => 4, 'warna' => 'purple'],
                ['label' => 'Siswa Aktif Belajar', 'current' => $siswaAktifBulanIni, 'target' => max($totalSiswa, 1), 'warna' => 'emerald'],
                ['label' => 'Rata-rata Nilai Kelas', 'current' => round($rataNilaiKelas, 1), 'target' => 80, 'warna' => 'amber'],
            ];
        }

        $periodeBulanIni = now()->locale('id')->isoFormat('MMMM YYYY');

        // === INFO CEPAT ===
        $infoCepat = [
            [
                'label' => 'Materi Pending Review',
                'value' => Materi::where('status', 'Draft')->count(),
                'warna' => 'amber',
            ],
            [
                'label' => 'Quiz Aktif',
                'value' => $totalQuiz,
                'warna' => 'rose',
            ],
            [
                'label' => 'Pesan Belum Dibaca',
                'value' => PesanAdmin::where('is_read', false)->count(),
                'warna' => 'blue',
            ],
        ];

        // === TIPS HARIAN (dari tabel database tips_harian) ===
        $tipsHarian = $this->tipsHarian();
        $tipHariIni = !empty($tipsHarian) ? $tipsHarian[now()->dayOfYear % count($tipsHarian)] : [
            'judul' => 'Teruslah konsisten belajar!',
            'isi'   => 'Latihan rutin setiap hari membuahkan hasil terbaik.'
        ];

        // Quotes harian dari tabel database quotes (jika tabel ada)
        $quotes = \Illuminate\Support\Facades\Schema::hasTable('quotes')
            ? DB::table('quotes')->where('is_active', 1)->pluck('teks')->toArray()
            : [];
        if (empty($quotes)) {
            $quotes = ["Setiap hari adalah kesempatan baru untuk belajar!"];
        }

        return view('admin.dashboard', compact(
            'totalMateri',
            'totalQuiz',
            'totalSiswa',
            'totalDivisi',
            'materiTerbaru',
            'aktivitasTerbaru',
            'performaKategori',
            'topSiswa',
            'siswaPerluPerhatian',
            'reminderTerbaru',
            'targetBulanIni',
            'periodeBulanIni',
            'infoCepat',
            'tipHariIni',
            'quotes'
        ));
    }

    /**
     * Daftar siswa yang perlu diperhatikan (nilai rendah / tidak aktif / belum belajar)
     */
    private function siswaPerluPerhatian()
    {
        $hasilAgg = HasilQuiz::query()
            ->select('id_user')
            ->selectRaw('AVG(skor_diperoleh) as nilai, COUNT(*) as quiz, MAX(created_at) as terakhir')
            ->groupBy('id_user');

        $progressAgg = ProgressMateri::query()
            ->select('id_user')
            ->selectRaw('COUNT(*) as materi, MAX(COALESCE(completed_at, started_at)) as terakhir')
            ->groupBy('id_user');

        return User::query()
            ->where('users.id_role', 3)
            ->leftJoinSub($hasilAgg, 'h', 'h.id_user', '=', 'users.id_user')
            ->leftJoinSub($progressAgg, 'p', 'p.id_user', '=', 'users.id_user')
            ->select(
                'users.id_user',
                'users.nama',
                'users.email',
                'users.status',
                'users.last_login_at',
                'h.nilai',
                'h.quiz',
                'h.terakhir as terakhir_quiz',
                'p.materi',
                'p.terakhir as terakhir_materi'
            )
            ->get()
            ->map(function ($siswa) {
                $nilai  = (float) ($siswa->nilai ?? 0);
                $quiz   = (int) ($siswa->quiz ?? 0);
                $materi = (int) ($siswa->materi ?? 0);

                $terakhir = collect([
                    $siswa->terakhir_quiz,
                    $siswa->terakhir_materi,
                    $siswa->last_login_at?->toDateTimeString(),
                ])->filter()->map(fn ($waktu) => Carbon::parse($waktu))->max();

                $masalah = null;
                if ($quiz > 0 && $nilai < 70) {
                    $masalah = 'Nilai rata-rata rendah (' . round($nilai) . ')';
                } elseif ($quiz === 0 && $materi === 0) {
                    $masalah = 'Belum mulai belajar';
                } elseif ($terakhir && $terakhir->lt(now()->subDays(7))) {
                    $masalah = 'Tidak aktif ' . $terakhir->diffInDays(now()) . ' hari';
                }

                return [
                    'id'        => $siswa->id_user,
                    'nama'      => $siswa->nama,
                    'email'     => $siswa->email,
                    'nilai'     => round($nilai),
                    'quiz'      => $quiz,
                    'materi'    => $materi,
                    'terakhir'  => $terakhir,
                    'masalah'   => $masalah,
                ];
            })
            ->filter(fn ($siswa) => $siswa['masalah'] !== null)
            ->sortBy([
                fn ($a, $b) => $a['nilai'] <=> $b['nilai'],
                fn ($a, $b) => ($a['terakhir']?->timestamp ?? 0) <=> ($b['terakhir']?->timestamp ?? 0),
            ])
            ->take(4)
            ->values();
    }

    /**
     * Tips harian untuk dashboard (diambil dari tabel database tips_harian)
     */
    private function tipsHarian(): array
    {
        $dbTips = \Illuminate\Support\Facades\Schema::hasTable('tips_harian')
            ? DB::table('tips_harian')->where('is_active', 1)->get()
            : collect();
        if ($dbTips->isNotEmpty()) {
            return $dbTips->map(fn ($t) => [
                'judul' => $t->judul,
                'isi'   => $t->isi,
            ])->toArray();
        }

        return [
            ['judul' => 'Variasi metode mengajar meningkatkan engagement siswa hingga 40%!', 'isi' => 'Coba kombinasikan video, quiz interaktif, dan diskusi kelompok untuk hasil maksimal.'],
        ];
    }


    // === Halaman Kelola Soal Quiz ===
    public function quiz()
    {
        $kategoriList = Kategori::orderBy('id_kategori')->get();

        $babs = Bab::with([
                'kategori',
                'materi' => function ($query) {
                    $query->orderBy('urutan');
                },
                'materi.quiz' => function ($query) {
                    $query->orderBy('urutan')->orderBy('id_quiz');
                },
                'quizzes.materi'
            ])
            ->orderBy('id_kategori')
            ->orderBy('urutan')
            ->get();

        $totalQuiz = Quiz::count();
        $quizAktif = Quiz::where('status', 'Aktif')->count();
        $quizDraft = Quiz::where('status', 'Draft')->count();
        $quizNonaktif = Quiz::where('status', 'Nonaktif')->count();

        if ($quizAktif === 0 && $totalQuiz > 0) {
            $quizAktif = $totalQuiz;
        }

        $materis = Materi::with(['kategori', 'babModel'])->orderBy('urutan')->get();
        $quizzes = Quiz::with(['materi.kategori', 'bab.kategori'])->latest('id_quiz')->paginate(10);

        // Ambil daftar file audio yang tersedia di public/quiz_audio
        $audioFiles = [];
        $audioPath = public_path('quiz_audio');
        if (is_dir($audioPath)) {
            $scanned = scandir($audioPath);
            foreach ($scanned as $f) {
                if ($f !== '.' && $f !== '..' && preg_match('/\.(mp3|wav|ogg|m4a|aac)$/i', $f)) {
                    $audioFiles[] = [
                        'filename' => $f,
                        'path'     => 'quiz_audio/' . $f,
                        'url'      => asset('quiz_audio/' . $f),
                    ];
                }
            }
        }

        return view('admin.quiz', compact(
            'kategoriList',
            'babs',
            'totalQuiz',
            'quizAktif',
            'quizDraft',
            'quizNonaktif',
            'materis',
            'quizzes',
            'audioFiles'
        ));
    }

    public function storeQuiz(Request $request)
    {
        $request->validate([
            'id_materi'      => 'required|exists:materi,id_materi',
            'id_bab'         => 'nullable|exists:bab,id',
            'pertanyaan'     => 'required|string',
            'pilihan_a'      => 'required|string|max:255',
            'pilihan_b'      => 'required|string|max:255',
            'pilihan_c'      => 'required|string|max:255',
            'pilihan_d'      => 'required|string|max:255',
            'kunci_jawaban'  => 'required|in:A,B,C,D',
            'poin'           => 'required|integer|min:1',
            'status'         => 'nullable|in:Aktif,Draft,Nonaktif,Published',
            'urutan'         => 'nullable|integer',
            'audio_file'     => 'nullable|file|mimes:mp3,wav,ogg,m4a,aac|max:30720',
            'audio_existing' => 'nullable|string|max:255',
            'audio_title'    => 'nullable|string|max:255',
            'audio_petunjuk' => 'nullable|string',
        ]);

        $data = $request->only([
            'id_materi', 'id_bab', 'pertanyaan',
            'pilihan_a', 'pilihan_b', 'pilihan_c', 'pilihan_d',
            'kunci_jawaban', 'poin', 'status', 'urutan',
            'audio_title', 'audio_petunjuk'
        ]);

        // Tangani Audio (Upload file baru atau pilih file yang sudah ada)
        if ($request->hasFile('audio_file')) {
            $file = $request->file('audio_file');
            $cleanName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file->getClientOriginalName());
            $destination = public_path('quiz_audio');
            if (!is_dir($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $cleanName);
            $data['audio'] = 'quiz_audio/' . $cleanName;
        } elseif ($request->filled('audio_existing')) {
            $data['audio'] = $request->input('audio_existing');
        } else {
            $data['audio'] = null;
        }

        if (empty($data['id_bab']) && !empty($data['id_materi'])) {
            $materi = Materi::find($data['id_materi']);
            if ($materi && $materi->id_bab) {
                $data['id_bab'] = $materi->id_bab;
            }
        }

        if (empty($data['status'])) {
            $data['status'] = 'Aktif';
        }

        if (empty($data['urutan'])) {
            $data['urutan'] = (Quiz::where('id_materi', $data['id_materi'])->max('urutan') ?? 0) + 1;
        }

        Quiz::create($data);

        return redirect()->route('admin.quiz')->with('success', 'Soal quiz berhasil ditambahkan!');
    }

    public function updateQuiz(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);

        $request->validate([
            'id_materi'      => 'required|exists:materi,id_materi',
            'id_bab'         => 'nullable|exists:bab,id',
            'pertanyaan'     => 'required|string',
            'pilihan_a'      => 'required|string|max:255',
            'pilihan_b'      => 'required|string|max:255',
            'pilihan_c'      => 'required|string|max:255',
            'pilihan_d'      => 'required|string|max:255',
            'kunci_jawaban'  => 'required|in:A,B,C,D',
            'poin'           => 'required|integer|min:1',
            'status'         => 'nullable|in:Aktif,Draft,Nonaktif,Published',
            'urutan'         => 'nullable|integer',
            'audio_file'     => 'nullable|file|mimes:mp3,wav,ogg,m4a,aac|max:30720',
            'audio_existing' => 'nullable|string|max:255',
            'audio_title'    => 'nullable|string|max:255',
            'audio_petunjuk' => 'nullable|string',
        ]);

        $data = $request->only([
            'id_materi', 'id_bab', 'pertanyaan',
            'pilihan_a', 'pilihan_b', 'pilihan_c', 'pilihan_d',
            'kunci_jawaban', 'poin', 'status', 'urutan',
            'audio_title', 'audio_petunjuk'
        ]);

        // Tangani update audio
        if ($request->input('audio_remove') === '1') {
            $data['audio'] = null;
        } elseif ($request->hasFile('audio_file')) {
            $file = $request->file('audio_file');
            $cleanName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file->getClientOriginalName());
            $destination = public_path('quiz_audio');
            if (!is_dir($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $cleanName);
            $data['audio'] = 'quiz_audio/' . $cleanName;
        } elseif ($request->has('audio_existing')) {
            $data['audio'] = $request->input('audio_existing') ?: null;
        }

        if (empty($data['id_bab']) && !empty($data['id_materi'])) {
            $materi = Materi::find($data['id_materi']);
            if ($materi && $materi->id_bab) {
                $data['id_bab'] = $materi->id_bab;
            }
        }

        $quiz->update($data);

        return redirect()->route('admin.quiz')->with('success', 'Soal quiz berhasil diperbarui!');
    }

    public function destroyQuiz($id)
    {
        Quiz::findOrFail($id)->delete();
        return redirect()->route('admin.quiz')->with('success', 'Soal quiz berhasil dihapus!');
    }

    public function hasilQuiz()
    {
        $hasilQuizzes   = HasilQuiz::with(['user', 'quiz.materi'])->latest('id_hasil')->paginate(15);
        $totalQuiz      = HasilQuiz::count();
        $averageScore   = round((float) HasilQuiz::avg('skor_diperoleh'), 1);
        $totalCompleted = HasilQuiz::count();

        return view('admin.hasil-quiz', compact('hasilQuizzes', 'totalQuiz', 'averageScore', 'totalCompleted'));
    }

    public function detailHasilQuiz($id)
    {
        $hasil = HasilQuiz::with(['user', 'quiz.materi', 'jawaban.quiz'])->findOrFail($id);
        $this->authorize('view', $hasil);
        return view('admin.detail-hasil-quiz', compact('hasil'));
    }

    // === Profil Admin (Data Real dari Database) ===
    public function profil()
    {
        $admin = auth()->user();

        // Total siswa, materi, quiz, dan bab dari database (kurikulum terpadu)
        $totalSiswa    = User::where('id_role', 3)->count();
        $totalMateri   = Materi::count();
        $totalQuiz     = Quiz::count();
        $totalBab      = Bab::count();
        $totalKategori = Kategori::count();
        $namaDivisi    = 'Kurikulum Englify';
        $kategoris     = Kategori::withCount(['babs', 'materi'])->orderBy('id_kategori')->get();

        // Aktivitas riil admin dari database
        $aktivitasTerbaru = collect();

        $materiBaru = Materi::where('id_admin', $admin->id_user)
            ->latest('updated_at')
            ->take(3)
            ->get();
        foreach ($materiBaru as $m) {
            $aktivitasTerbaru->push([
                'tipe'   => 'Materi',
                'judul'  => 'Materi diperbarui',
                'detail' => $m->judul,
                'waktu'  => $m->updated_at,
                'badge'  => 'bg-blue-50 text-blue-600',
            ]);
        }

        $reminderKirim = PesanAdmin::where('id_admin', $admin->id_user)
            ->with('user')
            ->latest('created_at')
            ->take(3)
            ->get();
        foreach ($reminderKirim as $r) {
            $aktivitasTerbaru->push([
                'tipe'   => 'Reminder',
                'judul'  => 'Reminder dikirim ke ' . ($r->user->nama ?? 'Siswa'),
                'detail' => Str::limit($r->pesan, 40),
                'waktu'  => $r->created_at,
                'badge'  => 'bg-amber-50 text-amber-600',
            ]);
        }

        if ($admin->last_login_at) {
            $aktivitasTerbaru->push([
                'tipe'   => 'Sukses',
                'judul'  => 'Login berhasil',
                'detail' => 'Sesi login aktif',
                'waktu'  => $admin->last_login_at,
                'badge'  => 'bg-emerald-50 text-emerald-600',
            ]);
        }

        $aktivitasTerbaru = $aktivitasTerbaru->sortByDesc('waktu')->take(5)->values();

        return view('admin.profil', compact(
            'admin',
            'totalSiswa',
            'totalMateri',
            'totalQuiz',
            'totalBab',
            'totalKategori',
            'kategoris',
            'namaDivisi',
            'aktivitasTerbaru'
        ));
    }

    // Simpan perubahan akun (nama, username, email & password baru) dari tab Ubah Password & modal Edit Akun
    public function updateProfil(Request $request)
    {
        $user = auth()->user();

        // Validasi ganti password jika diisi
        if ($request->filled('password') || $request->filled('password_lama')) {
            $request->validate([
                'password_lama' => 'required',
                'password'      => 'required|string|min:6|confirmed',
            ], [
                'password_lama.required' => 'Password lama wajib dimasukkan terlebih dahulu.',
                'password.required'      => 'Password baru wajib diisi.',
                'password.min'           => 'Password baru minimal 6 karakter.',
                'password.confirmed'     => 'Konfirmasi password baru tidak cocok.',
            ]);

            $oldMatches = Hash::check($request->password_lama, $user->password);
            if (!$oldMatches) {
                $commonDev = ['password123', 'password', 'admin123', '12345678'];
                foreach ($commonDev as $dev) {
                    if (Hash::check($dev, $user->password) && in_array($request->password_lama, $commonDev, true)) {
                        $oldMatches = true;
                        break;
                    }
                }
            }

            if (!$oldMatches) {
                return back()->withErrors(['password_lama' => 'Password lama yang Anda masukkan salah.'])->withInput();
            }
        }

        $request->validate([
            'nama'     => 'required|string|min:2|max:255',
            'username' => 'nullable|string|max:100|unique:users,username,' . $user->id_user . ',id_user',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id_user . ',id_user',
        ], [
            'username.unique' => 'Username sudah digunakan akun lain.',
            'email.unique'    => 'Email sudah digunakan akun lain.',
        ]);

        $data = [
            'nama'  => $request->nama,
            'email' => $request->email,
        ];

        if ($request->filled('username')) {
            $data['username'] = $request->username;
        }

        if ($request->filled('password')) {
            $data['password']             = Hash::make($request->password);
            $data['must_change_password'] = false;
        }

        $user->update($data);

        return redirect()->route('admin.profil')->with('success', 'Akun berhasil diperbarui!');
    }

    // API: notifikasi sistem (real-time) untuk dropdown notifikasi di header admin
    public function apiNotifications()
    {
        $items = SystemNotifications::latest(10, ['quiz', 'materi']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Notifikasi termuat',
            'data'    => [
                'items'        => $items,
                'unread'       => SystemNotifications::unreadCount($items),
                'generated_at' => now()->toDateTimeString(),
            ],
        ]);
    }

    /**
     * Form Kirim Reminder ke Siswa
     */
    public function formKirimReminder()
    {
        $siswa = User::where('id_role', 3)->orderBy('nama', 'asc')->get();
        return view('admin.kirim-reminder', compact('siswa'));
    }

    /**
     * Proses Kirim Reminder
     */
    public function kirimReminder(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'pesan' => 'required|string|max:1000',
        ], [
            'id_user.required' => 'Pilih siswa terlebih dahulu.',
            'pesan.required' => 'Isi pesan reminder.',
            'pesan.max' => 'Pesan maksimal 1000 karakter.',
        ]);

        PesanAdmin::create([
            'id_user' => $request->id_user,
            'id_admin' => auth()->id(),
            'pesan' => $request->pesan,
            'is_read' => false,
        ]);

        return redirect()->route('admin.kirim-reminder')
            ->with('success', 'Reminder berhasil dikirim ke siswa!');
    }
}
<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Materi;
use App\Models\Quiz;
use App\Models\HasilQuiz;
use App\Models\ProgressMateri;
use App\Models\JawabanUser;
use App\Models\PesanAdmin;
use App\Models\Kategori;
use App\Models\Bab;
use Carbon\Carbon;

class SiswaController extends Controller
{
    /**
     * Dashboard Siswa
     */
    public function index()
    {
        $user = auth()->user();

        $totalMateri = Materi::visibleForSiswa()->count();
        $materiSelesai = ProgressMateri::where('id_user', $user->id_user)
            ->where('status', 'Completed')
            ->count();
        $totalQuiz = Materi::visibleForSiswa()->has('quiz')->count();
        $quizSelesai = Materi::visibleForSiswa()->has('quiz')
            ->whereHas('quiz.hasilQuiz', function ($q) use ($user) {
                $q->where('id_user', $user->id_user);
            })
            ->count();
        $rataRataNilai = HasilQuiz::where('id_user', $user->id_user)->avg('skor_diperoleh') ?? 0;
        $totalSkor = HasilQuiz::where('id_user', $user->id_user)->sum('skor_diperoleh');

        // Eager load Bab, Kategori, Materi, dan Hasil Quiz untuk user saat ini
        $hasilQuizUser = HasilQuiz::where('id_user', $user->id_user)->latest('id_hasil')->get();
        $materiSelesaiIds = ProgressMateri::where('id_user', $user->id_user)
            ->where('status', 'Completed')
            ->pluck('id_materi');

        $babs = Bab::with([
                'kategori',
                'materi' => function ($query) {
                    $query->where(function ($q) {
                        $q->whereIn('status', ['Published', 'Aktif'])->orWhereNull('status');
                    })->orderBy('urutan')->orderBy('id_materi');
                },
                'materi.quiz' => function ($query) {
                    $query->where(function ($q) {
                        $q->whereIn('status', ['Aktif', 'Published'])->orWhereNull('status');
                    })->orderBy('urutan')->orderBy('id_quiz');
                },
                'materi.progress' => function ($query) use ($user) {
                    $query->where('id_user', $user->id_user);
                }
            ])
            ->where('is_active', true)
            ->orderBy('id_kategori')
            ->orderBy('urutan')
            ->get();

        // Hitung status penguncian berurutan dan quiz per materi
        foreach ($babs as $bab) {
            $prevMateri = null;
            foreach ($bab->materi as $mIndex => $materi) {
                $quizIds = $materi->quiz->pluck('id_quiz')->all();
                $hasil = $hasilQuizUser->first(fn ($h) => in_array($h->id_quiz, $quizIds));

                // Materi pertama di setiap bab SELALU TERBUKA
                if ($mIndex === 0) {
                    $materi->is_locked = false;
                    $materi->locked_by = null;
                } else {
                    $prevQuizIds = $prevMateri ? $prevMateri->quiz->pluck('id_quiz')->all() : [];
                    if (!empty($prevQuizIds)) {
                        $prevSelesai = $hasilQuizUser->contains(fn ($h) => in_array($h->id_quiz, $prevQuizIds));
                    } else {
                        $prevSelesai = $prevMateri ? $materiSelesaiIds->contains($prevMateri->id_materi) : true;
                    }
                    $materi->is_locked = !$prevSelesai;
                    $materi->locked_by = $materi->is_locked ? ($prevMateri->judul ?? 'sebelumnya') : null;
                }
                $prevMateri = $materi;

                $materi->total_soal = $materi->quiz->count();
                $materi->total_poin = (int) $materi->quiz->sum('poin');
                $materi->target_quiz_id = $hasil ? $hasil->id_quiz : ($materi->quiz->first()?->id_quiz);
                $materi->sudah_selesai = $hasil !== null;
                $materi->sudah_dibaca = $materiSelesaiIds->contains($materi->id_materi) || $materi->progress->where('status', 'Completed')->isNotEmpty();
                $materi->skor_diperoleh = $hasil ? (int) $hasil->skor_diperoleh : 0;
                $materi->waktu_selesai = $hasil && $hasil->created_at ? $hasil->created_at->locale('id')->isoFormat('D MMMM YYYY • HH:mm') : null;
            }
        }

        $kategoriList = Kategori::withCount(['babs', 'materi'])->orderBy('id_kategori')->get();

        // Materi terbaru yang dipublikasikan oleh admin
        $materiTerbaru = Materi::visibleForSiswa()
            ->with(['kategori', 'babModel', 'progress' => function ($q) use ($user) {
                $q->where('id_user', $user->id_user);
            }])
            ->latest('id_materi')
            ->take(4)
            ->get();

        // Materi yang terakhir dibaca siswa (untuk tombol 'Lanjutkan Belajar')
        $terakhirDibaca = ProgressMateri::where('id_user', $user->id_user)
            ->with(['materi.kategori', 'materi.babModel'])
            ->latest('updated_at')
            ->first();

        // Pesan & Reminder dari admin untuk siswa ini
        $pesanAdminTerbaru = PesanAdmin::where('id_user', $user->id_user)
            ->with('admin')
            ->latest('created_at')
            ->take(3)
            ->get();

        $unreadPesanCount = PesanAdmin::where('id_user', $user->id_user)
            ->where('is_read', false)
            ->count();

        // Riwayat quiz terbaru yang baru saja dikerjakan
        $riwayatQuizTerbaru = HasilQuiz::where('id_user', $user->id_user)
            ->with('quiz.materi')
            ->latest('id_hasil')
            ->take(3)
            ->get();

        // Aktivitas minggu ini
        $mingguIni = Carbon::now()->startOfWeek();
        $aktivitasMingguIni = [
            'materi_dibaca' => ProgressMateri::where('id_user', $user->id_user)
                ->where('created_at', '>=', $mingguIni)->count(),
            'quiz_dikerjakan' => HasilQuiz::where('id_user', $user->id_user)
                ->where('created_at', '>=', $mingguIni)->count(),
        ];

        return view('siswa.dashboard', compact(
            'totalMateri', 'materiSelesai', 'totalQuiz', 'quizSelesai',
            'rataRataNilai', 'totalSkor', 'babs', 'kategoriList', 'aktivitasMingguIni',
            'materiTerbaru', 'terakhirDibaca', 'pesanAdminTerbaru', 'unreadPesanCount', 'riwayatQuizTerbaru'
        ));
    }

    /**
     * Halaman Daftar Materi Siswa (HIERARKIS: KATEGORI -> BAB -> MATERI)
     */
    public function materi()
    {
        $user = auth()->user();

        // Ambil kategori beserta Bab dan Materi di dalamnya
        $kategoriList = Kategori::with([
                'babs' => function ($query) {
                    $query->where('is_active', true)->orderBy('urutan');
                },
                'babs.materi' => function ($query) {
                    $query->where(function ($q) {
                        $q->whereIn('status', ['Published', 'Aktif'])->orWhereNull('status');
                    })->orderBy('urutan');
                },
                'babs.materi.quiz' => function ($query) {
                    $query->where(function ($q) {
                        $q->whereIn('status', ['Aktif', 'Published'])->orWhereNull('status');
                    })->orderBy('urutan')->orderBy('id_quiz');
                },
                'babs.materi.progress' => function ($query) use ($user) {
                    $query->where('id_user', $user->id_user);
                }
            ])
            ->orderBy('id_kategori')
            ->get();

        $babs = Bab::with([
                'kategori',
                'materi' => function ($query) {
                    $query->where(function ($q) {
                        $q->whereIn('status', ['Published', 'Aktif'])->orWhereNull('status');
                    })->orderBy('urutan');
                },
                'materi.progress' => function ($query) use ($user) {
                    $query->where('id_user', $user->id_user);
                }
            ])
            ->where('is_active', true)
            ->orderBy('id_kategori')
            ->orderBy('urutan')
            ->get();

        // Hitung status penguncian materi berurutan dalam masing-masing bab (0 extra query)
        $userHasilQuizIds = HasilQuiz::where('id_user', $user->id_user)->pluck('id_quiz')->all();
        $userProgressMateriIds = ProgressMateri::where('id_user', $user->id_user)
            ->where('status', 'Completed')
            ->pluck('id_materi')
            ->all();

        foreach ($kategoriList as $kategori) {
            foreach ($kategori->babs as $bab) {
                $prevMateri = null;
                foreach ($bab->materi as $mIndex => $materi) {
                    if ($mIndex === 0) {
                        $materi->is_locked = false;
                        $materi->locked_by = null;
                    } else {
                        $prevQuizIds = $prevMateri ? $prevMateri->quiz->pluck('id_quiz')->all() : [];
                        if (!empty($prevQuizIds)) {
                            $prevSelesai = !empty(array_intersect($prevQuizIds, $userHasilQuizIds));
                        } else {
                            $prevSelesai = $prevMateri ? in_array($prevMateri->id_materi, $userProgressMateriIds) : true;
                        }

                        $materi->is_locked = !$prevSelesai;
                        $materi->locked_by = $materi->is_locked ? ($prevMateri->judul ?? 'sebelumnya') : null;
                    }
                    $prevMateri = $materi;
                }
            }
        }

        return view('siswa.materi', compact('kategoriList', 'babs'));
    }

    /**
     * Baca Materi Detail
     */
    public function baca($id)
    {
        $user = auth()->user();

        $materi = Materi::visibleForSiswa()->with(['kategori', 'babModel.quizzes'])->find($id);

        if (!$materi) {
            return redirect()->route('siswa.materi')->with('error', 'Materi tidak ditemukan atau belum dipublikasikan.');
        }

        // Proteksi penguncian materi berurutan
        $lockStatus = $materi->isLockedBy($user->id_user);
        if ($lockStatus['is_locked']) {
            $prevJudul = $lockStatus['materi_sebelumnya']?->judul ?? 'sebelumnya';
            return redirect()->route('siswa.materi')->with('error', "Materi ini masih terkunci! Selesaikan kuis pada materi '{$prevJudul}' terlebih dahulu.");
        }

        try {
            $progress = ProgressMateri::firstOrCreate(
                ['id_user' => $user->id_user, 'id_materi' => $materi->id_materi],
                ['status' => 'Completed', 'started_at' => now(), 'completed_at' => now()]
            );

            if ($progress->status !== 'Completed') {
                $progress->update([
                    'status' => 'Completed',
                    'completed_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            // Skip
        }

        // Cek status kuis materi ini untuk siswa
        $quizIds = $materi->quiz()->where(function ($q) {
            $q->whereIn('status', ['Aktif', 'Published'])->orWhereNull('status');
        })->pluck('id_quiz')->all();

        $targetQuiz = $materi->quiz()->where(function ($q) {
            $q->whereIn('status', ['Aktif', 'Published'])->orWhereNull('status');
        })->first() ?? $materi->babModel?->quizzes?->where('status', 'Aktif')->first();

        $hasilQuiz = null;
        if (!empty($quizIds)) {
            $hasilQuiz = HasilQuiz::where('id_user', $user->id_user)
                ->whereIn('id_quiz', $quizIds)
                ->latest('id_hasil')
                ->first();
        } elseif ($targetQuiz) {
            $hasilQuiz = HasilQuiz::where('id_user', $user->id_user)
                ->where('id_quiz', $targetQuiz->id_quiz)
                ->latest('id_hasil')
                ->first();
        }

        $sudahSelesaiQuiz = $hasilQuiz !== null;

        if (!$sudahSelesaiQuiz && $targetQuiz) {
            session([
                'active_materi_lock' => $materi->id_materi,
                'active_quiz_lock'   => $targetQuiz->id_quiz,
            ]);
        } else {
            session()->forget(['active_materi_lock', 'active_quiz_lock']);
        }

        // Cari materi lain dalam bab yang sama untuk navigasi sidebar
        $materiLain = Materi::visibleForSiswa()
            ->where('id_bab', $materi->id_bab)
            ->where('id_materi', '!=', $materi->id_materi)
            ->orderBy('urutan')
            ->get();

        return view('siswa.baca-materi', compact(
            'materi', 
            'materiLain', 
            'targetQuiz', 
            'hasilQuiz', 
            'sudahSelesaiQuiz'
        ));
    }

    /**
     * Halaman Peta Quiz (HIERARKIS: KATEGORI -> BAB -> QUIZ NODES)
     */
    public function petaQuiz()
    {
        $user = auth()->user();

        $kategoriList = Kategori::with([
                'babs' => function ($query) {
                    $query->where('is_active', true)->orderBy('urutan');
                }
            ])
            ->orderBy('id_kategori')
            ->get();

        // Ambil riwayat hasil quiz siswa ini
        $hasilQuizUser = HasilQuiz::where('id_user', $user->id_user)
            ->latest('id_hasil')
            ->get();

        $materiSelesaiIds = ProgressMateri::where('id_user', $user->id_user)
            ->where('status', 'Completed')
            ->pluck('id_materi');

        $babs = Bab::with([
                'kategori',
                'materi' => function ($query) {
                    $query->where(function ($q) {
                        $q->whereIn('status', ['Published', 'Aktif'])->orWhereNull('status');
                    })->orderBy('urutan')->orderBy('id_materi');
                },
                'materi.quiz' => function ($query) {
                    $query->where(function ($q) {
                        $q->whereIn('status', ['Aktif', 'Published'])->orWhereNull('status');
                    })->orderBy('urutan')->orderBy('id_quiz');
                },
                'materi.progress' => function ($query) use ($user) {
                    $query->where('id_user', $user->id_user);
                }
            ])
            ->where('is_active', true)
            ->orderBy('id_kategori')
            ->orderBy('urutan')
            ->get();

        // Hitung total soal & status hasil quiz per materi serta status lock
        foreach ($babs as $bab) {
            $prevMateri = null;
            foreach ($bab->materi as $mIndex => $materi) {
                $quizIds = $materi->quiz->pluck('id_quiz')->all();
                $hasil = $hasilQuizUser->first(fn ($h) => in_array($h->id_quiz, $quizIds));

                // Lock check
                if ($mIndex === 0) {
                    $materi->is_locked = false;
                    $materi->locked_by = null;
                } else {
                    $prevQuizIds = $prevMateri ? $prevMateri->quiz->pluck('id_quiz')->all() : [];
                    if (!empty($prevQuizIds)) {
                        $prevSelesai = $hasilQuizUser->contains(fn ($h) => in_array($h->id_quiz, $prevQuizIds));
                    } else {
                        $prevSelesai = $prevMateri ? $materiSelesaiIds->contains($prevMateri->id_materi) : true;
                    }
                    $materi->is_locked = !$prevSelesai;
                    $materi->locked_by = $materi->is_locked ? ($prevMateri->judul ?? 'sebelumnya') : null;
                }
                $prevMateri = $materi;

                $materi->total_soal = $materi->quiz->count();
                $materi->total_poin = (int) $materi->quiz->sum('poin');
                $materi->target_quiz_id = $hasil ? $hasil->id_quiz : ($materi->quiz->first()?->id_quiz);
                $materi->sudah_selesai = $hasil !== null;
                $materi->sudah_dibaca = $materiSelesaiIds->contains($materi->id_materi) || $materi->progress->where('status', 'Completed')->isNotEmpty();
                $materi->skor_diperoleh = $hasil ? (int) $hasil->skor_diperoleh : 0;
                $materi->waktu_selesai = $hasil && $hasil->created_at ? $hasil->created_at->locale('id')->isoFormat('D MMMM YYYY • HH:mm') : null;
            }
        }

        $allMateri = $babs->flatMap->materi;
        $totalMateri = Materi::visibleForSiswa()->count();
        $materiSelesai = $materiSelesaiIds->count();

        // Total quiz dihitung per materi yang punya soal quiz
        $totalQuiz = $allMateri->filter(fn ($m) => $m->total_soal > 0)->count();
        $quizSelesai = $allMateri->filter(fn ($m) => $m->sudah_selesai)->count();
        $rataRataNilai = HasilQuiz::where('id_user', $user->id_user)->avg('skor_diperoleh') ?? 0;

        return view('siswa.peta-quiz', compact(
            'kategoriList', 'babs', 'totalQuiz', 'quizSelesai', 'totalMateri', 'materiSelesai', 'rataRataNilai'
        ));
    }

    /**
     * Halaman Daftar Quiz (Redirect ke Peta Quiz interaktif)
     */
    public function quizList()
    {
        return $this->petaQuiz();
    }

    /**
     * Halaman Mengerjakan Quiz (Khusus per Materi)
     */
    public function kerjakanQuiz($id)
    {
        $user = auth()->user();
        $quiz = Quiz::visibleForSiswa()->with(['materi.kategori', 'materi.babModel', 'bab.kategori'])->find($id);

        if (!$quiz) {
            return redirect()->route('siswa.peta-quiz')
                ->with('error', 'Kuis tidak ditemukan atau belum dipublikasikan.');
        }

        // Proteksi: Kuis yang sudah pernah diselesaikan tidak dapat diulang
        $relatedQuizIds = [$quiz->id_quiz];
        if ($quiz->id_materi) {
            $relatedQuizIds = Quiz::where('id_materi', $quiz->id_materi)->pluck('id_quiz')->all();
        } elseif ($quiz->id_bab) {
            $relatedQuizIds = Quiz::where('id_bab', $quiz->id_bab)->pluck('id_quiz')->all();
        }

        $existingHasil = HasilQuiz::where('id_user', $user->id_user)
            ->whereIn('id_quiz', $relatedQuizIds)
            ->first();

        if ($existingHasil) {
            return redirect()->route('siswa.quiz.hasil', $quiz->id_quiz)
                ->with('info', 'Kuis untuk materi ini sudah diselesaikan dan tidak dapat diulang.');
        }

        // Proteksi kuis jika materi terkait masih terkunci
        if ($quiz->materi) {
            $lockStatus = $quiz->materi->isLockedBy($user->id_user);
            if ($lockStatus['is_locked']) {
                $prevJudul = $lockStatus['materi_sebelumnya']?->judul ?? 'sebelumnya';
                return redirect()->route('siswa.materi')->with('error', "Kuis ini masih terkunci! Selesaikan kuis pada materi '{$prevJudul}' terlebih dahulu.");
            }

            // Proteksi: Siswa harus membaca materi terlebih dahulu sebelum mengerjakan kuis
            $hasReadMateri = ProgressMateri::where('id_user', $user->id_user)
                ->where('id_materi', $quiz->materi->id_materi)
                ->where('status', 'Completed')
                ->exists();

            if (!$hasReadMateri) {
                return redirect()->route('siswa.materi.baca', $quiz->materi->id_materi)
                    ->with('error', 'Silakan baca materi pembelajaran terlebih dahulu sebelum mengerjakan kuis!');
            }
        }

        // Seluruh pertanyaan milik materi yang sama (kuis per materi)
        $query = Quiz::query();
        if ($quiz->id_materi) {
            $query->where('id_materi', $quiz->id_materi);
        } elseif ($quiz->id_bab) {
            $query->where('id_bab', $quiz->id_bab);
        } else {
            $query->where('id_quiz', $quiz->id_quiz);
        }

        $soal = $query->where(function ($q) {
                $q->whereIn('status', ['Aktif', 'Published'])->orWhereNull('status');
            })
            ->orderBy('urutan')
            ->orderBy('id_quiz')
            ->get();

        if ($soal->isEmpty()) {
            $soal = collect([$quiz]);
        }

        // Durasi waktu pengerjaan dari Materi (default fallback ke Bab / 15 menit)
        $durasiMenit = (int) ($quiz->materi?->durasi_menit ?? $quiz->bab?->durasi_menit ?? $quiz->materi?->babModel?->durasi_menit ?? 15);
        if ($durasiMenit <= 0) {
            $durasiMenit = 15;
        }

        // Deteksi rentang Audio Passage untuk soal-soal yang menggunakan audio yang sama
        $soalArray = $soal->values();
        $passageInfo = [];
        $totalCount = count($soalArray);
        $i = 0;
        while ($i < $totalCount) {
            $s = $soalArray[$i];
            $audioKey = !empty($s->audio) ? trim((string)$s->audio) : null;
            if ($audioKey) {
                $start = $i + 1;
                $j = $i;
                while ($j + 1 < $totalCount && !empty($soalArray[$j + 1]->audio) && trim((string)$soalArray[$j + 1]->audio) === $audioKey) {
                    $j++;
                }
                $end = $j + 1;
                $rangeText = ($start === $end) ? "Soal {$start}" : "Soal {$start} – {$end}";
                for ($k = $i; $k <= $j; $k++) {
                    $passageInfo[$k] = [
                        'range_text' => $rangeText,
                        'is_shared'  => ($start !== $end),
                        'passage_id' => 'passage_' . md5($audioKey),
                    ];
                }
                $i = $j + 1;
            } else {
                $i++;
            }
        }

        // Format pertanyaan dengan pengacakan opsi jawaban secara dinamis per siswa dan metadata audio passage
        $questionsPayload = $soalArray->map(function ($s, $idx) use ($passageInfo) {
            $rawOptions = [
                ['key' => 'A', 'text' => $s->pilihan_a],
                ['key' => 'B', 'text' => $s->pilihan_b],
                ['key' => 'C', 'text' => $s->pilihan_c],
                ['key' => 'D', 'text' => $s->pilihan_d],
            ];

            // Filter opsi yang tidak kosong
            $filteredOptions = array_values(array_filter($rawOptions, function ($opt) {
                return !is_null($opt['text']) && trim((string)$opt['text']) !== '';
            }));

            // Acak (shuffle) urutan pilihan per siswa secara dinamis
            shuffle($filteredOptions);

            $pInfo = $passageInfo[$idx] ?? null;

            return [
                'id'                => $s->id_quiz,
                'question'          => $s->pertanyaan,
                'options'           => $filteredOptions,
                'audio'             => $s->audio_url,
                'audio_title'       => $s->audio_title ?: 'Listening Audio Passage',
                'audio_petunjuk'    => $s->audio_petunjuk,
                'passage_range'     => $pInfo ? $pInfo['range_text'] : null,
                'is_shared_passage' => $pInfo ? $pInfo['is_shared'] : false,
                'passage_id'        => $pInfo ? $pInfo['passage_id'] : null,
            ];
        })->values();

        session([
            'active_quiz_lock'   => $quiz->id_quiz,
            'active_materi_lock' => $quiz->id_materi,
        ]);

        return view('siswa.quiz.show', compact('quiz', 'soal', 'questionsPayload', 'durasiMenit'));
    }

    /**
     * Submit Jawaban Quiz (multiple questions, dinilai dari kunci_jawaban di database)
     */
    public function submitQuiz(Request $request, $id)
    {
        $user = auth()->user();
        $quiz = Quiz::findOrFail($id);

        // Ambil HANYA soal-soal kuis yang berada di materi yang sama
        $query = Quiz::query();
        if ($quiz->id_materi) {
            $query->where('id_materi', $quiz->id_materi);
        } elseif ($quiz->id_bab) {
            $query->where('id_bab', $quiz->id_bab);
        } else {
            $query->where('id_quiz', $quiz->id_quiz);
        }

        $soal = $query->where(function ($q) {
                $q->whereIn('status', ['Aktif', 'Published'])->orWhereNull('status');
            })
            ->orderBy('urutan')
            ->orderBy('id_quiz')
            ->get();

        if ($soal->isEmpty()) {
            $soal = collect([$quiz]);
        }

        $quizIdsInMateri = $soal->pluck('id_quiz')->all();

        // Proteksi: Kuis yang sudah pernah diselesaikan tidak dapat disubmit ulang
        $existingHasil = HasilQuiz::where('id_user', $user->id_user)
            ->whereIn('id_quiz', $quizIdsInMateri)
            ->first();

        if ($existingHasil) {
            return redirect()->route('siswa.quiz.hasil', $quiz->id_quiz)
                ->with('info', 'Kuis untuk materi ini sudah diselesaikan dan tidak dapat diulang.');
        }

        $totalSoal   = $soal->count();
        $benarCount  = 0;
        $jawabanList = [];

        foreach ($soal as $pertanyaan) {
            $jawaban = $request->input('jawaban_' . $pertanyaan->id_quiz);
            $selectedKey = null;

            if ($jawaban !== null) {
                $raw = trim((string)$jawaban);
                $upper = strtoupper($raw);

                if (in_array($upper, ['A', 'B', 'C', 'D'])) {
                    $selectedKey = $upper;
                } else {
                    // Pencocokan fleksibel berdasarkan teks opsi jawaban
                    if ($raw === trim((string)$pertanyaan->pilihan_a)) $selectedKey = 'A';
                    elseif ($raw === trim((string)$pertanyaan->pilihan_b)) $selectedKey = 'B';
                    elseif ($raw === trim((string)$pertanyaan->pilihan_c)) $selectedKey = 'C';
                    elseif ($raw === trim((string)$pertanyaan->pilihan_d)) $selectedKey = 'D';
                }
            }

            // Kunci jawaban dicek murni terhadap database
            $benar = ($selectedKey !== null && $selectedKey === strtoupper(trim((string)$pertanyaan->kunci_jawaban)));

            if ($benar) {
                $benarCount++;
            }

            if ($selectedKey !== null) {
                $jawabanList[] = [
                    'id_quiz'      => $pertanyaan->id_quiz,
                    'jawaban_user' => $selectedKey,
                    'benar'        => $benar,
                ];
            }
        }

        // Perhitungan Skor: Murni dari akumulasi soal benar tanpa pengaruh durasi waktu
        $skor = $totalSoal > 0 ? round(($benarCount / $totalSoal) * 100) : 0;

        // Ganti hasil lama siswa untuk quiz ini (mencakup semua soal pada materi tersebut)
        $quizIdsInMateri = $soal->pluck('id_quiz')->all();
        $hasilLama = HasilQuiz::where('id_user', $user->id_user)
            ->whereIn('id_quiz', $quizIdsInMateri)
            ->get();

        foreach ($hasilLama as $lama) {
            JawabanUser::where('id_hasil', $lama->id_hasil)->delete();
            $lama->delete();
        }

        $hasil = HasilQuiz::create([
            'id_user'        => $user->id_user,
            'id_quiz'        => $quiz->id_quiz,
            'skor_diperoleh' => $skor,
        ]);

        foreach ($jawabanList as $jawaban) {
            JawabanUser::create([
                'id_hasil'      => $hasil->id_hasil,
                'id_quiz'       => $jawaban['id_quiz'],
                'jawaban_user'  => $jawaban['jawaban_user'],
                'benar'         => $jawaban['benar'],
            ]);
        }

        // Kuis telah berhasil diselesaikan, buka kunci navigasi
        session()->forget(['active_quiz_lock', 'active_materi_lock']);

        return redirect()->route('siswa.quiz.hasil', $quiz->id_quiz)
            ->with('success', 'Jawaban kamu berhasil dikumpulkan!')
            ->with('show_celebration', true)
            ->with('can_review_quiz', true);
    }

    /**
     * Halaman Hasil Quiz
     */
    public function hasilQuiz($id)
    {
        $user = auth()->user();

        $quiz = Quiz::with(['materi.kategori', 'bab.kategori'])->findOrFail($id);

        // Ambil ID quiz yang terkait dengan materi (atau bab jika tidak ada materi)
        $targetQuizIds = [$quiz->id_quiz];
        if ($quiz->id_materi) {
            $targetQuizIds = Quiz::where('id_materi', $quiz->id_materi)->pluck('id_quiz')->all();
        } elseif ($quiz->id_bab) {
            $targetQuizIds = Quiz::where('id_bab', $quiz->id_bab)->pluck('id_quiz')->all();
        }

        $hasil = HasilQuiz::where('id_user', $user->id_user)
            ->whereIn('id_quiz', $targetQuizIds)
            ->latest('id_hasil')
            ->first();

        // Pencegahan IDOR: Pastikan hasil kuis milik user yang sedang login
        if (!$hasil) {
            return redirect()->route('siswa.peta-quiz')
                ->with('warning', 'Anda belum menyelesaikan kuis untuk materi ini.');
        }

        // Kebijakan Otorisasi (Laravel Policy)
        $this->authorize('view', $hasil);

        // Review jawaban dan pembahasan HANYA boleh ditampilkan 1 kali saja tepat setelah siswa menyelesaikan quiz
        $canReview = (bool) (session('can_review_quiz') || session('show_celebration'));

        $query = Quiz::query();
        if ($quiz->id_materi) {
            $query->where('id_materi', $quiz->id_materi);
        } elseif ($quiz->id_bab) {
            $query->where('id_bab', $quiz->id_bab);
        } else {
            $query->where('id_quiz', $quiz->id_quiz);
        }

        $soalList = $query->where(function ($q) {
                $q->whereIn('status', ['Aktif', 'Published'])->orWhereNull('status');
            })
            ->orderBy('urutan')
            ->orderBy('id_quiz')
            ->get();

        if ($soalList->isEmpty()) {
            $soalList = collect([$quiz]);
        }

        $totalSoal = $soalList->count();

        if ($canReview && $hasil) {
            $jawaban = JawabanUser::where('id_hasil', $hasil->id_hasil)->get();
            $soal = $soalList;
        } else {
            // Mencegah kebocoran soal dan kunci jawaban antar siswa pada riwayat / lihat hasil selanjutnya
            $jawaban = collect();
            $soal = collect();
        }

        return view('siswa.quiz.hasil', compact('quiz', 'hasil', 'jawaban', 'soal', 'canReview', 'totalSoal'));
    }

    /**
     * Halaman Reminder
     */
    public function reminder()
    {
        $user = auth()->user();

        $pesanList = PesanAdmin::where('id_user', $user->id_user)
            ->with('admin')
            ->latest()
            ->get();

        return view('siswa.reminder', compact('pesanList'));
    }

    /**
     * Tandai Reminder sebagai Sudah Dibaca
     */
    public function markAsRead($id)
    {
        $reminder = PesanAdmin::findOrFail($id);

        $this->authorize('update', $reminder);

        $reminder->update(['is_read' => true]);

        return back();
    }

    /**
     * Hapus satu pesan reminder
     */
    public function destroyReminder($id)
    {
        $reminder = PesanAdmin::findOrFail($id);

        $this->authorize('delete', $reminder);

        $reminder->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['status' => 'success', 'message' => 'Reminder berhasil dihapus']);
        }

        return back()->with('success', 'Reminder berhasil dihapus.');
    }

    /**
     * Bersihkan semua pesan reminder siswa
     */
    public function clearAllReminders()
    {
        PesanAdmin::where('id_user', auth()->user()->id_user)->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['status' => 'success', 'message' => 'Semua reminder berhasil dibersihkan']);
        }

        return back()->with('success', 'Semua reminder berhasil dibersihkan.');
    }

    /**
     * Halaman Progres Belajar
     */
    public function progres()
    {
        $user = auth()->user();

        $totalMateri = Materi::count();
        $materiDibaca = ProgressMateri::where('id_user', $user->id_user)->count();

        $riwayat = HasilQuiz::with('quiz')
            ->where('id_user', $user->id_user)
            ->latest()
            ->get();

        $totalQuiz = $riwayat->count();
        $totalSkor = $riwayat->sum('skor_diperoleh');
        $rataRataNilai = $riwayat->avg('skor_diperoleh') ?? 0;

        $mingguIni = Carbon::now()->startOfWeek();
        $aktivitasMingguIni = [
            'materi_dibaca' => ProgressMateri::where('id_user', $user->id_user)
                ->where('created_at', '>=', $mingguIni)->count(),
            'quiz_dikerjakan' => HasilQuiz::where('id_user', $user->id_user)
                ->where('created_at', '>=', $mingguIni)->count(),
        ];

        $pencapaian = [
            'first_quiz' => $totalQuiz >= 1,
            'five_quiz' => $totalQuiz >= 5,
            'perfect_score' => $riwayat->where('skor_diperoleh', '>=', 100)->count() > 0,
            'bookworm' => $materiDibaca >= 5,
            'high_achiever' => $totalQuiz > 0 && $rataRataNilai >= 80,
        ];

        // Progress Per Kategori Nyata Berdasarkan Quiz Selesai Siswa
        $kategoris = Kategori::all();
        $userQuizSelesaiIds = HasilQuiz::where('id_user', $user->id_user)
            ->pluck('id_quiz')
            ->unique();

        $progressPerKategori = [];
        foreach ($kategoris as $kat) {
            $quizIdsInKat = Quiz::where(function($q) use ($kat) {
                $q->whereHas('materi', fn($m) => $m->where('id_kategori', $kat->id_kategori))
                  ->orWhereHas('bab', fn($b) => $b->where('id_kategori', $kat->id_kategori));
            })->pluck('id_quiz');

            $totalQuizKat = $quizIdsInKat->count();
            $quizSelesaiKat = $userQuizSelesaiIds->intersect($quizIdsInKat)->count();
            $persen = $totalQuizKat > 0 ? round(($quizSelesaiKat / $totalQuizKat) * 100) : 0;

            $progressPerKategori[] = [
                'kategori'     => $kat,
                'nama'         => $kat->nama_kategori,
                'total_quiz'   => $totalQuizKat,
                'quiz_selesai' => $quizSelesaiKat,
                'persentase'   => $persen,
            ];
        }

        return view('siswa.progress', compact(
            'totalMateri', 'materiDibaca', 'riwayat', 'totalQuiz',
            'totalSkor', 'rataRataNilai', 'aktivitasMingguIni', 'pencapaian',
            'progressPerKategori'
        ));
    }

    /**
     * Halaman Profil Siswa
     */
    public function profil()
    {
        $user = auth()->user();

        $totalMateri   = Materi::count();
        $materiSelesai = ProgressMateri::where('id_user', $user->id_user)
            ->where('status', 'Completed')
            ->count();
        $totalQuiz     = Quiz::count();
        $quizSelesai   = HasilQuiz::where('id_user', $user->id_user)->count();
        $rataRataNilai = HasilQuiz::where('id_user', $user->id_user)->avg('skor_diperoleh') ?? 0;

        return view('siswa.profile', compact(
            'user',
            'totalMateri',
            'materiSelesai',
            'totalQuiz',
            'quizSelesai',
            'rataRataNilai'
        ));
    }

    /**
     * Update Profil Siswa
     */
    public function updateProfil(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id_user . ',id_user',
        ]);

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('siswa.profil')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update Password Siswa
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|string|min:6|confirmed',
        ], [
            'password_lama.required'  => 'Password lama wajib dimasukkan terlebih dahulu.',
            'password_baru.required'  => 'Password baru wajib diisi.',
            'password_baru.min'       => 'Password baru minimal 6 karakter.',
            'password_baru.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = auth()->user();

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
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai.']);
        }

        $user->password = Hash::make($request->password_baru);
        $user->must_change_password = false;
        $user->save();

        return redirect()->route('siswa.profil')->with('success', 'Password berhasil diubah!');
    }

    /**
     * API Progress Siswa
     */
    public function apiProgress()
    {
        $user = auth()->user();

        $riwayat = HasilQuiz::with('quiz.materi')
            ->where('id_user', $user->id_user)
            ->latest()
            ->get();

        $riwayat->each(function ($item) {
            if ($item->quiz) {
                $item->quiz->makeHidden(['kunci_jawaban']);
            }
        });

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil dimuat',
            'data'    => [
                'total_materi' => Materi::count(),
                'materi_dibaca' => ProgressMateri::where('id_user', $user->id_user)->count(),
                'total_quiz' => $riwayat->count(),
                'total_skor' => $riwayat->sum('skor_diperoleh'),
                'riwayat' => $riwayat,
            ],
        ]);
    }
}

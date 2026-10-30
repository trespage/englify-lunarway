<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\HasilQuiz;
use App\Models\Quiz;

class LockActiveMateriAndQuiz
{
    /**
     * Mengunci navigasi siswa saat membaca materi belum selesai atau mengerjakan kuis
     * Siswa tidak dapat membuka navbar atau berpindah ke halaman umum (dashboard, daftar materi, peta quiz, progress, reminder, profil)
     * sampai kuis selesai dikerjakan.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Hanya terapkan proteksi pada siswa yang sedang login
        if (!$user || (int) $user->id_role !== 3) {
            return $next($request);
        }

        $activeQuizId = session('active_quiz_lock');
        $activeMateriId = session('active_materi_lock');

        // Daftar rute umum navbar yang dilarang diakses selama kuis/materi berlangsung
        $restrictedRoutes = [
            'siswa.dashboard',
            'siswa.materi',
            'siswa.peta-quiz',
            'siswa.quiz',
            'siswa.progres',
            'siswa.reminder',
            'siswa.profil',
        ];

        $currentRouteName = $request->route()?->getName();

        // 1. Jika ada sesi quiz yang sedang terkunci
        if ($activeQuizId) {
            // Cek apakah kuis ini sudah selesai di database
            $isQuizDone = HasilQuiz::where('id_user', $user->id_user)
                ->where('id_quiz', $activeQuizId)
                ->exists();

            if ($isQuizDone) {
                // Kuis sudah diselesaikan, lepas kunci
                session()->forget(['active_quiz_lock', 'active_materi_lock']);
            } else {
                if (in_array($currentRouteName, $restrictedRoutes, true)) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'error' => 'Kuis sedang berlangsung! Selesaikan kuis terlebih dahulu.',
                            'redirect' => route('siswa.quiz.kerjakan', $activeQuizId)
                        ], 403);
                    }

                    return redirect()->route('siswa.quiz.kerjakan', $activeQuizId)
                        ->with('error', 'Halaman kuis sedang terkunci! Selesaikan kuis terlebih dahulu sebelum membuka halaman lain.');
                }
            }
        }

        // 2. Jika ada sesi materi yang sedang terkunci (dan belum masuk kuis)
        if ($activeMateriId && !$activeQuizId) {
            $targetQuiz = Quiz::where('id_materi', $activeMateriId)->first();
            $isMateriDone = false;

            if ($targetQuiz) {
                $isMateriDone = HasilQuiz::where('id_user', $user->id_user)
                    ->where('id_quiz', $targetQuiz->id_quiz)
                    ->exists();
            }

            if ($isMateriDone || !$targetQuiz) {
                session()->forget(['active_materi_lock', 'active_quiz_lock']);
            } else {
                if (in_array($currentRouteName, $restrictedRoutes, true)) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'error' => 'Kamu sedang membaca materi! Selesaikan kuis terlebih dahulu.',
                            'redirect' => route('siswa.materi.baca', $activeMateriId)
                        ], 403);
                    }

                    return redirect()->route('siswa.materi.baca', $activeMateriId)
                        ->with('error', 'Halaman materi sedang terkunci! Selesaikan membaca dan kerjakan kuis terlebih dahulu.');
                }
            }
        }

        return $next($request);
    }
}

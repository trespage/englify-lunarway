<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Materi;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with('materi')->orderBy('created_at', 'desc')->get();
        $materis = Materi::orderBy('id_kategori')->orderBy('urutan')->get();
        return view('admin.quiz', compact('quizzes', 'materis'));
    }

    public function apiIndex(Request $request)
    {
        $query = Quiz::with(['materi', 'bab'])->orderBy('created_at', 'desc');

        if ($request->filled('id_materi')) {
            $query->where('id_materi', $request->id_materi);
        }

        if ($request->filled('id_bab')) {
            $query->where('id_bab', $request->id_bab);
        }

        if ($request->filled('q')) {
            $query->where('pertanyaan', 'like', '%' . $request->q . '%');
        }

        $isAdmin = auth()->check() && in_array((int) auth()->user()->id_role, [1, 2]);

        if (!$isAdmin) {
            $query->visibleForSiswa();
        }

        $quizzes = $query->get();

        if (!$isAdmin) {
            $quizzes->makeHidden(['kunci_jawaban']);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil dimuat',
            'data'    => $quizzes,
        ]);
    }

    public function apiShow($id)
    {
        $isAdmin = auth()->check() && in_array((int) auth()->user()->id_role, [1, 2]);

        $query = Quiz::with(['materi', 'bab']);

        if (!$isAdmin) {
            $query->visibleForSiswa();
        }

        $quiz = $query->find($id);

        if (!$quiz) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Soal quiz tidak ditemukan',
                'data'    => null,
            ], 404);
        }

        if (!$isAdmin) {
            $quiz->makeHidden(['kunci_jawaban']);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Detail quiz berhasil dimuat',
            'data'    => $quiz,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_materi' => 'required|exists:materi,id_materi',
            'pertanyaan' => 'required|string',
            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',
            'kunci_jawaban' => 'required|in:A,B,C,D',
            'poin' => 'required|integer|min:1',
        ]);

        $data = $request->all();
        if (empty($data['id_bab']) && !empty($data['id_materi'])) {
            $materi = Materi::find($data['id_materi']);
            if ($materi) {
                $data['id_bab'] = $materi->id_bab;
            }
        }

        Quiz::create($data);
        return redirect()->route('admin.quiz')->with('success', 'Soal Quiz berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_materi' => 'required|exists:materi,id_materi',
            'pertanyaan' => 'required|string',
            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',
            'kunci_jawaban' => 'required|in:A,B,C,D',
            'poin' => 'required|integer|min:1',
        ]);

        $quiz = Quiz::findOrFail($id);
        $data = $request->all();
        if (empty($data['id_bab']) && !empty($data['id_materi'])) {
            $materi = Materi::find($data['id_materi']);
            if ($materi) {
                $data['id_bab'] = $materi->id_bab;
            }
        }

        $quiz->update($data);
        return redirect()->route('admin.quiz')->with('success', 'Soal Quiz berhasil diupdate!');
    }

    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();
        return redirect()->route('admin.quiz')->with('success', 'Soal Quiz berhasil dihapus!');
    }
}

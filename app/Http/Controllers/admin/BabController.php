<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bab;
use App\Models\Kategori;
use App\Models\Materi;
use App\Models\Quiz;
use App\Models\HasilQuiz;
use App\Models\JawabanUser;
use App\Models\ProgressMateri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BabController extends Controller
{
    /**
     * Menampilkan daftar Bab kurikulum per Kategori
     */
    public function index(Request $request)
    {
        $kategoriList = Kategori::orderBy('id_kategori')->get();

        $query = Bab::with(['kategori'])
            ->withCount(['materi', 'quizzes'])
            ->orderBy('id_kategori')
            ->orderBy('urutan');

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->filled('q')) {
            $query->where('judul', 'like', '%' . $request->q . '%');
        }

        $babs = $query->paginate(15)->withQueryString();

        // Hitung statistik per kategori
        $stats = [
            'total'     => Bab::count(),
            'speaking'  => Bab::whereHas('kategori', fn($q) => $q->where('nama_kategori', 'Speaking'))->count(),
            'writing'   => Bab::whereHas('kategori', fn($q) => $q->where('nama_kategori', 'Writing'))->count(),
            'reading'   => Bab::whereHas('kategori', fn($q) => $q->where('nama_kategori', 'Reading'))->count(),
            'listening' => Bab::whereHas('kategori', fn($q) => $q->where('nama_kategori', 'Listening'))->count(),
        ];

        return view('admin.bab', compact('babs', 'kategoriList', 'stats'));
    }

    /**
     * Simpan Bab baru (Mendukung Form biasa & AJAX dari modal Materi/Quiz)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_kategori'  => 'required|exists:kategori,id_kategori',
            'judul'        => 'required|string|max:255',
            'urutan'       => 'nullable|integer|min:1',
            'durasi_menit' => 'nullable|integer|min:1|max:300',
            'is_active'    => 'nullable|boolean',
        ]);

        // Jika urutan tidak diisi, otomatis urutkan setelah bab terakhir di kategori tersebut
        if (empty($validated['urutan'])) {
            $lastUrutan = Bab::where('id_kategori', $validated['id_kategori'])->max('urutan') ?? 0;
            $validated['urutan'] = $lastUrutan + 1;
        }

        if (empty($validated['durasi_menit'])) {
            $validated['durasi_menit'] = 15;
        }

        $validated['is_active'] = $request->boolean('is_active');

        $bab = Bab::create($validated);
        $bab->load('kategori');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Bab berhasil ditambahkan!',
                'data'    => [
                    'id'           => $bab->id,
                    'judul'        => $bab->judul,
                    'urutan'       => $bab->urutan,
                    'durasi_menit' => $bab->durasi_menit,
                    'is_active'    => (bool) $bab->is_active,
                    'id_kategori'  => $bab->id_kategori,
                    'kategori'     => $bab->kategori?->nama_kategori ?? '-',
                ]
            ]);
        }

        return redirect()->back()->with('success', "Bab '{$bab->judul}' berhasil ditambahkan ke kategori {$bab->kategori?->nama_kategori}!");
    }

    /**
     * Update data Bab
     */
    public function update(Request $request, $id)
    {
        $bab = Bab::findOrFail($id);

        $validated = $request->validate([
            'id_kategori'  => 'required|exists:kategori,id_kategori',
            'judul'        => 'required|string|max:255',
            'urutan'       => 'required|integer|min:1',
            'durasi_menit' => 'nullable|integer|min:1|max:300',
            'is_active'    => 'nullable',
        ]);

        if (empty($validated['durasi_menit'])) {
            $validated['durasi_menit'] = $bab->durasi_menit ?: 15;
        }

        // Fungsionalkan centang 'Aktifkan Bab ini sekarang': jika checkbox dicentang maka true (1), jika tidak maka false (0)
        $validated['is_active'] = $request->boolean('is_active');

        $bab->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Bab berhasil diperbarui!',
                'data'    => $bab
            ]);
        }

        return redirect()->back()->with('success', "Bab '{$bab->judul}' berhasil diperbarui!");
    }

    /**
     * Hapus Bab beserta seluruh Materi dan Quiz di dalamnya (Cascade Delete)
     */
    public function destroy(Request $request, $id)
    {
        $bab = Bab::findOrFail($id);
        $judul = $bab->judul;

        DB::transaction(function () use ($bab) {
            // 1. Ambil semua materi yang terkait dengan bab ini
            $materis = Materi::where('id_bab', $bab->id)
                ->orWhere(function ($q) use ($bab) {
                    $q->whereNull('id_bab')
                      ->where('id_kategori', $bab->id_kategori)
                      ->where('bab', $bab->judul);
                })
                ->get();

            $materiIds = $materis->pluck('id_materi')->all();

            // 2. Ambil semua kuis yang terkait dengan bab ini atau materi di dalamnya
            $quizzes = Quiz::where('id_bab', $bab->id)
                ->when(!empty($materiIds), function ($q) use ($materiIds) {
                    $q->orWhereIn('id_materi', $materiIds);
                })
                ->get();

            $quizIds = $quizzes->pluck('id_quiz')->all();

            // 3. Hapus relasi hasil kuis dan jawaban user
            if (!empty($quizIds)) {
                $hasilIds = HasilQuiz::whereIn('id_quiz', $quizIds)->pluck('id_hasil')->all();
                if (!empty($hasilIds)) {
                    JawabanUser::whereIn('id_hasil', $hasilIds)->delete();
                }
                JawabanUser::whereIn('id_quiz', $quizIds)->delete();
                HasilQuiz::whereIn('id_quiz', $quizIds)->delete();
                Quiz::whereIn('id_quiz', $quizIds)->delete();
            }

            // 4. Hapus materi (file attachment & progress belajar siswa)
            foreach ($materis as $m) {
                if ($m->file && file_exists(public_path($m->file))) {
                    @unlink(public_path($m->file));
                }
                if ($m->gambar && file_exists(public_path($m->gambar))) {
                    @unlink(public_path($m->gambar));
                }
                ProgressMateri::where('id_materi', $m->id_materi)->delete();
                $m->delete();
            }

            // 5. Hapus Bab itu sendiri
            $bab->delete();
        });

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Bab '{$judul}' beserta seluruh materi dan kuis di dalamnya berhasil dihapus!"
            ]);
        }

        return redirect()->back()->with('success', "Bab '{$judul}' beserta seluruh materi dan kuis di dalamnya berhasil dihapus!");
    }

    /**
     * API JSON: Mengambil Bab berdasarkan ID Kategori untuk dropdown dinamis
     */
    public function apiByKategori($kategoriId)
    {
        $babs = Bab::where('id_kategori', $kategoriId)
            ->where('is_active', true)
            ->orderBy('urutan')
            ->get(['id', 'judul', 'urutan', 'durasi_menit']);

        return response()->json($babs);
    }

    /**
     * API JSON: Daftar seluruh Bab (dengan filter kategori & pencarian judul)
     */
    public function apiIndex(Request $request)
    {
        $query = Bab::with('kategori')
            ->withCount(['materi', 'quizzes'])
            ->orderBy('id_kategori')
            ->orderBy('urutan');

        if ($request->filled('id_kategori')) {
            $query->where('id_kategori', $request->id_kategori);
        }

        if ($request->filled('q')) {
            $query->where('judul', 'like', '%' . $request->q . '%');
        }

        $isAdmin = auth()->check() && in_array((int) auth()->user()->id_role, [1, 2]);
        if (!$isAdmin) {
            $query->where('is_active', true);
        }

        $babs = $query->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data bab berhasil dimuat',
            'data'    => $babs,
        ]);
    }

    /**
     * API JSON: Detail satu Bab beserta materi di dalamnya
     */
    public function apiShow($id)
    {
        $isAdmin = auth()->check() && in_array((int) auth()->user()->id_role, [1, 2]);

        $query = Bab::with(['kategori', 'materi' => function ($q) use ($isAdmin) {
            if (!$isAdmin) {
                $q->where(function ($sub) {
                    $sub->whereIn('status', ['Published', 'Aktif'])->orWhereNull('status');
                });
            }
            $q->orderBy('urutan');
        }]);

        if (!$isAdmin) {
            $query->where('is_active', true);
        }

        $bab = $query->find($id);

        if (!$bab) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Bab tidak ditemukan',
                'data'    => null,
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Detail bab berhasil dimuat',
            'data'    => $bab,
        ]);
    }
}

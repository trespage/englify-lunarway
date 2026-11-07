<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Bab;
use App\Models\Materi;
use App\Models\Quiz;
use App\Models\HasilQuiz;
use App\Models\JawabanUser;
use App\Models\ProgressMateri;
use App\Models\User;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::withCount(['materi', 'babs'])->orderBy('id_kategori', 'asc')->get();
        return view('admin.kategori', compact('kategoris'));
    }

    public function apiIndex(Request $request)
    {
        $query = Kategori::withCount(['materi', 'babs'])->orderBy('id_kategori', 'asc');

        if ($request->filled('q')) {
            $q = '%' . $request->q . '%';
            $query->where(function ($sub) use ($q) {
                $sub->where('nama_kategori', 'like', $q)
                    ->orWhere('deskripsi', 'like', $q);
            });
        }

        $kategoris = $query->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil dimuat',
            'data'    => $kategoris,
        ]);
    }

    public function apiShow($id)
    {
        $isAdmin = auth()->check() && in_array((int) auth()->user()->id_role, [1, 2]);

        $query = Kategori::with(['babs' => function ($q) use ($isAdmin) {
            if (!$isAdmin) {
                $q->where('is_active', true);
            }
            $q->orderBy('urutan');
            $q->with(['materi' => function ($mq) use ($isAdmin) {
                if (!$isAdmin) {
                    $mq->where(function ($sub) {
                        $sub->whereIn('status', ['Published', 'Aktif'])->orWhereNull('status');
                    });
                }
                $mq->orderBy('urutan');
            }]);
        }]);

        $kategori = $query->find($id);

        if (!$kategori) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kategori tidak ditemukan',
                'data'    => null,
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Detail kategori berhasil dimuat',
            'data'    => $kategori,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori',
            'deskripsi' => 'nullable|string',
        ]);

        Kategori::create($request->only(['nama_kategori', 'deskripsi']));
        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori,' . $id . ',id_kategori',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->only(['nama_kategori', 'deskripsi']));
        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $namaKategori = $kategori->nama_kategori;

        DB::transaction(function () use ($kategori) {
            // 1. Ambil semua Bab dalam kategori ini
            $babs = Bab::where('id_kategori', $kategori->id_kategori)->get();
            $babIds = $babs->pluck('id')->all();

            // 2. Ambil semua Materi yang terkait dengan kategori ini atau bab-bab di dalamnya
            $materis = Materi::where('id_kategori', $kategori->id_kategori)
                ->when(!empty($babIds), fn($q) => $q->orWhereIn('id_bab', $babIds))
                ->get();
            $materiIds = $materis->pluck('id_materi')->all();

            // 3. Ambil semua Quiz yang terkait dengan bab atau materi di dalamnya
            $quizzes = Quiz::where(function ($q) use ($babIds, $materiIds) {
                if (!empty($babIds)) {
                    $q->whereIn('id_bab', $babIds);
                }
                if (!empty($materiIds)) {
                    $q->orWhereIn('id_materi', $materiIds);
                }
            })->get();
            $quizIds = $quizzes->pluck('id_quiz')->all();

            // 4. Hapus data Quiz, Hasil Quiz, dan Jawaban User
            if (!empty($quizIds)) {
                $hasilIds = HasilQuiz::whereIn('id_quiz', $quizIds)->pluck('id_hasil')->all();
                if (!empty($hasilIds)) {
                    JawabanUser::whereIn('id_hasil', $hasilIds)->delete();
                }
                JawabanUser::whereIn('id_quiz', $quizIds)->delete();
                HasilQuiz::whereIn('id_quiz', $quizIds)->delete();
                Quiz::whereIn('id_quiz', $quizIds)->delete();
            }

            // 5. Hapus file fisik materi dan record materi beserta progress belajar
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

            // 6. Hapus semua Bab dalam kategori
            if (!empty($babIds)) {
                Bab::whereIn('id', $babIds)->delete();
            }

            // 7. Lepaskan relasi kategori pada user (admin divisi / siswa) agar aman
            User::where('id_kategori', $kategori->id_kategori)->update(['id_kategori' => null]);

            // 8. Hapus Kategori
            $kategori->delete();
        });

        return redirect()->route('admin.kategori')->with('success', "Kategori '{$namaKategori}' beserta seluruh bab, materi, dan kuis di dalamnya berhasil dihapus!");
    }
}

<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::withCount('materi')->orderBy('id_kategori', 'asc')->get();
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
        $kategori->delete();
        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil dihapus!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bab;
use App\Models\Kategori;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MateriController extends Controller
{
    public function index(Request $request)
    {
        // Pastikan setiap materi selalu terhubung ke Bab (materi harus memiliki bab)
        $unlinked = Materi::whereNull('id_bab')->get();
        if ($unlinked->isNotEmpty()) {
            foreach ($unlinked as $u) {
                $babJudul = trim($u->bab) ?: 'Bab 1: Pengenalan';
                $bab = Bab::firstOrCreate(
                    ['id_kategori' => $u->id_kategori, 'judul' => $babJudul],
                    ['urutan' => 1, 'is_active' => true]
                );
                $u->id_bab = $bab->id;
                $u->bab = $bab->judul;
                $u->saveQuietly();
            }
        }

        $kategoriList = Kategori::orderBy('id_kategori')->get();
        $babList      = Bab::with('kategori')->orderBy('id_kategori')->orderBy('urutan')->get();

        // 1. Ambil data materi sesuai filter
        $query = Materi::with(['kategori', 'babModel', 'admin']);

        if ($request->filled('q')) {
            $query->where('judul', 'like', '%' . $request->q . '%');
        }
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }
        if ($request->filled('bab')) {
            $query->where(function ($q) use ($request) {
                if (is_numeric($request->bab)) {
                    $q->where('id_bab', (int) $request->bab);
                } else {
                    $q->where('bab', $request->bab)
                      ->orWhereHas('babModel', fn ($b) => $b->where('judul', $request->bab));
                }
            });
        }

        // Ambil dan urutkan materi: Kategori -> Bab -> Urutan materi -> ID
        $rawMateri = $query->get();
        $allMateri = $rawMateri->sortBy([
            fn ($a, $b) => ($a->kategori?->id_kategori ?? 999) <=> ($b->kategori?->id_kategori ?? 999),
            fn ($a, $b) => ($a->babModel?->urutan ?? 999) <=> ($b->babModel?->urutan ?? 999),
            fn ($a, $b) => ($a->urutan ?? 999) <=> ($b->urutan ?? 999),
            fn ($a, $b) => $b->id_materi <=> $a->id_materi,
        ])->values();

        // Format data materi untuk view dan interaksi modal JS (edit, preview POV)
        $materiList = $allMateri->map(fn (Materi $m) => [
            'id'          => $m->id_materi,
            'judul'       => $m->judul,
            'kategori'    => $m->kategori?->nama_kategori ?? '-',
            'id_kategori' => $m->id_kategori,
            'id_bab'      => $m->id_bab,
            'bab'         => $m->babModel?->judul ?? $m->bab ?? '-',
            'bab_urutan'  => $m->babModel?->urutan ?? 0,
            'konten'      => $m->isi_materi,
            'deskripsi'   => $m->deskripsi,
            'contoh'      => $m->contoh,
            'tips'        => $m->tips,
            'status'      => $m->status,
            'urutan'      => $m->urutan,
            'durasi_menit'=> (int) ($m->durasi_menit ?? 15),
            'tanggal'     => $m->created_at ? $m->created_at->translatedFormat('d M Y, H:i') : '-',
            'gambar'      => $m->gambar,
            'file'        => $m->file,
            'url'         => $m->url,
            'urls'        => $m->urls_list,
            'quiz_count'  => $m->quiz?->count() ?? 0,
        ]);

        // Paginator tetap disediakan untuk kompatibilitas route/smoke tests
        $materi = $query->paginate(30)->withQueryString();

        // 2. Kelompokkan Materi per Bab
        $filteredBabs = $babList;
        if ($request->filled('kategori')) {
            $filteredBabs = $filteredBabs->where('id_kategori', $request->kategori);
        }
        if ($request->filled('bab')) {
            $filteredBabs = $filteredBabs->filter(function ($b) use ($request) {
                return (string) $b->id === (string) $request->bab || $b->judul === $request->bab;
            });
        }

        $babsGrouped = $filteredBabs->map(function ($bab) use ($materiList) {
            $items = $materiList->filter(function ($item) use ($bab) {
                return ($item['id_bab'] && $item['id_bab'] == $bab->id)
                    || (!$item['id_bab'] && $item['bab'] == $bab->judul);
            })->values();

            return [
                'id'            => $bab->id,
                'judul'         => $bab->judul,
                'urutan'        => $bab->urutan,
                'id_kategori'   => $bab->id_kategori,
                'nama_kategori' => $bab->kategori?->nama_kategori ?? '-',
                'materi'        => $items,
                'total'         => $items->count(),
            ];
        });

        // Jika pencarian 'q' aktif, hanya tampilkan bab yang memuat materi atau judul bab cocok
        if ($request->filled('q')) {
            $qLower = strtolower($request->q);
            $babsGrouped = $babsGrouped->filter(function ($b) use ($qLower) {
                return $b['total'] > 0 || str_contains(strtolower($b['judul']), $qLower);
            })->values();
        }

        // Jumlah materi per kategori (real-time dari database)
        $jumlahPerKategori = DB::table('materi')
            ->select('id_kategori', DB::raw('COUNT(*) as jml'))
            ->groupBy('id_kategori')
            ->pluck('jml', 'id_kategori');

        $statistikKategori = $kategoriList->map(function (Kategori $k) use ($jumlahPerKategori) {
            $warna = match (strtolower($k->nama_kategori)) {
                'speaking'  => ['red',     'bg-rose-50',    'text-rose-600',    'border-rose-200'],
                'writing'   => ['blue',    'bg-blue-50',    'text-blue-600',    'border-blue-200'],
                'reading'   => ['emerald', 'bg-emerald-50', 'text-emerald-600', 'border-emerald-200'],
                'listening' => ['purple',  'bg-purple-50',  'text-purple-600',  'border-purple-200'],
                default     => ['slate',   'bg-slate-50',   'text-slate-600',   'border-slate-200'],
            };

            return [
                'nama'   => $k->nama_kategori,
                'jumlah' => (int) ($jumlahPerKategori[$k->id_kategori] ?? 0),
                'warna'  => $warna[0],
                'bg'     => $warna[1],
                'text'   => $warna[2],
            ];
        });

        $totalMateri = Materi::count();

        return view('admin.materi', compact(
            'materi',
            'materiList',
            'babsGrouped',
            'kategoriList',
            'babList',
            'statistikKategori',
            'totalMateri'
        ));
    }

    public function apiIndex(Request $request)
    {
        $query = Materi::with(['admin', 'kategori', 'babModel'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('id_kategori')) {
            $query->where('id_kategori', $request->id_kategori);
        }

        if ($request->filled('id_bab')) {
            $query->where('id_bab', $request->id_bab);
        }

        if ($request->filled('q')) {
            $q = '%' . $request->q . '%';
            $query->where(function ($sub) use ($q) {
                $sub->where('judul', 'like', $q)
                    ->orWhere('deskripsi', 'like', $q)
                    ->orWhere('isi_materi', 'like', $q);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $isAdmin = auth()->check() && in_array((int) auth()->user()->id_role, [1, 2]);
            if (!$isAdmin) {
                $query->where(function ($q) {
                    $q->whereIn('status', ['Published', 'Aktif'])
                      ->orWhereNull('status');
                });
            }
        }

        $materis = $query->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil dimuat',
            'data'    => $materis,
        ]);
    }

    public function apiShow($id)
    {
        $isAdmin = auth()->check() && in_array((int) auth()->user()->id_role, [1, 2]);

        $query = Materi::with(['admin', 'kategori', 'babModel', 'quizzes']);

        if (!$isAdmin) {
            $query->visibleForSiswa();
        }

        $materi = $query->find($id);

        if (!$materi) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Materi tidak ditemukan',
                'data'    => null,
            ], 404);
        }

        if (!$isAdmin && $materi->quizzes) {
            $materi->quizzes->makeHidden(['kunci_jawaban']);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Detail materi berhasil dimuat',
            'data'    => $materi,
        ]);
    }

    /**
     * Endpoint API untuk mengambil daftar Bab berdasarkan Kategori terpilih (tanpa subbab)
     */
    public function getBabsByKategori($kategoriId)
    {
        $babs = Bab::where('id_kategori', $kategoriId)
            ->where('is_active', true)
            ->orderBy('urutan')
            ->get(['id', 'judul', 'urutan']);

        return response()->json($babs);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $bab = Bab::findOrFail($data['id_bab']);
        $data['id_admin']    = auth()->id();
        $data['bab']         = $bab->judul;
        $data['id_kategori'] = $bab->id_kategori;
        $data['urutan']      = $data['urutan'] ?? (Materi::where('id_bab', $data['id_bab'])->max('urutan') ?? 0) + 1;
        $data['status']      = $data['status'] ?? 'Draft';

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $this->simpanFile($request->file('gambar'), 'images/materi', 'img');
        }

        Materi::create($data);

        return redirect()->route('admin.materi')->with('success', 'Materi berhasil ditambahkan ke Bab!');
    }

    public function update(Request $request, $id)
    {
        $materi = Materi::findOrFail($id);

        $data = $this->validateData($request, $materi);
        $bab = Bab::findOrFail($data['id_bab']);
        $data['bab']         = $bab->judul;
        $data['id_kategori'] = $bab->id_kategori;

        if ($request->hasFile('gambar')) {
            if ($materi->gambar && file_exists(public_path($materi->gambar))) {
                @unlink(public_path($materi->gambar));
            }
            $data['gambar'] = $this->simpanFile($request->file('gambar'), 'images/materi', 'img');
        }

        $materi->update($data);

        return redirect()->route('admin.materi')->with('success', 'Materi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);

        if ($materi->file && file_exists(public_path($materi->file))) {
            @unlink(public_path($materi->file));
        }
        if ($materi->gambar && file_exists(public_path($materi->gambar))) {
            @unlink(public_path($materi->gambar));
        }

        $materi->delete();

        return redirect()->route('admin.materi')->with('success', 'Materi berhasil dihapus!');
    }

    /**
     * Validasi payload materi: Kategori -> Bab -> Materi
     */
    private function validateData(Request $request, ?Materi $materi = null): array
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'id_kategori'  => 'required|integer|exists:kategori,id_kategori',
            'id_bab'       => 'required|integer|exists:bab,id',
            'isi_materi'   => 'required|string',
            'deskripsi'    => 'nullable|string',
            'durasi_menit' => 'nullable|integer|min:1|max:300',
            'status'       => 'nullable|in:Draft,Published',
            'urutan'       => 'nullable|integer|min:1',
            'gambar'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'urls'         => 'nullable|array',
            'urls.*'       => 'nullable|string|max:2000',
            'url'          => 'nullable|string|max:2000',
        ], [
            'id_kategori.required' => 'Pilih kategori terlebih dahulu.',
            'id_bab.required'      => 'Materi harus memiliki Bab dan tidak bisa dibuat jika tidak memiliki Bab.',
            'id_bab.exists'        => 'Bab yang dipilih tidak valid atau belum terdaftar.',
            'judul.required'       => 'Judul materi wajib diisi.',
            'isi_materi.required'  => 'Konten materi wajib diisi.',
        ]);

        $data = [
            'judul'        => $request->judul,
            'id_kategori'  => (int) $request->id_kategori,
            'id_bab'       => (int) $request->id_bab,
            'isi_materi'   => $request->isi_materi,
            'deskripsi'    => $request->deskripsi,
            'durasi_menit' => (int) ($request->input('durasi_menit', 15) ?: 15),
            'status'       => $request->status ?: ($materi->status ?? 'Draft'),
        ];

        if ($request->filled('urutan')) {
            $data['urutan'] = (int) $request->urutan;
        }

        // Tangani multiple URLs (dari input array urls[] atau fallback single url)
        $rawUrls = $request->input('urls', []);
        if (!is_array($rawUrls)) {
            $rawUrls = $request->filled('url') ? [$request->url] : [];
        } elseif ($request->filled('url') && !in_array($request->url, $rawUrls)) {
            $rawUrls[] = $request->url;
        }

        $validUrls = [];
        foreach ($rawUrls as $u) {
            $trimmed = trim((string) $u);
            if ($trimmed !== '') {
                $validUrls[] = $trimmed;
            }
        }
        $validUrls = array_values(array_unique($validUrls));
        $data['url'] = !empty($validUrls) ? json_encode($validUrls) : null;

        return $data;
    }

    /**
     * Simpan file ke folder publik dan kembalikan path relatifnya.
     */
    private function simpanFile($file, string $folder, string $prefix): string
    {
        if (!file_exists(public_path($folder))) {
            mkdir(public_path($folder), 0755, true);
        }

        $fileName = time() . '_' . $prefix . '.' . $file->extension();
        $file->move(public_path($folder), $fileName);

        return $folder . '/' . $fileName;
    }
}

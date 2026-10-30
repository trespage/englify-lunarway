<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Simpan review baru dari pengguna / siswa
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|min:2|max:70',
            'role' => 'nullable|string|max:70',
            'rating' => 'required|integer|min:1|max:5',
            'pesan' => 'required|string|min:5|max:500',
        ], [
            'nama.required' => 'Mohon masukkan nama kamu.',
            'nama.min' => 'Nama minimal 2 karakter.',
            'rating.required' => 'Pilih bintang penilaian (1-5).',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'pesan.required' => 'Mohon tuliskan pesan atau ulasan kamu.',
            'pesan.min' => 'Ulasan minimal 5 karakter agar bermakna.',
            'pesan.max' => 'Ulasan maksimal 500 karakter.',
        ]);

        $userId = auth()->id();
        $nama = strip_tags(trim($validated['nama']));
        $defaultRole = auth()->check() ? 'Siswa English Club' : 'Pengguna Englify';
        $role = !empty($validated['role']) ? strip_tags(trim($validated['role'])) : $defaultRole;

        $newReview = Review::create([
            'user_id' => $userId,
            'nama' => $nama,
            'role' => $role,
            'rating' => (int) $validated['rating'],
            'pesan' => strip_tags(trim($validated['pesan'])),
            'is_approved' => true,
        ]);

        return redirect(url('/#ulasan'))
            ->with('review_success', 'Terima kasih banyak! Review kamu berhasil ditambahkan dan langsung tampil di halaman ini.')
            ->with('latest_review', $newReview);
    }

    /**
     * API JSON: Daftar ulasan / testimoni publik yang telah disetujui
     */
    public function apiIndex(Request $request)
    {
        $limit = min((int) $request->input('limit', 20), 100);

        $reviews = Review::where('is_approved', true)
            ->latest()
            ->take($limit)
            ->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data ulasan berhasil dimuat',
            'data'    => $reviews,
        ]);
    }
}

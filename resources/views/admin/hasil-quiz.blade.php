@extends('layouts.admin')

@section('title', 'Hasil Quiz')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                Hasil Quiz
            </h1>
            <p class="text-slate-500 mt-1 ml-1">Monitor hasil quiz dan performa siswa.</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Total Quiz Dikerjakan</p>
                    <p class="text-4xl font-bold mt-2">{{ $totalQuiz }}</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-sm font-medium">Rata-rata Nilai</p>
                    <p class="text-4xl font-bold mt-2">{{ number_format($averageScore, 1) }}</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Rekap Tersimpan</p>
                    <p class="text-4xl font-bold mt-2">{{ $totalCompleted }}</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Hasil Quiz Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Riwayat Pengerjaan Quiz</h3>
                <p class="text-xs text-slate-400 mt-0.5">Daftar rekap kuis per siswa, kategori, bab, dan materi pembelajaran.</p>
            </div>
            <form method="GET" action="{{ route('admin.hasil-quiz') }}" class="flex items-center gap-2">
                <div class="relative">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari siswa, bab, materi..."
                           class="w-56 sm:w-64 pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">
                </div>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition">
                    Cari
                </button>
                @if(request('q'))
                    <a href="{{ route('admin.hasil-quiz') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Bab</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Materi Ke-</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Skor</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                        $catColors = [
                            'Speaking'  => 'bg-rose-50 text-rose-700 border-rose-200',
                            'Writing'   => 'bg-blue-50 text-blue-700 border-blue-200',
                            'Reading'   => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'Listening' => 'bg-purple-50 text-purple-700 border-purple-200',
                        ];
                    @endphp
                    @forelse($hasilQuizzes as $hasil)
                    @php
                        $materi = $hasil->quiz?->materi;
                        $babModel = $materi?->babModel ?? $hasil->quiz?->bab;
                        $kategori = $materi?->kategori ?? $babModel?->kategori;
                        $kategoriNama = $kategori?->nama_kategori ?? 'Umum';
                        $kategoriBadge = $catColors[$kategoriNama] ?? 'bg-slate-50 text-slate-700 border-slate-200';

                        $babJudul = $babModel?->formatted_judul ?? ($materi?->bab ? 'Bab: ' . $materi->bab : 'Umum');
                        $materiUrutan = $materi?->urutan ?? 1;
                        $materiJudul = $materi?->judul ?? ($hasil->quiz?->judul ?? 'Quiz Materi');
                    @endphp
                    <tr class="hover:bg-slate-50 transition">
                        <!-- 1. SISWA -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-sm">
                                    {{ strtoupper(substr($hasil->user->nama ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 text-sm leading-tight">{{ $hasil->user->nama ?? '-' }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $hasil->user->email ?? '' }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- 2. KATEGORI -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {{ $kategoriBadge }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70"></span>
                                {{ $kategoriNama }}
                            </span>
                        </td>

                        <!-- 3. BAB -->
                        <td class="px-6 py-4">
                            <div class="max-w-[200px]">
                                <p class="font-semibold text-slate-800 text-sm leading-snug truncate" title="{{ $babJudul }}">
                                    {{ $babJudul }}
                                </p>
                                @if($babModel && $babModel->urutan)
                                    <p class="text-[11px] text-slate-400">Bab Urutan #{{ $babModel->urutan }}</p>
                                @endif
                            </div>
                        </td>

                        <!-- 4. MATERI KE BERAPA -->
                        <td class="px-6 py-4">
                            <div class="max-w-[220px]">
                                @if($materi)
                                    <div class="mb-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-extrabold bg-indigo-50 text-indigo-700 border border-indigo-200/80">
                                            Materi {{ $materiUrutan }}
                                        </span>
                                    </div>
                                    <p class="text-xs font-medium text-slate-700 truncate" title="{{ $materiJudul }}">
                                        {{ $materiJudul }}
                                    </p>
                                @else
                                    <span class="text-xs text-slate-400 italic">Quiz Bab Langsung</span>
                                @endif
                            </div>
                        </td>

                        <!-- 5. SKOR -->
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            @if($hasil->skor_diperoleh >= 75)
                                <span class="inline-flex items-center justify-center min-w-12 h-10 px-3 rounded-xl font-bold text-base bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    {{ $hasil->skor_diperoleh }}
                                </span>
                            @elseif($hasil->skor_diperoleh >= 60)
                                <span class="inline-flex items-center justify-center min-w-12 h-10 px-3 rounded-xl font-bold text-base bg-amber-100 text-amber-800 border border-amber-200">
                                    {{ $hasil->skor_diperoleh }}
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center min-w-12 h-10 px-3 rounded-xl font-bold text-base bg-rose-100 text-rose-800 border border-rose-200">
                                    {{ $hasil->skor_diperoleh }}
                                </span>
                            @endif
                        </td>

                        <!-- 6. WAKTU -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-sm font-semibold text-slate-700">{{ $hasil->created_at->format('d M Y, H:i') }}</p>
                            <p class="text-[11px] text-slate-400">{{ $hasil->created_at->diffForHumans() }}</p>
                        </td>

                        <!-- 7. AKSI -->
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <a href="{{ route('admin.hasil-quiz.detail', $hasil->id_hasil) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-bold hover:bg-indigo-100 transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-semibold text-sm">Belum ada hasil quiz</p>
                                <p class="text-slate-400 text-xs">Hasil pengerjaan kuis siswa akan muncul otomatis di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($hasilQuizzes->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $hasilQuizzes->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

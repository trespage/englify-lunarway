@extends('layouts.admin')

@section('title', 'Detail Hasil Quiz - ' . ($hasil->user->nama ?? 'Siswa'))

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('admin.hasil-quiz') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-indigo-600 hover:text-indigo-800 transition mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Hasil Quiz
            </a>
            <h1 class="text-2xl font-extrabold text-slate-800">Detail Hasil Quiz</h1>
            <p class="text-slate-500 text-sm mt-0.5">Rincian kurikulum, materi pembelajaran, dan rekap pengerjaan kuis siswa.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs font-semibold px-3 py-1.5 rounded-xl bg-slate-100 text-slate-600 border border-slate-200">
                ID Hasil: #{{ $hasil->id_hasil }}
            </span>
        </div>
    </div>

    @php
        $catColors = [
            'Speaking'  => 'bg-rose-50 text-rose-700 border-rose-200',
            'Writing'   => 'bg-blue-50 text-blue-700 border-blue-200',
            'Reading'   => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'Listening' => 'bg-purple-50 text-purple-700 border-purple-200',
        ];

        $materi = $hasil->quiz?->materi;
        $babModel = $materi?->babModel ?? $hasil->quiz?->bab;
        $kategori = $materi?->kategori ?? $babModel?->kategori;
        $kategoriNama = $kategori?->nama_kategori ?? 'Umum';
        $kategoriBadge = $catColors[$kategoriNama] ?? 'bg-slate-50 text-slate-700 border-slate-200';

        $babJudul = $babModel?->formatted_judul ?? ($materi?->bab ? 'Bab: ' . $materi->bab : 'Umum');
        $materiUrutan = $materi?->urutan ?? 1;
        $materiJudul = $materi?->judul ?? ($hasil->quiz?->judul ?? 'Quiz Materi');
    @endphp

    <!-- 4 RINGKASAN CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Siswa -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Informasi Siswa</p>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-extrabold text-base shrink-0 shadow-sm">
                        {{ strtoupper(substr($hasil->user->nama ?? 'U', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-bold text-slate-800 text-sm truncate">{{ $hasil->user->nama ?? '-' }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ $hasil->user->email ?? '-' }}</p>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-400">Status Akun</span>
                <span class="font-semibold {{ ($hasil->user->status ?? '') === 'aktif' ? 'text-emerald-600' : 'text-slate-600' }}">
                    {{ ucfirst($hasil->user->status ?? 'Aktif') }}
                </span>
            </div>
        </div>

        <!-- Card 2: Materi & Kurikulum -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kurikulum &amp; Materi</p>
                <div class="space-y-1.5">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold border {{ $kategoriBadge }}">
                            {{ $kategoriNama }}
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200/80">
                            Materi {{ $materiUrutan }}
                        </span>
                    </div>
                    <p class="font-bold text-slate-800 text-sm line-clamp-1" title="{{ $materiJudul }}">{{ $materiJudul }}</p>
                    <p class="text-xs text-slate-500 line-clamp-1" title="{{ $babJudul }}">{{ $babJudul }}</p>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-400">Bab Terkait</span>
                <span class="font-semibold text-slate-700 truncate max-w-[130px]">{{ $babJudul }}</span>
            </div>
        </div>

        <!-- Card 3: Skor Total -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Skor Akhir</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold {{ $hasil->skor_diperoleh >= 75 ? 'text-emerald-600' : ($hasil->skor_diperoleh >= 60 ? 'text-amber-600' : 'text-rose-600') }}">
                        {{ $hasil->skor_diperoleh }}
                    </span>
                    <span class="text-xs text-slate-400 font-semibold">/ 100</span>
                </div>
                <div class="mt-1">
                    @if($hasil->skor_diperoleh >= 75)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-bold bg-emerald-100 text-emerald-800">
                            ✓ Lulus Sangat Baik
                        </span>
                    @elseif($hasil->skor_diperoleh >= 60)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-bold bg-amber-100 text-amber-800">
                            ! Cukup (Lulus)
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-bold bg-rose-100 text-rose-800">
                            ✕ Perlu Latihan Lagi
                        </span>
                    @endif
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-400">Waktu Pengerjaan</span>
                <span class="font-semibold text-slate-600">{{ $hasil->created_at->format('d M Y, H:i') }}</span>
            </div>
        </div>

        <!-- Card 4: Statistik Jawaban -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Statistik Soal</p>
                <div class="grid grid-cols-3 gap-2 text-center">
                    <div class="p-2 rounded-xl bg-slate-50 border border-slate-100">
                        <p class="text-xs text-slate-400 font-medium">Total</p>
                        <p class="text-lg font-extrabold text-slate-800">{{ $totalSoal }}</p>
                    </div>
                    <div class="p-2 rounded-xl bg-emerald-50 border border-emerald-100">
                        <p class="text-xs text-emerald-600 font-medium">Benar</p>
                        <p class="text-lg font-extrabold text-emerald-700">{{ $totalBenar }}</p>
                    </div>
                    <div class="p-2 rounded-xl bg-rose-50 border border-rose-100">
                        <p class="text-xs text-rose-600 font-medium">Salah</p>
                        <p class="text-lg font-extrabold text-rose-700">{{ $totalSalah }}</p>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-400">Akurasi Jawaban</span>
                <span class="font-bold text-slate-700">{{ $totalSoal > 0 ? round(($totalBenar / $totalSoal) * 100) : 0 }}%</span>
            </div>
        </div>
    </div>

    <!-- DETAIL MATERI PEMBELAJARAN -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Detail Materi Pembelajaran
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Informasi materi yang menjadi bahan kuis ini.</p>
            </div>
            @if($materi)
            <div class="flex items-center gap-2 text-xs">
                <span class="px-3 py-1 rounded-lg bg-white border border-slate-200 text-slate-600 font-medium">
                    Durasi: {{ $materi->durasi_menit ?? 10 }} Menit
                </span>
                <span class="px-3 py-1 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold">
                    {{ ucfirst($materi->status ?? 'Published') }}
                </span>
            </div>
            @endif
        </div>
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <p class="text-xs font-semibold text-slate-400 uppercase">Kategori Pembelajaran</p>
                    <p class="font-bold text-slate-800 text-sm mt-1">{{ $kategoriNama }}</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <p class="text-xs font-semibold text-slate-400 uppercase">Bab Kurikulum</p>
                    <p class="font-bold text-slate-800 text-sm mt-1">{{ $babJudul }}</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <p class="text-xs font-semibold text-slate-400 uppercase">Materi Pembelajaran</p>
                    <p class="font-bold text-slate-800 text-sm mt-1">Materi {{ $materiUrutan }}: {{ $materiJudul }}</p>
                </div>
            </div>

            @if($materi && !empty($materi->deskripsi))
            <div class="p-4 rounded-xl bg-indigo-50/50 border border-indigo-100">
                <p class="text-xs font-bold text-indigo-700 uppercase mb-1">Deskripsi Materi:</p>
                <p class="text-xs text-slate-600 leading-relaxed">{{ $materi->deskripsi }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- RINCIAN JAWABAN QUIZ -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Rincian Jawaban Soal Quiz
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Analisis setiap butir soal kuis, pilihan jawaban siswa, dan kunci jawaban benar.</p>
            </div>
            <span class="text-xs font-bold px-3 py-1.5 rounded-xl bg-slate-100 text-slate-600">
                {{ $totalSoal }} Butir Soal
            </span>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($hasil->jawaban as $i => $j)
            @php
                $q = $j->quiz;
                $userAns = strtoupper(trim($j->jawaban_user ?? ''));
                $keyAns  = strtoupper(trim($q->kunci_jawaban ?? ''));
                $options = [
                    'A' => $q->pilihan_a ?? null,
                    'B' => $q->pilihan_b ?? null,
                    'C' => $q->pilihan_c ?? null,
                    'D' => $q->pilihan_d ?? null,
                ];
            @endphp
            <div class="p-6 space-y-4 hover:bg-slate-50/50 transition">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start gap-3">
                        <span class="w-8 h-8 rounded-xl flex items-center justify-center text-sm font-extrabold shrink-0 {{ $j->benar ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-rose-100 text-rose-700 border border-rose-200' }}">
                            {{ $i + 1 }}
                        </span>
                        <div>
                            <p class="font-bold text-slate-800 text-base leading-snug">
                                {{ $q->pertanyaan ?? 'Pertanyaan kuis' }}
                            </p>
                            @if(!empty($q->audio_url))
                            <div class="mt-2 p-2 bg-indigo-50/60 rounded-xl border border-indigo-100 inline-block">
                                <p class="text-[11px] font-bold text-indigo-700 mb-1 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
                                    </svg>
                                    Audio Soal {{ $q->audio_title ? '• ' . $q->audio_title : '' }}
                                </p>
                                <audio controls class="h-8 max-w-xs">
                                    <source src="{{ $q->audio_url }}" type="audio/mpeg">
                                    Browser tidak mendukung pemutar audio.
                                </audio>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div>
                        @if($j->benar)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200 shrink-0">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Benar
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-200 shrink-0">
                                <svg class="w-3.5 h-3.5 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                                Salah
                            </span>
                        @endif
                    </div>
                </div>

                <!-- 4 Pilihan Jawaban -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-1 pl-11">
                    @foreach($options as $huruf => $teks)
                    @if(!is_null($teks))
                    @php
                        $isKey = ($huruf === $keyAns);
                        $isChosen = ($huruf === $userAns);

                        $boxStyle = 'bg-white border-slate-200 text-slate-700';
                        if ($isKey && $isChosen) {
                            $boxStyle = 'bg-emerald-50/80 border-emerald-300 text-emerald-900 ring-2 ring-emerald-400/30';
                        } elseif ($isKey) {
                            $boxStyle = 'bg-emerald-50/50 border-emerald-300 text-emerald-900 font-semibold';
                        } elseif ($isChosen) {
                            $boxStyle = 'bg-rose-50/80 border-rose-300 text-rose-900 ring-2 ring-rose-400/30';
                        }
                    @endphp
                    <div class="p-3 rounded-xl border text-xs flex items-center justify-between gap-2 {{ $boxStyle }} transition">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <span class="w-6 h-6 rounded-lg flex items-center justify-center font-bold text-xs shrink-0 {{ $isKey ? 'bg-emerald-600 text-white' : ($isChosen ? 'bg-rose-600 text-white' : 'bg-slate-100 text-slate-600') }}">
                                {{ $huruf }}
                            </span>
                            <span class="truncate font-medium">{{ $teks }}</span>
                        </div>
                        <div class="shrink-0 flex items-center gap-1">
                            @if($isKey && $isChosen)
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-600 text-white">Jawaban Siswa (Kunci ✓)</span>
                            @elseif($isKey)
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">Kunci Jawaban</span>
                            @elseif($isChosen)
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-800">Jawaban Siswa ✗</span>
                            @endif
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>

                <div class="pl-11 pt-1 flex items-center gap-4 text-xs text-slate-500">
                    <span>Jawaban Siswa: <strong class="text-slate-800">{{ $userAns ?: '-' }}</strong></span>
                    <span>•</span>
                    <span>Kunci Jawaban: <strong class="text-emerald-700">{{ $keyAns ?: '-' }}</strong></span>
                    <span>•</span>
                    <span>Poin Soal: <strong class="text-slate-800">{{ $q->poin ?? 0 }} Poin</strong></span>
                </div>
            </div>
            @empty
            <div class="p-10 text-center">
                <p class="text-sm font-semibold text-slate-500">Belum ada rincian jawaban tersimpan untuk kuis ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Kelola Quiz')

@section('content')
<div class="space-y-6">

    <!-- ===================================================== -->
    <!-- HEADER                                                 -->
    <!-- ===================================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-purple-500/20 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Kelola Soal Quiz</h1>
                <p class="text-slate-500 text-sm mt-0.5">Kelola pertanyaan evaluasi per Kategori dan Bab.</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.bab') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                Kelola Bab
            </a>
            <a href="{{ route('admin.hasil-quiz') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Hasil Quiz
            </a>
            <button onclick="openQuizModal('add')" class="px-4 py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold rounded-xl transition flex items-center gap-2 shadow-lg shadow-purple-600/30 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Soal Quiz
            </button>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- STATS CARDS                                            -->
    <!-- ===================================================== -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-purple-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm font-semibold text-slate-500">Total Soal</p>
            <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalQuiz }}</p>
            <p class="text-xs text-slate-400 mt-1">Seluruh butir pertanyaan</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm font-semibold text-slate-500">Quiz Aktif</p>
            <p class="text-3xl font-extrabold text-emerald-600 mt-1">{{ $quizAktif }}</p>
            <p class="text-xs text-slate-400 mt-1">Dapat dikerjakan siswa</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm font-semibold text-slate-500">Draft</p>
            <p class="text-3xl font-extrabold text-amber-600 mt-1">{{ $quizDraft }}</p>
            <p class="text-xs text-slate-400 mt-1">Belum dipublikasikan</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-rose-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm font-semibold text-slate-500">Nonaktif</p>
            <p class="text-3xl font-extrabold text-rose-600 mt-1">{{ $quizNonaktif }}</p>
            <p class="text-xs text-slate-400 mt-1">Dinonaktifkan</p>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- FILTER & SEARCH                                        -->
    <!-- ===================================================== -->
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200">
        <!-- Filter Tabs Kategori dengan warna masing-masing -->
        <div class="flex items-center gap-2 overflow-x-auto pb-3 lg:pb-0 mb-3 lg:mb-0 scrollbar-hide">
            <button data-category="all" class="filter-btn active px-4 py-2 bg-purple-600 text-white text-sm font-semibold rounded-xl whitespace-nowrap transition">
                Semua Kategori
            </button>
            @php
                $catBadgeStyles = [
                    'Speaking'  => 'hover:bg-rose-50 hover:text-rose-600 border border-transparent hover:border-rose-200',
                    'Writing'   => 'hover:bg-blue-50 hover:text-blue-600 border border-transparent hover:border-blue-200',
                    'Reading'   => 'hover:bg-emerald-50 hover:text-emerald-600 border border-transparent hover:border-emerald-200',
                    'Listening' => 'hover:bg-purple-50 hover:text-purple-600 border border-transparent hover:border-purple-200',
                ];
            @endphp
            @foreach($kategoriList as $kat)
                <button data-category="{{ $kat->nama_kategori }}" class="filter-btn px-4 py-2 bg-slate-100 text-slate-600 text-sm font-semibold rounded-xl transition whitespace-nowrap {{ $catBadgeStyles[$kat->nama_kategori] ?? '' }}">
                    {{ $kat->nama_kategori }}
                </button>
            @endforeach
        </div>

        <!-- Search Bar -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-3 border-t border-slate-100">
            <div class="relative flex-1">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="quizSearchInput" placeholder="Cari pertanyaan, judul bab, atau materi..." 
                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition">
            </div>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- MAIN CONTENT: BAB & QUIZ LIST                          -->
    <!-- ===================================================== -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        
        <!-- Left: Quiz Nodes by Bab (Kategori -> Bab -> Soal) -->
        <div class="xl:col-span-2 space-y-4" id="babContainer">
            @php
                $catTheme = [
                    'Speaking'  => ['bg' => 'bg-rose-50', 'border' => 'border-rose-200', 'badge' => 'bg-rose-500 text-white', 'text' => 'text-rose-600'],
                    'Writing'   => ['bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'badge' => 'bg-blue-500 text-white', 'text' => 'text-blue-600'],
                    'Reading'   => ['bg' => 'bg-emerald-50', 'border' => 'border-emerald-200', 'badge' => 'bg-emerald-500 text-white', 'text' => 'text-emerald-600'],
                    'Listening' => ['bg' => 'bg-purple-50', 'border' => 'border-purple-200', 'badge' => 'bg-purple-500 text-white', 'text' => 'text-purple-600'],
                ];
            @endphp

            @forelse($babs as $bab)
                @php
                    $katNama = $bab->kategori?->nama_kategori ?? 'Umum';
                    $theme = $catTheme[$katNama] ?? ['bg' => 'bg-slate-50', 'border' => 'border-slate-200', 'badge' => 'bg-slate-500 text-white', 'text' => 'text-slate-600'];
                    $quizzesInBab = $bab->quizzes;
                    $materiTitles = $bab->materi->pluck('judul')->implode(' ');
                    $allQuestions = $bab->quizzes->pluck('pertanyaan')->implode(' ');
                    $searchString = strtolower($bab->judul . ' ' . $katNama . ' ' . $materiTitles . ' ' . $allQuestions);
                @endphp
                <div class="bab-card bg-white rounded-3xl p-6 border border-slate-200 shadow-sm" data-category="{{ $katNama }}" data-search="{{ $searchString }}">
                    <!-- Bab Header -->
                    <div class="flex items-start justify-between mb-5 pb-4 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-xl text-xs font-bold {{ $theme['badge'] }} shadow-xs">
                                {{ $katNama }}
                            </span>
                            <div>
                                <h3 class="font-extrabold text-slate-800 text-lg">Bab {{ $bab->urutan }}: {{ $bab->judul }}</h3>
                                <p class="text-xs text-slate-400 mt-0.5">
                                    {{ $bab->materi->count() }} Materi Pembelajaran &bull; {{ $quizzesInBab->count() }} Total Soal Kuis
                                </p>
                            </div>
                        </div>
                        <button onclick="addQuizToBab({{ $bab->id }}, '{{ addslashes($bab->judul) }}', '{{ $katNama }}')"
                                class="px-3.5 py-2 bg-slate-50 hover:bg-purple-50 text-purple-700 rounded-xl text-xs font-bold border border-purple-200 flex items-center gap-1.5 transition active:scale-95 shadow-xs whitespace-nowrap">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Soal
                        </button>
                    </div>

                    <!-- Kolom Quiz Terpisah Per Materi -->
                    <div class="space-y-4">
                        @forelse($bab->materi as $materi)
                            @php
                                $materiQuizzes = $materi->quiz ?: collect();
                            @endphp
                            <div class="materi-quiz-block bg-slate-50/80 rounded-2xl p-4 border border-slate-200/90 transition-all hover:border-purple-300 hover:bg-slate-50">
                                <!-- Materi Header -->
                                <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-200/70">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-9 h-9 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-sm shrink-0 shadow-xs">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <h4 class="font-bold text-slate-800 text-sm truncate">Materi {{ $materi->urutan }}: {{ $materi->judul }}</h4>
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $materiQuizzes->count() > 0 ? 'bg-purple-100 text-purple-700' : 'bg-slate-200 text-slate-600' }}">
                                                    {{ $materiQuizzes->count() }} Soal Kuis
                                                </span>
                                            </div>
                                            <p class="text-[11px] text-slate-400 mt-0.5">Quiz mandiri khusus materi ini (tidak digabung dengan materi lain)</p>
                                        </div>
                                    </div>
                                    <button onclick="addQuizToMateri({{ $materi->id_materi }}, '{{ addslashes($materi->judul) }}', {{ $bab->id }}, '{{ addslashes($bab->judul) }}', '{{ $katNama }}')"
                                            class="px-3 py-1.5 bg-white hover:bg-purple-600 hover:text-white text-purple-600 rounded-xl text-xs font-semibold border border-purple-200 shadow-xs flex items-center gap-1.5 transition active:scale-95 shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Tambah Soal
                                    </button>
                                </div>

                                <!-- Grid Soal Materi Ini -->
                                @if($materiQuizzes->isNotEmpty())
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                        @foreach($materiQuizzes as $qIndex => $q)
                                            @php
                                                $qData = [
                                                    'id_quiz'      => $q->id_quiz,
                                                    'id_bab'       => $bab->id,
                                                    'bab_judul'    => $bab->judul,
                                                    'kategori'     => $katNama,
                                                    'id_materi'    => $materi->id_materi,
                                                    'materi_judul' => $materi->judul,
                                                    'pertanyaan'   => $q->pertanyaan,
                                                    'pilihan_a'    => $q->pilihan_a,
                                                    'pilihan_b'    => $q->pilihan_b,
                                                    'pilihan_c'    => $q->pilihan_c,
                                                    'pilihan_d'    => $q->pilihan_d,
                                                    'kunci_jawaban'=> $q->kunci_jawaban,
                                                    'poin'         => $q->poin,
                                                    'status'       => $q->status ?: 'Aktif',
                                                    'urutan'       => $q->urutan ?: ($qIndex + 1),
                                                    'audio'        => $q->audio,
                                                    'audio_url'    => $q->audio_url,
                                                    'audio_title'  => $q->audio_title,
                                                    'audio_petunjuk' => $q->audio_petunjuk,
                                                ];
                                            @endphp
                                            <div class="quiz-item-card p-3 rounded-xl bg-white border border-slate-200 hover:border-purple-400 hover:shadow-xs transition cursor-pointer flex items-start gap-2.5"
                                                 onclick='selectQuizNode(@json($qData), this)'>
                                                <div class="w-7 h-7 rounded-lg bg-purple-50 text-purple-700 font-bold text-xs flex items-center justify-center shrink-0 border border-purple-100">
                                                    {{ $q->urutan ?: ($qIndex + 1) }}
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p class="text-xs font-semibold text-slate-800 line-clamp-2">{{ $q->pertanyaan }}</p>
                                                    <div class="flex items-center gap-2 mt-1.5 text-[10px] flex-wrap">
                                                        <span class="text-slate-400">Kunci: <strong class="text-purple-600 font-bold">{{ $q->kunci_jawaban }}</strong></span>
                                                        <span class="text-slate-300">•</span>
                                                        <span class="text-slate-400">{{ $q->poin }} poin</span>
                                                        <span class="text-slate-300">•</span>
                                                        <span class="px-1.5 py-0.2 rounded font-semibold {{ $q->status === 'Draft' ? 'bg-amber-100 text-amber-700' : ($q->status === 'Nonaktif' ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700') }}">
                                                            {{ $q->status ?: 'Aktif' }}
                                                        </span>
                                                        @if($q->audio)
                                                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full bg-purple-100 text-purple-700 font-bold text-[9px]">
                                                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M18.364 5.636a9 9 0 010 12.728M12 18.75V5.25L7.5 9.75H4.5v4.5h3L12 18.75z"/></svg>
                                                                Audio Passage
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="py-4 text-center text-xs text-slate-400 bg-white/70 rounded-xl border border-dashed border-slate-200">
                                        Belum ada soal kuis untuk materi <strong>"{{ $materi->judul }}"</strong>. Klik <strong>"Tambah Soal"</strong> untuk membuat quiz materi ini.
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="py-6 text-center text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                                Belum ada materi di bab ini. Tambahkan materi terlebih dahulu di menu <a href="{{ route('admin.materi') }}" class="text-blue-600 font-semibold underline">Kelola Materi</a> sebelum membuat quiz.
                            </div>
                        @endforelse

                        {{-- Fallback jika ada soal bab yang belum terhubung ke materi spesifik --}}
                        @php
                            $materiIds = $bab->materi->pluck('id_materi')->toArray();
                            $unassignedQuizzes = $bab->quizzes->whereNotIn('id_materi', $materiIds);
                        @endphp
                        @if($unassignedQuizzes->isNotEmpty())
                            <div class="materi-quiz-block bg-amber-50/70 rounded-2xl p-4 border border-amber-200">
                                <div class="flex items-center justify-between pb-3 mb-3 border-b border-amber-200">
                                    <h4 class="font-bold text-amber-900 text-sm">Soal Lainnya dalam Bab ini</h4>
                                    <span class="text-xs text-amber-700 font-semibold">{{ $unassignedQuizzes->count() }} Soal</span>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                    @foreach($unassignedQuizzes as $qIndex => $q)
                                        @php
                                            $qData = [
                                                'id_quiz'      => $q->id_quiz,
                                                'id_bab'       => $bab->id,
                                                'bab_judul'    => $bab->judul,
                                                'kategori'     => $katNama,
                                                'id_materi'    => $q->id_materi,
                                                'materi_judul' => $q->materi?->judul ?? 'Umum',
                                                'pertanyaan'   => $q->pertanyaan,
                                                'pilihan_a'    => $q->pilihan_a,
                                                'pilihan_b'    => $q->pilihan_b,
                                                'pilihan_c'    => $q->pilihan_c,
                                                'pilihan_d'    => $q->pilihan_d,
                                                'kunci_jawaban'=> $q->kunci_jawaban,
                                                'poin'         => $q->poin,
                                                'status'       => $q->status ?: 'Aktif',
                                                'urutan'       => $q->urutan ?: ($qIndex + 1),
                                            ];
                                        @endphp
                                        <div class="quiz-item-card p-3 rounded-xl bg-white border border-slate-200 hover:border-amber-400 hover:shadow-xs transition cursor-pointer flex items-start gap-2.5"
                                             onclick='selectQuizNode(@json($qData), this)'>
                                            <div class="w-7 h-7 rounded-lg bg-amber-100 text-amber-800 font-bold text-xs flex items-center justify-center shrink-0">
                                                {{ $q->urutan ?: ($qIndex + 1) }}
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-xs font-semibold text-slate-800 line-clamp-2">{{ $q->pertanyaan }}</p>
                                                <div class="flex items-center gap-2 mt-1.5 text-[10px]">
                                                    <span class="text-slate-400">Kunci: <strong class="text-amber-600 font-bold">{{ $q->kunci_jawaban }}</strong></span>
                                                    <span class="text-slate-300">•</span>
                                                    <span class="text-slate-400">{{ $q->poin }} poin</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl p-10 text-center border border-slate-200 shadow-sm">
                    <div class="w-16 h-16 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-base font-bold text-slate-700">Belum ada Bab / Quiz</p>
                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Tambahkan materi dan bab terlebih dahulu di menu Kelola Materi untuk mulai mengelola kuis per materi.</p>
                </div>
            @endforelse
        </div>

        <!-- Right: Quiz Detail Panel -->
        <div class="space-y-4">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden sticky top-4">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-purple-50 to-blue-50">
                    <div class="flex items-center gap-2 min-w-0">
                        <svg class="w-5 h-5 text-purple-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <h3 id="detailTitle" class="font-bold text-slate-800 text-sm truncate">Detail Soal Quiz</h3>
                    </div>
                    <span id="detailStatusBadge" class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded-full shrink-0">Aktif</span>
                </div>

                <!-- Content -->
                <div class="p-6 space-y-4">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-500">Kategori</span>
                            <span id="detailKategori" class="text-xs font-semibold text-slate-800">-</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-500">Bab</span>
                            <span id="detailBab" class="text-xs font-semibold text-slate-800">-</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-500">Materi Terkait</span>
                            <span id="detailMateri" class="text-xs font-semibold text-slate-800 truncate max-w-[150px]">-</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-500">Kunci Jawaban</span>
                            <span id="detailKunci" class="w-6 h-6 rounded-md bg-purple-600 text-white font-bold text-xs flex items-center justify-center">A</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-500">Bobot Poin</span>
                            <span id="detailPoin" class="text-xs font-bold text-emerald-600">10 Poin</span>
                        </div>
                    </div>

                    <!-- Pertanyaan & Opsi -->
                    <div class="border-t border-slate-100 pt-3">
                        <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Teks Pertanyaan</p>
                        <p id="detailPertanyaan" class="text-xs text-slate-800 font-medium bg-slate-50 p-3 rounded-xl border border-slate-200">
                            Pilih soal kuis di samping untuk melihat pratinjau.
                        </p>

                        <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mt-3 mb-2">Pilihan Jawaban</p>
                        <div class="space-y-1.5 text-xs" id="detailPilihanList">
                            <div class="p-2 rounded-lg bg-slate-50 border border-slate-100" id="detailPilihanA"><strong>A:</strong> -</div>
                            <div class="p-2 rounded-lg bg-slate-50 border border-slate-100" id="detailPilihanB"><strong>B:</strong> -</div>
                            <div class="p-2 rounded-lg bg-slate-50 border border-slate-100" id="detailPilihanC"><strong>C:</strong> -</div>
                            <div class="p-2 rounded-lg bg-slate-50 border border-slate-100" id="detailPilihanD"><strong>D:</strong> -</div>
                        </div>
                    <!-- Audio Passage Preview di Detail Panel -->
                    <div id="detailAudioBox" class="hidden border-t border-slate-100 pt-3">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-[11px] font-bold text-purple-700 uppercase tracking-wider flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M18.364 5.636a9 9 0 010 12.728M12 18.75V5.25L7.5 9.75H4.5v4.5h3L12 18.75z"/></svg>
                                Audio Passage
                            </span>
                            <span id="detailAudioTitle" class="text-[11px] text-slate-500 font-medium truncate max-w-[130px]">-</span>
                        </div>
                        <audio id="detailAudioPlayer" controls class="w-full h-8 mt-1"></audio>
                        <p id="detailAudioPetunjuk" class="text-[11px] text-slate-500 italic mt-1.5"></p>
                    </div>
                </div>

                <div class="space-y-2 pt-2 border-t border-slate-100">
                        <button onclick="handleDetailEdit()" class="w-full py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold rounded-xl transition flex items-center justify-center gap-2 active:scale-98">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Soal Ini
                        </button>

                        <button onclick="handleDetailDelete()" class="w-full py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-sm font-semibold rounded-xl transition flex items-center justify-center gap-2 border border-rose-200 active:scale-98">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Soal Quiz
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- ===================================================== -->
<!-- MODAL TAMBAH/EDIT QUIZ                                 -->
<!-- ===================================================== -->
<div id="quizModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-3 sm:p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between sticky top-0 bg-white z-10 rounded-t-3xl">
            <div>
                <h3 id="quizModalTitle" class="text-xl font-bold text-slate-800">Tambah Soal Quiz Baru</h3>
                <p class="text-xs text-slate-500 mt-0.5">Lengkapi pertanyaan, pilihan jawaban, dan kunci jawaban</p>
            </div>
            <button onclick="closeQuizModal()" class="p-2 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="quizForm" class="p-6 space-y-4" method="POST" action="{{ route('admin.quiz.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="quizMethod" value="">
            <input type="hidden" id="quizId" name="id">

            <!-- Pilih Bab Terkait & Materi Terkait -->
            <div class="p-4 bg-slate-50/80 rounded-2xl border border-slate-200/80 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-600 uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Penempatan Soal Kuis
                    </span>
                    <span id="quizPlacementBadge" class="hidden px-2.5 py-0.5 rounded-full text-[11px] font-bold"></span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <!-- 1. Bab Terkait -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Bab Terkait <span class="text-rose-500">*</span>
                        </label>
                        <select id="inputQuizBab" name="id_bab" required onchange="onQuizBabChanged(this.value)"
                                class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition">
                            <option value="">-- Pilih Bab Terkait --</option>
                            @php
                                $babsGrouped = $babs->groupBy(function($item) {
                                    return $item->kategori?->nama_kategori ?? 'Umum';
                                });
                            @endphp
                            @foreach($babsGrouped as $kategoriNama => $babsInKat)
                                <optgroup label="Kategori {{ $kategoriNama }}">
                                    @foreach($babsInKat as $b)
                                        <option value="{{ $b->id }}" 
                                                data-kategori="{{ $kategoriNama }}"
                                                data-urutan="{{ $b->urutan }}">
                                            Bab {{ $b->urutan }}: {{ $b->clean_judul }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <!-- 2. Materi Terkait -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Materi Terkait <span class="text-rose-500">*</span>
                        </label>
                        <select id="inputQuizMateri" name="id_materi" required onchange="onQuizMateriChanged(this)"
                                class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition">
                            <option value="">-- Pilih Materi Pembelajaran --</option>
                            @foreach($materis as $m)
                                <option value="{{ $m->id_materi }}" 
                                        data-bab-id="{{ $m->id_bab }}"
                                        data-kategori="{{ $m->kategori?->nama_kategori ?? 'Umum' }}">
                                    Materi {{ $m->urutan }}: {{ $m->judul }} ({{ $m->kategori?->nama_kategori ?? 'Umum' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <p class="text-[11px] text-slate-400 mt-0.5" id="quizPlacementHint">
                    Pilih bab terlebih dahulu untuk menyaring materi, atau pilih materi secara langsung.
                </p>
            </div>

            <!-- Pertanyaan -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Pertanyaan Quiz <span class="text-rose-500">*</span></label>
                <textarea id="inputPertanyaan" name="pertanyaan" rows="3" required
                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition resize-none"
                          placeholder="Tuliskan butir soal atau pertanyaan di sini..."></textarea>
            </div>

            <!-- Fitur Audio Passage (Kuis Listening) -->
            <div class="p-4 rounded-2xl bg-purple-50/70 border border-purple-200/80 space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-purple-600 text-white flex items-center justify-center shrink-0 shadow-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M18.364 5.636a9 9 0 010 12.728M12 18.75V5.25L7.5 9.75H4.5v4.5h3L12 18.75z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-purple-950">Audio Passage (Kuis Listening)</h4>
                            <p class="text-[11px] text-purple-700">Gunakan 1 rekaman dialog / cerita untuk 1 atau beberapa soal berturut-turut.</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full bg-purple-200 text-purple-800 text-[10px] font-bold">Opsional</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pilih dari Audio Tersedia / Kuis Lain</label>
                        <select id="inputAudioExisting" name="audio_existing" onchange="previewExistingAudio(this.value)"
                                class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition">
                            <option value="">-- Tanpa Audio / Upload Baru --</option>
                            @if(isset($audioFiles) && count($audioFiles) > 0)
                                @foreach($audioFiles as $af)
                                    <option value="{{ $af['path'] }}">{{ $af['filename'] }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Atau Upload File Audio Baru (.mp3 / .wav)</label>
                        <input type="file" id="inputAudioFile" name="audio_file" accept="audio/*" onchange="previewUploadedAudio(this)"
                               class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200 cursor-pointer">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Passage / Label Audio</label>
                        <input type="text" id="inputAudioTitle" name="audio_title" placeholder="Contoh: Passage 1: Dialog at the Airport"
                               class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Petunjuk Mendengarkan</label>
                        <input type="text" id="inputAudioPetunjuk" name="audio_petunjuk" placeholder="Contoh: Dengarkan dialog berikut untuk menjawab soal 1 - 3"
                               class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition">
                    </div>
                </div>

                <!-- Preview Audio di dalam Modal -->
                <div id="modalAudioPreviewBox" class="hidden items-center justify-between gap-3 p-2.5 bg-white rounded-xl border border-purple-200">
                    <div class="flex items-center gap-2 flex-1 min-w-0">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0 animate-pulse"></span>
                        <audio id="modalAudioElement" controls class="w-full h-8"></audio>
                    </div>
                    <button type="button" onclick="clearModalAudio()" class="px-3 py-1.5 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-lg border border-rose-200 transition shrink-0 cursor-pointer">
                        Hapus Audio
                    </button>
                </div>
                <input type="hidden" name="audio_remove" id="inputAudioRemove" value="0">
            </div>

            <!-- Pilihan Jawaban A, B, C, D -->
            <div class="space-y-3 pt-1">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pilihan Jawaban (A, B, C, D)</p>

                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-purple-100 text-purple-600 font-bold text-xs flex items-center justify-center shrink-0">A</span>
                        <input type="text" id="inputPilihanA" name="pilihan_a" required
                               class="flex-1 px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition"
                               placeholder="Opsi jawaban A">
                    </div>
                </div>

                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-purple-100 text-purple-600 font-bold text-xs flex items-center justify-center shrink-0">B</span>
                        <input type="text" id="inputPilihanB" name="pilihan_b" required
                               class="flex-1 px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition"
                               placeholder="Opsi jawaban B">
                    </div>
                </div>

                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-purple-100 text-purple-600 font-bold text-xs flex items-center justify-center shrink-0">C</span>
                        <input type="text" id="inputPilihanC" name="pilihan_c" required
                               class="flex-1 px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition"
                               placeholder="Opsi jawaban C">
                    </div>
                </div>

                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-purple-100 text-purple-600 font-bold text-xs flex items-center justify-center shrink-0">D</span>
                        <input type="text" id="inputPilihanD" name="pilihan_d" required
                               class="flex-1 px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition"
                               placeholder="Opsi jawaban D">
                    </div>
                </div>
            </div>

            <!-- Kunci Jawaban & Poin & Status -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kunci Jawaban <span class="text-rose-500">*</span></label>
                    <select id="inputKunciJawaban" name="kunci_jawaban" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition">
                        <option value="A">Opsi A</option>
                        <option value="B">Opsi B</option>
                        <option value="C">Opsi C</option>
                        <option value="D">Opsi D</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Poin</label>
                    <input type="number" id="inputPoin" name="poin" value="10" min="1" max="100" required
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                    <select id="inputQuizStatus" name="status"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition">
                        <option value="Aktif">Aktif / Published</option>
                        <option value="Draft">Draft</option>
                        <option value="Nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="pt-4 flex gap-3 border-t border-slate-100">
                <button type="button" onclick="closeQuizModal()" class="flex-1 px-4 py-2.5 border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition text-sm">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-xl shadow-lg shadow-purple-600/30 transition text-sm">
                    Simpan Soal Quiz
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Soal -->
<div id="deleteQuizModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full p-6 text-center">
        <div class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-slate-800 mb-1">Hapus Soal Quiz Ini?</h3>
        <p class="text-xs text-slate-500 mb-6">Soal ini akan dihapus permanen dari sistem.</p>
        <form id="deleteQuizForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex gap-3">
                <button type="button" onclick="closeDeleteQuizModal()" class="flex-1 py-2.5 border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition text-sm">
                    Batal
                </button>
                <button type="submit" class="flex-1 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-xl transition text-sm">
                    Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@php
    $quizMaterisJson = $materis->map(function($m) {
        return [
            'id_materi'   => $m->id_materi,
            'id_bab'      => $m->id_bab,
            'id_kategori' => $m->id_kategori,
            'kategori'    => $m->kategori?->nama_kategori ?? 'Umum',
            'bab_judul'   => $m->babModel?->clean_judul ?? 'Bab Umum',
            'bab_urutan'  => $m->babModel?->urutan ?? 1,
            'urutan'      => $m->urutan,
            'judul'       => $m->judul,
        ];
    })->values();

    $quizBabsJson = $babs->map(function($b) {
        return [
            'id'          => $b->id,
            'id_kategori' => $b->id_kategori,
            'kategori'    => $b->kategori?->nama_kategori ?? 'Umum',
            'urutan'      => $b->urutan,
            'judul'       => $b->clean_judul,
        ];
    })->values();
@endphp

@push('scripts')
<script>
const URL_QUIZ_STORE  = @json(route('admin.quiz.store'));
const URL_QUIZ_UPDATE = @json(route('admin.quiz.update', ['__ID__']));

const QUIZ_MATERIS = {!! json_encode($quizMaterisJson) !!};
const QUIZ_BABS    = {!! json_encode($quizBabsJson) !!};

let selectedNodeData = null;

function selectQuizNode(nodeData, element) {
    selectedNodeData = nodeData;

    // Highlight aktif
    document.querySelectorAll('.quiz-item-card').forEach(el => {
        el.classList.remove('border-purple-500', 'bg-purple-50/50', 'ring-2', 'ring-purple-200');
    });
    if (element) {
        element.classList.add('border-purple-500', 'bg-purple-50/50', 'ring-2', 'ring-purple-200');
    }

    // Update panel kanan
    document.getElementById('detailTitle').textContent       = 'Soal #' + nodeData.urutan;
    document.getElementById('detailKategori').textContent    = nodeData.kategori;
    document.getElementById('detailBab').textContent         = nodeData.bab_judul;
    document.getElementById('detailMateri').textContent      = nodeData.materi_judul;
    document.getElementById('detailKunci').textContent       = nodeData.kunci_jawaban;
    document.getElementById('detailPoin').textContent        = nodeData.poin + ' Poin';
    document.getElementById('detailStatusBadge').textContent = nodeData.status;

    document.getElementById('detailPertanyaan').textContent  = nodeData.pertanyaan;
    document.getElementById('detailPilihanA').innerHTML     = '<strong>A:</strong> ' + escapeHtml(nodeData.pilihan_a);
    document.getElementById('detailPilihanB').innerHTML     = '<strong>B:</strong> ' + escapeHtml(nodeData.pilihan_b);
    document.getElementById('detailPilihanC').innerHTML     = '<strong>C:</strong> ' + escapeHtml(nodeData.pilihan_c);
    document.getElementById('detailPilihanD').innerHTML     = '<strong>D:</strong> ' + escapeHtml(nodeData.pilihan_d);

    // Audio Passage Preview
    const audioBox = document.getElementById('detailAudioBox');
    const audioPlayer = document.getElementById('detailAudioPlayer');
    const audioTitle = document.getElementById('detailAudioTitle');
    const audioPetunjuk = document.getElementById('detailAudioPetunjuk');

    if (nodeData.audio_url || nodeData.audio) {
        const audioSrc = nodeData.audio_url || ('/' + String(nodeData.audio).replace(/^\/+/, ''));
        audioBox.classList.remove('hidden');
        audioPlayer.src = audioSrc;
        audioTitle.textContent = nodeData.audio_title || 'Audio Passage';
        audioPetunjuk.textContent = nodeData.audio_petunjuk ? `"${nodeData.audio_petunjuk}"` : '';
    } else {
        audioBox.classList.add('hidden');
        audioPlayer.pause();
        audioPlayer.removeAttribute('src');
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text || '';
    return div.innerHTML;
}

function handleDetailEdit() {
    if (!selectedNodeData || !selectedNodeData.id_quiz) {
        if (typeof window.showAlert === 'function') {
            window.showAlert('Pilih Soal Kuis', 'Silakan pilih soal kuis yang ingin diedit terlebih dahulu.', 'info');
        } else if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'info',
                title: 'Pilih Soal Kuis',
                html: '<p class="text-sm text-slate-600">Silakan pilih soal kuis yang ingin diedit terlebih dahulu.</p>',
                customClass: { popup: 'englify-swal', confirmButton: 'englify-swal-confirm' }
            });
        }
        return;
    }
    openQuizModal('edit', selectedNodeData);
}

function handleDetailDelete() {
    if (!selectedNodeData || !selectedNodeData.id_quiz) {
        if (typeof window.showAlert === 'function') {
            window.showAlert('Pilih Soal Kuis', 'Silakan pilih soal kuis yang ingin dihapus terlebih dahulu.', 'info');
        } else if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'info',
                title: 'Pilih Soal Kuis',
                html: '<p class="text-sm text-slate-600">Silakan pilih soal kuis yang ingin dihapus terlebih dahulu.</p>',
                customClass: { popup: 'englify-swal', confirmButton: 'englify-swal-confirm' }
            });
        }
        return;
    }
    openDeleteQuizModal(selectedNodeData.id_quiz);
}

function addQuizToMateri(materiId, materiJudul, babId, babJudul, kategori) {
    openQuizModal('add', {
        id_materi: materiId,
        materi_judul: materiJudul,
        id_bab: babId,
        bab_judul: babJudul,
        kategori: kategori
    });
}

function addQuizToBab(babId, babJudul, kategori) {
    openQuizModal('add', { id_bab: babId, bab_judul: babJudul, kategori: kategori });
}

function onQuizBabChanged(babId) {
    renderMateriOptions(babId, null);
    updatePlacementBadge();
}

function onQuizMateriChanged(select) {
    const selectedOption = select.options[select.selectedIndex];
    const babId = selectedOption ? selectedOption.dataset.babId : null;
    if (babId) {
        const babSelect = document.getElementById('inputQuizBab');
        if (babSelect && String(babSelect.value) !== String(babId)) {
            babSelect.value = babId;
            renderMateriOptions(babId, select.value);
            return;
        }
    }
    updatePlacementBadge();
}

function renderMateriOptions(selectedBabId, selectedMateriId = null) {
    const materiSelect = document.getElementById('inputQuizMateri');
    if (!materiSelect) return;

    const currentVal = (selectedMateriId !== null && selectedMateriId !== undefined) 
        ? String(selectedMateriId) 
        : String(materiSelect.value || '');

    materiSelect.innerHTML = '';

    if (selectedBabId) {
        const filtered = QUIZ_MATERIS.filter(m => String(m.id_bab) === String(selectedBabId));
        if (filtered.length === 0) {
            const opt = document.createElement('option');
            opt.value = '';
            opt.textContent = '-- Belum ada materi di bab ini --';
            materiSelect.appendChild(opt);
        } else {
            const defaultOpt = document.createElement('option');
            defaultOpt.value = '';
            defaultOpt.textContent = '-- Pilih Materi Pembelajaran --';
            materiSelect.appendChild(defaultOpt);

            let hasSelected = false;
            filtered.forEach(m => {
                const opt = document.createElement('option');
                opt.value = m.id_materi;
                opt.dataset.babId = m.id_bab;
                opt.dataset.kategori = m.kategori;
                opt.textContent = `Materi ${m.urutan}: ${m.judul}`;
                if (currentVal && String(m.id_materi) === currentVal) {
                    opt.selected = true;
                    hasSelected = true;
                }
                materiSelect.appendChild(opt);
            });

            // Jika hanya ada 1 materi dan belum ada yang dipilih, langsung pilih otomatis
            if (filtered.length === 1 && !hasSelected && !selectedMateriId) {
                materiSelect.value = filtered[0].id_materi;
            }
        }
    } else {
        // Jika belum pilih Bab: Tampilkan semua materi dengan optgroup per bab
        const defaultOpt = document.createElement('option');
        defaultOpt.value = '';
        defaultOpt.textContent = '-- Pilih Bab Terlebih Dahulu (atau Pilih Materi Langsung) --';
        materiSelect.appendChild(defaultOpt);

        const groups = {};
        QUIZ_MATERIS.forEach(m => {
            const key = `[${m.kategori}] Bab ${m.bab_urutan}: ${m.bab_judul}`;
            if (!groups[key]) groups[key] = [];
            groups[key].push(m);
        });

        for (const groupLabel in groups) {
            const optGroup = document.createElement('optgroup');
            optGroup.label = groupLabel;
            groups[groupLabel].forEach(m => {
                const opt = document.createElement('option');
                opt.value = m.id_materi;
                opt.dataset.babId = m.id_bab;
                opt.dataset.kategori = m.kategori;
                opt.textContent = `Materi ${m.urutan}: ${m.judul}`;
                if (currentVal && String(m.id_materi) === currentVal) {
                    opt.selected = true;
                }
                optGroup.appendChild(opt);
            });
            materiSelect.appendChild(optGroup);
        }
    }

    updatePlacementBadge();
}

function updatePlacementBadge() {
    const babSelect = document.getElementById('inputQuizBab');
    const badge = document.getElementById('quizPlacementBadge');
    const hint = document.getElementById('quizPlacementHint');
    if (!badge || !babSelect) return;

    const selectedOption = babSelect.options[babSelect.selectedIndex];
    if (selectedOption && selectedOption.value) {
        const kat = selectedOption.dataset.kategori || 'Umum';
        const urutan = selectedOption.dataset.urutan || '1';
        badge.textContent = `${kat} • Bab ${urutan}`;
        badge.className = 'px-2.5 py-0.5 rounded-full text-[11px] font-bold border transition';

        if (kat === 'Writing') {
            badge.classList.add('bg-blue-100', 'text-blue-700', 'border-blue-200');
        } else if (kat === 'Listening') {
            badge.classList.add('bg-purple-100', 'text-purple-700', 'border-purple-200');
        } else if (kat === 'Reading') {
            badge.classList.add('bg-emerald-100', 'text-emerald-700', 'border-emerald-200');
        } else if (kat === 'Speaking') {
            badge.classList.add('bg-rose-100', 'text-rose-700', 'border-rose-200');
        } else {
            badge.classList.add('bg-slate-100', 'text-slate-700', 'border-slate-200');
        }

        badge.classList.remove('hidden');
        if (hint) hint.textContent = `Menambahkan butir soal untuk Bab ${urutan} (${kat}).`;
    } else {
        badge.classList.add('hidden');
        if (hint) hint.textContent = 'Pilih bab terlebih dahulu untuk menyaring materi, atau pilih materi secara langsung.';
    }
}

// =============================================
// AUDIO PASSAGE PREVIEW DI MODAL
// =============================================
function previewExistingAudio(val) {
    const previewBox = document.getElementById('modalAudioPreviewBox');
    const audioElement = document.getElementById('modalAudioElement');
    const audioRemove = document.getElementById('inputAudioRemove');
    audioRemove.value = '0';

    if (val) {
        previewBox.classList.remove('hidden');
        previewBox.classList.add('flex');
        audioElement.src = '/' + val.replace(/^\/+/, '');
        audioElement.play().catch(() => {});
    } else {
        previewBox.classList.add('hidden');
        previewBox.classList.remove('flex');
        audioElement.pause();
        audioElement.removeAttribute('src');
    }
}

function previewUploadedAudio(input) {
    const previewBox = document.getElementById('modalAudioPreviewBox');
    const audioElement = document.getElementById('modalAudioElement');
    const audioRemove = document.getElementById('inputAudioRemove');
    audioRemove.value = '0';

    if (input.files && input.files[0]) {
        const file = input.files[0];
        const url = URL.createObjectURL(file);
        previewBox.classList.remove('hidden');
        previewBox.classList.add('flex');
        audioElement.src = url;
        audioElement.play().catch(() => {});
    }
}

function clearModalAudio() {
    document.getElementById('inputAudioExisting').value = '';
    const audioFileInput = document.getElementById('inputAudioFile');
    if (audioFileInput) audioFileInput.value = '';
    document.getElementById('inputAudioTitle').value = '';
    document.getElementById('inputAudioPetunjuk').value = '';
    document.getElementById('inputAudioRemove').value = '1';

    const previewBox = document.getElementById('modalAudioPreviewBox');
    const audioElement = document.getElementById('modalAudioElement');
    previewBox.classList.add('hidden');
    previewBox.classList.remove('flex');
    audioElement.pause();
    audioElement.removeAttribute('src');
}

// =============================================
// MODAL TAMBAH/EDIT
// =============================================
function openQuizModal(type = 'add', nodeData = null) {
    const modal = document.getElementById('quizModal');
    const title = document.getElementById('quizModalTitle');
    const form  = document.getElementById('quizForm');

    const audioExisting = document.getElementById('inputAudioExisting');
    const audioFileInput = document.getElementById('inputAudioFile');
    const audioTitle = document.getElementById('inputAudioTitle');
    const audioPetunjuk = document.getElementById('inputAudioPetunjuk');
    const audioRemove = document.getElementById('inputAudioRemove');
    const previewBox = document.getElementById('modalAudioPreviewBox');
    const audioElement = document.getElementById('modalAudioElement');

    audioRemove.value = '0';
    if (audioFileInput) audioFileInput.value = '';

    if (type === 'edit' && nodeData && nodeData.id_quiz) {
        title.textContent = 'Edit Soal Quiz';
        form.action = URL_QUIZ_UPDATE.replace('__ID__', nodeData.id_quiz);
        document.getElementById('quizMethod').value = 'PUT';
        document.getElementById('quizId').value     = nodeData.id_quiz;

        let editBabId = nodeData.id_bab ? String(nodeData.id_bab) : '';
        if (!editBabId && nodeData.id_materi) {
            const foundM = QUIZ_MATERIS.find(m => String(m.id_materi) === String(nodeData.id_materi));
            if (foundM && foundM.id_bab) editBabId = String(foundM.id_bab);
        }

        document.getElementById('inputQuizBab').value = editBabId;
        renderMateriOptions(editBabId, nodeData.id_materi || null);
        updatePlacementBadge();

        document.getElementById('inputPertanyaan').value   = nodeData.pertanyaan || '';
        document.getElementById('inputPilihanA').value     = nodeData.pilihan_a || '';
        document.getElementById('inputPilihanB').value     = nodeData.pilihan_b || '';
        document.getElementById('inputPilihanC').value     = nodeData.pilihan_c || '';
        document.getElementById('inputPilihanD').value     = nodeData.pilihan_d || '';
        document.getElementById('inputKunciJawaban').value = nodeData.kunci_jawaban || 'A';
        document.getElementById('inputPoin').value         = nodeData.poin || 10;
        document.getElementById('inputQuizStatus').value   = nodeData.status || 'Aktif';

        // Set audio info
        audioTitle.value = nodeData.audio_title || '';
        audioPetunjuk.value = nodeData.audio_petunjuk || '';
        if (nodeData.audio) {
            audioExisting.value = nodeData.audio;
            previewBox.classList.remove('hidden');
            previewBox.classList.add('flex');
            audioElement.src = nodeData.audio_url || ('/' + String(nodeData.audio).replace(/^\/+/, ''));
        } else {
            audioExisting.value = '';
            previewBox.classList.add('hidden');
            previewBox.classList.remove('flex');
            audioElement.pause();
            audioElement.removeAttribute('src');
        }
    } else {
        title.textContent = 'Tambah Soal Quiz Baru';
        form.reset();
        form.action = URL_QUIZ_STORE;
        document.getElementById('quizMethod').value = '';
        document.getElementById('quizId').value     = '';
        document.getElementById('inputPoin').value = 10;
        document.getElementById('inputQuizStatus').value = 'Aktif';

        audioExisting.value = '';
        audioTitle.value = '';
        audioPetunjuk.value = '';
        previewBox.classList.add('hidden');
        previewBox.classList.remove('flex');
        audioElement.pause();
        audioElement.removeAttribute('src');

        let targetBabId = '';
        let targetMateriId = null;

        if (nodeData) {
            if (nodeData.id_bab) {
                targetBabId = String(nodeData.id_bab);
            }
            if (nodeData.id_materi) {
                targetMateriId = String(nodeData.id_materi);
                if (!targetBabId) {
                    const matchedM = QUIZ_MATERIS.find(m => String(m.id_materi) === String(nodeData.id_materi));
                    if (matchedM && matchedM.id_bab) targetBabId = String(matchedM.id_bab);
                }
            }
            if (nodeData.materi_judul) {
                title.textContent = `Tambah Soal: ${nodeData.materi_judul}`;
            }
        }

        document.getElementById('inputQuizBab').value = targetBabId;
        renderMateriOptions(targetBabId, targetMateriId);
        updatePlacementBadge();
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeQuizModal() {
    const audioElement = document.getElementById('modalAudioElement');
    if (audioElement) {
        audioElement.pause();
        audioElement.removeAttribute('src');
    }
    document.getElementById('quizModal').classList.add('hidden');
    document.getElementById('quizModal').classList.remove('flex');
    document.getElementById('quizForm').reset();
}

function openDeleteQuizModal(id) {
    document.getElementById('deleteQuizForm').action = `/admin/quiz/${id}`;
    document.getElementById('deleteQuizModal').classList.remove('hidden');
    document.getElementById('deleteQuizModal').classList.add('flex');
}

function closeDeleteQuizModal() {
    document.getElementById('deleteQuizModal').classList.add('hidden');
    document.getElementById('deleteQuizModal').classList.remove('flex');
}

// =============================================
// CATEGORY FILTER & SEARCH
// =============================================
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('bg-purple-600', 'text-white');
            b.classList.add('bg-slate-100', 'text-slate-600');
        });
        this.classList.remove('bg-slate-100', 'text-slate-600');
        this.classList.add('bg-purple-600', 'text-white');

        const cat = this.getAttribute('data-category');
        applyFilters(cat, document.getElementById('quizSearchInput').value.trim().toLowerCase());
    });
});

document.getElementById('quizSearchInput').addEventListener('input', function() {
    const activeBtn = document.querySelector('.filter-btn.bg-purple-600');
    const cat = activeBtn ? activeBtn.getAttribute('data-category') : 'all';
    applyFilters(cat, this.value.trim().toLowerCase());
});

function applyFilters(category, searchQuery) {
    document.querySelectorAll('.bab-card').forEach(card => {
        const cardCat    = card.getAttribute('data-category');
        const cardSearch = card.getAttribute('data-search') || '';

        const matchCat    = (category === 'all' || cardCat === category);
        const matchSearch = (searchQuery === '' || cardSearch.includes(searchQuery));

        if (matchCat && matchSearch) {
            card.classList.remove('hidden');
        } else {
            card.classList.add('hidden');
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    renderMateriOptions('', null);
    const firstNode = document.querySelector('.quiz-item-card');
    if (firstNode) {
        firstNode.click();
    }
});
</script>
@endpush
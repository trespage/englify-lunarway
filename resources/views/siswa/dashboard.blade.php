@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="space-y-6">

    <!-- ===================================================== -->
    <!-- ROW 1: WELCOME BANNER + LIVE CLOCK CARD               -->
    <!-- ===================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-stretch">
        <!-- Welcome Banner (2/3) -->
        <div class="lg:col-span-2 bg-gradient-to-br from-[#D6EBEE] via-[#D6EBEE]/60 to-[#97CADB]/30 rounded-2xl p-4 sm:p-6 relative overflow-hidden border border-[#97CADB]/40 shadow-xs flex flex-col justify-between">
            <div class="absolute top-4 right-36 text-sky-400 text-xs opacity-60 animate-pulse">✧</div>
            <div class="absolute bottom-4 right-44 text-indigo-300 text-xs opacity-60">✦</div>
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/30 rounded-full blur-2xl pointer-events-none"></div>

            <div class="flex items-center gap-3 sm:gap-4 mb-4 sm:mb-5">
                <!-- User Avatar / Greeting Icon -->
                <div class="relative shrink-0 group">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-br from-[#018ABE] to-[#02457A] p-0.5 shadow-md shadow-[#018ABE]/20 flex items-center justify-center">
                        <div class="w-full h-full rounded-[14px] bg-white flex items-center justify-center overflow-hidden p-0.5">
                            <img src="{{ auth()->user()->avatar_url }}" alt="Avatar {{ auth()->user()->nama }}" class="header-user-avatar w-full h-full object-contain transition-transform duration-300 group-hover:scale-110">
                        </div>
                    </div>
                    <span class="absolute -bottom-1 -right-1 w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-500 border-2 border-white flex items-center justify-center text-[9px] sm:text-[10px] text-white shadow-xs" title="Online & Aktif">✓</span>
                </div>

                <div class="flex-1 min-w-0">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-white/80 border border-[#97CADB]/50 text-xs font-bold text-[#018ABE] mb-1.5 shadow-2xs">
                        <span id="siswaGreetingIcon">👋</span>
                        <span id="siswaGreetingTime">Selamat Datang</span>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-800 leading-tight">
                        Halo, <span class="text-[#018ABE]">{{ auth()->user()->nama }}</span>! ✨
                    </h1>
                    <p class="text-slate-600 text-xs sm:text-sm mt-1 leading-relaxed">
                        Fokus pada materi pembelajaranmu hari ini. Belajar teratur langkah demi langkah untuk hasil yang maksimal!
                    </p>
                </div>

                <div class="hidden sm:flex items-center gap-2 shrink-0 pl-2">
                    <div class="text-right">
                        <p class="font-cute text-base text-[#018ABE] leading-tight transform -rotate-3">Sedikit demi</p>
                        <p class="font-cute text-base text-[#018ABE] leading-tight transform -rotate-3">sedikit,</p>
                        <p class="font-cute text-base text-[#018ABE] leading-tight transform -rotate-3">lama-lama jadi</p>
                        <p class="font-cute text-base text-[#018ABE] leading-tight transform -rotate-3">bisa! 🐾</p>
                    </div>
                    <img src="{{ asset('images/cat-welcome.png') }}" alt="Englify Cat" class="w-20 h-auto object-contain drop-shadow-sm">
                </div>
            </div>

            <!-- Quick Action Shortcuts -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-2.5 pt-2 border-t border-[#97CADB]/30">
                <a href="{{ route('siswa.materi') }}" class="bg-white/80 backdrop-blur hover:bg-white rounded-xl p-2 sm:p-2.5 border border-white/90 shadow-2xs hover:shadow-xs transition group flex items-center gap-2 sm:gap-2.5">
                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-[#D6EBEE] group-hover:bg-[#97CADB]/60 flex items-center justify-center shrink-0 transition">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <span class="block text-xs font-bold text-slate-800 leading-tight truncate">Materi</span>
                        <span class="block text-[10px] text-slate-500 truncate">Daftar bacaan</span>
                    </div>
                </a>

                <a href="{{ route('siswa.peta-quiz') }}" class="bg-white/80 backdrop-blur hover:bg-white rounded-xl p-2 sm:p-2.5 border border-white/90 shadow-2xs hover:shadow-xs transition group flex items-center gap-2 sm:gap-2.5">
                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-amber-100 group-hover:bg-amber-200 flex items-center justify-center shrink-0 transition">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <span class="block text-xs font-bold text-slate-800 leading-tight truncate">Peta Quiz</span>
                        <span class="block text-[10px] text-slate-500 truncate">Alur tantangan</span>
                    </div>
                </a>

                <a href="{{ route('siswa.progres') }}" class="bg-white/80 backdrop-blur hover:bg-white rounded-xl p-2 sm:p-2.5 border border-white/90 shadow-2xs hover:shadow-xs transition group flex items-center gap-2 sm:gap-2.5">
                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-emerald-100 group-hover:bg-emerald-200 flex items-center justify-center shrink-0 transition">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <span class="block text-xs font-bold text-slate-800 leading-tight truncate">Progress</span>
                        <span class="block text-[10px] text-slate-500 truncate">Lihat statistik</span>
                    </div>
                </a>

                <a href="{{ route('siswa.reminder') }}" class="bg-white/80 backdrop-blur hover:bg-white rounded-xl p-2 sm:p-2.5 border border-white/90 shadow-2xs hover:shadow-xs transition group flex items-center gap-2 sm:gap-2.5">
                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-rose-100 group-hover:bg-rose-200 flex items-center justify-center shrink-0 transition relative">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @if($unreadPesanCount > 0)
                            <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-white"></span>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <span class="block text-xs font-bold text-slate-800 leading-tight truncate">Reminder</span>
                        <span class="block text-[10px] text-slate-500 truncate">{{ $unreadPesanCount > 0 ? $unreadPesanCount . ' baru' : 'Kotak masuk' }}</span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Live Clock & Motivation Card (1/3) -->
        <div id="liveClockCardSiswa" class="relative overflow-hidden rounded-2xl shadow-sm border border-[#97CADB]/40 bg-gradient-to-br from-[#018ABE] to-[#02457A] p-4 sm:p-5 text-white flex flex-col justify-between gap-3">
            <div class="absolute -top-6 -right-6 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>

            <div class="relative space-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/15 backdrop-blur border border-white/20">
                        <span id="siswaGreetingIconBadge" class="text-sm">☀️</span>
                        <span id="siswaGreetingTextBadge" class="text-[10px] font-extrabold text-white uppercase tracking-wider">Semangat Belajar</span>
                    </div>
                    <div class="flex items-center gap-1 text-[10px] font-semibold text-sky-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>WIB</span>
                    </div>
                </div>

                <div class="flex items-end justify-between pt-1">
                    <div>
                        <p id="liveDateSiswa" class="text-xs font-medium text-sky-100">
                            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                        </p>
                        <div class="flex items-baseline gap-1 mt-0.5">
                            <span id="liveTimeSiswa" class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white tabular-nums leading-none">
                                {{ \Carbon\Carbon::now()->format('H:i') }}
                            </span>
                            <span id="liveSecondsSiswa" class="text-xs sm:text-sm font-bold text-sky-200/80 tabular-nums">
                                :{{ \Carbon\Carbon::now()->format('s') }}
                            </span>
                        </div>
                    </div>

                    <div class="text-right">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-white/15 backdrop-blur text-[11px] font-bold text-amber-300 border border-white/20 shadow-2xs">
                            <span>🔥</span>
                            <span>{{ ($materiSelesai + $quizSelesai) > 0 ? 'Aktif' : 'Mulai!' }}</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Mini Progress Waktu Hari Ini -->
            <div class="relative space-y-1.5 py-1">
                <div class="flex items-center justify-between text-[10px] text-sky-100 font-semibold">
                    <span>Waktu Hari Ini Berjalan</span>
                    <span id="siswaDayProgress" class="font-bold text-white">0%</span>
                </div>
                <div class="w-full h-1.5 bg-black/20 rounded-full overflow-hidden border border-white/10">
                    <div id="siswaDayProgressBar" class="h-full bg-gradient-to-r from-emerald-300 to-sky-300 rounded-full transition-all duration-1000" style="width: 0%"></div>
                </div>
            </div>

            <!-- Daily Motivation Quote -->
            <div class="relative pt-2 border-t border-white/15">
                <p id="dailyQuoteSiswa" class="text-xs font-medium text-sky-100 italic leading-snug">
                    "A little progress each day adds up to big results."
                </p>
            </div>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- ROW 2: RINGKASAN INTI STATISTIK (4 STAT CARDS)        -->
    <!-- ===================================================== -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-4">
        <!-- 1. Materi Selesai -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#97CADB]/30 shadow-xs hover:shadow-md transition">
            <div class="flex items-start justify-between mb-2 sm:mb-3">
                <div class="w-10 h-10 rounded-xl bg-[#D6EBEE] flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <span class="text-[11px] font-bold text-[#018ABE] bg-[#D6EBEE] px-2 py-0.5 rounded-full">
                    {{ $totalMateri > 0 ? round(($materiSelesai / $totalMateri) * 100) : 0 }}%
                </span>
            </div>
            <p class="text-xs font-semibold text-slate-500">Materi Selesai</p>
            <p class="text-2xl sm:text-3xl font-extrabold text-slate-800 mt-0.5">{{ $materiSelesai }}</p>
            <p class="text-[11px] text-slate-400 mt-0.5">dari {{ $totalMateri }} materi</p>
        </div>

        <!-- 2. Quiz Selesai -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#97CADB]/30 shadow-xs hover:shadow-md transition">
            <div class="flex items-start justify-between mb-2 sm:mb-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                    {{ $totalQuiz > 0 ? round(($quizSelesai / $totalQuiz) * 100) : 0 }}%
                </span>
            </div>
            <p class="text-xs font-semibold text-slate-500">Quiz Selesai</p>
            <p class="text-2xl sm:text-3xl font-extrabold text-slate-800 mt-0.5">{{ $quizSelesai }}</p>
            <p class="text-[11px] text-slate-400 mt-0.5">dari {{ $totalQuiz }} quiz</p>
        </div>

        <!-- 3. Rata-rata Nilai -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#97CADB]/30 shadow-xs hover:shadow-md transition">
            <div class="flex items-start justify-between mb-2 sm:mb-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <span class="text-[11px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full">
                    {{ $quizSelesai > 0 ? ($rataRataNilai >= 80 ? 'Bagus!' : ($rataRataNilai >= 60 ? 'Cukup' : 'Semangat!')) : 'Belum Ada' }}
                </span>
            </div>
            <p class="text-xs font-semibold text-slate-500">Rata-rata Nilai</p>
            <p class="text-2xl sm:text-3xl font-extrabold text-amber-600 mt-0.5">{{ $quizSelesai > 0 ? round($rataRataNilai) . '%' : '-' }}</p>
            <p class="text-[11px] text-slate-400 mt-0.5">dari seluruh kuis</p>
        </div>

        <!-- 4. Total Poin -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#97CADB]/30 shadow-xs hover:shadow-md transition">
            <div class="flex items-start justify-between mb-2 sm:mb-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <span class="text-[11px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full">XP</span>
            </div>
            <p class="text-xs font-semibold text-slate-500">Total Poin</p>
            <p class="text-2xl sm:text-3xl font-extrabold text-indigo-600 mt-0.5">{{ number_format($totalSkor, 0, ',', '.') }}</p>
            <p class="text-[11px] text-slate-400 mt-0.5">poin terkumpul</p>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- ROW 3: KARTU AKSI UTAMA ("LANJUTKAN BELAJAR")          -->
    <!-- ===================================================== -->
    @if($materiLanjutan)
        <div class="bg-gradient-to-r from-white via-white to-[#D6EBEE]/40 rounded-2xl border border-[#97CADB]/40 p-5 sm:p-6 shadow-xs hover:shadow-md transition">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start sm:items-center gap-3.5 sm:gap-4 min-w-0 flex-1">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-br from-[#018ABE] to-[#02457A] flex items-center justify-center text-white shrink-0 shadow-md shadow-[#018ABE]/20">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2 flex-wrap mb-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wide bg-[#D6EBEE] text-[#02457A]">
                                Rekomendasi Belajar
                            </span>
                            @if($materiLanjutan->kategori)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $materiLanjutan->kategori->color['badge'] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ $materiLanjutan->kategori->nama_kategori }}
                                </span>
                            @endif
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-800 leading-tight truncate" title="{{ $materiLanjutan->judul }}">
                            {{ $materiLanjutan->judul }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">
                            {{ $materiLanjutan->babModel ? 'Bab ' . $materiLanjutan->babModel->urutan . ' – ' . $materiLanjutan->babModel->judul : 'Kurikulum Englify' }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2.5 shrink-0 self-stretch sm:self-center">
                    <a href="{{ route('siswa.materi.baca', $materiLanjutan->id_materi) }}" class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#018ABE] hover:bg-[#02457A] text-white font-bold text-xs sm:text-sm shadow-sm hover:shadow transition">
                        <span>Lanjutkan Membaca</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <a href="{{ route('siswa.peta-quiz') }}" class="inline-flex items-center justify-center px-3.5 py-2.5 rounded-xl bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs sm:text-sm border border-slate-200 transition" title="Buka Peta Quiz">
                        <span>Peta Quiz</span>
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-2xl border border-[#97CADB]/30 p-6 text-center shadow-xs">
            <span class="text-3xl mb-2 block">🎉</span>
            <h3 class="text-base font-bold text-slate-800">Luar Biasa! Semua Materi Telah Kamu Selesaikan</h3>
            <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">
                Kamu telah menuntaskan semua materi bacaan. Asah terus pemahamanmu melalui tantangan quiz di Peta Quiz!
            </p>
            <div class="mt-4">
                <a href="{{ route('siswa.peta-quiz') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#018ABE] hover:bg-[#02457A] text-white font-bold text-xs shadow-xs transition">
                    <span>Buka Peta Quiz</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    @endif

    <!-- ===================================================== -->
    <!-- ROW 4: PROGRESS BELAJAR PER KATEGORI (DIVISI)         -->
    <!-- ===================================================== -->
    <div class="bg-white rounded-2xl border border-[#97CADB]/30 shadow-xs overflow-hidden">
        <div class="px-5 sm:px-6 py-4 border-b border-[#97CADB]/20 flex items-center justify-between">
            <div>
                <h3 class="text-sm sm:text-base font-bold text-slate-800 flex items-center gap-2">
                    <span class="text-[#018ABE]">📊</span>
                    <span>Progres Pembelajaran per Kategori</span>
                </h3>
                <p class="text-[11px] sm:text-xs text-slate-500 mt-0.5">Ringkasan penguasaan kurikulum di setiap divisi pembelajaran</p>
            </div>
            <a href="{{ route('siswa.materi') }}" class="text-xs font-bold text-[#018ABE] hover:underline flex items-center gap-1">
                <span>Lihat Materi</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="p-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
            @forelse($kategoriList as $kat)
                @php
                    $isSpeaking = strtolower($kat->nama_kategori) === 'speaking';
                    $isWriting = strtolower($kat->nama_kategori) === 'writing';
                    $isReading = strtolower($kat->nama_kategori) === 'reading';
                    $isListening = strtolower($kat->nama_kategori) === 'listening';

                    $barColor = 'bg-[#018ABE]';
                    $cardBg = 'bg-slate-50/60 hover:bg-white border-slate-200/80';
                    $icon = '📖';

                    if ($isSpeaking) {
                        $barColor = 'bg-rose-500';
                        $cardBg = 'bg-rose-50/40 hover:bg-white border-rose-100 hover:border-rose-300';
                        $icon = '🗣️';
                    } elseif ($isWriting) {
                        $barColor = 'bg-[#018ABE]';
                        $cardBg = 'bg-sky-50/40 hover:bg-white border-sky-100 hover:border-sky-300';
                        $icon = '✍️';
                    } elseif ($isReading) {
                        $barColor = 'bg-emerald-500';
                        $cardBg = 'bg-emerald-50/40 hover:bg-white border-emerald-100 hover:border-emerald-300';
                        $icon = '📚';
                    } elseif ($isListening) {
                        $barColor = 'bg-purple-500';
                        $cardBg = 'bg-purple-50/40 hover:bg-white border-purple-100 hover:border-purple-300';
                        $icon = '🎧';
                    }
                @endphp

                <div class="p-4 rounded-xl border {{ $cardBg }} transition flex flex-col justify-between gap-3 shadow-2xs">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <span class="text-base">{{ $icon }}</span>
                            <span class="text-xs font-extrabold text-slate-700">{{ $kat->persen }}%</span>
                        </div>
                        <h4 class="font-bold text-slate-800 text-sm leading-tight">{{ $kat->nama_kategori }}</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">
                            {{ $kat->selesai_materi }} dari {{ $kat->total_materi }} materi selesai
                        </p>
                    </div>

                    <div class="space-y-1.5">
                        <div class="w-full h-1.5 bg-slate-200/80 rounded-full overflow-hidden">
                            <div class="h-full {{ $barColor }} rounded-full transition-all duration-500" style="width: {{ $kat->persen }}%"></div>
                        </div>
                        <div class="flex items-center justify-between pt-1">
                            <span class="text-[10px] text-slate-400">{{ $kat->babs_count ?? 0 }} Bab</span>
                            <a href="{{ route('siswa.materi', ['kategori' => $kat->id_kategori]) }}" class="text-[11px] font-bold text-[#018ABE] hover:underline">
                                Buka Materi →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-6 text-slate-400 text-xs">
                    Belum ada kategori pembelajaran yang dibuat.
                </div>
            @endforelse
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- ROW 5: RIWAYAT QUIZ TERAKHIR & REMINDER DARI ADMIN    -->
    <!-- ===================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        <!-- Kolom Kiri (2/3): Riwayat Quiz Terakhir -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-[#97CADB]/30 shadow-xs overflow-hidden">
            <div class="px-5 sm:px-6 py-4 border-b border-[#97CADB]/20 flex items-center justify-between">
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-800 flex items-center gap-2">
                        <span class="text-amber-500">🏆</span>
                        <span>Riwayat Pengerjaan Quiz Terakhir</span>
                    </h3>
                    <p class="text-[11px] sm:text-xs text-slate-500 mt-0.5">Catatan skor dari quiz yang baru kamu selesaikan</p>
                </div>
                <a href="{{ route('siswa.peta-quiz') }}" class="text-xs font-bold text-[#018ABE] hover:underline flex items-center gap-1">
                    <span>Peta Quiz Lengkap</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="p-5">
                @if($riwayatQuizTerbaru->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($riwayatQuizTerbaru as $hasil)
                            @php
                                $materi = $hasil->quiz->materi ?? null;
                                $skor = (int) $hasil->skor_diperoleh;
                                $skorBadge = $skor >= 80 ? 'bg-emerald-100 text-emerald-800 border-emerald-300' : ($skor >= 60 ? 'bg-amber-100 text-amber-800 border-amber-300' : 'bg-rose-100 text-rose-800 border-rose-300');
                            @endphp
                            <div class="flex items-center justify-between gap-3 p-3.5 rounded-xl border border-slate-200/80 hover:border-[#97CADB] bg-slate-50/40 hover:bg-white transition">
                                <div class="flex items-center gap-3 min-w-0 flex-1">
                                    <div class="px-3 py-1.5 rounded-xl border font-black text-sm {{ $skorBadge }} shrink-0">
                                        {{ $skor }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h4 class="font-bold text-slate-800 text-xs sm:text-sm truncate">
                                                {{ $materi->judul ?? 'Quiz Pembelajaran' }}
                                            </h4>
                                            @if($materi && $materi->kategori)
                                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold {{ $materi->kategori->color['badge'] ?? 'bg-slate-100 text-slate-700' }}">
                                                    {{ $materi->kategori->nama_kategori }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-[11px] text-slate-400 mt-0.5 truncate">
                                            {{ $materi && $materi->babModel ? 'Bab ' . $materi->babModel->urutan . ' – ' . $materi->babModel->judul : 'Quiz' }} • {{ $hasil->created_at ? $hasil->created_at->locale('id')->diffForHumans() : '-' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="shrink-0">
                                    <a href="{{ route('siswa.quiz.hasil', $hasil->id_quiz) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-[#D6EBEE] text-[#02457A] hover:bg-[#97CADB]/60 transition inline-flex items-center gap-1">
                                        <span>Hasil</span>
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 px-4 bg-slate-50/50 rounded-xl border border-dashed border-slate-200">
                        <span class="text-3xl mb-1.5 block">🎯</span>
                        <h4 class="text-sm font-bold text-slate-700">Belum Ada Quiz yang Dikerjakan</h4>
                        <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                            Selesaikan materi belajarmu dan mulailah mengerjakan quiz pertama untuk melihat nilaimu di sini!
                        </p>
                        <div class="mt-3">
                            <a href="{{ route('siswa.peta-quiz') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-bold bg-[#018ABE] text-white hover:bg-[#02457A] transition shadow-xs">
                                <span>Mulai di Peta Quiz</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Kolom Kanan (1/3): Reminder & Informasi dari Admin -->
        <div class="bg-white rounded-2xl border border-[#97CADB]/30 shadow-xs p-5">
            <div class="flex items-center justify-between mb-3.5 pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-800 leading-tight">Reminder Admin</h4>
                        <p class="text-[10px] text-slate-500">Pemberitahuan & tugas</p>
                    </div>
                </div>
                @if($unreadPesanCount > 0)
                    <span class="px-2 py-0.5 rounded-full bg-rose-500 text-white text-[10px] font-extrabold animate-pulse shadow-xs">
                        {{ $unreadPesanCount }} Baru
                    </span>
                @endif
            </div>

            <div class="space-y-2.5">
                @forelse($pesanAdminTerbaru as $pesan)
                    <div class="p-3 rounded-xl border {{ $pesan->is_read ? 'bg-slate-50/70 border-slate-200/80' : 'bg-rose-50/60 border-rose-200' }} transition">
                        <div class="flex items-center justify-between gap-1 mb-1">
                            <span class="text-xs font-bold text-slate-800 truncate">
                                {{ $pesan->admin->nama ?? 'Admin' }}
                            </span>
                            <span class="text-[10px] text-slate-400 shrink-0">
                                {{ $pesan->created_at ? $pesan->created_at->diffForHumans() : '-' }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                            {{ $pesan->pesan ?? $pesan->isi_pesan ?? $pesan->subjek ?? 'Tidak ada pesan' }}
                        </p>
                    </div>
                @empty
                    <div class="text-center py-6 px-3 bg-slate-50/60 rounded-xl border border-dashed border-slate-200">
                        <span class="text-2xl mb-1 block">📬</span>
                        <p class="text-xs font-semibold text-slate-600">Belum ada reminder</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">Pesan dari admin akan muncul di sini</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-3.5 pt-3 border-t border-slate-100 text-center">
                <a href="{{ route('siswa.reminder') }}" class="text-xs font-bold text-[#018ABE] hover:underline inline-flex items-center gap-1">
                    <span>Buka Semua Pesan</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

    </div>

</div>

@include('siswa.quiz.modal-detail')
@endsection

@push('scripts')
<script>
// Live Clock & Dynamic Greeting Siswa
const quotesSiswa = [
    "A little progress each day adds up to big results.",
    "Practice makes progress, not perfection.",
    "Mistakes are proof that you are trying and learning.",
    "The expert in anything was once a beginner.",
    "Believe you can and you are halfway there.",
    "Every day is a new chance to learn something new.",
    "Success begins with small, consistent daily steps."
];

function updateLiveClockSiswa() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');

    const liveTimeEl = document.getElementById('liveTimeSiswa');
    const liveSecEl = document.getElementById('liveSecondsSiswa');
    if (liveTimeEl) liveTimeEl.textContent = `${hours}:${minutes}`;
    if (liveSecEl) liveSecEl.textContent = `:${seconds}`;

    const hour = now.getHours();
    let greeting, icon;
    if (hour >= 4 && hour < 11) { greeting = 'Selamat Pagi'; icon = '☀️'; }
    else if (hour >= 11 && hour < 15) { greeting = 'Selamat Siang'; icon = '🌤️'; }
    else if (hour >= 15 && hour < 18) { greeting = 'Selamat Sore'; icon = '🌆'; }
    else { greeting = 'Selamat Malam'; icon = '🌙'; }

    const greetingTimeEl = document.getElementById('siswaGreetingTime');
    const greetingIconEl = document.getElementById('siswaGreetingIcon');
    const greetingBadgeEl = document.getElementById('siswaGreetingTextBadge');
    const greetingBadgeIconEl = document.getElementById('siswaGreetingIconBadge');

    if (greetingTimeEl) greetingTimeEl.textContent = greeting;
    if (greetingIconEl) greetingIconEl.textContent = icon;
    if (greetingBadgeEl) greetingBadgeEl.textContent = greeting;
    if (greetingBadgeIconEl) greetingBadgeIconEl.textContent = icon;

    const dayOfYear = Math.floor((now - new Date(now.getFullYear(), 0, 0)) / 86400000);
    const quoteIndex = dayOfYear % quotesSiswa.length;
    const dailyQuoteEl = document.getElementById('dailyQuoteSiswa');
    if (dailyQuoteEl) dailyQuoteEl.textContent = `"${quotesSiswa[quoteIndex]}"`;

    // Progress Waktu Hari Ini
    const totalMinutesInDay = 24 * 60;
    const currentMinutes = now.getHours() * 60 + now.getMinutes();
    const dayProgress = Math.round((currentMinutes / totalMinutesInDay) * 100);

    const dayProgressEl = document.getElementById('siswaDayProgress');
    const dayProgressBarEl = document.getElementById('siswaDayProgressBar');
    if (dayProgressEl) dayProgressEl.textContent = `${dayProgress}%`;
    if (dayProgressBarEl) dayProgressBarEl.style.width = `${dayProgress}%`;
}

updateLiveClockSiswa();
setInterval(updateLiveClockSiswa, 1000);
</script>
@endpush

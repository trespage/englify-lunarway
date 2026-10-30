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
                <div class="relative shrink-0">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-br from-[#018ABE] to-[#02457A] text-white p-0.5 shadow-md shadow-[#018ABE]/20 flex items-center justify-center">
                        <div class="w-full h-full rounded-[14px] bg-white flex items-center justify-center text-[#018ABE] font-black text-lg sm:text-xl">
                            {{ substr(auth()->user()->nama ?? auth()->user()->name ?? 'S', 0, 1) }}
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
                        Senang melihatmu kembali! Siap melangkah lebih jauh dalam belajar bahasa Inggris hari ini? Yuk taklukkan materi baru & raih skor tertinggi di quiz!
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
                        <span class="block text-[10px] text-slate-500 truncate">Mulai belajar</span>
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
                        <span class="block text-[10px] text-slate-500 truncate">Uji kemampuan</span>
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
                        @php
                            $unreadCount = \App\Models\PesanAdmin::where('id_user', auth()->user()->id_user)->where('is_read', false)->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-white"></span>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <span class="block text-xs font-bold text-slate-800 leading-tight truncate">Reminder</span>
                        <span class="block text-[10px] text-slate-500 truncate">{{ $unreadCount > 0 ? $unreadCount . ' baru' : 'Kotak masuk' }}</span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Live Clock & Inspiration Card (1/3) -->
        <div id="liveClockCardSiswa" class="relative overflow-hidden rounded-2xl shadow-lg border border-[#97CADB]/40 bg-gradient-to-br from-[#018ABE] to-[#02457A] p-4 sm:p-5 text-white flex flex-col justify-between gap-3">
            <div class="absolute -top-6 -right-6 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
            <div class="absolute top-3 right-4 text-white/30 text-xs">✦</div>
            <div class="absolute bottom-3 left-4 text-white/30 text-xs">✧</div>

            <!-- Bagian Atas: Badge, Tanggal & Jam -->
            <div class="relative space-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/15 backdrop-blur border border-white/20">
                        <span id="siswaGreetingIconBadge" class="text-sm">☀️</span>
                        <span id="siswaGreetingTextBadge" class="text-[10px] font-extrabold text-white uppercase tracking-wider">Semangat Belajar</span>
                    </div>
                    <div class="flex items-center gap-1 text-[10px] font-semibold text-sky-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>LIVE • WIB</span>
                    </div>
                </div>

                <div class="flex items-end justify-between">
                    <div>
                        <p id="liveDateSiswa" class="text-xs font-medium text-sky-100">
                            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                        </p>
                        <div class="flex items-baseline gap-1 mt-0.5">
                            <span id="liveTimeSiswa" class="text-2xl sm:text-4xl font-extrabold tracking-tight text-white tabular-nums leading-none">
                                {{ \Carbon\Carbon::now()->format('H:i') }}
                            </span>
                            <span id="liveSecondsSiswa" class="text-xs sm:text-base font-bold text-sky-200/80 tabular-nums">
                                :{{ \Carbon\Carbon::now()->format('s') }}
                            </span>
                        </div>
                    </div>

                    <!-- Mini Streak / Mood Pill -->
                    <div class="text-right">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-white/15 backdrop-blur text-[11px] font-bold text-amber-300 border border-white/20 shadow-2xs">
                            <span>🔥</span>
                            <span>{{ ($materiSelesai + $quizSelesai) > 0 ? 'Sedang Aktif' : 'Ayo Mulai!' }}</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Bagian Tengah: Progress Waktu Hari Ini & Mini Snapshot Belajar -->
            <div class="relative space-y-2.5 py-1">
                <!-- Bar Waktu Hari Ini -->
                <div class="space-y-1">
                    <div class="flex items-center justify-between text-[10px] text-sky-100 font-semibold">
                        <span>Waktu Hari Ini Berjalan</span>
                        <span id="siswaDayProgress" class="font-bold text-white">0%</span>
                    </div>
                    <div class="w-full h-1.5 bg-black/20 rounded-full overflow-hidden border border-white/10">
                        <div id="siswaDayProgressBar" class="h-full bg-gradient-to-r from-emerald-300 to-sky-300 rounded-full transition-all duration-1000" style="width: 0%"></div>
                    </div>
                </div>

                <!-- 2 Micro Cards Progress Ringkas -->
                <div class="grid grid-cols-2 gap-2">
                    <div class="bg-white/10 backdrop-blur-md rounded-xl p-2 sm:p-2.5 border border-white/15 hover:bg-white/15 transition">
                        <div class="flex items-center justify-between text-[9px] sm:text-[10px] text-sky-200 font-bold mb-1">
                            <span>📚 MATERI</span>
                            <span class="text-white">{{ $totalMateri > 0 ? round(($materiSelesai / $totalMateri) * 100) : 0 }}%</span>
                        </div>
                        <p class="text-xs sm:text-sm font-extrabold text-white leading-tight">
                            {{ $materiSelesai }} <span class="text-[9px] sm:text-[10px] font-normal text-sky-200">/ {{ $totalMateri }}</span>
                        </p>
                        <div class="w-full h-1 bg-white/20 rounded-full mt-1.5 overflow-hidden">
                            <div class="h-full bg-sky-300 rounded-full" style="width: {{ $totalMateri > 0 ? min(100, round(($materiSelesai / $totalMateri) * 100)) : 0 }}%"></div>
                        </div>
                    </div>

                    <div class="bg-white/10 backdrop-blur-md rounded-xl p-2 sm:p-2.5 border border-white/15 hover:bg-white/15 transition">
                        <div class="flex items-center justify-between text-[9px] sm:text-[10px] text-sky-200 font-bold mb-1">
                            <span>🎯 QUIZ</span>
                            <span class="text-white">{{ $totalQuiz > 0 ? round(($quizSelesai / $totalQuiz) * 100) : 0 }}%</span>
                        </div>
                        <p class="text-xs sm:text-sm font-extrabold text-white leading-tight">
                            {{ $quizSelesai }} <span class="text-[9px] sm:text-[10px] font-normal text-sky-200">/ {{ $totalQuiz }}</span>
                        </p>
                        <div class="w-full h-1 bg-white/20 rounded-full mt-1.5 overflow-hidden">
                            <div class="h-full bg-amber-300 rounded-full" style="width: {{ $totalQuiz > 0 ? min(100, round(($quizSelesai / $totalQuiz) * 100)) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian Bawah: Motivational Quote -->
            <div class="relative pt-2.5 border-t border-white/15">
                <div class="flex items-start gap-2">
                    <span class="text-amber-300 text-base leading-none">“</span>
                    <div class="flex-1">
                        <p id="dailyQuoteSiswa" class="text-xs font-medium text-sky-100 italic leading-snug">
                            "A little progress each day adds up to big results."
                        </p>
                        <p class="text-[10px] text-sky-200/70 mt-1 font-cute text-right">~ Daily English Motivation ✨</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- STATS CARDS                                            -->
    <!-- ===================================================== -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 sm:gap-4">
        <!-- Materi Selesai -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#97CADB]/30 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-[#D6EBEE] flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <span class="text-xs font-bold text-[#018ABE] bg-[#D6EBEE] px-2 py-1 rounded-full">{{ $materiSelesai }} dari {{ $totalMateri }}</span>
            </div>
            <p class="text-xs sm:text-sm font-semibold text-slate-500">Materi Selesai</p>
            <p class="text-2xl sm:text-3xl font-extrabold text-slate-800 mt-1">{{ $materiSelesai }}</p>
            <p class="text-xs text-slate-400 mt-1">dari {{ $totalMateri }} materi</p>
        </div>

        <!-- Quiz Selesai -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#97CADB]/30 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-emerald-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">{{ $quizSelesai }} dari {{ $totalQuiz }}</span>
            </div>
            <p class="text-xs sm:text-sm font-semibold text-slate-500">Quiz Selesai</p>
            <p class="text-2xl sm:text-3xl font-extrabold text-slate-800 mt-1">{{ $quizSelesai }}</p>
            <p class="text-xs text-slate-400 mt-1">dari {{ $totalQuiz }} quiz</p>
        </div>

        <!-- Rata-rata Nilai -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#97CADB]/30 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-amber-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">{{ $rataRataNilai >= 80 ? '↑ Bagus!' : ($rataRataNilai >= 60 ? 'Cukup' : 'Semangat!') }}</span>
            </div>
            <p class="text-xs sm:text-sm font-semibold text-slate-500">Rata-rata Nilai</p>
            <p class="text-2xl sm:text-3xl font-extrabold text-amber-600 mt-1">{{ round($rataRataNilai) }}%</p>
            <p class="text-xs text-slate-400 mt-1">dari semua quiz</p>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- MAIN GRID: QUIZ & MATERI (2/3) + REMINDER & STATS (1/3) -->
    <!-- ===================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        <!-- SISI KIRI (2/3): QUIZ PER BAB & MATERI TERBARU -->
        <div class="lg:col-span-2 space-y-6">

            <!-- 1. Daftar Quiz per Bab -->
            <div class="bg-white rounded-2xl border border-[#97CADB]/30 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-[#97CADB]/20 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#02457A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            Daftar Quiz per Bab
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Selesaikan quiz untuk menguji pemahaman dan raih nilai terbaik</p>
                    </div>
                    <a href="{{ route('siswa.peta-quiz') }}" class="text-xs font-bold text-[#018ABE] hover:underline flex items-center gap-1">
                        <span>Peta Quiz Lengkap</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="p-5 space-y-4">
                    @forelse($babs as $bab)
                        @php
                            $kat = $bab->kategori->nama_kategori ?? '';
                            $iconBg = 'bg-[#D6EBEE]';
                            $iconColor = 'text-[#02457A]';
                            $borderHover = 'hover:border-[#97CADB]';

                            if ($kat == 'Speaking') {
                                $iconBg = 'bg-rose-100';
                                $iconColor = 'text-rose-600';
                                $borderHover = 'hover:border-rose-200';
                            } elseif ($kat == 'Writing') {
                                $iconBg = 'bg-blue-100';
                                $iconColor = 'text-blue-600';
                                $borderHover = 'hover:border-blue-200';
                            } elseif ($kat == 'Reading') {
                                $iconBg = 'bg-emerald-100';
                                $iconColor = 'text-emerald-600';
                                $borderHover = 'hover:border-emerald-200';
                            } elseif ($kat == 'Listening') {
                                $iconBg = 'bg-purple-100';
                                $iconColor = 'text-purple-600';
                                $borderHover = 'hover:border-purple-200';
                            }
                        @endphp

                        <!-- Bab Card -->
                        <div class="dashboard-bab-card border border-[#97CADB]/25 hover:border-[#018ABE]/40 bg-white rounded-2xl p-3.5 sm:p-5 transition-all shadow-xs hover:shadow-sm">
                            <!-- Header Bab -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 sm:gap-3 mb-3.5 sm:mb-4 pb-3 border-b border-slate-100">
                                <div class="flex items-center gap-3 min-w-0 flex-1">
                                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl {{ $iconBg }} flex items-center justify-center font-bold text-xs sm:text-sm {{ $iconColor }} shrink-0 shadow-xs">
                                        {{ $bab->urutan }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h4 class="font-bold text-slate-800 text-sm sm:text-base truncate">Bab {{ $bab->urutan }} – {{ $bab->judul }}</h4>
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $iconBg }} {{ $iconColor }} border border-current/20">
                                                {{ $kat ?: 'English Lesson' }}
                                            </span>
                                        </div>
                                        <p class="text-[11px] text-slate-400 mt-0.5">
                                            {{ $bab->materi->where('total_soal', '>', 0)->count() }} Quiz • {{ $bab->materi->count() }} Materi
                                        </p>
                                    </div>
                                </div>

                                <a href="{{ route('siswa.peta-quiz') }}" class="text-xs font-semibold text-[#018ABE] hover:underline flex items-center gap-1 self-end sm:self-center shrink-0">
                                    <span>Peta Lengkap</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>

                            <!-- Circles Row (Materi / Quiz Nodes) -->
                            <div class="flex items-center justify-start overflow-x-auto pb-2 pt-1 gap-2 sm:gap-3 scrollbar-hide" style="-webkit-overflow-scrolling: touch;">
                                @forelse($bab->materi as $materi)
                                    @php
                                        $isSelesai = $materi->sudah_selesai;
                                        $isLocked = $materi->is_locked ?? false;
                                        $lockedBy = $materi->locked_by ?? 'sebelumnya';
                                        $hasQuiz = $materi->total_soal > 0;
                                        $judulMateri = $materi->judul;
                                        $urlMateri = route('siswa.materi.baca', $materi->id_materi);

                                        $modalData = [
                                            'id_quiz'       => $materi->target_quiz_id,
                                            'id_materi'     => $materi->id_materi,
                                            'judul_materi'  => $judulMateri,
                                            'bab_judul'     => 'Bab ' . $bab->urutan . ' – ' . $bab->judul,
                                            'kategori'      => $kat,
                                            'total_soal'    => $materi->total_soal,
                                            'total_poin'    => $materi->total_poin,
                                            'durasi_menit'  => (int) ($materi->durasi_menit ?? $bab->durasi_menit ?? 15),
                                            'sudah_selesai' => $isSelesai,
                                            'sudah_dibaca'  => (bool) ($materi->sudah_dibaca ?? false),
                                            'is_locked'     => $isLocked,
                                            'locked_by'     => $lockedBy,
                                            'skor'          => $materi->skor_diperoleh,
                                            'waktu_selesai' => $materi->waktu_selesai,
                                            'url_materi'    => $isLocked ? null : $urlMateri,
                                            'url_quiz'      => ($isLocked || $isSelesai || !$materi->target_quiz_id) ? null : route('siswa.quiz.kerjakan', $materi->target_quiz_id),
                                            'url_hasil'     => $materi->target_quiz_id ? route('siswa.quiz.hasil', $materi->target_quiz_id) : null,
                                        ];
                                    @endphp

                                    <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                                        @if($isSelesai)
                                            <!-- Quiz Selesai dengan nilai -->
                                            <button type="button" 
                                                    onclick="openQuizDetailModal(this)"
                                                    data-quiz='@json($modalData)'
                                                    class="flex flex-col items-center gap-1.5 cursor-pointer group shrink-0 bg-transparent border-0 p-0 text-center min-w-[56px]" 
                                                    title="{{ $judulMateri }} (Nilai: {{ $materi->skor_diperoleh }}/100)">
                                                <div class="w-11 h-11 rounded-full bg-emerald-100 border-2 border-emerald-500 flex items-center justify-center group-hover:scale-110 transition shadow-xs">
                                                    <span class="text-sm font-bold text-emerald-700">{{ $loop->iteration }}</span>
                                                </div>
                                                <span class="text-[10px] font-bold text-emerald-600">{{ $materi->skor_diperoleh }}/100</span>
                                                <span class="text-[9px] text-slate-400">Selesai</span>
                                            </button>
                                        @elseif($isLocked)
                                            <!-- Quiz Terkunci (Selesaikan materi sebelumnya dahulu) -->
                                            <button type="button" 
                                                    onclick="openQuizDetailModal(this)"
                                                    data-quiz='@json($modalData)'
                                                    class="flex flex-col items-center gap-1.5 cursor-pointer group shrink-0 bg-transparent border-0 p-0 text-center min-w-[56px]" 
                                                    title="{{ $judulMateri }} (Terkunci: selesaikan '{{ $lockedBy }}')">
                                                <div class="w-11 h-11 rounded-full bg-slate-100 border-2 border-slate-300 flex items-center justify-center text-slate-400 group-hover:scale-105 transition shadow-xs">
                                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                                </div>
                                                <span class="text-[10px] font-semibold text-slate-400">Terkunci</span>
                                                <span class="text-[9px] text-slate-400">&nbsp;</span>
                                            </button>
                                        @elseif($hasQuiz)
                                            <!-- Quiz Tersedia / Siap dikerjakan -->
                                            <button type="button" 
                                                    onclick="openQuizDetailModal(this)"
                                                    data-quiz='@json($modalData)'
                                                    class="flex flex-col items-center gap-1.5 cursor-pointer group shrink-0 bg-transparent border-0 p-0 text-center min-w-[56px]" 
                                                    title="{{ $judulMateri }}">
                                                <div class="w-11 h-11 rounded-full bg-white border-2 border-[#018ABE] flex items-center justify-center group-hover:bg-[#018ABE] transition shadow-xs group-hover:scale-110">
                                                    <span class="text-sm font-bold text-[#018ABE] group-hover:text-white">{{ $loop->iteration }}</span>
                                                </div>
                                                <span class="text-[10px] font-bold text-[#018ABE]">Mulai</span>
                                                <span class="text-[9px] text-slate-400">&nbsp;</span>
                                            </button>
                                        @else
                                            <!-- Materi Belum Memiliki Kuis (Materi Bacaan) -->
                                            <button type="button" 
                                                    onclick="openQuizDetailModal(this)"
                                                    data-quiz='@json($modalData)'
                                                    class="flex flex-col items-center gap-1.5 cursor-pointer group shrink-0 bg-transparent border-0 p-0 text-center min-w-[56px]" 
                                                    title="{{ $judulMateri }} (Materi Bacaan)">
                                                <div class="w-11 h-11 rounded-full bg-slate-50 border-2 border-slate-200 flex items-center justify-center text-slate-400 transition shadow-xs">
                                                    <span class="text-sm font-bold text-slate-400">{{ $loop->iteration }}</span>
                                                </div>
                                                <span class="text-[10px] font-semibold text-slate-400">Baca</span>
                                                <span class="text-[9px] text-slate-400">&nbsp;</span>
                                            </button>
                                        @endif

                                        @if(!$loop->last)
                                            <div class="w-8 sm:w-12 h-0.5 {{ $isSelesai ? 'bg-emerald-400' : 'bg-slate-200' }} shrink-0"></div>
                                        @endif
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 text-center w-full py-3">Belum ada materi atau quiz untuk bab ini.</p>
                                @endforelse
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 px-4">
                            <div class="w-14 h-14 rounded-2xl bg-[#D6EBEE] text-[#018ABE] flex items-center justify-center mx-auto mb-3 shadow-xs">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <h4 class="font-bold text-slate-800 text-sm">Belum Ada Quiz Tersedia</h4>
                            <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 leading-relaxed">
                                Admin sedang menyiapkan materi dan quiz pembelajaran. Begitu admin membuat quiz baru, quiz akan langsung muncul di sini! 🐾
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- 2. Materi Pembelajaran Terbaru dari Admin -->
            <div class="bg-white rounded-2xl border border-[#97CADB]/30 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-[#97CADB]/20 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Materi Pembelajaran Terbaru
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Materi terstruktur yang dipublikasikan oleh tim pengajar</p>
                    </div>
                    <a href="{{ route('siswa.materi') }}" class="text-xs font-bold text-[#018ABE] hover:underline flex items-center gap-1">
                        <span>Lihat Semua Materi</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="p-5">
                    @if($materiTerbaru->isNotEmpty())
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($materiTerbaru as $m)
                                @php
                                    $sudahDibaca = $m->progress->where('status', 'Completed')->isNotEmpty();
                                    $color = $m->kategori?->color;
                                @endphp
                                <div class="dashboard-materi-card p-4 rounded-xl border border-slate-200/90 hover:border-[#97CADB] bg-slate-50/50 hover:bg-white transition flex flex-col justify-between gap-3 shadow-2xs">
                                    <div>
                                        <div class="flex items-center justify-between gap-2 mb-1.5">
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold uppercase tracking-wide {{ $color['badge'] ?? 'bg-slate-100 text-slate-700' }}">
                                                {{ $m->kategori->nama_kategori ?? 'Umum' }}
                                            </span>
                                            @if($sudahDibaca)
                                                <span class="text-[10px] font-bold text-emerald-600 flex items-center gap-0.5">
                                                    <span>✓</span> Selesai
                                                </span>
                                            @endif
                                        </div>
                                        <h4 class="font-bold text-slate-800 text-sm line-clamp-1" title="{{ $m->judul }}">
                                            {{ $m->judul }}
                                        </h4>
                                        <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">
                                            Bab: {{ $m->babModel->judul ?? $m->bab ?? '-' }}
                                        </p>
                                    </div>
                                    <div class="flex items-center justify-between pt-2 border-t border-slate-200/60">
                                        <span class="text-[10px] text-slate-400">
                                            {{ $m->created_at ? $m->created_at->diffForHumans() : '-' }}
                                        </span>
                                        <a href="{{ route('siswa.materi.baca', $m->id_materi) }}" 
                                           @if(!$sudahDibaca) onclick="return confirmBukaMateri(event, '{{ route('siswa.materi.baca', $m->id_materi) }}')" @endif
                                           class="px-3 py-1.5 rounded-lg text-xs font-bold {{ $sudahDibaca ? 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' : 'bg-[#018ABE] text-white hover:bg-[#02457A]' }} transition flex items-center gap-1 shadow-2xs">
                                            <span>{{ $sudahDibaca ? 'Baca Lagi' : 'Mulai Baca' }}</span>
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 px-4">
                            <p class="text-sm font-semibold text-slate-700">Belum ada materi pembelajaran</p>
                            <p class="text-xs text-slate-400 mt-1">Admin belum mempublikasikan materi. Setelah admin menambahkan materi, kamu bisa langsung mempelajarinya di sini!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- SISI KANAN (1/3): REMINDER ADMIN & PENCAPAIAN -->
        <div class="space-y-6">

            <!-- 1. KOTAK MASUK & REMINDER DARI ADMIN -->
            <div class="bg-white rounded-2xl border border-[#97CADB]/30 shadow-sm p-5">
                <div class="flex items-center justify-between mb-3.5 pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-800 leading-tight">Reminder dari Admin</h4>
                            <p class="text-[10px] text-slate-500">Pemberitahuan & tugas belajar</p>
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
                        <span>Buka Semua Reminder</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            <!-- 2. PENCAPAIAN MINGGU INI (DATA REAL DARI DATABASE) -->
            <div class="bg-white rounded-2xl border border-[#97CADB]/30 shadow-sm p-5">
                <div class="flex items-center gap-3 mb-3 pb-3 border-b border-slate-100">
                    <div class="w-9 h-9 rounded-xl bg-amber-100 flex items-center justify-center text-lg">
                        🌟
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-800">Aktivitas Mingguan</p>
                        <p class="text-[10px] text-slate-500">Pencapaian minggu ini</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-emerald-50 border border-emerald-100/60">
                        <span class="text-xs text-slate-700 font-medium">Quiz diselesaikan</span>
                        <span class="text-xs font-extrabold text-emerald-700">+{{ $aktivitasMingguIni['quiz_dikerjakan'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-[#D6EBEE]/70 border border-[#97CADB]/40">
                        <span class="text-xs text-slate-700 font-medium">Materi dibaca</span>
                        <span class="text-xs font-extrabold text-[#02457A]">+{{ $aktivitasMingguIni['materi_dibaca'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-amber-50 border border-amber-100/60">
                        <span class="text-xs text-slate-700 font-medium">Rata-rata skor</span>
                        <span class="text-xs font-extrabold text-amber-700">{{ $quizSelesai > 0 ? round($rataRataNilai) . '%' : '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- 3. TIPS BELAJAR ADAPTIF & MASKOT -->
            <div class="bg-gradient-to-br from-[#D6EBEE] via-white to-[#97CADB]/30 rounded-2xl p-5 border border-[#97CADB]/40 text-center shadow-xs">
                <img src="{{ asset('images/cat-welcome.png') }}" alt="Englify Cat" class="w-20 h-auto mx-auto mb-2 drop-shadow-xs">
                <p class="font-cute text-xl text-[#018ABE] leading-tight">
                    @if($totalMateri == 0)
                        Siap Belajar! 🐾
                    @elseif($materiSelesai == 0)
                        Ayo Mulai Membaca! 📖
                    @elseif($quizSelesai == 0)
                        Waktunya Uji Quiz! 🎯
                    @elseif($rataRataNilai >= 80)
                        Luar Biasa, Hebat! 🌟
                    @else
                        Terus Berlatih! 💪
                    @endif
                </p>
                <p class="text-xs text-slate-600 mt-1.5 leading-relaxed">
                    @if($totalMateri == 0)
                        Materi pembelajaran sedang dipersiapkan oleh admin. Jangan lupa pantau reminder ya!
                    @elseif($materiSelesai == 0)
                        Yuk klik menu Materi untuk mulai membaca bab pembelajaran pertama kamu.
                    @elseif($quizSelesai == 0)
                        Kamu sudah membaca materi! Sekarang asah kemampuanmu di menu Peta Quiz.
                    @elseif($rataRataNilai >= 80)
                        Pertahankan konsistensimu! Skor rata-ratamu sangat memuaskan.
                    @else
                        Setiap kesalahan adalah proses belajar. Ulangi materi yang belum dipahami!
                    @endif
                </p>
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

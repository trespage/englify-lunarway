@extends('layouts.admin')

@section('title', 'Dashboard Admin - Englify')

@section('content')
<div class="space-y-6">

    <!-- ===================================================== -->
    <!-- ROW 1: WELCOME BANNER + LIVE CLOCK CARD               -->
    <!-- ===================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
        <!-- Welcome Banner (2/3) -->
        <div class="lg:col-span-2 bg-gradient-to-br from-[#D6EBEE] via-[#D6EBEE]/50 to-[#97CADB]/30 rounded-2xl p-5 sm:p-6 relative overflow-hidden border border-[#97CADB]/40">
            <div class="absolute top-4 right-36 text-blue-300 text-xs opacity-60">✧</div>
            <div class="absolute bottom-4 right-44 text-indigo-300 text-xs opacity-60">✦</div>

            <div class="flex items-center gap-4 mb-5">
                <div class="w-12 h-12 rounded-2xl bg-white/80 backdrop-blur flex items-center justify-center shrink-0 shadow-sm">
                    <svg class="w-6 h-6 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>

                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-800 leading-tight">
                        Selamat datang, {{ auth()->user()->nama }}!
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">
                        Kelola materi, quiz, dan konten pembelajaran {{ auth()->user()->kategori?->nama_kategori ?? 'semua divisi' }} dengan mudah.
                    </p>
                </div>

                <div class="hidden sm:flex items-center gap-2 shrink-0">
                    <div class="text-right">
                        <p class="font-cute text-base text-[#018ABE] leading-tight transform -rotate-3">Keep</p>
                        <p class="font-cute text-base text-[#018ABE] leading-tight transform -rotate-3">Making</p>
                        <p class="font-cute text-base text-[#018ABE] leading-tight transform -rotate-3">Progress!</p>
                    </div>
                    <img src="{{ asset('images/cat-welcome.png') }}" alt="Englify Cat" class="w-20 h-auto object-contain">
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-3 gap-3">
                <a href="{{ route('admin.materi') }}" class="bg-white/70 backdrop-blur hover:bg-white rounded-xl p-3 border border-white/80 transition group">
                    <div class="flex items-center gap-2 mb-1">
                        <div class="w-8 h-8 rounded-lg bg-[#97CADB] group-hover:bg-[#97CADB]/80 flex items-center justify-center transition">
                            <svg class="w-4 h-4 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold text-slate-700 uppercase">Materi</span>
                    </div>
                    <p class="text-xs text-slate-500">Tambah baru</p>
                </a>

                <a href="{{ route('admin.quiz') }}" class="bg-white/70 backdrop-blur hover:bg-white rounded-xl p-3 border border-white/80 transition group">
                    <div class="flex items-center gap-2 mb-1">
                        <div class="w-8 h-8 rounded-lg bg-[#97CADB] group-hover:bg-[#97CADB]/80 flex items-center justify-center transition">
                            <svg class="w-4 h-4 text-[#02457A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold text-slate-700 uppercase">Quiz</span>
                    </div>
                    <p class="text-xs text-slate-500">Buat quiz</p>
                </a>

                <a href="{{ route('admin.monitoring-siswa') }}" class="bg-white/70 backdrop-blur hover:bg-white rounded-xl p-3 border border-white/80 transition group">
                    <div class="flex items-center gap-2 mb-1">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 group-hover:bg-emerald-200 flex items-center justify-center transition">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold text-slate-700 uppercase">Siswa</span>
                    </div>
                    <p class="text-xs text-slate-500">Monitoring</p>
                </a>
            </div>
        </div>

        <!-- Live Clock Card (1/3) -->
        <div id="liveClockCard" class="relative overflow-hidden rounded-2xl shadow-lg border border-[#97CADB]/40 bg-gradient-to-br from-[#018ABE] to-[#02457A] p-5 text-white flex flex-col">
            <div class="absolute -top-6 -right-6 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
            <div class="absolute top-3 right-4 text-white/30 text-xs">✦</div>
            <div class="absolute bottom-3 left-4 text-white/30 text-xs">✧</div>

            <div class="relative flex flex-col h-full justify-between gap-4">
                <div>
                    <div class="flex items-center gap-1.5 mb-1">
                        <span id="greetingIcon" class="text-lg"></span>
                        <p id="greetingText" class="text-xs font-bold text-white/90 uppercase tracking-wider"></p>
                    </div>
                    <p id="liveDate" class="text-sm font-semibold text-white leading-tight">
                        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                    </p>
                </div>

                <div class="text-right">
                    <div class="flex items-baseline justify-end gap-1">
                        <span id="liveTime" class="text-4xl font-extrabold tracking-tight text-white tabular-nums leading-none">
                            {{ \Carbon\Carbon::now()->format('H:i') }}
                        </span>
                        <span id="liveSeconds" class="text-lg font-bold text-white/70 tabular-nums">
                            :{{ \Carbon\Carbon::now()->format('s') }}
                        </span>
                    </div>
                    <div class="flex items-center justify-end gap-1 mt-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                        <p class="text-[10px] font-semibold text-white/80">LIVE • WIB</p>
                    </div>
                </div>

                <div class="pt-3 border-t border-white/20 space-y-2">
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-[10px] font-semibold text-white/80">Progress Hari Ini</span>
                            <span id="dayProgress" class="text-[10px] font-bold text-white">0%</span>
                        </div>
                        <div class="w-full h-1.5 bg-white/20 rounded-full overflow-hidden">
                            <div id="dayProgressBar" class="h-full bg-gradient-to-r from-emerald-300 to-emerald-400 rounded-full transition-all duration-1000" style="width: 0%"></div>
                        </div>
                    </div>

                    <div class="flex items-start gap-2 pt-1">
                        <svg class="w-3.5 h-3.5 text-white/60 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                        </svg>
                        <p id="dailyQuote" class="font-cute text-xs text-white/90 leading-tight">
                            "Setiap hari adalah kesempatan baru untuk belajar!"
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- ROW 2: STATS CARDS (4 Cards)                          -->
    <!-- ===================================================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-[#D6EBEE] flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm font-semibold text-slate-500">Total Materi</p>
            <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalMateri }}</p>
            <a href="{{ route('admin.materi') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-[#018ABE] hover:text-[#02457A] mt-2">
                Lihat semua materi
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-[#D6EBEE] flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#02457A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm font-semibold text-slate-500">Total Quiz</p>
            <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalQuiz }}</p>
            <a href="{{ route('admin.quiz') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-[#02457A] hover:text-[#001B48] mt-2">
                Lihat semua quiz
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm font-semibold text-slate-500">Total Divisi</p>
            <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalDivisi }}</p>
            <a href="{{ route('admin.kategori') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 hover:text-emerald-700 mt-2">
                Lihat divisi
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-[#D6EBEE] flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm font-semibold text-slate-500">Total Siswa</p>
            <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalSiswa }}</p>
            <a href="{{ route('admin.monitoring-siswa') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-[#018ABE] hover:text-[#02457A] mt-2">
                Lihat semua siswa
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- ROW 3: MATERI TERBARU + AKTIVITAS TERBARU             -->
    <!-- ===================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Materi Terbaru (2/3) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <h3 class="text-base font-bold text-slate-800">Materi Terbaru</h3>
                </div>
                <a href="{{ route('admin.materi') }}" class="text-xs font-semibold text-[#018ABE] hover:text-[#02457A] flex items-center gap-1">
                    Lihat semua
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-xs font-semibold text-slate-500 border-b border-slate-100">
                            <th class="px-6 py-3 text-left">No.</th>
                            <th class="px-6 py-3 text-left">Judul Materi</th>
                            <th class="px-6 py-3 text-left">Kategori</th>
                            <th class="px-6 py-3 text-left">Bab</th>
                            <th class="px-6 py-3 text-left">Tanggal Dibuat</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @php
                            $badgeColors = [
                                'Speaking' => 'bg-rose-50 text-rose-700 border-rose-200',
                                'Writing' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'Reading' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'Listening' => 'bg-purple-50 text-purple-700 border-purple-200',
                            ];
                        @endphp

                        @forelse($materiTerbaru as $index => $materi)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-3.5 text-sm font-semibold text-slate-600">{{ $index + 1 }}</td>
                            <td class="px-6 py-3.5 text-sm font-semibold text-slate-800">{{ $materi['judul'] }}</td>
                            <td class="px-6 py-3.5">
                                @php $color = $badgeColors[$materi['kategori']] ?? 'bg-slate-50 text-slate-700 border-slate-100'; @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $color }}">
                                    {{ $materi['kategori'] }}
                                </span>
                            </td>
                            <td class="px-6 py-3.5">
                                <p class="text-xs font-semibold text-slate-700">{{ $materi['bab'] }}</p>
                            </td>
                            <td class="px-6 py-3.5 text-xs text-slate-500 whitespace-nowrap">{{ $materi['tanggal'] }}</td>
                            <td class="px-6 py-3.5 text-right">
                                <a href="{{ route('admin.materi') }}" class="text-slate-400 hover:text-slate-600">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="5" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="12" cy="19" r="2"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center">
                                <p class="text-sm font-semibold text-slate-500">Belum ada materi</p>
                                <p class="text-xs text-slate-400 mt-1">Tambahkan materi pertama untuk mulai mengelola konten.</p>
                                <a href="{{ route('admin.materi') }}" class="inline-block mt-3 text-xs font-semibold text-[#018ABE]">Tambah Materi →</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Aktivitas Terbaru (1/3) -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-base font-bold text-slate-800">Aktivitas Terbaru</h3>
                </div>
            </div>

            <div class="p-4 space-y-3">
                @php
                    $activityStyles = [
                        'siswa_baru'  => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'icon' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z'],
                        'admin_baru'  => ['bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'icon' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z'],
                        'materi_baru' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                        'quiz_baru'   => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        'hasil_quiz'  => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ];
                @endphp

                @forelse($aktivitasTerbaru as $aktivitas)
                <div class="flex items-start gap-3 p-2 rounded-xl hover:bg-slate-50 transition">
                    @php $style = $activityStyles[$aktivitas['type']] ?? $activityStyles['materi_baru']; @endphp
                    <div class="w-9 h-9 rounded-xl {{ $style['bg'] }} flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 {{ $style['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $style['icon'] }}"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-slate-800">{{ $aktivitas['label'] }}</p>
                        <p class="text-[11px] text-slate-500 truncate">{{ $aktivitas['detail'] }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">{{ $aktivitas['time']?->locale('id')->isoFormat('D MMM YYYY • HH:mm') }}</p>
                    </div>
                </div>
                @empty
                <div class="p-6 text-center">
                    <p class="text-sm font-semibold text-slate-500">Belum ada aktivitas</p>
                    <p class="text-xs text-slate-400 mt-1">Aktivitas siswa, materi, dan quiz akan muncul di sini.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- ROW 4: PERFORMA KATEGORI + TOP SISWA BERPRESTASI      -->
    <!-- ===================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- PERFORMA KATEGORI (Bar Chart) -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <h3 class="text-base font-bold text-slate-800">Performa Kategori</h3>
                </div>
                <a href="{{ route('admin.hasil-quiz') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    Lihat detail
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="p-6">
                <div class="flex flex-wrap gap-3 mb-4">
                    @php
                        $chartColors = [
                            'Speaking' => 'bg-emerald-500',
                            'Writing' => 'bg-purple-500',
                            'Reading' => 'bg-blue-500',
                            'Listening' => 'bg-amber-500',
                        ];
                    @endphp
                    @foreach($performaKategori as $kategori)
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full {{ $chartColors[$kategori['nama']] ?? 'bg-slate-400' }}"></span>
                        <span class="text-xs font-semibold text-slate-600">{{ $kategori['nama'] }}</span>
                        <span class="text-[10px] text-slate-400">{{ $kategori['jumlah'] }} hasil</span>
                    </div>
                    @endforeach
                </div>

                <div class="relative h-56">
                    <canvas id="categoryPerformanceChart"></canvas>
                </div>

                @php
                    $performaTerisi = $performaKategori->filter(fn ($k) => $k['jumlah'] > 0)->values();
                    $tertinggi = $performaTerisi->sortByDesc('nilai')->first();
                    $terendah  = $performaTerisi->sortBy('nilai')->first();
                @endphp
                <div class="grid grid-cols-2 gap-3 mt-4 pt-4 border-t border-slate-100">
                    <div class="p-3 bg-emerald-50 rounded-xl">
                        <p class="text-[10px] text-slate-500 font-semibold uppercase">Rata-rata Tertinggi</p>
                        <p class="text-sm font-bold text-emerald-700 mt-0.5">{{ $tertinggi ? $tertinggi['nama'] . ' (' . $tertinggi['nilai'] . ')' : 'Belum ada data' }}</p>
                    </div>
                    <div class="p-3 bg-amber-50 rounded-xl">
                        <p class="text-[10px] text-slate-500 font-semibold uppercase">Perlu Perhatian</p>
                        <p class="text-sm font-bold text-amber-700 mt-0.5">{{ $terendah ? $terendah['nama'] . ' (' . $terendah['nilai'] . ')' : 'Belum ada data' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- TOP 5 SISWA BERPRESTASI -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5zm14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z"/>
                    </svg>
                    <h3 class="text-base font-bold text-slate-800">Top 5 Siswa Berprestasi</h3>
                </div>
                <a href="{{ route('admin.monitoring-siswa') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    Lihat semua
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="p-4 space-y-2">
                @php
                    $medalColors = ['bg-amber-400', 'bg-slate-400', 'bg-amber-600', 'bg-blue-100', 'bg-blue-100'];
                    $medalIcons = ['🥇', '🥈', '🥉', '4', '5'];
                @endphp

                @forelse($topSiswa as $index => $student)
                <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition border border-slate-100">
                    <div class="w-9 h-9 rounded-xl {{ $medalColors[$index] ?? 'bg-slate-100' }} flex items-center justify-center shrink-0 text-sm font-bold {{ $index < 3 ? 'text-white' : 'text-slate-600' }}">
                        {{ $medalIcons[$index] ?? ($index + 1) }}
                    </div>

                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-indigo-500 flex items-center justify-center text-white font-bold text-sm shrink-0">
                        {{ substr($student['nama'], 0, 1) }}
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 truncate">{{ $student['nama'] }}</p>
                        <p class="text-[10px] text-slate-500 truncate">{{ $student['email'] }} • {{ $student['quiz'] }} quiz</p>
                    </div>

                    <div class="text-right shrink-0">
                        <p class="text-lg font-extrabold text-slate-800">{{ $student['nilai'] }}</p>
                        <p class="text-[10px] text-slate-400 font-semibold">Rata-rata</p>
                    </div>
                </div>
                @empty
                <div class="p-6 text-center">
                    <p class="text-sm font-semibold text-slate-500">Belum ada data prestasi</p>
                    <p class="text-xs text-slate-400 mt-1">Data muncul setelah siswa mengerjakan quiz.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- ROW 5: JADWAL HARI INI + SISWA BUTUH PERHATIAN        -->
    <!-- (BARU - Biar Ga Kosong)                               -->
    <!-- ===================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- REMINDER TERKIRIM -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="text-base font-bold text-slate-800">Reminder Terkirim</h3>
                </div>
                <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">{{ $reminderTerbaru->count() }} Reminder</span>
            </div>

            <div class="p-4 space-y-3">
                @forelse($reminderTerbaru as $reminder)
                <div class="flex items-start gap-3 p-3 rounded-xl bg-blue-50 border border-blue-100">
                    <div class="w-9 h-9 rounded-xl bg-white flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-slate-800">{{ $reminder['nama'] }}</p>
                        <p class="text-[11px] text-slate-600">{{ $reminder['pesan'] }}</p>
                        <p class="text-[10px] text-slate-400 mt-1">{{ $reminder['waktu'] }} • {{ $reminder['dibaca'] ? 'Sudah dibaca' : 'Belum dibaca' }}</p>
                    </div>
                </div>
                @empty
                <div class="p-6 text-center">
                    <p class="text-sm font-semibold text-slate-500">Belum ada reminder</p>
                    <p class="text-xs text-slate-400 mt-1">Kirim pengingat belajar ke siswa melalui menu Kirim Reminder.</p>
                    <a href="{{ route('admin.kirim-reminder') }}" class="inline-block mt-3 text-xs font-semibold text-[#018ABE] hover:text-[#02457A]">Kirim Reminder →</a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- SISWA BUTUH PERHATIAN -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <h3 class="text-base font-bold text-slate-800">Siswa Butuh Perhatian</h3>
                </div>
                <span class="text-xs font-bold text-rose-600 bg-rose-50 px-2.5 py-1 rounded-full">{{ $siswaPerluPerhatian->count() }} Siswa</span>
            </div>

            <div class="p-4 space-y-2">
                @forelse($siswaPerluPerhatian as $student)
                <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition border border-slate-100">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-rose-400 to-pink-500 flex items-center justify-center text-white font-bold text-sm shrink-0">
                        {{ substr($student['nama'], 0, 1) }}
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 truncate">{{ $student['nama'] }}</p>
                        <p class="text-[10px] text-rose-600 font-semibold truncate">{{ $student['masalah'] }}</p>
                    </div>

                    <div class="text-right shrink-0">
                        <p class="text-lg font-extrabold text-rose-600">{{ $student['nilai'] }}</p>
                        <p class="text-[10px] text-slate-400 font-semibold">Nilai</p>
                    </div>
                </div>
                @empty
                <div class="p-6 text-center">
                    <p class="text-sm font-semibold text-slate-500">Semua siswa dalam pantauan</p>
                    <p class="text-xs text-slate-400 mt-1">Tidak ada siswa dengan nilai rendah atau tidak aktif.</p>
                </div>
                @endforelse

                <a href="{{ route('admin.monitoring-siswa') }}" class="block w-full py-2.5 mt-2 text-center text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition">
                    Lihat Semua Siswa →
                </a>
            </div>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- ROW 6: AKTIVITAS BULANAN + TIPS HARIAN                  -->
    <!-- ===================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- AKTIVITAS BULAN INI -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Aktivitas Bulan Ini</h3>
                        <p class="text-xs text-slate-400">Ringkasan aktivitas materi, kuis, dan interaksi pembelajaran siswa</p>
                    </div>
                </div>
                <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">{{ $periodeBulanIni }}</span>
            </div>

            <div class="p-6 space-y-3.5">
                @php
                    $palette = [
                        'blue'    => ['bg' => 'bg-blue-50/60 border-blue-100', 'icon_bg' => 'bg-blue-100 text-blue-600', 'badge' => 'text-blue-700 bg-blue-100/70 border-blue-200'],
                        'purple'  => ['bg' => 'bg-purple-50/60 border-purple-100', 'icon_bg' => 'bg-purple-100 text-purple-600', 'badge' => 'text-purple-700 bg-purple-100/70 border-purple-200'],
                        'emerald' => ['bg' => 'bg-emerald-50/60 border-emerald-100', 'icon_bg' => 'bg-emerald-100 text-emerald-600', 'badge' => 'text-emerald-700 bg-emerald-100/70 border-emerald-200'],
                        'amber'   => ['bg' => 'bg-amber-50/60 border-amber-100', 'icon_bg' => 'bg-amber-100 text-amber-600', 'badge' => 'text-amber-700 bg-amber-100/70 border-amber-200'],
                    ];
                @endphp

                @foreach($aktivitasBulanIni ?? $targetBulanIni as $item)
                @php
                    $warnaKey = $item['warna'] ?? 'blue';
                    $p = $palette[$warnaKey] ?? $palette['blue'];
                    $nilai = $item['nilai'] ?? ($item['current'] ?? 0);
                    $satuan = $item['satuan'] ?? '';
                    $deskripsi = $item['deskripsi'] ?? 'Aktivitas pembelajaran bulan ini';
                @endphp
                <div class="p-3.5 rounded-2xl border {{ $p['bg'] }} flex items-center justify-between gap-4 transition hover:bg-white hover:shadow-sm">
                    <div class="flex items-center gap-3.5 min-w-0">
                        <div class="w-10 h-10 rounded-xl {{ $p['icon_bg'] }} flex items-center justify-center shrink-0 shadow-xs">
                            @if(($item['icon'] ?? '') === 'materi')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            @elseif(($item['icon'] ?? '') === 'quiz')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            @elseif(($item['icon'] ?? '') === 'siswa')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-slate-800 truncate">{{ $item['label'] }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ $deskripsi }}</p>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border {{ $p['badge'] }} text-sm font-extrabold shadow-2xs">
                            <span>{{ $nilai }}</span>
                            @if($satuan)
                                <span class="text-xs font-semibold opacity-85">{{ $satuan }}</span>
                            @endif
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- TIPS HARIAN + QUICK INFO -->
        <div class="space-y-4">
            <!-- Tips Harian -->
            <div class="bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 opacity-10 -mr-8 -mt-8">
                    <svg viewBox="0 0 200 200" class="w-full h-full text-white" fill="currentColor">
                        <circle cx="100" cy="60" r="40"/>
                        <circle cx="60" cy="140" r="35"/>
                        <circle cx="140" cy="140" r="35"/>
                    </svg>
                </div>
                <div class="relative">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-2xl">💡</span>
                        <p class="text-xs font-bold uppercase tracking-wider text-white/90">Tips Hari Ini</p>
                    </div>
                    <p class="font-cute text-lg text-white leading-tight mb-3">
                        "{{ $tipHariIni['judul'] }}"
                    </p>
                    <p class="text-xs text-white/80">
                        {{ $tipHariIni['isi'] }}
                    </p>
                </div>
            </div>

            <!-- Quick Info Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Info Cepat
                </h3>
                <div class="space-y-2">
                    @php
                        $infoColors = [
                            'amber' => 'text-amber-600 bg-amber-50',
                            'rose'  => 'text-rose-600 bg-rose-50',
                            'blue'  => 'text-blue-600 bg-blue-50',
                        ];
                    @endphp
                    @foreach($infoCepat as $info)
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-50">
                        <span class="text-xs text-slate-600">{{ $info['label'] }}</span>
                        <span class="text-xs font-bold px-2 py-0.5 rounded {{ $infoColors[$info['warna']] ?? 'text-slate-600 bg-slate-100' }}">{{ $info['value'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// =============================================
// LIVE CLOCK
// =============================================
const quotes = @json($quotes);

function updateLiveClock() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');

    document.getElementById('liveTime').textContent = `${hours}:${minutes}`;
    document.getElementById('liveSeconds').textContent = `:${seconds}`;

    const hour = now.getHours();
    let greeting, icon;
    if (hour >= 4 && hour < 11) { greeting = 'Selamat Pagi'; icon = '☀️'; }
    else if (hour >= 11 && hour < 15) { greeting = 'Selamat Siang'; icon = '🌤️'; }
    else if (hour >= 15 && hour < 18) { greeting = 'Selamat Sore'; icon = ''; }
    else { greeting = 'Selamat Malam'; icon = '🌙'; }

    document.getElementById('greetingText').textContent = greeting;
    document.getElementById('greetingIcon').textContent = icon;

    const totalMinutesInDay = 24 * 60;
    const currentMinutes = now.getHours() * 60 + now.getMinutes();
    const dayProgress = Math.round((currentMinutes / totalMinutesInDay) * 100);

    document.getElementById('dayProgress').textContent = `${dayProgress}%`;
    document.getElementById('dayProgressBar').style.width = `${dayProgress}%`;

    const dayOfYear = Math.floor((now - new Date(now.getFullYear(), 0, 0)) / 86400000);
    const quoteIndex = dayOfYear % quotes.length;
    document.getElementById('dailyQuote').textContent = `"${quotes[quoteIndex]}"`;
}

updateLiveClock();
setInterval(updateLiveClock, 1000);

// =============================================
// BAR CHART - Performa Kategori (data dari database)
// =============================================
const kategoriData = @json($performaKategori->pluck('nilai', 'nama'));
const kategoriLabels = Object.keys(kategoriData);
const kategoriNilai = Object.values(kategoriData);
const warnaKategori = {
    'Speaking': 'rgba(16, 185, 129, 0.8)',
    'Writing': 'rgba(168, 85, 247, 0.8)',
    'Reading': 'rgba(59, 130, 246, 0.8)',
    'Listening': 'rgba(245, 158, 11, 0.8)'
};

const ctx = document.getElementById('categoryPerformanceChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: kategoriLabels,
        datasets: [{
            label: 'Rata-rata Nilai',
            data: kategoriNilai,
            backgroundColor: kategoriLabels.map(nama => warnaKategori[nama] || 'rgba(148, 163, 184, 0.8)'),
            borderRadius: 8,
            borderSkipped: false,
            barPercentage: 0.6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1e293b',
                titleFont: { size: 12, family: 'Plus Jakarta Sans' },
                bodyFont: { size: 11, family: 'Plus Jakarta Sans' },
                padding: 10,
                cornerRadius: 8,
                callbacks: { label: function(context) { return 'Rata-rata: ' + context.parsed.y; } }
            }
        },
        scales: {
            y: { beginAtZero: true, max: 100, grid: { color: '#f1f5f9' }, ticks: { font: { size: 11, family: 'Plus Jakarta Sans' }, color: '#94a3b8' } },
            x: { grid: { display: false }, ticks: { font: { size: 11, family: 'Plus Jakarta Sans', weight: '600' }, color: '#64748B' } }
        }
    }
});
</script>
@endpush

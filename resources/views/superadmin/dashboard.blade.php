@extends('layouts.superadmin')

@section('title', 'Dashboard Super Admin')

@section('content')
<div class="space-y-6">

    @if($errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-800 text-sm px-4 py-3 rounded-2xl shadow-xs">
        <p class="font-bold mb-1">Gagal menyimpan akun:</p>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- ============================================================== -->
    <!-- 1. WELCOME BANNER (Matching the mockup illustration)          -->
    <!-- ============================================================== -->
    <div class="bg-gradient-to-r from-sky-100/70 via-blue-50/50 to-white rounded-3xl p-6 sm:p-8 border border-sky-200/70 shadow-sm relative overflow-hidden">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 relative z-10">
            <!-- Left: Greeting text & sparkles -->
            <div class="max-w-xl">
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="text-sky-500 text-lg">✦</span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">
                        Selamat Datang, Satpam &amp; HRD!
                    </h1>
                </div>
                <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                    Kelola akun dan data sistem Englify dengan mudah dan aman.
                </p>
                <div class="mt-4 flex flex-wrap items-center gap-3">
                    <button onclick="openTambahModal('siswa')" 
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-sky-600 hover:bg-sky-700 text-white text-xs sm:text-sm font-bold shadow-md shadow-sky-600/20 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Tambah Siswa Baru
                    </button>
                    <button onclick="openTambahModal('admin')" 
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white hover:bg-slate-50 text-slate-700 border border-slate-200/80 text-xs sm:text-sm font-bold shadow-xs transition">
                        <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Tambah Admin Divisi
                    </button>
                </div>
            </div>

            <!-- Right: Englify Cat Mascot & Speech Callout -->
            <div class="flex items-center gap-4 self-center sm:self-auto shrink-0">
                <!-- Speech Bubble -->
                <div class="hidden md:block relative bg-white/95 backdrop-blur-xs border border-sky-200/70 rounded-2xl p-3.5 shadow-sm max-w-[210px]">
                    <p class="font-cute text-base text-slate-700 leading-tight">
                        “Kelola akun, bangun masa depan bersama Englify!” 🐾
                    </p>
                    <span class="absolute -right-2 top-1/2 -translate-y-1/2 w-3 h-3 bg-white border-t border-r border-sky-200/70 transform rotate-45"></span>
                </div>
                <!-- Mascot Image -->
                <div class="relative">
                    <img src="{{ asset('images/cat-welcome.png') }}" alt="Englify Cat Mascot" 
                         class="w-32 sm:w-44 h-auto object-contain drop-shadow-lg transform hover:scale-105 transition-transform duration-300">
                    <span class="absolute -top-2 right-1 text-amber-400 text-sm animate-bounce">✨</span>
                </div>
            </div>
        </div>
        
        <!-- Subtle decorative gradient blur spots -->
        <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-sky-100/50 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-sky-100/50 rounded-full blur-2xl pointer-events-none"></div>
    </div>


    <!-- ============================================================== -->
    <!-- 2. METRIC CARDS ROW (Exact match: Total Siswa, Divisi, Sistem) -->
    <!-- ============================================================== -->
    <!-- Desktop: 3 prominent cards | Mobile: 2x2 grid (including Admin Divisi) -->
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3.5 sm:gap-5">
        
        <!-- CARD 1: Total Siswa -->
        <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 border border-slate-200/70 shadow-sm hover:shadow-md transition duration-200">
            <div class="flex items-center justify-between mb-2 sm:mb-3">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center">
                    <!-- Users icon -->
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <span id="siswa-growth-badge" class="inline-flex items-center text-[10px] sm:text-xs font-bold text-emerald-600 bg-emerald-50 border border-emerald-200/70 px-2 py-0.5 rounded-full">
                    {{ $siswaGrowth ?? '+ 0%' }}
                </span>
            </div>
            <p class="text-xs sm:text-sm font-semibold text-slate-500">Total Siswa</p>
            <div class="flex items-baseline gap-2 mt-0.5">
                <h3 id="total-siswa-value" class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">
                    {{ $totalSiswa ?? 0 }}
                </h3>
            </div>
            <p class="text-[10px] sm:text-xs text-slate-400 mt-1">dari bulan lalu</p>
        </div>

        <!-- CARD 2: Total Admin -->
        <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 border border-slate-200/70 shadow-sm hover:shadow-md transition duration-200">
            <div class="flex items-center justify-between mb-2 sm:mb-3">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <!-- Shield icon -->
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <span id="admin-growth-badge" class="inline-flex items-center text-[10px] sm:text-xs font-bold text-emerald-600 bg-emerald-50 border border-emerald-200/70 px-2 py-0.5 rounded-full">
                    {{ $adminGrowth ?? '+ 0%' }}
                </span>
            </div>
            <p class="text-xs sm:text-sm font-semibold text-slate-500">Total Admin</p>
            <div class="flex items-baseline gap-2 mt-0.5">
                <h3 id="total-admin-value" class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">
                    {{ $totalAdmin ?? 0 }}
                </h3>
            </div>
            <p class="text-[10px] sm:text-xs text-slate-400 mt-1">dari bulan lalu</p>
        </div>

        <!-- CARD 3: Data Sistem (Desktop 3rd card, on mobile shown in 2x2 grid) -->
        <div class="col-span-2 lg:col-span-1 bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 border border-slate-200/70 shadow-sm hover:shadow-md transition duration-200">
            <div class="flex items-center justify-between mb-2 sm:mb-3">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center">
                    <!-- Server / database check icon -->
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                    </svg>
                </div>
                <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-xs">
                    ✓
                </span>
            </div>
            <p class="text-xs sm:text-sm font-semibold text-slate-500">Data Sistem</p>
            <div class="flex items-baseline gap-2 mt-0.5">
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">
                    {{ $systemStatus ?? 'Normal' }}
                </h3>
            </div>
            <p class="text-[10px] sm:text-xs text-slate-400 mt-1">Semua sistem berjalan dengan baik/aktif</p>
        </div>

        <!-- Extra card for mobile view: Total Divisi (so mobile has exact 2x2 symmetry) -->
        <div class="lg:hidden bg-white rounded-2xl p-4 border border-slate-200/70 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </div>
                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">{{ $divisiGrowth ?? '+ 0%' }}</span>
            </div>
            <p class="text-xs font-semibold text-slate-500">Total Divisi</p>
            <h3 class="text-2xl font-extrabold text-slate-800">{{ $totalDivisi ?? 0 }}</h3>
            <p class="text-[10px] text-slate-400 mt-1">dari bulan lalu</p>
        </div>
    </div>


    <!-- ============================================================== -->
    <!-- 3. MIDDLE SECTION (2 COLUMNS: Aktivitas Terbaru & Statistik)   -->
    <!-- ============================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 sm:gap-6">
        
        <!-- ============ LEFT COLUMN: Aktivitas Terbaru ============ -->
        <div class="bg-white rounded-3xl p-5 sm:p-7 border border-slate-200/70 shadow-sm flex flex-col justify-between">
            <div>
                <!-- Header with Lihat Semua link -->
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-base sm:text-lg font-extrabold text-slate-800">
                        Aktivitas Terbaru
                    </h2>
                    <a href="#tabel-kelola-akun" class="text-xs sm:text-sm font-bold text-sky-600 hover:text-sky-800 flex items-center gap-1 group">
                        <span>Lihat Semua</span>
                        <span class="transition-transform group-hover:translate-x-1">→</span>
                    </a>
                </div>

                <!-- Activity List items -->
                <div class="space-y-3.5">
                    @forelse(($recentActivities ?? collect()) as $act)
                    <div class="flex items-center justify-between gap-3 p-2.5 rounded-2xl hover:bg-sky-50/40 transition duration-150">
                        <!-- Icon & text -->
                        <div class="flex items-center gap-3.5 min-w-0">
                            <!-- Circular user icon -->
                            <div class="w-10 h-10 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs sm:text-sm font-bold text-slate-800 truncate">
                                    {{ $act->title }}
                                </p>
                                <p class="text-[11px] sm:text-xs text-slate-500 truncate">
                                    {{ $act->desc }}
                                </p>
                                <p class="text-[10px] text-slate-400 mt-0.5">
                                    {{ $act->time }}
                                </p>
                            </div>
                        </div>
                        <!-- Role Badge (Siswa / Admin Divisi) -->
                        <span class="shrink-0 text-[11px] font-bold px-3 py-1 rounded-full border {{ $act->badge_class }}">
                            {{ $act->role }}
                        </span>
                    </div>
                    @empty
                    <p class="text-xs text-slate-400 text-center py-6">Belum ada aktivitas tercatat.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- ============ RIGHT COLUMN: Statistik Akun & Ringkasan ============ -->
        <div class="space-y-5">
            <!-- 1. Statistik Akun (Line Chart) -->
            <div class="bg-white rounded-3xl p-5 sm:p-7 border border-slate-200/70 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h2 class="text-base sm:text-lg font-extrabold text-slate-800">
                            Statistik Akun
                        </h2>
                        <p id="stats-last-update" class="text-[10px] text-slate-400 mt-0.5">
                            Diperbarui {{ ($generatedAt ?? '') !== '' ? \Carbon\Carbon::parse($generatedAt)->format('d M Y H:i:s') : now()->format('d M Y H:i:s') }}
                        </p>
                    </div>
                    <!-- Timeframe: hanya 7 hari terakhir (real-time) -->
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span>Live • 7 Hari Terakhir</span>
                    </span>
                </div>

                <!-- Legend: Siswa -->
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-sky-600"></span>
                    <span class="text-xs font-bold text-slate-600">Siswa</span>
                </div>

                <!-- Interactive Chart Canvas -->
                <div class="h-44 sm:h-52 w-full relative">
                    <canvas id="studentGrowthChart"></canvas>
                </div>
            </div>

            <!-- 2. Ringkasan (4 mini boxes in a row) -->
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/70 shadow-sm">
                <h3 class="text-sm font-extrabold text-slate-800 mb-3.5">Ringkasan</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <!-- Mini 1: Siswa Baru -->
                    <div class="bg-slate-50/60 rounded-2xl p-3 border border-slate-200/60 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="w-7 h-7 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center text-xs">👥</span>
                            <span id="new-siswa-growth" class="text-[10px] font-bold text-emerald-600">{{ $newSiswaGrowth ?? '▲ 0%' }}</span>
                        </div>
                        <div class="mt-2">
                            <p class="text-[10px] font-semibold text-slate-400">Siswa Baru</p>
                            <p id="new-siswa-count" class="text-lg font-extrabold text-slate-800 leading-tight">{{ $newSiswaCount ?? 0 }}</p>
                        </div>
                    </div>

                    <!-- Mini 2: Admin Baru -->
                    <div class="bg-slate-50/60 rounded-2xl p-3 border border-slate-200/60 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs">🛡️</span>
                            <span id="new-admin-growth" class="text-[10px] font-bold text-emerald-600">{{ $newAdminGrowth ?? '▲ 0%' }}</span>
                        </div>
                        <div class="mt-2">
                            <p class="text-[10px] font-semibold text-slate-400">Admin Baru</p>
                            <p id="new-admin-count" class="text-lg font-extrabold text-slate-800 leading-tight">{{ $newAdminCount ?? 0 }}</p>
                        </div>
                    </div>

                    <!-- Mini 3: Divisi Aktif -->
                    <div class="bg-slate-50/60 rounded-2xl p-3 border border-slate-200/60 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs">🏛️</span>
                            <span id="total-akun-growth" class="text-[10px] font-bold text-emerald-600">{{ $totalAkunGrowth ?? '▲ 0%' }}</span>
                        </div>
                        <div class="mt-2">
                            <p class="text-[10px] font-semibold text-slate-400">Total Akun</p>
                            <p id="total-akun-value" class="text-lg font-extrabold text-slate-800 leading-tight">{{ $totalAkun ?? 0 }}</p>
                        </div>
                    </div>

                    <!-- Mini 4: Akun Aktif -->
                    <div class="bg-slate-50/60 rounded-2xl p-3 border border-slate-200/60 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs">✓</span>
                            <span id="active-growth" class="text-[10px] font-bold text-emerald-600">{{ $activeGrowth ?? '▲ 0%' }}</span>
                        </div>
                        <div class="mt-2">
                            <p class="text-[10px] font-semibold text-slate-400">Akun Aktif</p>
                            <p id="active-accounts-value" class="text-lg font-extrabold text-slate-800 leading-tight">{{ $activeAccounts ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ============================================================== -->
    <!-- 4. BOTTOM SECTION: KELOLA AKUN (Dual Tables Side-by-Side)      -->
    <!-- ============================================================== -->
    <div id="tabel-kelola-akun" class="bg-white rounded-3xl p-5 sm:p-8 border border-slate-200/70 shadow-sm">
        <!-- Section Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-slate-200/60">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                    <!-- Users table / folder badge icon -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg sm:text-xl font-extrabold text-slate-800">Kelola Akun</h2>
                    <p class="text-xs sm:text-sm text-slate-500">Buat dan kelola akun siswa serta admin divisi.</p>
                </div>
            </div>

            <!-- Primary Action: + Tambah Akun -->
            <button onclick="openTambahModal('siswa')" 
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs sm:text-sm shadow-md shadow-sky-600/25 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                <span>Tambah Akun</span>
            </button>
        </div>

        <!-- Dual Table Container: 2 equal columns on desktop, stacked on mobile -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 pt-6">

            <!-- ===================== TABLE 1: AKUN SISWA ===================== -->
            <div class="border border-slate-200/60 rounded-2xl p-4 sm:p-5 bg-slate-50/40 flex flex-col justify-between">
                <div>
                    <!-- Sub-header -->
                    <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-200/60">
                        <div class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center text-xs">👤</span>
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-800">Akun Siswa</h3>
                                <p class="text-[11px] text-slate-400">{{ $totalSiswa ?? 0 }} akun</p>
                            </div>
                        </div>
                        <a href="{{ route('superadmin.siswa') }}" class="text-xs font-bold text-sky-600 hover:text-sky-800 flex items-center gap-1">
                            Lihat Semua &gt;
                        </a>
                    </div>

                    <!-- Responsive Table -->
                    <div class="overflow-x-auto touch-pan-y cursor-grab active:cursor-grabbing select-none" id="table-container-siswa" title="Geser / swipe ke kiri atau kanan untuk berpindah halaman">
                        <table class="w-full text-left text-xs min-w-[340px]">
                            <thead>
                                <tr class="text-slate-400 font-bold border-b border-slate-200/60">
                                    <th class="py-2.5 px-2">No</th>
                                    <th class="py-2.5 px-2">Nama</th>
                                    <th class="py-2.5 px-2">Email</th>
                                    <th class="py-2.5 px-2">Status</th>
                                    <th class="py-2.5 px-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100/80 text-slate-700 transition-opacity duration-150" id="tbody-siswa">
                                @forelse(($students ?? collect()) as $idx => $s)
                                @php $page = (int) floor($idx / 5) + 1; @endphp
                                <tr class="hover:bg-sky-50/50 transition row-siswa {{ $page > 1 ? 'hidden' : '' }}" data-page="{{ $page }}">
                                    <td class="py-2.5 px-2 font-semibold text-slate-400">{{ $idx + 1 }}</td>
                                    <td class="py-2.5 px-2 font-bold text-slate-800">{{ $s->nama }}</td>
                                    <td class="py-2.5 px-2 text-slate-500 truncate max-w-[140px]">{{ $s->email }}</td>
                                    <td class="py-2.5 px-2">
                                        <span class="inline-block text-[10px] font-bold px-2.5 py-0.5 rounded-full {{ strtolower($s->status ?? 'aktif') === 'aktif' ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'bg-amber-50 text-amber-600 border border-amber-200' }}">
                                            {{ ucfirst($s->status ?? 'aktif') }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-2 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <!-- Edit button -->
                                            <button onclick="openEditModal(@js($s->id_user), @js($s->nama), @js($s->email), 'siswa')" 
                                                    class="p-1 rounded text-sky-600 hover:bg-sky-100 transition" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            </button>
                                            <!-- Delete button -->
                                            <form action="{{ route('superadmin.siswa.destroy', $s->id_user) }}" method="POST" onsubmit="return confirmHapus(event, @js($s->nama))">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1 rounded text-rose-500 hover:bg-rose-100 transition" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-slate-400">Belum ada akun siswa.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination Matching Mockup (< [1] 2 3 >) -->
                <div id="pagination-siswa" class="flex items-center justify-center gap-1 pt-4 mt-3 border-t border-slate-200/60 select-none">
                    <!-- Dinamis diinisialisasi oleh JS -->
                </div>
            </div>

            <!-- ===================== TABLE 2: AKUN ADMIN ===================== -->
            <div class="border border-slate-200/60 rounded-2xl p-4 sm:p-5 bg-slate-50/40 flex flex-col justify-between">
                <div>
                    <!-- Sub-header -->
                    <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-200/60">
                        <div class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs">🏛️</span>
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-800">Akun Admin</h3>
                                <p class="text-[11px] text-slate-400">{{ $totalAdmin ?? 0 }} akun</p>
                            </div>
                        </div>
                        <a href="{{ route('superadmin.adminDivisi') }}" class="text-xs font-bold text-sky-600 hover:text-sky-800 flex items-center gap-1">
                            Lihat Semua &gt;
                        </a>
                    </div>

                    <!-- Responsive Table -->
                    <div class="overflow-x-auto touch-pan-y cursor-grab active:cursor-grabbing select-none" id="table-container-admin" title="Geser / swipe ke kiri atau kanan untuk berpindah halaman">
                        <table class="w-full text-left text-xs min-w-[340px]">
                            <thead>
                                <tr class="text-slate-400 font-bold border-b border-slate-200/60">
                                    <th class="py-2.5 px-2">No</th>
                                    <th class="py-2.5 px-2">Nama</th>
                                    <th class="py-2.5 px-2">Email</th>
                                    <th class="py-2.5 px-2">Status</th>
                                    <th class="py-2.5 px-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100/80 text-slate-700 transition-opacity duration-150" id="tbody-admin">
                                @forelse(($admins ?? collect()) as $idx => $a)
                                @php $page = (int) floor($idx / 5) + 1; @endphp
                                <tr class="hover:bg-sky-50/50 transition row-admin {{ $page > 1 ? 'hidden' : '' }}" data-page="{{ $page }}">
                                    <td class="py-2.5 px-2 font-semibold text-slate-400">{{ $idx + 1 }}</td>
                                    <td class="py-2.5 px-2 font-bold text-slate-800">{{ $a->nama }}</td>
                                    <td class="py-2.5 px-2 text-slate-600 break-all">{{ $a->email }}</td>
                                    <td class="py-2.5 px-2">
                                        <span class="inline-block text-[10px] font-bold px-2.5 py-0.5 rounded-full {{ strtolower($a->status ?? 'aktif') === 'aktif' ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'bg-amber-50 text-amber-600 border border-amber-200' }}">
                                            {{ ucfirst($a->status ?? 'aktif') }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-2 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <!-- Edit button -->
                                            <button onclick="openEditModal(@js($a->id_user), @js($a->nama), @js($a->email ?? ''), 'admin')" 
                                                    class="p-1 rounded text-sky-600 hover:bg-sky-100 transition" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            </button>
                                            <!-- Delete button -->
                                            <form action="{{ route('superadmin.adminDivisi.destroy', $a->id_user) }}" method="POST" onsubmit="return confirmHapus(event, @js($a->nama))">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1 rounded text-rose-500 hover:bg-rose-100 transition" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-slate-400">Belum ada akun admin divisi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination Matching Mockup (< [1] 2 3 >) -->
                <div id="pagination-admin" class="flex items-center justify-center gap-1 pt-4 mt-3 border-t border-slate-200/60 select-none">
                    <!-- Dinamis diinisialisasi oleh JS -->
                </div>
            </div>

        </div>
    </div>

</div>

<!-- ============================================================== -->
<!-- MODAL TAMBAH AKUN (Siswa / Admin Divisi)                       -->
<!-- ============================================================== -->
<div id="modal-tambah-akun" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full p-6 sm:p-7 relative max-h-[90vh] overflow-y-auto border border-slate-100">
        <div class="flex items-center justify-between pb-4 border-b border-slate-200/60 mb-5">
            <h3 id="modal-tambah-title" class="text-lg font-extrabold text-slate-800">Tambah Akun Baru</h3>
            <button onclick="closeTambahModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form action="{{ route('superadmin.users.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Tipe Role Akun</label>
                <div class="grid grid-cols-2 gap-2">
                    <label class="flex items-center gap-2 p-3 rounded-2xl border border-slate-200/80 cursor-pointer has-[:checked]:border-sky-600 has-[:checked]:bg-sky-50/60">
                        <input type="radio" name="role" value="siswa" id="role-siswa" checked class="text-sky-600">
                        <span class="text-xs font-bold text-slate-800">Akun Siswa</span>
                    </label>
                    <label class="flex items-center gap-2 p-3 rounded-2xl border border-slate-200/80 cursor-pointer has-[:checked]:border-sky-600 has-[:checked]:bg-sky-50/60">
                        <input type="radio" name="role" value="admin" id="role-admin" class="text-sky-600">
                        <span class="text-xs font-bold text-slate-800">Admin Divisi</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap</label>
                <input type="text" name="nama" required placeholder="Contoh: Rani Putri"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/30 focus:border-sky-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Email Pengguna</label>
                <input type="email" name="email" required placeholder="Contoh: rani@gmail.com"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/30 focus:border-sky-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Password Awal (Default: password123)</label>
                <div class="relative">
                    <input type="password" name="password" id="tambah-password" placeholder="Minimal 6 karakter"
                           class="w-full px-4 py-2.5 pr-11 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/30 focus:border-sky-500">
                    <button type="button" onclick="togglePassword('tambah-password', this)" title="Lihat password"
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-400 hover:text-slate-600 transition">
                        <svg class="w-4 h-4 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg class="w-4 h-4 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                    </button>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-3">
                <button type="button" onclick="closeTambahModal()" class="flex-1 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">Batal</button>
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold shadow-md shadow-sky-600/20 transition">Simpan Akun</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL EDIT AKUN                                                -->
<!-- ============================================================== -->
<div id="modal-edit-akun" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full p-6 sm:p-7 relative border border-slate-100">
        <div class="flex items-center justify-between pb-4 border-b border-slate-200/60 mb-5">
            <h3 class="text-lg font-extrabold text-slate-800">Edit Akun Pengguna</h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="edit-akun-form" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap</label>
                <input type="text" id="edit-nama" name="nama" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/30 focus:border-sky-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Email</label>
                <input type="email" id="edit-email" name="email" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/30 focus:border-sky-500">
            </div>
            <div class="flex items-center gap-3 pt-3">
                <button type="button" onclick="closeEditModal()" class="flex-1 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">Batal</button>
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold shadow-md shadow-sky-600/20 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Modal Tambah logic
function openTambahModal(type) {
    const m = document.getElementById('modal-tambah-akun');
    const roleSiswa = document.getElementById('role-siswa');
    const roleAdmin = document.getElementById('role-admin');
    const title = document.getElementById('modal-tambah-title');
    
    if (type === 'admin') {
        roleAdmin.checked = true;
        roleSiswa.checked = false;
        title.textContent = 'Tambah Akun Admin Divisi';
    } else {
        roleSiswa.checked = true;
        roleAdmin.checked = false;
        title.textContent = 'Tambah Akun Siswa Baru';
    }
    const activeRadio = (type === 'admin') ? roleAdmin : roleSiswa;
    activeRadio.dispatchEvent(new Event('change', { bubbles: true }));

    m.classList.remove('hidden');
    m.classList.add('flex');
}

function closeTambahModal() {
    const m = document.getElementById('modal-tambah-akun');
    m.classList.add('hidden');
    m.classList.remove('flex');
    const form = m.querySelector('form');
    if (form) form.reset();
}

// Toggle lihat/sembunyi password
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const show = input.type === 'password';
    input.type = show ? 'text' : 'password';
    btn.querySelector('.eye-open').classList.toggle('hidden', show);
    btn.querySelector('.eye-closed').classList.toggle('hidden', !show);
}

// Modal Edit logic
function openEditModal(id, nama, email, role) {
    const form = document.getElementById('edit-akun-form');
    const routeTemplate = role === 'admin'
        ? @js(route('superadmin.adminDivisi.update', ['id' => '__ID__']))
        : @js(route('superadmin.siswa.update', ['id' => '__ID__']));
    form.action = routeTemplate.replace('__ID__', encodeURIComponent(id));
    document.getElementById('edit-nama').value = nama;
    document.getElementById('edit-email').value = email;
    const m = document.getElementById('modal-edit-akun');
    m.classList.remove('hidden');
    m.classList.add('flex');
}

function closeEditModal() {
    const m = document.getElementById('modal-edit-akun');
    m.classList.add('hidden');
    m.classList.remove('flex');
}

// Confirm Delete logic (SweetAlert2)
function confirmHapus(event, nama) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    const form = event ? event.target.closest('form') : null;
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'warning',
            title: 'Hapus Akun?',
            html: `<p class="text-sm text-slate-600">Yakin ingin menghapus akun <strong>${nama}</strong>?<br>Tindakan ini tidak dapat dibatalkan.</p>`,
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            buttonsStyling: false,
            customClass: {
                popup: 'englify-swal',
                confirmButton: 'englify-swal-danger',
                cancelButton: 'englify-swal-cancel'
            }
        }).then((result) => {
            if (result.isConfirmed && form) {
                form.submit();
            }
        });
        return false;
    }
    if (form) form.submit();
    return false;
}

// Switch Table tabs if needed on mobile
function switchTableTab(tab) {
    const target = document.getElementById('tabel-kelola-akun');
    if (target) {
        target.scrollIntoView({ behavior: 'smooth' });
    }
}

// ESC closes modals
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeTambahModal();
        closeEditModal();
        const guide = document.getElementById('guide-modal');
        if (guide && !guide.classList.contains('hidden')) {
            guide.classList.add('hidden');
            guide.classList.remove('flex');
        }
    }
});

// Pagination & Horizontal Swipe Gesture for Dashboard Tables (Siswa & Admin)
function initTablePaging(type) {
    const tbody = document.getElementById(`tbody-${type}`);
    const container = document.getElementById(`table-container-${type}`);
    const paginationEl = document.getElementById(`pagination-${type}`);
    if (!tbody || !paginationEl) return;

    const rows = Array.from(tbody.querySelectorAll(`.row-${type}`));
    const perPage = 5;
    const totalItems = rows.length;
    const totalPages = Math.max(1, Math.ceil(totalItems / perPage));
    const displayPages = Math.max(3, totalPages);
    let currentPage = 1;

    function renderPagination() {
        paginationEl.innerHTML = '';

        // Previous button (<)
        const prevBtn = document.createElement('button');
        prevBtn.type = 'button';
        prevBtn.innerHTML = '&lt;';
        prevBtn.title = 'Halaman sebelumnya (atau geser/swipe ke kanan)';
        if (currentPage <= 1) {
            prevBtn.className = 'w-6 h-6 rounded-md flex items-center justify-center text-xs text-slate-300 cursor-not-allowed opacity-40 select-none';
            prevBtn.disabled = true;
        } else {
            prevBtn.className = 'w-6 h-6 rounded-md flex items-center justify-center text-xs text-slate-600 hover:bg-white hover:text-sky-600 transition cursor-pointer select-none';
            prevBtn.onclick = () => goToPage(currentPage - 1);
        }
        paginationEl.appendChild(prevBtn);

        // Page number buttons (1, 2, 3...)
        for (let p = 1; p <= displayPages; p++) {
            const pageBtn = document.createElement('button');
            pageBtn.type = 'button';
            pageBtn.textContent = p;

            if (p === currentPage) {
                pageBtn.className = 'w-6 h-6 rounded-md flex items-center justify-center text-xs font-bold bg-sky-600 text-white shadow-xs cursor-default select-none';
            } else if (p <= totalPages) {
                pageBtn.className = 'w-6 h-6 rounded-md flex items-center justify-center text-xs font-bold text-slate-600 hover:bg-white hover:text-sky-600 transition cursor-pointer select-none';
                pageBtn.onclick = () => goToPage(p);
            } else {
                pageBtn.className = 'w-6 h-6 rounded-md flex items-center justify-center text-xs font-bold text-slate-300 cursor-not-allowed opacity-40 select-none';
                pageBtn.disabled = true;
                pageBtn.title = `Belum ada data untuk halaman ${p}`;
            }
            paginationEl.appendChild(pageBtn);
        }

        // Next button (>)
        const nextBtn = document.createElement('button');
        nextBtn.type = 'button';
        nextBtn.innerHTML = '&gt;';
        nextBtn.title = 'Halaman berikutnya (atau geser/swipe ke kiri)';
        if (currentPage >= totalPages) {
            nextBtn.className = 'w-6 h-6 rounded-md flex items-center justify-center text-xs text-slate-300 cursor-not-allowed opacity-40 select-none';
            nextBtn.disabled = true;
        } else {
            nextBtn.className = 'w-6 h-6 rounded-md flex items-center justify-center text-xs text-slate-600 hover:bg-white hover:text-sky-600 transition cursor-pointer select-none';
            nextBtn.onclick = () => goToPage(currentPage + 1);
        }
        paginationEl.appendChild(nextBtn);
    }

    function goToPage(targetPage) {
        if (targetPage < 1 || targetPage > totalPages) return;
        if (targetPage === currentPage) return;

        currentPage = targetPage;

        // Smooth fade effect
        tbody.classList.add('opacity-0');
        setTimeout(() => {
            rows.forEach(row => {
                const rowPage = parseInt(row.getAttribute('data-page') || '1', 10);
                if (rowPage === currentPage) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
            tbody.classList.remove('opacity-0');
            renderPagination();
        }, 120);
    }

    // Initial render
    renderPagination();

    // Attach Swipe & Drag Gesture Listeners
    if (container) {
        let startX = 0;
        let startY = 0;
        let isPointerActive = false;
        let startTime = 0;

        container.addEventListener('pointerdown', (e) => {
            if (e.target.closest('button, a, form, input, select')) return;
            startX = e.clientX;
            startY = e.clientY;
            startTime = Date.now();
            isPointerActive = true;
        });

        container.addEventListener('pointerup', (e) => {
            if (!isPointerActive) return;
            isPointerActive = false;
            const diffX = e.clientX - startX;
            const diffY = e.clientY - startY;
            const elapsed = Date.now() - startTime;

            if (Math.abs(diffX) > 40 && Math.abs(diffX) > Math.abs(diffY) && elapsed < 800) {
                if (diffX < 0) {
                    // Swiped left -> next page
                    goToPage(currentPage + 1);
                } else {
                    // Swiped right -> prev page
                    goToPage(currentPage - 1);
                }
            }
        });

        container.addEventListener('pointercancel', () => {
            isPointerActive = false;
        });

        // Touch event fallback
        let touchX = 0;
        let touchY = 0;
        container.addEventListener('touchstart', (e) => {
            if (e.target.closest('button, a, form, input, select')) return;
            touchX = e.changedTouches[0].clientX;
            touchY = e.changedTouches[0].clientY;
        }, { passive: true });

        container.addEventListener('touchend', (e) => {
            const diffX = e.changedTouches[0].clientX - touchX;
            const diffY = e.changedTouches[0].clientY - touchY;
            if (Math.abs(diffX) > 40 && Math.abs(diffX) > Math.abs(diffY)) {
                if (diffX < 0) {
                    goToPage(currentPage + 1);
                } else {
                    goToPage(currentPage - 1);
                }
            }
        }, { passive: true });
    }
}

// Initialize Chart.js Growth Line Chart + auto-refresh real-time
document.addEventListener('DOMContentLoaded', function () {
    // Inisialisasi Paginasi & Swipe untuk tabel dashboard
    initTablePaging('siswa');
    initTablePaging('admin');

    const chartEl = document.getElementById('studentGrowthChart');
    if (!chartEl) return;
    const ctx = chartEl.getContext('2d');
    
    // Gradient fill under the curve
    const gradient = ctx.createLinearGradient(0, 0, 0, 180);
    gradient.addColorStop(0, 'rgba(2, 132, 199, 0.25)');
    gradient.addColorStop(1, 'rgba(2, 132, 199, 0.00)');

    const growthChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels ?? []),
            datasets: [{
                label: 'Siswa',
                data: @json($chartData ?? []),
                borderColor: '#0284C7',
                borderWidth: 2.5,
                pointBackgroundColor: '#0284C7',
                pointBorderColor: '#FFFFFF',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                tension: 0.35, // smooth curved line
                fill: true,
                backgroundColor: gradient
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0F1E36',
                    titleColor: '#FFFFFF',
                    bodyColor: '#BAE6FD',
                    padding: 10,
                    cornerRadius: 10,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Total Siswa: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#94a3b8',
                        font: { size: 10, weight: '500' }
                    }
                },
                y: {
                    min: 0,
                    max: @json($chartMax ?? 10),
                    ticks: {
                        stepSize: @json($chartStep ?? 2),
                        color: '#94a3b8',
                        font: { size: 10, weight: '500' }
                    },
                    grid: {
                        color: '#f1f5f9',
                        drawBorder: false
                    }
                }
            }
        }
    });

    // ===== REAL-TIME STATS REFRESH =====
    const statsUrl = @js(route('superadmin.dashboard.stats'));
    let statsRefreshing = false;

    function setText(id, value) {
        const el = document.getElementById(id);
        if (el) el.textContent = value;
    }

    async function refreshStats() {
        if (statsRefreshing) return; // cegah request bertumpuk
        statsRefreshing = true;
        try {
            const res = await fetch(statsUrl, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) throw new Error('HTTP ' + res.status);
            const json = await res.json();
            if (json.status !== 'success') return;
            const d = json.data;

            // Kartu utama
            setText('total-siswa-value', d.totalSiswa ?? 0);
            setText('siswa-growth-badge', d.siswaGrowth ?? '+ 0%');
            setText('total-admin-value', d.totalAdmin ?? 0);
            setText('admin-growth-badge', d.adminGrowth ?? '+ 0%');

            // Ringkasan
            setText('new-siswa-count', d.newSiswaCount ?? 0);
            setText('new-siswa-growth', d.newSiswaGrowth ?? '▲ 0%');
            setText('new-admin-count', d.newAdminCount ?? 0);
            setText('new-admin-growth', d.newAdminGrowth ?? '▲ 0%');
            setText('total-akun-value', d.totalAkun ?? 0);
            setText('total-akun-growth', d.totalAkunGrowth ?? '▲ 0%');
            setText('active-accounts-value', d.activeAccounts ?? 0);
            setText('active-growth', d.activeGrowth ?? '▲ 0%');

            // Chart 7 hari terakhir (label tanggal nyata dari server)
            growthChart.data.labels = d.chartLabels ?? [];
            growthChart.data.datasets[0].data = d.chartData ?? [];
            growthChart.options.scales.y.max = d.chartMax ?? 10;
            growthChart.options.scales.y.ticks.stepSize = d.chartStep ?? 2;
            growthChart.update('none');

            // Waktu update terakhir (real-life)
            const lastUpdate = document.getElementById('stats-last-update');
            if (lastUpdate) {
                const now = new Date();
                const pad = n => String(n).padStart(2, '0');
                lastUpdate.textContent = 'Diperbarui '
                    + now.getDate() + ' ' + ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'][now.getMonth()]
                    + ' ' + now.getFullYear() + ' '
                    + pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds());
            }
        } catch (e) {
            // diamkan error jaringan; coba lagi di interval berikutnya
        } finally {
            statsRefreshing = false;
        }
    }

    // Polling tiap 15 detik
    setInterval(refreshStats, 15000);

    // Refresh segera saat user kembali ke tab (visibilitychange)
    document.addEventListener('visibilitychange', function () {
        if (document.visibilityState === 'visible') refreshStats();
    });
});
</script>
@endpush
@endsection

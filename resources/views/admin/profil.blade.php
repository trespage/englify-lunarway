@extends('layouts.admin')

@section('title', 'Profil Admin - Englify')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                Profil Administrator
            </h1>
            <p class="text-slate-500 mt-1 ml-1">Kelola data akun dan preferensi pengajaran Anda.</p>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 h-28 sm:h-32 relative">
            <div class="absolute top-0 right-0 w-40 h-40 opacity-20 -mr-8 -mt-8">
                <svg viewBox="0 0 200 200" class="w-full h-full text-white" fill="currentColor">
                    <circle cx="100" cy="60" r="40"/>
                    <circle cx="60" cy="140" r="35"/>
                    <circle cx="140" cy="140" r="35"/>
                </svg>
            </div>
        </div>
        <div class="px-6 sm:px-8 pb-6">
            <div class="relative flex flex-col sm:flex-row items-center sm:items-end -mt-12 sm:-mt-14 mb-4 gap-4">
                <!-- Avatar -->
                <div class="relative group">
                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl bg-white p-2 shadow-lg ring-4 ring-purple-100">
                        <div class="w-full h-full rounded-xl bg-gradient-to-br from-purple-100 to-indigo-100 flex items-center justify-center p-1 overflow-hidden">
                            <img id="main-admin-avatar" src="{{ auth()->user()->avatar_url }}" alt="Avatar {{ auth()->user()->nama }}" class="w-full h-full object-contain filter drop-shadow-sm transition-transform duration-300 group-hover:scale-110">
                        </div>
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-emerald-500 rounded-full border-4 border-white flex items-center justify-center shadow-md">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>

                <!-- Name & Info -->
                <div class="text-center sm:text-left sm:flex-1 sm:mb-2">
                    <div class="flex flex-col sm:flex-row items-center gap-2">
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-800">{{ auth()->user()->nama }}</h2>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-700">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Administrator
                        </span>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center gap-1 sm:gap-3 mt-1 text-sm text-slate-500">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ auth()->user()->email }}
                        </span>
                        <span class="hidden sm:inline text-slate-300">•</span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            {{ $namaDivisi ?? 'Kurikulum Englify' }}
                        </span>
                        <span class="hidden sm:inline text-slate-300">•</span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Bergabung sejak {{ \Carbon\Carbon::parse(auth()->user()->created_at)->format('j M Y') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Pilihan Karakter Maskot Profil -->
            @php
                $currentAvatar = auth()->user()->avatar ?? 'avatar-cat-laptop.png';
                $avatars = \App\Models\User::availableAvatars();
            @endphp
            <div class="mt-6 pt-5 border-t border-slate-100">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
                    <div class="flex items-center gap-2">
                        <span class="text-base">🐱</span>
                        <h3 class="text-sm font-bold text-slate-800">Karakter Maskot Profil</h3>
                        <span class="text-xs text-slate-400">• Pilih avatar kucing favorit Anda</span>
                    </div>
                    <div id="admin-avatar-status" class="hidden items-center gap-1.5 px-2.5 py-0.5 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full border border-emerald-200">
                        <svg class="w-3 h-3 animate-spin text-emerald-600 hidden" id="admin-avatar-spinner" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                        <span id="admin-avatar-status-text">Tersimpan</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2.5 sm:gap-3">
                    @foreach($avatars as $file => $meta)
                        @php
                            $isSelected = ($currentAvatar === $file);
                        @endphp
                        <button type="button"
                                onclick="selectAdminAvatar('{{ $file }}', '{{ $meta['nama'] }}')"
                                class="admin-avatar-card relative flex flex-col items-center p-2.5 rounded-xl border-2 transition-all duration-200 text-center cursor-pointer {{ $isSelected ? 'border-purple-600 bg-purple-50/60 ring-2 ring-purple-600/20 shadow-sm' : 'border-slate-200/80 bg-white hover:border-purple-300 hover:bg-slate-50' }}"
                                data-avatar="{{ $file }}">
                            <div class="admin-avatar-check absolute top-1.5 right-1.5 w-4 h-4 rounded-full bg-purple-600 text-white flex items-center justify-center {{ $isSelected ? '' : 'hidden' }}">
                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div class="w-14 h-14 rounded-xl bg-white p-1 flex items-center justify-center mb-1.5">
                                <img src="{{ asset('images/avatars/' . $file) }}" alt="{{ $meta['nama'] }}" class="w-full h-full object-contain">
                            </div>
                            <p class="text-[11px] font-bold text-slate-800 leading-tight truncate w-full">{{ $meta['nama'] }}</p>
                            <span class="inline-block mt-0.5 text-[9px] font-semibold px-2 py-0.5 rounded-full {{ $isSelected ? 'bg-purple-600 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $meta['badge'] }}
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="flex gap-1 border-b border-slate-200 mt-6 overflow-x-auto">
                <button onclick="switchTab('informasi')" id="tab-informasi" class="tab-btn px-4 py-3 text-sm font-semibold border-b-2 border-purple-600 text-purple-600 whitespace-nowrap transition">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Informasi Akun
                    </span>
                </button>

                <button onclick="switchTab('keamanan')" id="tab-keamanan" class="tab-btn px-4 py-3 text-sm font-semibold border-b-2 border-transparent text-slate-500 hover:text-slate-700 whitespace-nowrap transition">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Keamanan
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- Tab Content: Informasi Akun -->
    <div id="content-informasi" class="tab-content space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informasi Akun (2/3) -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Informasi Akun</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Data dasar akun Anda.</p>
                    </div>
                    <button onclick="openEditModal()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-purple-50 hover:bg-purple-100 text-purple-600 text-xs font-semibold rounded-lg transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </button>
                </div>

                <div class="space-y-1">
                    <!-- Nama Lengkap -->
                    <div class="flex items-center justify-between p-4 rounded-xl hover:bg-slate-50 transition border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-purple-100 flex items-center justify-center shrink-0">
                                <svg class="w-4.5 h-4.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-medium">Nama Lengkap</p>
                                <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->nama }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-center justify-between p-4 rounded-xl hover:bg-slate-50 transition border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                                <svg class="w-4.5 h-4.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-medium">Email</p>
                                <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Cakupan Pengelolaan -->
                    <div class="flex items-center justify-between p-4 rounded-xl hover:bg-slate-50 transition border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-amber-100 flex items-center justify-center shrink-0">
                                <svg class="w-4.5 h-4.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-medium">Cakupan Pengelolaan</p>
                                <p class="text-sm font-semibold text-slate-800">
                                    @if(auth()->user()->kategori)
                                        Bab, Materi & Quiz (Divisi {{ auth()->user()->kategori->nama_kategori }})
                                    @else
                                        Bab, Materi & Quiz (Semua Kategori)
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Role -->
                    <div class="flex items-center justify-between p-4 rounded-xl hover:bg-slate-50 transition border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-purple-100 flex items-center justify-center shrink-0">
                                <svg class="w-4.5 h-4.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-medium">Role</p>
                                <p class="text-sm font-semibold text-slate-800">Administrator</p>
                            </div>
                        </div>
                    </div>

                    <!-- Terdaftar Sejak -->
                    <div class="flex items-center justify-between p-4 rounded-xl hover:bg-slate-50 transition border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                                <svg class="w-4.5 h-4.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-medium">Terdaftar Sejak</p>
                                <p class="text-sm font-semibold text-slate-800">{{ \Carbon\Carbon::parse(auth()->user()->created_at)->isoFormat('D MMMM YYYY') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status Akun -->
                    <div class="flex items-center justify-between p-4 rounded-xl hover:bg-slate-50 transition border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                                <svg class="w-4.5 h-4.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-medium">Status Akun</p>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Aktif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Kanan: Statistik Kurikulum + Jaga Keamanan -->
            <div class="space-y-4">
                <!-- Statistik Kurikulum -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Statistik Kurikulum</h3>
                    <p class="text-xs text-slate-500 mb-4">Ringkasan pengelolaan kurikulum Englify.</p>

                    <div class="flex items-center gap-3 p-3.5 rounded-xl bg-gradient-to-r from-purple-50 to-indigo-50 border border-purple-100 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-600 to-indigo-600 text-white flex items-center justify-center shrink-0 shadow-sm shadow-purple-500/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-slate-800 text-sm">{{ $namaDivisi ?? 'Platform Englify' }}</p>
                            <p class="text-xs text-slate-500 truncate" title="{{ $subDivisiText ?? '' }}">{{ $subDivisiText ?? ($totalKategori . ' Kategori') }}</p>
                        </div>
                    </div>

                    <div class="space-y-2 text-xs">
                        <div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-50">
                            <span class="text-slate-500 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span> Total Siswa Terdaftar
                            </span>
                            <span class="font-bold text-slate-800">{{ $totalSiswa }} Siswa</span>
                        </div>
                        <div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-50">
                            <span class="text-slate-500 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-purple-500"></span> Total Bab Kurikulum
                            </span>
                            <span class="font-bold text-slate-800">{{ $totalBab }} Bab</span>
                        </div>
                        <div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-50">
                            <span class="text-slate-500 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Total Materi Pelajaran
                            </span>
                            <span class="font-bold text-slate-800">{{ $totalMateri }} Materi</span>
                        </div>
                        <div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-50">
                            <span class="text-slate-500 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span> Total Soal Quiz
                            </span>
                            <span class="font-bold text-slate-800">{{ $totalQuiz }} Soal</span>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100 grid grid-cols-3 gap-2">
                        <a href="{{ route('admin.bab') }}" class="px-2 py-1.5 bg-slate-50 hover:bg-purple-50 hover:text-purple-600 text-slate-600 text-[11px] font-semibold rounded-lg text-center transition">
                            + Bab
                        </a>
                        <a href="{{ route('admin.materi') }}" class="px-2 py-1.5 bg-slate-50 hover:bg-blue-50 hover:text-blue-600 text-slate-600 text-[11px] font-semibold rounded-lg text-center transition">
                            + Materi
                        </a>
                        <a href="{{ route('admin.quiz') }}" class="px-2 py-1.5 bg-slate-50 hover:bg-amber-50 hover:text-amber-600 text-slate-600 text-[11px] font-semibold rounded-lg text-center transition">
                            + Quiz
                        </a>
                    </div>
                </div>

                <!-- Keamanan Akun -->
                <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 opacity-10 -mr-8 -mt-8">
                        <svg viewBox="0 0 200 200" class="w-full h-full text-white" fill="currentColor">
                            <circle cx="100" cy="60" r="40"/>
                            <circle cx="60" cy="140" r="35"/>
                            <circle cx="140" cy="140" r="35"/>
                        </svg>
                    </div>
                    <div class="relative">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-11 h-11 rounded-xl bg-white/20 flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold">Keamanan Akun</p>
                                <p class="text-xs text-purple-100">Informasi Akses Administrator</p>
                            </div>
                        </div>
                        <div class="p-3.5 bg-white/10 backdrop-blur rounded-xl border border-white/20 mt-3 text-xs leading-relaxed text-purple-50 font-medium">
                            Jika ingin mengubah password, silakan hubungi Super Admin.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktivitas Terakhir -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mt-6 sm:mt-8">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Aktivitas Terakhir</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Riwayat aktivitas akun Anda.</p>
                </div>
                <a href="#" class="text-xs font-bold text-purple-600 hover:text-purple-700 flex items-center gap-1">
                    Lihat Semua
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <div class="space-y-3">
                @forelse($aktivitasTerbaru as $act)
                <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition">
                    <div class="w-10 h-10 rounded-xl @if($act['tipe'] === 'Sukses') bg-emerald-100 text-emerald-600 @elseif($act['tipe'] === 'Materi') bg-blue-100 text-blue-600 @elseif($act['tipe'] === 'Reminder') bg-amber-100 text-amber-600 @else bg-purple-100 text-purple-600 @endif flex items-center justify-center shrink-0">
                        @if($act['tipe'] === 'Sukses')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                        @elseif($act['tipe'] === 'Materi')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        @elseif($act['tipe'] === 'Reminder')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800">{{ $act['judul'] }}</p>
                        <p class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($act['waktu'])->diffForHumans() }} • {{ $act['detail'] }}</p>
                    </div>
                    <span class="text-xs font-bold {{ $act['badge'] }} px-2.5 py-1 rounded-full shrink-0">{{ $act['tipe'] }}</span>
                </div>
                @empty
                <div class="text-center py-6 text-slate-400 text-xs">
                    Belum ada riwayat aktivitas terbaru.
                </div>
                @endforelse
            </div>
        </div>
    </div>



    <!-- Tab Content: Keamanan -->
    <div id="content-keamanan" class="tab-content hidden">
        <div class="max-w-2xl mx-auto space-y-4">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-slate-800">Status Keamanan Akun</h3>
                        <p class="text-sm text-slate-500 mt-1">Akun Anda saat ini dalam kondisi aman.</p>
                        <div class="mt-4 space-y-2">
                            <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-xl">
                                <span class="text-sm font-medium text-slate-700">Password terakhir diubah</span>
                                <span class="text-xs font-bold text-emerald-700">{{ auth()->user()->updated_at ? \Carbon\Carbon::parse(auth()->user()->updated_at)->diffForHumans() : '-' }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-xl">
                                <span class="text-sm font-medium text-slate-700">Login terakhir</span>
                                <span class="text-xs font-bold text-emerald-700">{{ auth()->user()->last_login_at ? \Carbon\Carbon::parse(auth()->user()->last_login_at)->diffForHumans() : 'Sesi saat ini' }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-xl">
                                <span class="text-sm font-medium text-slate-700">Perangkat aktif</span>
                                <span class="text-xs font-bold text-emerald-700">1 perangkat</span>
                            </div>
                        </div>

                        <div class="mt-4 p-3.5 bg-purple-50 border border-purple-100 rounded-xl flex items-center gap-2.5 text-xs text-purple-800 font-medium">
                            <svg class="w-4 h-4 text-purple-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Jika ingin mengubah password, silakan hubungi Super Admin.</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Sesi Aktif</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-800">Browser - {{ str_contains(request()->header('User-Agent') ?? '', 'Chrome') ? 'Chrome' : (str_contains(request()->header('User-Agent') ?? '', 'Firefox') ? 'Firefox' : 'Web Browser') }}</p>
                                <p class="text-xs text-slate-500">{{ request()->ip() }} • Saat ini</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-100 px-2.5 py-1 rounded-full">Aktif</span>
                    </div>
                </div>
                <button class="mt-4 w-full py-2.5 border border-rose-200 text-rose-600 font-semibold rounded-xl hover:bg-rose-50 transition text-sm">
                    Logout dari Semua Sesi
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Profil -->
<div id="editModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between sticky top-0 bg-white z-10 rounded-t-3xl">
            <h3 class="text-xl font-bold text-slate-800">Edit Profil</h3>
            <button onclick="closeEditModal()" class="p-2 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.profil.update') }}" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama', auth()->user()->nama) }}"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition">
                @error('nama')
                <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>
            <input type="hidden" name="username" value="{{ old('username', auth()->user()->username) }}">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition">
                @error('email')
                <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Divisi (Kategori)</label>
                <select name="id_kategori" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition cursor-pointer">
                    <option value="" {{ empty(auth()->user()->id_kategori) ? 'selected' : '' }}>Semua Divisi (Kurikulum Terpadu)</option>
                    @foreach($kategoris ?? [] as $k)
                        <option value="{{ $k->id_kategori }}" {{ (string) auth()->user()->id_kategori === (string) $k->id_kategori ? 'selected' : '' }}>
                            Divisi {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                <p class="text-[11px] text-slate-400 mt-1">Pilih divisi pembelajaran khusus Anda untuk memfilter ringkasan statistik kurikulum.</p>
            </div>
            <!-- Info Perubahan Password -->
            <div class="p-3.5 bg-purple-50 border border-purple-100 rounded-xl flex items-center gap-2.5 text-xs text-purple-800 font-medium">
                <svg class="w-4 h-4 text-purple-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Jika ingin mengubah password, silakan hubungi Super Admin.</span>
            </div>
            <div class="pt-4 flex gap-3 sticky bottom-0 bg-white pb-1">
                <button type="button" onclick="closeEditModal()" class="flex-1 px-4 py-3 border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition">Batal</button>
                <button type="submit" class="flex-1 px-4 py-3 bg-purple-600 text-white font-semibold rounded-xl hover:bg-purple-700 shadow-lg shadow-purple-600/30 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function switchTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    // Show selected tab content
    document.getElementById('content-' + tabName).classList.remove('hidden');

    // Reset all tab buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('border-purple-600', 'text-purple-600');
        btn.classList.add('border-transparent', 'text-slate-500');
    });

    // Highlight active tab button
    const activeBtn = document.getElementById('tab-' + tabName);
    activeBtn.classList.remove('border-transparent', 'text-slate-500');
    activeBtn.classList.add('border-purple-600', 'text-purple-600');
}

function openEditModal() {
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
}

function selectAdminAvatar(filename, name) {
    const cards = document.querySelectorAll('.admin-avatar-card');
    cards.forEach(card => {
        const isTarget = card.getAttribute('data-avatar') === filename;
        const check = card.querySelector('.admin-avatar-check');
        const badge = card.querySelector('span');

        if (isTarget) {
            card.classList.remove('border-slate-200/80', 'bg-white', 'hover:border-purple-300', 'hover:bg-slate-50');
            card.classList.add('border-purple-600', 'bg-purple-50/60', 'ring-2', 'ring-purple-600/20', 'shadow-sm');
            if (check) check.classList.remove('hidden');
            if (badge) {
                badge.className = 'inline-block mt-0.5 text-[9px] font-semibold px-2 py-0.5 rounded-full bg-purple-600 text-white';
            }
        } else {
            card.classList.remove('border-purple-600', 'bg-purple-50/60', 'ring-2', 'ring-purple-600/20', 'shadow-sm');
            card.classList.add('border-slate-200/80', 'bg-white', 'hover:border-purple-300', 'hover:bg-slate-50');
            if (check) check.classList.add('hidden');
            if (badge) {
                badge.className = 'inline-block mt-0.5 text-[9px] font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600';
            }
        }
    });

    const newUrl = "{{ asset('images/avatars') }}/" + filename;
    const mainImg = document.getElementById('main-admin-avatar');
    if (mainImg) {
        mainImg.style.transform = 'scale(0.85)';
        setTimeout(() => {
            mainImg.src = newUrl;
            mainImg.style.transform = 'scale(1)';
        }, 120);
    }

    document.querySelectorAll('.header-user-avatar').forEach(img => {
        img.src = newUrl;
    });

    const statusBox = document.getElementById('admin-avatar-status');
    const spinner = document.getElementById('admin-avatar-spinner');
    const statusText = document.getElementById('admin-avatar-status-text');

    if (statusBox) {
        statusBox.classList.remove('hidden');
        statusBox.classList.add('flex');
        if (spinner) spinner.classList.remove('hidden');
        if (statusText) statusText.textContent = 'Menyimpan...';
    }

    fetch("{{ route('admin.profil.avatar') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ avatar: filename })
    })
    .then(res => res.json())
    .then(data => {
        if (spinner) spinner.classList.add('hidden');
        if (statusText) statusText.textContent = 'Tersimpan! ✨';
        setTimeout(() => {
            if (statusBox) {
                statusBox.classList.add('hidden');
                statusBox.classList.remove('flex');
            }
        }, 2200);
    })
    .catch(err => {
        if (spinner) spinner.classList.add('hidden');
        if (statusText) statusText.textContent = 'Gagal';
    });
}

@if($errors->any())
openEditModal();
@endif
</script>
@endpush

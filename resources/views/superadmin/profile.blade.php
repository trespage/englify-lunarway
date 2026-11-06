@extends('layouts.superadmin')

@section('title', 'Profil Super Admin')

@section('content')
<div class="space-y-6">

    {{-- ============================================================ --}}
    {{-- PAGE HEADER                                                  --}}
    {{-- ============================================================ --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-2xl bg-sky-100 flex items-center justify-center shrink-0 shadow-xs border border-sky-200/50">
                <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-800 leading-tight">Profil Super Admin</h1>
                <p class="text-sm text-slate-500 mt-0.5">Kelola informasi dan keamanan data Anda.</p>
                <div class="flex items-center gap-1.5 mt-1.5 text-[11px] font-bold text-emerald-600">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Data langsung dari server <span id="profile-sync" class="text-slate-400 font-semibold"></span>
                </div>
            </div>
        </div>
        {{-- Decorative illustration (top right) --}}
        <div class="hidden lg:flex items-center justify-end shrink-0">
            <img src="{{ asset('images/cat-mascot-clean.png') }}" alt="Englify Cat" class="h-16 w-auto object-contain drop-shadow-sm transform hover:scale-105 transition-transform duration-200">
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- PROFILE IDENTITY CARD                                        --}}
    {{-- ============================================================ --}}
    <div class="bg-white rounded-2xl shadow-card border border-slate-200/70 p-5 sm:p-6">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">

            {{-- Avatar --}}
            <div class="relative shrink-0 group">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-white border-4 border-white shadow-lg flex items-center justify-center overflow-hidden ring-4 ring-sky-100 p-1">
                    <img id="main-superadmin-avatar" src="{{ auth()->user()->avatar_url }}" alt="Avatar {{ auth()->user()->nama }}" class="w-full h-full object-contain filter drop-shadow-sm transition-transform duration-300 group-hover:scale-110">
                </div>
                {{-- Online indicator --}}
                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 rounded-full border-2 border-white shadow-sm flex items-center justify-center">
                    <div class="w-2 h-2 rounded-full bg-white"></div>
                </div>
            </div>

            {{-- Identity Info --}}
            <div class="flex-1 min-w-0 text-center sm:text-left">
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mb-1">
                    <h2 data-profile="nama" class="text-lg font-extrabold text-slate-800 break-words">{{ auth()->user()->nama ?? auth()->user()->name }}</h2>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-sky-100 text-sky-700 border border-sky-200">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Super Admin
                    </span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1.5 mt-2">
                    <div class="flex items-center justify-center sm:justify-start gap-2 text-sm text-slate-500 min-w-0">
                        <svg class="w-4 h-4 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span data-profile="email" class="truncate">{{ auth()->user()->email }}</span>
                    </div>
                    <div class="flex items-center justify-center sm:justify-start gap-2 text-sm text-slate-500 min-w-0">
                        <svg class="w-4 h-4 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span data-profile="role">{{ auth()->user()->role?->nama_role ?? 'Super Admin' }}</span>
                    </div>
                    <div class="flex items-center justify-center sm:justify-start gap-2 text-sm text-slate-500 min-w-0 sm:col-span-2">
                        <svg class="w-4 h-4 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Bergabung sejak <span data-profile="joined">{{ \Carbon\Carbon::parse(auth()->user()->created_at)->translatedFormat('d F Y') }}</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- PILIHAN KARAKTER MASKOT AVATAR SUPER ADMIN                   --}}
    {{-- ============================================================ --}}
    @php
        $currentAvatar = auth()->user()->avatar ?? 'avatar-cat-laptop.png';
        $avatars = \App\Models\User::availableAvatars();
    @endphp
    <div class="bg-white rounded-2xl shadow-card border border-slate-200/70 p-5 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-sky-100 flex items-center justify-center shrink-0">
                    <span class="text-xl">🐱</span>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-800 text-base sm:text-lg">Karakter Maskot Profil</h3>
                    <p class="text-xs text-slate-500">Pilih salah satu karakter kucing lucu Englify untuk profil Super Admin!</p>
                </div>
            </div>
            <div id="superadmin-avatar-status" class="hidden items-center gap-2 px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full border border-emerald-200">
                <svg class="w-3.5 h-3.5 animate-spin text-emerald-600 hidden" id="superadmin-avatar-spinner" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                <span id="superadmin-avatar-status-text">Tersimpan</span>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
            @foreach($avatars as $file => $meta)
                @php
                    $isSelected = ($currentAvatar === $file);
                @endphp
                <button type="button"
                        onclick="selectSuperAdminAvatar('{{ $file }}', '{{ $meta['nama'] }}')"
                        class="superadmin-avatar-card relative flex flex-col items-center p-3 rounded-2xl border-2 transition-all duration-200 group text-center cursor-pointer {{ $isSelected ? 'border-sky-500 bg-sky-50/60 ring-2 ring-sky-500/20 shadow-md' : 'border-slate-200/80 bg-white hover:border-sky-300 hover:bg-slate-50/80' }}"
                        data-avatar="{{ $file }}">
                    
                    <div class="superadmin-avatar-check absolute top-2 right-2 w-5 h-5 rounded-full bg-sky-600 text-white flex items-center justify-center {{ $isSelected ? '' : 'hidden' }}">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>

                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white p-1 flex items-center justify-center mb-2 shadow-2xs group-hover:scale-105 transition-transform duration-200">
                        <img src="{{ asset('images/avatars/' . $file) }}" alt="{{ $meta['nama'] }}" class="w-full h-full object-contain filter drop-shadow-sm">
                    </div>

                    <p class="text-xs font-extrabold text-slate-800 leading-tight truncate w-full">{{ $meta['nama'] }}</p>
                    <span class="inline-block mt-1 text-[10px] font-bold px-2 py-0.5 rounded-full {{ $isSelected ? 'bg-sky-600 text-white' : 'bg-slate-100 text-slate-600 group-hover:bg-sky-100 group-hover:text-sky-700' }} transition-colors">
                        {{ $meta['badge'] }}
                    </span>
                </button>
            @endforeach
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- TAB NAVIGATION                                               --}}
    {{-- ============================================================ --}}
    <div class="flex items-center gap-1 bg-white border border-slate-200/80 rounded-2xl p-1.5 shadow-card w-full sm:w-auto">
        <button id="tab-btn-info" onclick="switchTab('info')"
                class="tab-btn flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold transition-all flex-1 sm:flex-none justify-center active-tab">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span class="hidden sm:inline">Informasi Akun</span>
            <span class="sm:hidden">Akun</span>
        </button>
        <button id="tab-btn-password" onclick="switchTab('password')"
                class="tab-btn flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold transition-all flex-1 sm:flex-none justify-center text-slate-500 hover:text-slate-700 hover:bg-slate-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <span class="hidden sm:inline">Ubah Password</span>
            <span class="sm:hidden">Password</span>
        </button>
        <button id="tab-btn-security" onclick="switchTab('security')"
                class="tab-btn flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold transition-all flex-1 sm:flex-none justify-center text-slate-500 hover:text-slate-700 hover:bg-slate-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            <span>Keamanan</span>
        </button>
    </div>

    {{-- ============================================================ --}}
    {{-- TAB: INFORMASI AKUN                                          --}}
    {{-- ============================================================ --}}
    <div id="tab-info" class="tab-content">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- LEFT: Informasi Akun Card --}}
            <div class="lg:col-span-2 space-y-5">
                {{-- Section 1: Data Dasar --}}
                <div class="bg-white rounded-2xl shadow-card border border-slate-200/80 p-5 sm:p-6">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h3 class="text-base font-extrabold text-slate-800 flex items-center gap-2">
                                <span class="w-1.5 h-5 bg-blue-500 rounded-full inline-block"></span>
                                Informasi Akun
                            </h3>
                            <p class="text-xs text-slate-400 mt-0.5 ml-3.5">Data dasar akun Anda</p>
                        </div>
                        <button onclick="openEditModal()"
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-bold rounded-xl transition border border-blue-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </button>
                    </div>

                    <div class="divide-y divide-slate-100">
                        {{-- Nama Lengkap --}}
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 py-3.5">
                            <div class="flex items-center gap-4">
                                <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                                    <svg class="text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-slate-400 sm:w-32 shrink-0">Nama Lengkap</span>
                            </div>
                            <span data-profile="nama" class="text-sm font-bold text-slate-800 ml-[3.25rem] sm:ml-0 break-words">{{ auth()->user()->nama ?? auth()->user()->name }}</span>
                        </div>

                        {{-- Email --}}
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 py-3.5">
                            <div class="flex items-center gap-4">
                                <div class="w-9 h-9 rounded-xl bg-sky-50 flex items-center justify-center shrink-0">
                                    <svg class="text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-slate-400 sm:w-32 shrink-0">Email</span>
                            </div>
                            <span data-profile="email" class="text-sm font-bold text-slate-800 ml-[3.25rem] sm:ml-0 break-all">{{ auth()->user()->email }}</span>
                        </div>

                        {{-- Role --}}
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 py-3.5">
                            <div class="flex items-center gap-4">
                                <div class="w-9 h-9 rounded-xl bg-violet-50 flex items-center justify-center shrink-0">
                                    <svg class="text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-slate-400 sm:w-32 shrink-0">Role</span>
                            </div>
                            <span data-profile="role" class="text-sm font-bold text-slate-800 ml-[3.25rem] sm:ml-0">{{ auth()->user()->role?->nama_role ?? 'Super Admin' }}</span>
                        </div>

                        {{-- Status Akun --}}
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 py-3.5">
                            <div class="flex items-center gap-4">
                                <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                                    <svg class="text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-slate-400 sm:w-32 shrink-0">Status Akun</span>
                            </div>
                            @php $statusAktif = (auth()->user()->status ?: 'aktif') === 'aktif'; @endphp
                            <span data-profile="status"
                                  class="inline-flex items-center gap-1.5 w-fit px-2.5 py-1 rounded-full text-xs font-bold border ml-[3.25rem] sm:ml-0 {{ $statusAktif ? 'bg-emerald-100 text-emerald-700 border-emerald-200' : 'bg-rose-100 text-rose-700 border-rose-200' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $statusAktif ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500' }}"></span>
                                {{ $statusAktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Section 2: Informasi Tambahan --}}
                <div class="bg-white rounded-2xl shadow-card border border-slate-200/80 p-5 sm:p-6">
                    <div class="mb-5">
                        <h3 class="text-base font-extrabold text-slate-800 flex items-center gap-2">
                            <span class="w-1.5 h-5 bg-indigo-500 rounded-full inline-block"></span>
                            Informasi Tambahan
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5 ml-3.5">Informasi yang terkait dengan akun Anda.</p>
                    </div>

                    <div class="divide-y divide-slate-100">
                        {{-- Tanggal Terdaftar --}}
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 py-3.5">
                            <div class="flex items-center gap-4">
                                <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center shrink-0">
                                    <svg class="text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-slate-400 sm:w-32 shrink-0">Tanggal Terdaftar</span>
                            </div>
                            <span data-profile="registered" class="text-sm font-bold text-slate-800 ml-[3.25rem] sm:ml-0">
                                {{ \Carbon\Carbon::parse(auth()->user()->created_at)->translatedFormat('d F Y') }}
                            </span>
                        </div>

                        {{-- Terakhir Login --}}
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 py-3.5">
                            <div class="flex items-center gap-4">
                                <div class="w-9 h-9 rounded-xl bg-sky-50 flex items-center justify-center shrink-0">
                                    <svg class="text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-slate-400 sm:w-32 shrink-0">Terakhir Login</span>
                            </div>
                            <span data-profile="lastLogin" class="text-sm font-bold text-slate-800 ml-[3.25rem] sm:ml-0">
                                {{ auth()->user()->last_login_at ? \Carbon\Carbon::parse(auth()->user()->last_login_at)->translatedFormat('d F Y, H:i') : '-' }}
                            </span>
                        </div>

                        {{-- Alamat IP --}}
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 py-3.5">
                            <div class="flex items-center gap-4">
                                <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center shrink-0">
                                    <svg class="text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-slate-400 sm:w-32 shrink-0">Alamat IP</span>
                            </div>
                            <span data-profile="ip" class="text-sm font-bold text-slate-800 font-mono ml-[3.25rem] sm:ml-0">
                                {{ request()->ip() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Security Card --}}
            <div class="space-y-5">
                {{-- Account Secure Card --}}
                <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-700 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
                    {{-- Background decoration --}}
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute -top-6 -right-6 w-32 h-32 rounded-full bg-white"></div>
                        <div class="absolute -bottom-8 -left-4 w-24 h-24 rounded-full bg-white"></div>
                    </div>

                    <div class="relative">
                        <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-4 mx-auto">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h4 class="text-base font-extrabold text-white text-center mb-1">Akun Anda aman</h4>
                        <p class="text-xs text-blue-100 text-center leading-relaxed">
                            Gunakan password yang kuat dan unik untuk melindungi keamanan akun Anda.
                        </p>
                        <div class="mt-4 flex items-center gap-2 bg-white/15 rounded-xl px-3 py-2">
                            <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse shrink-0"></div>
                            <span class="text-xs font-semibold text-white">Keamanan: Terlindungi</span>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions Card --}}
                <div class="bg-white rounded-2xl shadow-card border border-slate-200/80 p-5">
                    <h4 class="text-sm font-extrabold text-slate-700 mb-3">Tindakan Cepat</h4>
                    <div class="space-y-2">
                        <button onclick="switchTab('password')"
                                class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition border border-slate-100 hover:border-blue-200 text-left">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                            </div>
                            Ubah Password
                        </button>
                        <button onclick="openEditModal()"
                                class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 transition border border-slate-100 hover:border-emerald-200 text-left">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            Edit Profil
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- TAB: UBAH PASSWORD                                           --}}
    {{-- ============================================================ --}}
    <div id="tab-password" class="tab-content hidden">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-card border border-slate-200/80 p-5 sm:p-6">
                    <div class="mb-6">
                        <h3 class="text-base font-extrabold text-slate-800 flex items-center gap-2">
                            <span class="w-1.5 h-5 bg-blue-500 rounded-full inline-block"></span>
                            Ubah Password
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5 ml-3.5">Pastikan password baru Anda kuat dan mudah diingat.</p>
                    </div>

                    <form method="POST" action="{{ route('update.password') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1.5">Password Lama <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <input type="password" name="current_password" id="current_password" placeholder="Masukkan password lama" required
                                       class="w-full pl-11 pr-11 py-3 bg-slate-50 border @error('current_password') border-rose-500 @else border-slate-200 @enderror rounded-xl text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition">
                                <svg class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <button type="button" onclick="togglePwd('current_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                    <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('current_password')
                            <p class="text-xs text-rose-600 font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1.5">Password Baru <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <input type="password" name="new_password" id="new_password" placeholder="Min. 6 karakter" required minlength="6"
                                       class="w-full pl-11 pr-11 py-3 bg-slate-50 border @error('new_password') border-rose-500 @else border-slate-200 @enderror rounded-xl text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition">
                                <svg class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                                <button type="button" onclick="togglePwd('new_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                    <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('new_password')
                            <p class="text-xs text-rose-600 font-semibold mt-1">{{ $message }}</p>
                            @enderror
                            {{-- Password Strength --}}
                            <div class="mt-2 flex gap-1" id="strength-bars">
                                <div class="h-1 flex-1 rounded-full bg-slate-200 strength-bar"></div>
                                <div class="h-1 flex-1 rounded-full bg-slate-200 strength-bar"></div>
                                <div class="h-1 flex-1 rounded-full bg-slate-200 strength-bar"></div>
                                <div class="h-1 flex-1 rounded-full bg-slate-200 strength-bar"></div>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-1" id="strength-label">Masukkan password untuk melihat kekuatan</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1.5">Konfirmasi Password Baru <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <input type="password" name="new_password_confirmation" id="confirm_password" placeholder="Ulangi password baru" required minlength="6"
                                       class="w-full pl-11 pr-11 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition">
                                <svg class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <button type="button" onclick="togglePwd('confirm_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                    <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="pt-2 flex gap-3">
                            <button type="submit"
                                    class="flex-1 sm:flex-none px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition shadow-lg shadow-blue-600/25">
                                Simpan Password
                            </button>
                            <button type="reset"
                                    class="flex-1 sm:flex-none px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold rounded-xl transition">
                                Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="space-y-5">
                {{-- Tips Card --}}
                <div class="bg-white rounded-2xl shadow-card border border-slate-200/80 p-5">
                    <h4 class="text-sm font-extrabold text-slate-700 mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 text-xs">💡</span>
                        Tips Password Aman
                    </h4>
                    <ul class="space-y-2 text-xs text-slate-500">
                        <li class="flex items-start gap-2"><span class="text-emerald-500 font-bold mt-0.5">✓</span> Minimal 8 karakter</li>
                        <li class="flex items-start gap-2"><span class="text-emerald-500 font-bold mt-0.5">✓</span> Kombinasi huruf besar & kecil</li>
                        <li class="flex items-start gap-2"><span class="text-emerald-500 font-bold mt-0.5">✓</span> Mengandung angka</li>
                        <li class="flex items-start gap-2"><span class="text-emerald-500 font-bold mt-0.5">✓</span> Mengandung simbol (!@#$%)</li>
                        <li class="flex items-start gap-2"><span class="text-rose-500 font-bold mt-0.5">✕</span> Jangan gunakan data pribadi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- TAB: KEAMANAN                                                --}}
    {{-- ============================================================ --}}
    <div id="tab-security" class="tab-content hidden">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <div class="lg:col-span-2 space-y-5">

                {{-- Status Keamanan --}}
                <div class="bg-white rounded-2xl shadow-card border border-slate-200/80 p-5 sm:p-6">
                    <div class="mb-5">
                        <h3 class="text-base font-extrabold text-slate-800 flex items-center gap-2">
                            <span class="w-1.5 h-5 bg-emerald-500 rounded-full inline-block"></span>
                            Status Keamanan Akun
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5 ml-3.5">Pantau dan tingkatkan keamanan akun Anda.</p>
                    </div>

                    <div class="space-y-3">
                        {{-- Enkripsi Password --}}
                        <div class="flex items-center gap-4 p-4 rounded-xl bg-emerald-50 border border-emerald-100">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-slate-800">Enkripsi Password</p>
                                <p class="text-xs text-slate-500 mt-0.5">Password tersimpan dengan enkripsi bcrypt</p>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-200 text-emerald-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                Aktif
                            </span>
                        </div>

                        {{-- Session Aktif --}}
                        <div class="flex items-center gap-4 p-4 rounded-xl bg-blue-50 border border-blue-100">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2h-2"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-slate-800">Sesi Login Aktif</p>
                                <p class="text-xs text-slate-500 mt-0.5">1 sesi aktif dari {{ request()->ip() }}</p>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-200 text-blue-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                                Online
                            </span>
                        </div>

                        {{-- Autentikasi Standar --}}
                        <div class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100">
                            <div class="w-10 h-10 rounded-xl bg-slate-200 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-slate-800">Autentikasi Dua Faktor (2FA)</p>
                                <p class="text-xs text-slate-500 mt-0.5">Tingkatkan keamanan dengan 2FA</p>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-slate-200 text-slate-600">
                                Tidak Aktif
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Login History --}}
                <div class="bg-white rounded-2xl shadow-card border border-slate-200/80 p-5 sm:p-6">
                    <div class="mb-5">
                        <h3 class="text-base font-extrabold text-slate-800 flex items-center gap-2">
                            <span class="w-1.5 h-5 bg-violet-500 rounded-full inline-block"></span>
                            Riwayat Aktivitas
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5 ml-3.5">Aktivitas login terakhir di akun Anda.</p>
                    </div>
                    <div class="space-y-3">
                        @php
                            $lastLoginAt = auth()->user()->last_login_at ? \Carbon\Carbon::parse(auth()->user()->last_login_at) : null;
                            $browser = str_contains(request()->header('User-Agent') ?? '', 'Chrome') ? 'Chrome' : (str_contains(request()->header('User-Agent') ?? '', 'Firefox') ? 'Firefox' : 'Browser');
                            $activities = [
                                ['color' => 'bg-blue-500', 'label' => 'Sesi aktif', 'sub' => 'Browser - ' . $browser, 'time' => \Carbon\Carbon::now()->format('d M Y, H:i')],
                            ];
                            if ($lastLoginAt) {
                                array_unshift($activities, ['color' => 'bg-emerald-500', 'label' => 'Login berhasil', 'sub' => request()->ip(), 'time' => $lastLoginAt->format('d M Y, H:i')]);
                            }
                        @endphp
                        @forelse($activities as $act)
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full {{ $act['color'] }} mt-1.5 shrink-0"></div>
                            <div class="flex-1 pb-3 border-b border-slate-100 last:border-0 last:pb-0">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="text-sm font-semibold text-slate-800">{{ $act['label'] }}</p>
                                    <span class="text-[11px] text-slate-400 shrink-0">{{ $act['time'] }}</span>
                                </div>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $act['sub'] }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-xs text-slate-400">Belum ada aktivitas login tercatat.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Right: Security Score --}}
            @php
                $securityScore = 70;
                if (auth()->user()->last_login_at) $securityScore += 15;
                if (!auth()->user()->must_change_password) $securityScore += 15;
            @endphp
            <div>
                <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-700 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute -top-6 -right-6 w-32 h-32 rounded-full bg-white"></div>
                        <div class="absolute -bottom-8 -left-4 w-24 h-24 rounded-full bg-white"></div>
                    </div>
                    <div class="relative text-center">
                        <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-3 mx-auto">
                            <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div class="text-3xl font-extrabold text-white mb-1">{{ $securityScore }}%</div>
                        <p class="text-sm font-bold text-blue-100 mb-3">Skor Keamanan</p>
                        <div class="bg-white/20 rounded-full h-2 mb-4">
                            <div class="bg-emerald-400 h-2 rounded-full" style="width: {{ $securityScore }}%"></div>
                        </div>
                        <p class="text-xs text-blue-100 leading-relaxed">Aktifkan 2FA untuk meningkatkan keamanan akun Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ============================================================ --}}
{{-- MODAL: EDIT PROFILE                                          --}}
{{-- ============================================================ --}}
<div id="editModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
        <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-800">Edit Profil</h3>
                    <p class="text-xs text-slate-400">Perbarui informasi akun Anda</p>
                </div>
            </div>
            <button onclick="closeEditModal()" class="p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="editProfileForm" class="p-5 sm:p-6 space-y-4" method="POST" action="{{ route('superadmin.profile.update') }}">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1.5">Nama Lengkap</label>
                <input type="text" name="nama" id="edit-nama" value="{{ auth()->user()->nama ?? auth()->user()->name }}"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition">
                <p class="text-[11px] text-rose-500 font-semibold mt-1 hidden" data-error="nama"></p>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1.5">Email</label>
                <input type="email" name="email" id="edit-email" value="{{ auth()->user()->email }}"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition">
                <p class="text-[11px] text-rose-500 font-semibold mt-1 hidden" data-error="email"></p>
            </div>
            <div class="pt-2 flex gap-3">
                <button type="button" onclick="closeEditModal()"
                        class="flex-1 px-4 py-3 border border-slate-200 text-slate-700 text-sm font-bold rounded-xl hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="submit" id="editProfileSubmit"
                        class="flex-1 px-4 py-3 bg-sky-600 text-white text-sm font-bold rounded-xl hover:bg-sky-700 shadow-lg shadow-sky-600/25 transition disabled:opacity-60">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<style>
    .tab-btn.active-tab {
        background-color: #0284c7;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(2, 132, 199, 0.30);
    }
    .tab-btn:not(.active-tab):hover {
        background-color: #f1f5f9;
    }
</style>
<script>
// ---- TAB SWITCHING ----
function switchTab(tab) {
    // Hide all
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active-tab', 'text-white');
        btn.classList.add('text-slate-500');
    });

    // Show selected
    document.getElementById('tab-' + tab).classList.remove('hidden');
    const activeBtn = document.getElementById('tab-btn-' + tab);
    activeBtn.classList.add('active-tab', 'text-white');
    activeBtn.classList.remove('text-slate-500');
}

// ---- MODAL ----
function openEditModal() {
    const m = document.getElementById('editModal');
    m.classList.remove('hidden');
    m.classList.add('flex');
    showFieldErrors({});
}
function closeEditModal() {
    const m = document.getElementById('editModal');
    m.classList.add('hidden');
    m.classList.remove('flex');
}
// Close on backdrop click
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});

// ---- REAL-TIME PROFILE (sambungan backend) ----
const profileDataUrl = @js(route('superadmin.profile.data'));
let profileRefreshing = false;

function setProfileText(key, value) {
    document.querySelectorAll('[data-profile="' + key + '"]').forEach(el => {
        el.textContent = (value === null || value === undefined || value === '') ? '-' : value;
    });
}

function showFieldErrors(errors) {
    document.querySelectorAll('[data-error]').forEach(el => {
        const msg = (errors || {})[el.dataset.error];
        el.textContent = msg || '';
        el.classList.toggle('hidden', !msg);
    });
}

function applyProfileData(d) {
    if (!d) return;

    setProfileText('nama', d.nama);
    setProfileText('email', d.email);
    setProfileText('role', d.role);
    setProfileText('registered', d.registered);
    setProfileText('joined', d.joined);
    setProfileText('lastLogin', d.lastLogin);
    setProfileText('ip', d.ip);

    // Badge status akun
    const aktif = (d.status || 'aktif').toLowerCase() === 'aktif';
    document.querySelectorAll('[data-profile="status"]').forEach(el => {
        el.className = 'inline-flex items-center gap-1.5 w-fit px-2.5 py-1 rounded-full text-xs font-bold border ml-[3.25rem] sm:ml-0 '
            + (aktif ? 'bg-emerald-100 text-emerald-700 border-emerald-200' : 'bg-rose-100 text-rose-700 border-rose-200');
        el.innerHTML = '<span class="w-1.5 h-1.5 rounded-full ' + (aktif ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500') + '"></span>'
            + (aktif ? 'Aktif' : 'Nonaktif');
    });

    // Nama & email di dropdown header layout
    const layoutEmail = document.getElementById('layout-user-email');
    if (layoutEmail) layoutEmail.textContent = d.email ?? '-';
    ['layout-user-name', 'layout-user-name-dd'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.textContent = d.nama ?? '-';
    });

    // Isi ulang input modal hanya saat modal tertutup (jangan timpa yang sedang diketik)
    const modal = document.getElementById('editModal');
    if (modal && modal.classList.contains('hidden')) {
        const namaInput = document.getElementById('edit-nama');
        const emailInput = document.getElementById('edit-email');
        if (namaInput) namaInput.value = d.nama ?? '';
        if (emailInput) emailInput.value = d.email ?? '';
    }

    const sync = document.getElementById('profile-sync');
    if (sync) {
        const now = new Date();
        const pad = n => String(n).padStart(2, '0');
        sync.textContent = '(diperbarui ' + pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds()) + ')';
    }
}

async function refreshProfile() {
    if (profileRefreshing) return; // cegah request bertumpuk
    profileRefreshing = true;
    try {
        const res = await fetch(profileDataUrl, { headers: { 'Accept': 'application/json' } });
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const json = await res.json();
        if (json.status !== 'success') return;
        applyProfileData(json.data);
    } catch (e) {
        // diamkan error jaringan; coba lagi di interval berikutnya
    } finally {
        profileRefreshing = false;
    }
}

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = 'fixed top-4 right-4 z-[60] max-w-xs w-fit px-4 py-3 rounded-2xl shadow-lg text-sm font-bold text-white flex items-center gap-2 transition '
        + (type === 'success' ? 'bg-emerald-600' : 'bg-rose-600');
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 4000);
}

// ---- SIMPAN PROFIL (AJAX ke backend) ----
const editProfileForm = document.getElementById('editProfileForm');
if (editProfileForm) {
    editProfileForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        showFieldErrors({});

        const btn = document.getElementById('editProfileSubmit');
        btn.disabled = true;
        btn.textContent = 'Menyimpan...';

        try {
            const res = await fetch(this.action, {
                method: 'POST', // method PUT dikirim lewat input _method (FormData)
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: new FormData(this),
            });
            const json = await res.json().catch(() => null);

            if (res.status === 422 && json && json.errors) {
                showFieldErrors(json.errors);
                return;
            }
            if (!res.ok || !json || json.status !== 'success') {
                showToast((json && json.message) || 'Gagal memperbarui profil.', 'error');
                return;
            }

            applyProfileData(json.data);
            closeEditModal();
            showToast(json.message || 'Profil berhasil diperbarui.');
        } catch (err) {
            showToast('Gagal terhubung ke server.', 'error');
        } finally {
            btn.disabled = false;
            btn.textContent = 'Simpan Perubahan';
        }
    });
}

// Muat data profil saat halaman dibuka, lalu polling tiap 15 detik + refresh saat tab aktif kembali
refreshProfile();
setInterval(refreshProfile, 15000);
document.addEventListener('visibilitychange', function () {
    if (document.visibilityState === 'visible') refreshProfile();
});

// ---- PASSWORD TOGGLE ----
function togglePwd(inputId, btn) {
    const input = document.getElementById(inputId);
    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';
    const icon = btn.querySelector('.eye-icon');
    if (isPassword) {
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
    } else {
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
}

// ---- PASSWORD STRENGTH METER ----
document.addEventListener('DOMContentLoaded', function() {
    const newPwd = document.getElementById('new_password');
    if (!newPwd) return;
    newPwd.addEventListener('input', function() {
        const val = this.value;
        const bars = document.querySelectorAll('.strength-bar');
        const label = document.getElementById('strength-label');

        let score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const colors = ['bg-rose-400', 'bg-amber-400', 'bg-yellow-400', 'bg-emerald-500'];
        const labels = ['Sangat Lemah', 'Lemah', 'Sedang', 'Kuat'];

        bars.forEach((bar, i) => {
            bar.className = 'h-1 flex-1 rounded-full ';
            if (i < score && val.length > 0) {
                bar.className += colors[score - 1];
            } else {
                bar.className += 'bg-slate-200';
            }
        });

        label.textContent = val.length > 0 ? 'Kekuatan: ' + (labels[score - 1] || 'Sangat Lemah') : 'Masukkan password untuk melihat kekuatan';
        label.className = 'text-[11px] mt-1 ' + (score >= 3 ? 'text-emerald-600 font-semibold' : score === 2 ? 'text-amber-600' : 'text-rose-500');
    });

    @if($errors->has('current_password') || $errors->has('new_password') || $errors->has('new_password_confirmation'))
    switchTab('password');
    @endif

    @if(session('success'))
    showToast("{{ session('success') }}", 'success');
    @endif
});

function selectSuperAdminAvatar(filename, name) {
    const cards = document.querySelectorAll('.superadmin-avatar-card');
    cards.forEach(card => {
        const isTarget = card.getAttribute('data-avatar') === filename;
        const check = card.querySelector('.superadmin-avatar-check');
        const badge = card.querySelector('span');

        if (isTarget) {
            card.classList.remove('border-slate-200/80', 'bg-white', 'hover:border-sky-300', 'hover:bg-slate-50/80');
            card.classList.add('border-sky-500', 'bg-sky-50/60', 'ring-2', 'ring-sky-500/20', 'shadow-md');
            if (check) check.classList.remove('hidden');
            if (badge) {
                badge.className = 'inline-block mt-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-sky-600 text-white transition-colors';
            }
        } else {
            card.classList.remove('border-sky-500', 'bg-sky-50/60', 'ring-2', 'ring-sky-500/20', 'shadow-md');
            card.classList.add('border-slate-200/80', 'bg-white', 'hover:border-sky-300', 'hover:bg-slate-50/80');
            if (check) check.classList.add('hidden');
            if (badge) {
                badge.className = 'inline-block mt-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 group-hover:bg-sky-100 group-hover:text-sky-700 transition-colors';
            }
        }
    });

    const newUrl = "{{ asset('images/avatars') }}/" + filename;
    const mainImg = document.getElementById('main-superadmin-avatar');
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

    const statusBox = document.getElementById('superadmin-avatar-status');
    const spinner = document.getElementById('superadmin-avatar-spinner');
    const statusText = document.getElementById('superadmin-avatar-status-text');

    if (statusBox) {
        statusBox.classList.remove('hidden');
        statusBox.classList.add('flex');
        if (spinner) spinner.classList.remove('hidden');
        if (statusText) statusText.textContent = 'Menyimpan...';
    }

    fetch("{{ route('superadmin.profile.avatar') }}", {
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
</script>
@endpush

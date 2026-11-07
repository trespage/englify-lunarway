@extends('layouts.siswa')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- ===================================================== -->
    <!-- HEADER                                                  -->
    <!-- ===================================================== -->
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-[#D6EBEE] flex items-center justify-center shrink-0">
            <svg class="w-6 h-6 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>
        <div class="flex-1">
            <h1 class="text-2xl font-extrabold text-[#001B48] leading-tight">Profil Saya</h1>
            <p class="text-slate-500 text-sm mt-0.5">Kelola keamanan akunmu.</p>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- FLASH MESSAGE                                           -->
    <!-- ===================================================== -->
    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold rounded-xl flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold rounded-xl">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- ===================================================== -->
    <!-- PROFILE INFO CARD (COMPACT)                             -->
    <!-- ===================================================== -->
    <div class="bg-gradient-to-br from-[#001B48] via-[#02457A] to-[#018ABE] rounded-2xl p-4 sm:p-6 text-white relative overflow-hidden shadow-lg shadow-[#001B48]/30">
        <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -mr-10 -mt-10"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full -ml-10 -mb-10"></div>

        <div class="relative z-10 flex flex-col sm:flex-row items-center gap-4 sm:gap-5">
            <!-- Avatar Karakter Englify -->
            <div class="relative shrink-0 group">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-white/25 backdrop-blur-md p-1.5 border-4 border-white/40 shadow-2xl flex items-center justify-center overflow-hidden transition-all duration-300 group-hover:scale-105 group-hover:border-white">
                    <img id="main-avatar-img" src="{{ auth()->user()->avatar_url }}" alt="Avatar {{ auth()->user()->nama }}" class="w-full h-full object-contain filter drop-shadow-md transition-transform duration-300 group-hover:scale-110">
                </div>
                <div class="absolute -bottom-1 -right-1 w-6 h-6 sm:w-7 sm:h-7 bg-emerald-400 rounded-full flex items-center justify-center border-2 sm:border-3 border-[#02457A] shadow-md" title="Akun Aktif">
                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>

            <!-- Info -->
            <div class="flex-1 text-center sm:text-left min-w-0">
                <h2 class="text-lg sm:text-xl font-extrabold truncate">{{ auth()->user()->nama ?? 'Siswa Englify' }}</h2>
                <p class="text-white/80 text-xs sm:text-sm mt-0.5 truncate">{{ auth()->user()->email ?? 'siswa@englify.com' }}</p>
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-1.5 sm:gap-2 mt-2">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 sm:py-1 bg-white/15 backdrop-blur text-white text-[11px] sm:text-xs font-semibold rounded-full">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        </svg>
                        Siswa
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 sm:py-1 bg-white/15 backdrop-blur text-white text-[11px] sm:text-xs font-semibold rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Aktif
                    </span>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="flex w-full sm:w-auto justify-center gap-2 sm:gap-3 mt-1 sm:mt-0">
                <div class="flex-1 sm:flex-none text-center px-2.5 sm:px-3 py-1.5 sm:py-2 bg-white/10 backdrop-blur rounded-xl border border-white/20">
                    <p class="text-base sm:text-xl font-extrabold">{{ $materiSelesai ?? 0 }}<span class="text-[10px] sm:text-xs text-white/70">/{{ $totalMateri ?? 0 }}</span></p>
                    <p class="text-[8px] sm:text-[9px] text-white/80 uppercase tracking-wider">Materi</p>
                </div>
                <div class="flex-1 sm:flex-none text-center px-2.5 sm:px-3 py-1.5 sm:py-2 bg-white/10 backdrop-blur rounded-xl border border-white/20">
                    <p class="text-base sm:text-xl font-extrabold">{{ $quizSelesai ?? 0 }}<span class="text-[10px] sm:text-xs text-white/70">/{{ $totalQuiz ?? 0 }}</span></p>
                    <p class="text-[8px] sm:text-[9px] text-white/80 uppercase tracking-wider">Quiz</p>
                </div>
                <div class="flex-1 sm:flex-none text-center px-2.5 sm:px-3 py-1.5 sm:py-2 bg-white/10 backdrop-blur rounded-xl border border-white/20">
                    <p class="text-base sm:text-xl font-extrabold">{{ round($rataRataNilai ?? 0) }}%</p>
                    <p class="text-[8px] sm:text-[9px] text-white/80 uppercase tracking-wider">Rata-rata</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- PILIH MASKOT AVATAR PROFIL (6 KARAKTER ENGLIFY)       -->
    <!-- ===================================================== -->
    @php
        $currentAvatar = auth()->user()->avatar ?? 'avatar-cat-reading.png';
        $avatars = \App\Models\User::availableAvatars();
    @endphp

    <div class="bg-white rounded-2xl border border-[#97CADB]/40 shadow-sm p-5 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#D6EBEE] flex items-center justify-center shrink-0">
                    <span class="text-xl">🐱</span>
                </div>
                <div>
                    <h3 class="font-extrabold text-[#001B48] text-base sm:text-lg">Karakter Maskot Profil</h3>
                    <p class="text-xs text-slate-500">Pilih salah satu karakter kucing lucu Englify untuk profilmu!</p>
                </div>
            </div>
            <div id="avatar-save-status" class="hidden items-center gap-2 px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full border border-emerald-200">
                <svg class="w-3.5 h-3.5 animate-spin text-emerald-600 hidden" id="avatar-spinner" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                <span id="avatar-status-text">Tersimpan</span>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
            @foreach($avatars as $file => $meta)
                @php
                    $isSelected = ($currentAvatar === $file);
                @endphp
                <button type="button"
                        onclick="selectAvatar('{{ $file }}', '{{ $meta['nama'] }}')"
                        class="avatar-card relative flex flex-col items-center p-3 rounded-2xl border-2 transition-all duration-200 group text-center cursor-pointer {{ $isSelected ? 'border-[#018ABE] bg-sky-50/60 ring-2 ring-[#018ABE]/20 shadow-md' : 'border-slate-200/80 bg-white hover:border-[#018ABE]/40 hover:bg-slate-50/80' }}"
                        data-avatar="{{ $file }}">
                    
                    {{-- Selected badge checkmark --}}
                    <div class="avatar-check absolute top-2 right-2 w-5 h-5 rounded-full bg-[#018ABE] text-white flex items-center justify-center {{ $isSelected ? '' : 'hidden' }}">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>

                    {{-- Image container --}}
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white p-1 flex items-center justify-center mb-2 shadow-2xs group-hover:scale-105 transition-transform duration-200">
                        <img src="{{ asset('images/avatars/' . $file) }}" alt="{{ $meta['nama'] }}" class="w-full h-full object-contain filter drop-shadow-sm">
                    </div>

                    {{-- Meta info --}}
                    <p class="text-xs font-extrabold text-[#001B48] leading-tight truncate w-full">{{ $meta['nama'] }}</p>
                    <span class="inline-block mt-1 text-[10px] font-bold px-2 py-0.5 rounded-full {{ $isSelected ? 'bg-[#018ABE] text-white' : 'bg-slate-100 text-slate-600 group-hover:bg-blue-100 group-hover:text-[#018ABE]' }} transition-colors">
                        {{ $meta['badge'] }}
                    </span>
                </button>
            @endforeach
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- MAIN GRID (2 KOLOM SEIMBANG)                            -->
    <!-- ===================================================== -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">

        <!-- LEFT: Info Akun (Read-Only) -->
        <div class="bg-white rounded-2xl border border-[#97CADB]/30 shadow-sm p-4 sm:p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-[#D6EBEE] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-[#001B48]">Informasi Akun</h3>
                    <p class="text-xs text-slate-500">Data akun kamu</p>
                </div>
            </div>

            <div class="space-y-4">
                <!-- Nama -->
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap</p>
                    <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->nama ?? '-' }}</p>
                </div>

                <!-- Email -->
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Email</p>
                    <p class="text-sm font-semibold text-slate-800 break-all">{{ auth()->user()->email ?? '-' }}</p>
                </div>

                <!-- Bergabung -->
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Bergabung Sejak</p>
                    <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->created_at?->format('d M Y') ?? '-' }}</p>
                </div>

                <!-- Terakhir Login -->
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Terakhir Login</p>
                    <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->last_login_at?->format('d M Y, H:i') ?? 'Hari ini' }}</p>
                </div>
            </div>

            <!-- Info Box -->
            <div class="mt-5 p-3 bg-blue-50 border border-blue-100 rounded-xl flex items-start gap-2">
                <svg class="w-4 h-4 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-xs text-blue-700">
                    Untuk mengubah nama atau data akun, silakan hubungi Super Admin.
                </p>
            </div>
        </div>

        <!-- RIGHT: Keamanan Akun & Informasi Password (Read-Only) -->
        <div class="bg-white rounded-2xl border border-[#97CADB]/30 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="px-4 sm:px-6 py-3.5 sm:py-4 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-[#001B48]">Keamanan Akun</h3>
                            <p class="text-xs text-slate-500">Informasi kata sandi & akses login</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 sm:p-6 space-y-4">
                    <!-- Status Keamanan -->
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-600">Status Kata Sandi</span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Terlindungi
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-600">Autentikasi</span>
                            <span class="text-xs font-bold text-slate-700">Terenkripsi (Bcrypt)</span>
                        </div>
                    </div>

                    <!-- Kotak Informasi Statis -->
                    <div class="p-4 bg-amber-50/80 border border-amber-200/80 rounded-xl flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-amber-900 uppercase tracking-wider mb-1">Informasi Perubahan Password</h4>
                            <p class="text-sm font-semibold text-amber-900 leading-relaxed">
                                Jika ingin mengubah password, silakan hubungi Super Admin.
                            </p>
                            <p class="text-xs text-amber-700 mt-1">
                                Perubahan data kredensial dilakukan secara terpusat oleh administrator untuk menjaga keamanan akun siswa.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Card / Catatan -->
            <div class="p-4 sm:p-6 bg-slate-50 border-t border-slate-100 text-xs text-slate-500">
                <span class="font-semibold text-slate-700">Catatan:</span> Pastikan selalu menjaga kerahasiaan kata sandi Anda dan tidak membagikannya kepada siapa pun.
            </div>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- CAT MASCOT                                              -->
    <!-- ===================================================== -->
    <div class="bg-gradient-to-br from-[#D6EBEE] to-white rounded-2xl p-4 sm:p-5 border border-[#97CADB]/50 flex flex-col sm:flex-row items-center text-center sm:text-left gap-3 sm:gap-4">
        <img src="{{ asset('images/cat-welcome.png') }}" alt="Cat" class="w-16 sm:w-20 h-auto">
        <div>
            <p class="font-cute text-base sm:text-lg text-[#02457A] leading-tight">Profilmu aman & terlindungi! 🔒</p>
            <p class="text-xs sm:text-sm text-slate-600 mt-1">Jangan bagikan passwordmu kepada siapapun ya. Tetap semangat belajar! ✨</p>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
// Smooth scroll behavior
document.documentElement.style.scrollBehavior = 'smooth';

function selectAvatar(filename, name) {
    const cards = document.querySelectorAll('.avatar-card');
    cards.forEach(card => {
        const isTarget = card.getAttribute('data-avatar') === filename;
        const check = card.querySelector('.avatar-check');
        const badge = card.querySelector('span');

        if (isTarget) {
            card.classList.remove('border-slate-200/80', 'bg-white', 'hover:border-[#018ABE]/40', 'hover:bg-slate-50/80');
            card.classList.add('border-[#018ABE]', 'bg-sky-50/60', 'ring-2', 'ring-[#018ABE]/20', 'shadow-md');
            if (check) check.classList.remove('hidden');
            if (badge) {
                badge.className = 'inline-block mt-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-[#018ABE] text-white transition-colors';
            }
        } else {
            card.classList.remove('border-[#018ABE]', 'bg-sky-50/60', 'ring-2', 'ring-[#018ABE]/20', 'shadow-md');
            card.classList.add('border-slate-200/80', 'bg-white', 'hover:border-[#018ABE]/40', 'hover:bg-slate-50/80');
            if (check) check.classList.add('hidden');
            if (badge) {
                badge.className = 'inline-block mt-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 group-hover:bg-blue-100 group-hover:text-[#018ABE] transition-colors';
            }
        }
    });

    // Update main avatar preview instantly
    const newUrl = "{{ asset('images/avatars') }}/" + filename;
    const mainImg = document.getElementById('main-avatar-img');
    if (mainImg) {
        mainImg.style.transform = 'scale(0.85)';
        setTimeout(() => {
            mainImg.src = newUrl;
            mainImg.style.transform = 'scale(1)';
        }, 120);
    }

    // Update header avatars instantly
    document.querySelectorAll('.header-user-avatar').forEach(img => {
        img.src = newUrl;
    });

    // Save to database
    const statusBox = document.getElementById('avatar-save-status');
    const spinner = document.getElementById('avatar-spinner');
    const statusText = document.getElementById('avatar-status-text');

    if (statusBox) {
        statusBox.classList.remove('hidden');
        statusBox.classList.add('flex');
        if (spinner) spinner.classList.remove('hidden');
        if (statusText) statusText.textContent = 'Menyimpan...';
    }

    fetch("{{ route('siswa.profil.avatar') }}", {
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
        if (statusText) statusText.textContent = 'Gagal menyimpan';
    });
}
</script>
@endpush

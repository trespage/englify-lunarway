<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password — Englify</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Space Grotesk"', 'sans-serif'],
                        cute: ['"Caveat"', 'cursive']
                    },
                    colors: {
                        navy: {
                            800: '#001B48',
                            850: '#02457A',
                            900: '#001B48'
                        },
                        sky: {
                            100: '#D6E8EE',
                            200: '#97CADB',
                            300: '#018ABE',
                            400: '#02457A'
                        }
                    },
                    animation: {
                        'float': 'float 4s ease-in-out infinite',
                        'blob': 'blob 8s infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-6px)' },
                        },
                        blob: {
                            '0%, 100%': { transform: 'translate(0, 0) scale(1)' },
                            '33%': { transform: 'translate(15px, -20px) scale(1.05)' },
                            '66%': { transform: 'translate(-10px, 10px) scale(0.95)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-cute { font-family: 'Caveat', cursive; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }

        body {
            background: linear-gradient(135deg, #C2DCF9 0%, #D4E6FA 50%, #E6F1FC 100%);
            min-height: 100vh;
        }

        /* Button Shine Effect */
        .btn-shine {
            position: relative;
            overflow: hidden;
        }
        .btn-shine::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.35), transparent);
            transition: left 0.6s ease;
        }
        .btn-shine:hover::before {
            left: 100%;
        }

        .input-englify {
            transition: all 0.2s ease;
        }
        .input-englify:focus {
            transform: translateY(-1px);
            box-shadow: 0 4px 14px -2px rgba(1, 138, 190, 0.2);
        }
    </style>
</head>
<body class="antialiased min-h-screen py-4 sm:py-6 px-4 flex items-center justify-center relative overflow-x-hidden">

    <!-- Decorative Animated Blobs -->
    <div class="fixed top-8 left-8 w-72 h-72 bg-[#018ABE]/15 rounded-full filter blur-3xl animate-blob pointer-events-none"></div>
    <div class="fixed bottom-8 right-8 w-80 h-80 bg-[#97CADB]/25 rounded-full filter blur-3xl animate-blob pointer-events-none" style="animation-delay: 3s"></div>

    <!-- ===================================================== -->
    <!-- UNIFIED COMPACT CARD CONTAINER                         -->
    <!-- ===================================================== -->
    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl shadow-[#02457A]/15 border border-white/90 overflow-hidden grid grid-cols-1 md:grid-cols-12 relative z-10 my-auto">

        <!-- ===================================================== -->
        <!-- LEFT PANEL: BRANDING & MASCOT (COMPACT & MATCHED)      -->
        <!-- ===================================================== -->
        <div class="hidden md:flex md:col-span-5 bg-gradient-to-br from-[#D6EBEE]/90 via-[#E8F4F8] to-[#97CADB]/40 p-6 flex-col justify-between items-center text-center border-r border-[#97CADB]/30 relative">
            
            <!-- Top Logo -->
            <div class="w-full flex items-center justify-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-white shadow-md shadow-[#018ABE]/10 flex items-center justify-center p-1.5 border border-white">
                    <img src="{{ asset('images/cat-welcome.png') }}" alt="Englify Cat" class="w-6 h-6 object-contain">
                </div>
                <div class="text-left">
                    <span class="text-2xl font-extrabold text-[#001B48] font-display tracking-tight block leading-none">englify</span>
                    <span class="text-[9px] font-bold uppercase tracking-wider text-[#018ABE]">English Club</span>
                </div>
            </div>

            <!-- Cat Mascot -->
            <div class="my-auto py-4 animate-float relative">
                <img src="{{ asset('images/cat-welcome.png') }}" alt="Englify Cat Mascot" class="w-36 lg:w-44 h-auto object-contain drop-shadow-xl mx-auto">
                <div class="absolute top-2 right-1 text-amber-400 text-base animate-pulse">✦</div>
                <div class="absolute bottom-2 left-1 text-[#018ABE] text-sm">✧</div>
            </div>

            <!-- Cute Speech Bubble -->
            <div class="w-full max-w-xs bg-white/90 backdrop-blur-sm rounded-2xl p-3 border border-white shadow-sm text-center">
                <div class="inline-flex items-center gap-1 px-2 py-0.5 bg-[#D6EBEE] rounded-full text-[10px] font-bold text-[#02457A] mb-1">
                    <span>🐾 Maskot Englify</span>
                </div>
                <p class="font-cute text-xl text-[#001B48] leading-tight">
                    "Akun aman, belajar pun jadi tenang!"
                </p>
                <span class="text-[10px] text-slate-500 font-semibold block mt-0.5">Langkah 1: Tentukan password barumu</span>
            </div>
        </div>

        <!-- ===================================================== -->
        <!-- RIGHT PANEL: COMPACT FORM GANTI PASSWORD               -->
        <!-- ===================================================== -->
        <div class="w-full md:col-span-7 p-6 sm:p-7 flex flex-col justify-center bg-white relative">

            <!-- Mobile Top Logo (Hanya di layar kecil) -->
            <div class="md:hidden flex items-center justify-center gap-2 mb-3">
                <div class="w-8 h-8 rounded-xl bg-white border border-[#97CADB]/40 shadow-xs flex items-center justify-center p-1">
                    <img src="{{ asset('images/cat-welcome.png') }}" alt="Englify Cat" class="w-5 h-5 object-contain">
                </div>
                <span class="text-xl font-extrabold text-[#001B48] font-display">englify</span>
            </div>

            <!-- Navigation Action Bar: Back to Login / Home (Tanda Panah Kembali) -->
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                @if(auth()->user()->must_change_password ?? false)
                    <form action="{{ route('logout') }}" method="POST" class="inline m-0">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-50 hover:bg-slate-100 text-slate-700 hover:text-[#018ABE] border border-slate-200/80 text-xs font-semibold transition group shadow-2xs cursor-pointer" title="Keluar dan kembali ke halaman login">
                            <svg class="w-3.5 h-3.5 group-hover:-translate-x-1 transition-transform text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            <span>Kembali ke Login</span>
                        </button>
                    </form>
                @else
                    @php
                        $backUrl = match((int)(auth()->user()->id_role ?? 3)) {
                            1 => route('superadmin.dashboard'),
                            2 => route('admin.dashboard'),
                            default => route('siswa.dashboard'),
                        };
                    @endphp
                    <a href="{{ $backUrl }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-50 hover:bg-slate-100 text-slate-700 hover:text-[#018ABE] border border-slate-200/80 text-xs font-semibold transition group shadow-2xs" title="Kembali ke Dashboard">
                        <svg class="w-3.5 h-3.5 group-hover:-translate-x-1 transition-transform text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Kembali ke Dashboard</span>
                    </a>
                @endif

                <a href="/" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full hover:bg-slate-50 text-slate-500 hover:text-[#018ABE] text-xs font-semibold transition" title="Ke Halaman Utama (Landing Page)">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="hidden sm:inline">Landing Page</span>
                    <span class="sm:hidden">Beranda</span>
                </a>
            </div>

            <!-- Breadcrumbs Rekam Jejak Navigasi -->
            @include('layouts.partials.breadcrumbs')

            <!-- Header Form -->
            <div class="mb-4">
                <div class="flex items-center gap-2.5 mb-1">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-[#018ABE] to-[#02457A] text-white flex items-center justify-center shadow-md shadow-[#018ABE]/20 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-extrabold text-[#001B48] font-display leading-tight">Ganti Password</h1>
                </div>
                <p class="text-xs text-slate-500">
                    @if(auth()->user()->must_change_password ?? false)
                        @php
                            $namaUser = auth()->user()->nama ?? '';
                            $tampilNama = ($namaUser && strtolower(trim($namaUser)) !== 'wjlrc') ? ', ' . $namaUser : '';
                        @endphp
                        Halo{{ $tampilNama }}! Ini adalah login pertama Anda. Silakan tentukan password baru.
                    @else
                        Perbarui password akun Anda untuk menjaga keamanan pembelajaran.
                    @endif
                </p>
            </div>

            <!-- Alert Errors -->
            @if ($errors->any())
            <div class="mb-3 p-3 bg-rose-50 border border-rose-200 rounded-xl flex items-start gap-2.5">
                <svg class="w-4 h-4 text-rose-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <div class="text-xs text-rose-700">
                    @foreach ($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Form -->
            <form id="changePasswordForm" method="POST" action="{{ route('update.password') }}" class="space-y-3">
                @csrf

                <!-- 1. Password Lama -->
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">
                        Password Lama <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" id="current_password" name="current_password" required autofocus
                               class="input-englify w-full pl-9 pr-9 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-[#001B48] placeholder-slate-400 focus:outline-none focus:border-[#018ABE] focus:ring-2 focus:ring-[#018ABE]/15 focus:bg-white @error('current_password') border-rose-300 @enderror"
                               placeholder="Masukkan password default/lama Anda">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <button type="button" onclick="togglePassword('current_password', this)" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#018ABE] transition p-1">
                            <svg class="w-4 h-4 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg class="w-4 h-4 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>

                <!-- 2. Password Baru -->
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">
                        Password Baru <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" id="new_password" name="new_password" required
                               class="input-englify w-full pl-9 pr-9 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-[#001B48] placeholder-slate-400 focus:outline-none focus:border-[#018ABE] focus:ring-2 focus:ring-[#018ABE]/15 focus:bg-white @error('new_password') border-rose-300 @enderror"
                               placeholder="Minimal 6 karakter" oninput="checkPasswordStrength(this.value)">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        <button type="button" onclick="togglePassword('new_password', this)" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#018ABE] transition p-1">
                            <svg class="w-4 h-4 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg class="w-4 h-4 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>

                    <!-- Bar Kekuatan & Checklist Ringkas -->
                    <div class="mt-2">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-[10px] font-bold text-slate-500">Kekuatan:</span>
                            <span id="strengthLabel" class="text-[10px] font-extrabold text-slate-400">-</span>
                        </div>
                        <div class="w-full h-1 bg-slate-100 rounded-full overflow-hidden">
                            <div id="strengthBar" class="h-full rounded-full transition-all duration-300" style="width: 0%"></div>
                        </div>

                        <!-- 4 Kriteria Mini -->
                        <div class="mt-1.5 grid grid-cols-2 gap-1 text-[10px] text-slate-400 font-medium">
                            <div id="req-length" class="flex items-center gap-1 transition">
                                <span class="req-bullet">•</span>
                                <span>Min. 6 karakter</span>
                            </div>
                            <div id="req-upper" class="flex items-center gap-1 transition">
                                <span class="req-bullet">•</span>
                                <span>Huruf besar (A-Z)</span>
                            </div>
                            <div id="req-lower" class="flex items-center gap-1 transition">
                                <span class="req-bullet">•</span>
                                <span>Huruf kecil (a-z)</span>
                            </div>
                            <div id="req-number" class="flex items-center gap-1 transition">
                                <span class="req-bullet">•</span>
                                <span>Angka (0-9)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Konfirmasi Password -->
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">
                        Konfirmasi Password Baru <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" id="confirm_password" name="new_password_confirmation" required
                               class="input-englify w-full pl-9 pr-9 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-[#001B48] placeholder-slate-400 focus:outline-none focus:border-[#018ABE] focus:ring-2 focus:ring-[#018ABE]/15 focus:bg-white"
                               placeholder="Ketik ulang password baru Anda" oninput="checkPasswordMatch()">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <button type="button" onclick="togglePassword('confirm_password', this)" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#018ABE] transition p-1">
                            <svg class="w-4 h-4 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg class="w-4 h-4 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                    
                    <div id="matchIndicator" class="hidden mt-1 flex items-center gap-1 text-[11px] font-semibold">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span id="matchText">Password cocok</span>
                    </div>
                </div>

                <!-- Tip Keamanan Ringkas -->
                <div class="bg-[#D6EBEE]/60 border border-[#97CADB]/40 rounded-xl px-3 py-2 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5 text-[#018ABE] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-[11px] text-[#02457A] leading-tight">
                        <strong>Tips:</strong> Gunakan minimal 8 karakter gabungan huruf dan angka yang mudah kamu ingat.
                    </p>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" id="submitBtn" disabled
                        class="btn-shine w-full py-3 px-4 bg-slate-300 text-white font-bold text-xs sm:text-sm rounded-xl transition-all duration-300 flex items-center justify-center gap-2 cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Simpan Password Baru & Masuk</span>
                </button>
            </form>

            <div class="mt-3 text-center">
                <p class="text-[10px] text-slate-400">
                    Akun terlindungi oleh sistem keamanan Englify.
                </p>
            </div>
        </div>
    </div>

    <!-- Script Logika Form -->
    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const eyeOpen = btn.querySelector('.eye-open');
            const eyeClosed = btn.querySelector('.eye-closed');

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }

        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('strengthBar');
            const strengthLabel = document.getElementById('strengthLabel');

            let score = 0;
            const checks = {
                length: password.length >= 6,
                upper: /[A-Z]/.test(password),
                lower: /[a-z]/.test(password),
                number: /[0-9]/.test(password)
            };

            updateRequirement('req-length', checks.length);
            updateRequirement('req-upper', checks.upper);
            updateRequirement('req-lower', checks.lower);
            updateRequirement('req-number', checks.number);

            Object.values(checks).forEach(v => { if (v) score++; });

            const percentage = (score / 4) * 100;
            strengthBar.style.width = percentage + '%';

            if (password.length === 0) {
                strengthBar.className = 'h-full rounded-full transition-all duration-300 bg-slate-200';
                strengthLabel.textContent = '-';
                strengthLabel.className = 'text-[10px] font-extrabold text-slate-400';
            } else if (score <= 1) {
                strengthBar.className = 'h-full rounded-full transition-all duration-300 bg-gradient-to-r from-rose-400 to-rose-500';
                strengthLabel.textContent = 'Lemah';
                strengthLabel.className = 'text-[10px] font-extrabold text-rose-600';
            } else if (score <= 2) {
                strengthBar.className = 'h-full rounded-full transition-all duration-300 bg-gradient-to-r from-amber-400 to-amber-500';
                strengthLabel.textContent = 'Sedang';
                strengthLabel.className = 'text-[10px] font-extrabold text-amber-600';
            } else if (score <= 3) {
                strengthBar.className = 'h-full rounded-full transition-all duration-300 bg-gradient-to-r from-[#018ABE] to-[#02457A]';
                strengthLabel.textContent = 'Kuat';
                strengthLabel.className = 'text-[10px] font-extrabold text-[#018ABE]';
            } else {
                strengthBar.className = 'h-full rounded-full transition-all duration-300 bg-gradient-to-r from-emerald-500 to-teal-500';
                strengthLabel.textContent = 'Sangat Kuat';
                strengthLabel.className = 'text-[10px] font-extrabold text-emerald-600';
            }

            checkCanSubmit();
        }

        function updateRequirement(id, passed) {
            const el = document.getElementById(id);
            if (!el) return;
            const bullet = el.querySelector('.req-bullet');

            if (passed) {
                el.classList.remove('text-slate-400');
                el.classList.add('text-emerald-600');
                if (bullet) bullet.textContent = '✓';
            } else {
                el.classList.remove('text-emerald-600');
                el.classList.add('text-slate-400');
                if (bullet) bullet.textContent = '•';
            }
        }

        function checkPasswordMatch() {
            const newPass = document.getElementById('new_password').value;
            const confirmPass = document.getElementById('confirm_password').value;
            const indicator = document.getElementById('matchIndicator');
            const matchText = document.getElementById('matchText');

            if (confirmPass.length === 0) {
                indicator.classList.add('hidden');
                return;
            }

            indicator.classList.remove('hidden');

            if (newPass === confirmPass) {
                indicator.classList.remove('text-rose-600');
                indicator.classList.add('text-emerald-600');
                matchText.textContent = 'Password cocok ✓';
            } else {
                indicator.classList.remove('text-emerald-600');
                indicator.classList.add('text-rose-600');
                matchText.textContent = 'Password belum cocok';
            }

            checkCanSubmit();
        }

        function checkCanSubmit() {
            const currentPass = document.getElementById('current_password').value;
            const newPass = document.getElementById('new_password').value;
            const confirmPass = document.getElementById('confirm_password').value;
            const btn = document.getElementById('submitBtn');

            const canSubmit = currentPass.length > 0 && newPass.length >= 6 && newPass === confirmPass;

            if (canSubmit) {
                btn.disabled = false;
                btn.className = "btn-shine w-full py-3 px-4 bg-gradient-to-r from-[#018ABE] to-[#02457A] hover:from-[#02457A] hover:to-[#001B48] text-white font-bold text-xs sm:text-sm rounded-xl shadow-lg shadow-[#018ABE]/25 transition-all duration-300 flex items-center justify-center gap-2 cursor-pointer hover:-translate-y-0.5";
            } else {
                btn.disabled = true;
                btn.className = "btn-shine w-full py-3 px-4 bg-slate-300 text-white font-bold text-xs sm:text-sm rounded-xl transition-all duration-300 flex items-center justify-center gap-2 cursor-not-allowed";
            }
        }

        document.getElementById('current_password').addEventListener('input', checkCanSubmit);
    </script>

    @include('layouts.partials.loading-modal')
</body>
</html>

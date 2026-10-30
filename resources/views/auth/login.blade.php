<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Englify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Space Grotesk', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                        cute: ['"Caveat"', 'cursive'],
                    },
                    colors: {
                        navy: {
                            50: '#eef2f8',
                            100: '#d6e1f0',
                            200: '#9eb8d6',
                            500: '#3d5a80',
                            700: '#1e3a5f',
                            800: '#182B4B',
                            900: '#0f1c35',
                            950: '#070f1f',
                        },
                        sky: {
                            50: '#e8f4f8',
                            100: '#D6E8EE',
                            200: '#97CADB',
                            300: '#018ABE',
                            400: '#00a8e8',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-delayed': 'float 6s ease-in-out 2s infinite',
                        'float-slow': 'float 8s ease-in-out 1s infinite',
                        'blob': 'blob 7s infinite',
                        'spin-slow': 'spin 20s linear infinite',
                        'slide-up': 'slideUp 0.6s ease-out forwards',
                        'fade-in': 'fadeIn 0.8s ease-out forwards',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                            '50%': { transform: 'translateY(-15px) rotate(2deg)' },
                        },
                        blob: {
                            '0%, 100%': { transform: 'translate(0, 0) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(30px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
        .font-cute { font-family: 'Caveat', cursive; }

        /* Grid Pattern */
        .grid-pattern {
            background-image:
                linear-gradient(rgba(24, 43, 75, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(24, 43, 75, 0.04) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        /* Noise Texture */
        .noise-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.4'/%3E%3C/svg%3E");
            opacity: 0.03;
            pointer-events: none;
        }

        /* Glass Card */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        /* Input Focus Effect */
        .input-field {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .input-field:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px -10px rgba(24, 43, 75, 0.2);
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
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        .btn-shine:hover::before {
            left: 100%;
        }

        /* Password Toggle */
        .password-toggle {
            cursor: pointer;
            transition: all 0.2s;
        }
        .password-toggle:hover {
            color: #182B4B;
        }

        /* Hide scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748b; }
    </style>
</head>
<body class="bg-white overflow-x-hidden">

    <div class="min-h-screen grid lg:grid-cols-2 relative">

        <!-- ============ LEFT SIDE: Branding ============ -->
        <div class="relative bg-gradient-to-br from-navy-800 via-navy-700 to-navy-900 text-white overflow-hidden hidden lg:flex flex-col justify-between p-8 xl:p-12">
            <!-- Animated Blobs -->
            <div class="absolute top-10 left-10 w-72 h-72 bg-sky-300/20 rounded-full mix-blend-screen filter blur-3xl animate-blob"></div>
            <div class="absolute bottom-10 right-10 w-72 h-72 bg-sky-200/20 rounded-full mix-blend-screen filter blur-3xl animate-blob" style="animation-delay: 2s"></div>
            <div class="absolute top-1/2 left-1/2 w-96 h-96 bg-navy-500/20 rounded-full mix-blend-screen filter blur-3xl animate-blob" style="animation-delay: 4s"></div>

            <!-- Grid Pattern Overlay -->
            <div class="absolute inset-0 opacity-10" style="background-image: linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 40px 40px;"></div>

            <!-- Top: Logo & Badges -->
            <div class="relative z-10 animate-fade-in space-y-3.5">
                <a href="/" class="inline-flex items-center gap-3 group">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-2xl group-hover:rotate-12 transition-transform duration-300 p-2">
                        <img src="{{ asset('images/cat-welcome.png') }}" alt="Englify Cat" class="w-8 h-8 object-contain">
                    </div>
                    <span class="font-display font-bold text-2xl tracking-tight">englify</span>
                </a>
                <div class="flex items-center gap-2">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-white/10 backdrop-blur border border-white/20 rounded-full">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                        <span class="text-xs font-bold uppercase tracking-wider">English Club</span>
                    </div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-sky-300/20 backdrop-blur border border-sky-300/30 rounded-full text-xs font-bold text-sky-200">
                        <span>🐾 Englify Buddy</span>
                    </div>
                </div>
            </div>

            <!-- Middle: Big Typography & Iconic Cat Mascot -->
            <div class="relative z-10 space-y-6 xl:space-y-7 max-w-lg xl:max-w-xl w-full my-auto py-4">
                <!-- Welcome Text with Iconic Cat Mascot -->
                <div class="flex items-end justify-between gap-4">
                    <h1 class="font-display font-bold text-5xl xl:text-6xl leading-[1.05] tracking-tight animate-slide-up">
                        Welcome,<br>
                        <span class="italic text-sky-300">awesome</span><br>
                        learner.
                    </h1>
                    <!-- Iconic Cat Mascot Image -->
                    <div class="relative shrink-0 animate-float hidden md:block">
                        <div class="relative p-2">
                            <img src="{{ asset('images/cat-welcome.png') }}" alt="Englify Cat Mascot" class="w-32 xl:w-36 h-auto object-contain drop-shadow-2xl">
                            <span class="absolute -top-1 -right-1 text-amber-300 text-lg animate-pulse">✨</span>
                            <span class="absolute -bottom-1 -left-1 text-sky-300 text-sm">✦</span>
                        </div>
                    </div>
                </div>

                <p class="text-sky-100 text-base xl:text-lg leading-relaxed animate-slide-up" style="animation-delay: 0.2s">
                    Lanjutkan perjalanan belajarmu bersama maskot Englify. Setiap langkah kecil membawamu lebih dekat ke masa depan cerah.
                </p>

                <!-- Floating Stats: Symmetrical 3-Column Grid -->
                <div class="grid grid-cols-3 gap-3.5 xl:gap-4 w-full animate-slide-up" style="animation-delay: 0.3s">
                    <div class="bg-white/5 backdrop-blur border border-white/10 rounded-2xl p-4 hover:bg-white/10 transition group text-left">
                        <div class="font-display font-bold text-2xl xl:text-3xl group-hover:text-sky-300 transition">100+</div>
                        <div class="text-xs text-sky-100/70 mt-0.5">Members</div>
                    </div>
                    <div class="bg-white/5 backdrop-blur border border-white/10 rounded-2xl p-4 hover:bg-white/10 transition group text-left">
                        <div class="font-display font-bold text-2xl xl:text-3xl group-hover:text-sky-300 transition">40+</div>
                        <div class="text-xs text-sky-100/70 mt-0.5">Materials</div>
                    </div>
                    <div class="bg-white/5 backdrop-blur border border-white/10 rounded-2xl p-4 hover:bg-white/10 transition group text-left">
                        <div class="font-display font-bold text-2xl xl:text-3xl group-hover:text-sky-300 transition">4</div>
                        <div class="text-xs text-sky-100/70 mt-0.5">Divisions</div>
                    </div>
                </div>
            </div>

            <!-- Bottom: Floating Cards (Symmetrical 2-Column Grid) -->
            <div class="relative z-10 grid grid-cols-2 gap-3.5 xl:gap-4 max-w-lg xl:max-w-xl w-full animate-slide-up" style="animation-delay: 0.4s">
                <!-- Floating Card 1 -->
                <div class="glass !bg-white/10 !border-white/20 rounded-2xl p-3.5 xl:p-4 animate-float">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-sky-300 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-white truncate">Quiz Completed!</div>
                            <div class="text-[10px] text-sky-100/70 truncate">Score: 90/100 • Speaking Bab 1</div>
                        </div>
                    </div>
                </div>

                <!-- Floating Card 2 -->
                <div class="glass !bg-white/10 !border-white/20 rounded-2xl p-3.5 xl:p-4 animate-float-delayed">
                    <div class="flex items-center gap-3">
                        <div class="flex -space-x-2 flex-shrink-0">
                            <div class="w-8 h-8 rounded-full bg-sky-300 border-2 border-navy-800 flex items-center justify-center text-[10px] font-bold">NA</div>
                            <div class="w-8 h-8 rounded-full bg-white border-2 border-navy-800 flex items-center justify-center text-[10px] font-bold text-navy-800">RP</div>
                            <div class="w-8 h-8 rounded-full bg-sky-200 border-2 border-navy-800 flex items-center justify-center text-[10px] font-bold">+5</div>
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-white truncate">8 students online</div>
                            <div class="text-[10px] text-sky-100/70 truncate">Learning right now</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============ RIGHT SIDE: Login Form ============ -->
        <div class="relative flex items-center justify-center p-6 lg:p-12 bg-gradient-to-br from-sky-50 via-white to-sky-50 noise-bg">
            <!-- Grid Pattern -->
            <div class="absolute inset-0 grid-pattern"></div>

            <!-- Decorative Blobs -->
            <div class="absolute top-20 right-20 w-64 h-64 bg-sky-200/30 rounded-full blur-3xl animate-blob"></div>
            <div class="absolute bottom-20 left-20 w-64 h-64 bg-navy-100/30 rounded-full blur-3xl animate-blob" style="animation-delay: 2s"></div>

            <!-- Header Navigation: Mobile Logo & Back Arrow Button -->
            <div class="absolute top-5 left-5 right-5 sm:top-6 sm:left-6 sm:right-6 lg:left-auto flex items-center justify-between z-20">
                <!-- Mobile Logo (only visible on small screens) -->
                <div class="lg:hidden">
                    <a href="/" class="inline-flex items-center gap-2 group">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 bg-white border border-navy-100 rounded-xl flex items-center justify-center p-1.5 shadow-sm transition-transform group-hover:scale-105">
                            <img src="{{ asset('images/cat-welcome.png') }}" alt="Englify Cat" class="w-6 h-6 sm:w-7 sm:h-7 object-contain">
                        </div>
                        <span class="font-display font-bold text-lg sm:text-xl text-navy-900">englify</span>
                    </a>
                </div>

                <!-- Back to Landing Page (Tanda Panah Kembali) -->
                <a href="/" class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 bg-white border border-navy-100 rounded-full text-xs sm:text-sm font-semibold text-navy-900 hover:border-navy-900 hover:shadow-md transition group shadow-xs">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="hidden sm:inline">Kembali ke Beranda</span>
                    <span class="sm:hidden">Beranda</span>
                </a>
            </div>

            <!-- Login Card -->
            <div class="relative z-10 w-full max-w-md animate-slide-up pt-10 sm:pt-6 lg:pt-0">

                <!-- Breadcrumbs Rekam Jejak Navigasi Publik -->
                @include('layouts.partials.breadcrumbs')

                <!-- Header -->
                <div class="mb-8">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-navy-200 rounded-full mb-4 shadow-sm">
                        <span class="w-1.5 h-1.5 bg-sky-300 rounded-full"></span>
                        <span class="text-[10px] font-bold text-navy-900 uppercase tracking-wider">Sign in to your account</span>
                    </div>
                    <h2 class="font-display font-bold text-4xl lg:text-5xl text-navy-900 leading-tight mb-2">
                        Let's get you<br>
                        <span class="italic text-sky-300">started.</span>
                    </h2>
                    <p class="text-slate-600 text-sm">Masuk untuk melanjutkan perjalanan belajarmu di Englify.</p>
                </div>

                <!-- Error Message -->
                @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl flex items-start gap-3 animate-slide-up">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-red-900 mb-1">Oops, ada masalah!</p>
                        <ul class="text-xs text-red-700 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <!-- Success Message -->
                @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-start gap-3 animate-slide-up">
                    <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-emerald-900">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                <!-- Warning Message (for first login) -->
                @if (session('warning'))
                <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-2xl flex items-start gap-3 animate-slide-up">
                    <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-amber-900">{{ session('warning') }}</p>
                    </div>
                </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label class="flex items-center justify-between">
                            <span class="text-xs font-bold text-navy-900 uppercase tracking-wider">Email Address</span>
                            <span class="text-[10px] text-slate-500">Required</span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                            </div>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                placeholder="nama@englify.com"
                                class="input-field w-full pl-12 pr-4 py-4 bg-white border-2 border-navy-100 rounded-2xl text-sm font-medium text-navy-900 placeholder-slate-400 focus:outline-none focus:border-navy-800 focus:bg-white @error('email') border-red-300 @enderror"
                            >
                        </div>
                        @error('email')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label class="flex items-center justify-between">
                            <span class="text-xs font-bold text-navy-900 uppercase tracking-wider">Password</span>
                            <span class="text-[10px] text-slate-500">Required</span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                required
                                placeholder="••••••••"
                                class="input-field w-full pl-12 pr-12 py-4 bg-white border-2 border-navy-100 rounded-2xl text-sm font-medium text-navy-900 placeholder-slate-400 focus:outline-none focus:border-navy-800 focus:bg-white @error('password') border-red-300 @enderror"
                            >
                            <button
                                type="button"
                                onclick="togglePassword()"
                                class="password-toggle absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"
                                id="toggleBtn"
                            >
                                <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg id="eyeOffIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-navy-200 text-navy-800 focus:ring-navy-800 focus:ring-offset-0 cursor-pointer">
                            <span class="text-xs font-medium text-slate-600 group-hover:text-navy-900 transition">Ingat saya</span>
                        </label>
                        <button type="button" onclick="showLupaPasswordInfo()" class="text-xs font-bold text-sky-300 hover:text-navy-800 transition">Lupa password?</button>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="btn-shine w-full py-4 bg-navy-800 text-white font-bold rounded-2xl hover:bg-navy-700 transition-all shadow-xl shadow-navy-800/20 hover:shadow-2xl hover:shadow-navy-800/30 hover:-translate-y-0.5 flex items-center justify-center gap-2 group"
                    >
                        <span>Masuk ke Englify</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </button>

                    <!-- Info: Akun Disediakan oleh Admin -->
                    <div class="mt-6 p-4 rounded-2xl bg-white border-2 border-navy-100 flex items-start gap-3 shadow-[4px_4px_0_0_#182B4B] text-left">
                        <div class="w-8 h-8 rounded-xl bg-sky-100 text-sky-800 flex items-center justify-center shrink-0 text-base shadow-2xs">
                            🐾
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-navy-900">Belum memiliki akun?</p>
                            <p class="text-[11px] text-slate-500 mt-0.5 leading-relaxed">
                                Akun Englify dibuat dan disediakan langsung oleh <span class="font-bold text-navy-900">Administrator</span>. Silakan hubungi admin sekolah atau divisi kamu untuk mendapatkan email &amp; password.
                            </p>
                        </div>
                    </div>
                </form>

                <!-- Footer Note -->
                <div class="mt-8 text-center">
                    <p class="text-xs text-slate-500">
                        Dengan masuk, kamu menyetujui
                        <a href="#" class="font-bold text-navy-900 hover:text-sky-300 transition">Syarat & Ketentuan</a>
                        Englify.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- ============ JAVASCRIPT ============ -->
    <script>
        // Password Toggle
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeOffIcon = document.getElementById('eyeOffIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }

        // Input focus label effect
        document.querySelectorAll('.input-field').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('scale-[1.02]');
            });
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('scale-[1.02]');
            });
        });

        // Auto-hide error after 5 seconds
        const errorBox = document.querySelector('.bg-red-50');
        if (errorBox) {
            setTimeout(() => {
                errorBox.style.transition = 'all 0.5s ease';
                errorBox.style.opacity = '0';
                errorBox.style.transform = 'translateY(-10px)';
                setTimeout(() => errorBox.remove(), 500);
            }, 5000);
        }
        // Lupa Password Modal
        function showLupaPasswordInfo() {
            Swal.fire({
                icon: 'info',
                title: 'Lupa Password?',
                html: '<p class="text-sm text-slate-600 leading-relaxed">Akun pembelajaran Englify dikelola langsung oleh <b>Administrator</b>. Silakan hubungi admin sekolah atau pengurus divisi Anda untuk melakukan reset kata sandi akun Anda. 🐾</p>',
                confirmButtonText: 'Mengerti',
                confirmButtonColor: '#182B4B',
                customClass: {
                    popup: 'rounded-3xl p-6',
                    confirmButton: 'rounded-xl px-6 py-2.5 font-bold text-sm'
                }
            });
        }

        // Tampilkan loading modal saat submit form login
        const loginForm = document.querySelector('form[action="{{ route('login') }}"]');
        if (loginForm) {
            loginForm.addEventListener('submit', function() {
                if (typeof window.showLoading === 'function') {
                    window.showLoading('Memverifikasi Akun...', 'Tunggu sebentar ya, sedang memproses login ke Englify! 🐾');
                }
            });
        }
    </script>

    @include('layouts.partials.loading-modal')
</body>
</html>

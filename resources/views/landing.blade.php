<!DOCTYPE html>
<html lang="id" class="scroll-smooth scroll-pt-24">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Englify — Learn English, Grow Your Future</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Space Grotesk', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
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
                        'marquee': 'marquee 30s linear infinite',
                        'spin-slow': 'spin 20s linear infinite',
                        'blob': 'blob 7s infinite',
                        'slide-up': 'slideUp 0.8s ease-out forwards',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                            '50%': { transform: 'translateY(-20px) rotate(2deg)' },
                        },
                        marquee: {
                            '0%': { transform: 'translateX(0%)' },
                            '100%': { transform: 'translateX(-50%)' },
                        },
                        blob: {
                            '0%, 100%': { transform: 'translate(0, 0) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(40px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }

        /* Custom Cursor Effect */
        .cursor-dot {
            width: 8px; height: 8px;
            background: #182B4B;
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            transition: transform 0.1s;
        }

        /* Noise Texture Overlay */
        .noise-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.4'/%3E%3C/svg%3E");
            opacity: 0.03;
            pointer-events: none;
        }

        /* Bento Card Hover */
        .bento-card {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .bento-card:hover {
            transform: translateY(-8px) rotate(-1deg);
            box-shadow: 0 30px 60px -15px rgba(24, 43, 75, 0.3);
        }

        /* Marquee */
        .marquee-track {
            display: flex;
            width: max-content;
        }
        .marquee-track:hover,
        .ticker-tape:hover .marquee-track {
            animation-play-state: paused !important;
        }

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, #182B4B 0%, #018ABE 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Diagonal Section */
        .diagonal-section {
            clip-path: polygon(0 5%, 100% 0, 100% 95%, 0 100%);
        }

        /* Grid Pattern */
        .grid-pattern {
            background-image:
                linear-gradient(rgba(24, 43, 75, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(24, 43, 75, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        /* Scroll Reveal */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Ticker Tape & Testimonials */
        .ticker-tape {
            overflow: hidden;
            white-space: nowrap;
        }

        .ticker-tape .testimonial-card,
        .testimonial-card {
            white-space: normal !important;
            word-break: break-word !important;
            overflow-wrap: break-word !important;
        }

        .ticker-tape:hover .marquee-track,
        .marquee-track:hover {
            animation-play-state: paused;
        }

        .review-text {
            white-space: normal !important;
            word-break: break-word !important;
            overflow-wrap: break-word !important;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Glass Card */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Hide scrollbar for marquee */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-white text-navy-900 overflow-x-hidden">

    <!-- ============ NAVBAR (Floating, Glass) ============ -->
    <nav class="fixed top-4 sm:top-6 left-1/2 -translate-x-1/2 w-[92%] sm:w-[95%] max-w-6xl z-50">
        <div class="glass rounded-full px-4 sm:px-6 py-2.5 sm:py-3 shadow-xl shadow-navy-900/5 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 sm:w-9 sm:h-9 bg-navy-800 rounded-full flex items-center justify-center relative shrink-0">
                    <div class="absolute inset-0 bg-navy-800 rounded-full animate-ping opacity-20"></div>
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="font-display font-bold text-base sm:text-lg text-navy-900">englify</span>
                <span class="hidden sm:inline text-[10px] font-bold text-sky-300 bg-sky-50 px-2 py-0.5 rounded-full ml-1">Club</span>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-1">
                <a href="#beranda" class="px-4 py-2 text-sm font-medium text-navy-900 hover:bg-navy-50 rounded-full transition">Beranda</a>
                <a href="#fitur" class="px-4 py-2 text-sm font-medium text-slate-600 hover:bg-navy-50 rounded-full transition">Fitur</a>
                <a href="#ulasan" class="px-4 py-2 text-sm font-medium text-slate-600 hover:bg-navy-50 rounded-full transition">Ulasan</a>
                <a href="#tentang" class="px-4 py-2 text-sm font-medium text-slate-600 hover:bg-navy-50 rounded-full transition">Tentang</a>
                <a href="#faq" class="px-4 py-2 text-sm font-medium text-slate-600 hover:bg-navy-50 rounded-full transition">FAQ</a>
            </div>

            <div class="flex items-center gap-2">
                <a href="/login" class="hidden sm:inline-flex px-4 py-2 text-sm font-semibold text-navy-900 hover:bg-navy-50 rounded-full transition">Masuk</a>
                <a href="/login" class="px-4 sm:px-5 py-2 text-xs sm:text-sm font-bold text-white bg-navy-800 rounded-full hover:bg-navy-700 transition shadow-lg shadow-navy-800/20">Mulai →</a>
                <!-- Mobile Hamburger Button -->
                <button type="button" id="mobileMenuBtn" onclick="toggleMobileMenu()" class="md:hidden w-8 h-8 rounded-full bg-navy-50 hover:bg-navy-100 text-navy-900 flex items-center justify-center transition cursor-pointer" aria-label="Toggle Menu">
                    <svg id="hamburgerIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg id="closeMenuIcon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobileMenuDropdown" class="hidden md:hidden mt-2 glass rounded-3xl p-4 shadow-2xl shadow-navy-900/10 border border-white/40 space-y-2 animate-in fade-in duration-200">
            <a href="#beranda" onclick="toggleMobileMenu()" class="block px-4 py-2.5 text-sm font-semibold text-navy-900 hover:bg-navy-50 rounded-2xl transition">Beranda</a>
            <a href="#fitur" onclick="toggleMobileMenu()" class="block px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-navy-50 rounded-2xl transition">Fitur</a>
            <a href="#ulasan" onclick="toggleMobileMenu()" class="block px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-navy-50 rounded-2xl transition">Ulasan</a>
            <a href="#tentang" onclick="toggleMobileMenu()" class="block px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-navy-50 rounded-2xl transition">Tentang</a>
            <a href="#faq" onclick="toggleMobileMenu()" class="block px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-navy-50 rounded-2xl transition">FAQ</a>
            <div class="pt-2 border-t border-slate-100 flex gap-2">
                <a href="/login" class="flex-1 text-center py-2.5 text-xs font-bold text-navy-900 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">Masuk Akun</a>
                <a href="/login" class="flex-1 text-center py-2.5 text-xs font-bold text-white bg-navy-800 rounded-xl hover:bg-navy-700 transition shadow-md">Mulai Belajar</a>
            </div>
        </div>
    </nav>

    <!-- ============ HERO SECTION (Asymmetric + Big Type) ============ -->
    <section id="beranda" class="relative min-h-screen pt-28 sm:pt-32 pb-16 sm:pb-20 overflow-hidden noise-bg">
        <!-- Animated Blobs -->
        <div class="absolute top-20 left-10 w-56 sm:w-72 h-56 sm:h-72 bg-sky-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
        <div class="absolute top-40 right-10 w-56 sm:w-72 h-56 sm:h-72 bg-navy-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob" style="animation-delay: 2s"></div>
        <div class="absolute bottom-20 left-1/2 w-56 sm:w-72 h-56 sm:h-72 bg-sky-200 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob" style="animation-delay: 4s"></div>

        <!-- Grid Pattern Background -->
        <div class="absolute inset-0 grid-pattern opacity-50"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-12 gap-8 items-center">

                <!-- Left: Typography -->
                <div class="lg:col-span-7 space-y-6 sm:space-y-8">
                    <div class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-1.5 sm:py-2 bg-white border-2 border-navy-900 rounded-full shadow-[4px_4px_0_0_#182B4B] hover:shadow-[2px_2px_0_0_#182B4B] hover:translate-x-[2px] hover:translate-y-[2px] transition-all cursor-pointer group">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        <span class="text-[11px] sm:text-xs font-bold text-navy-900">English Club • 2025</span>
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-navy-900 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>

                    <h1 class="font-display font-bold text-4xl sm:text-6xl lg:text-8xl leading-[1.05] sm:leading-[0.9] tracking-tight">
                        Learn <span class="italic text-sky-300">English</span>,<br>
                        <span class="relative inline-block">
                            Grow Your
                            <svg class="absolute -bottom-2 left-0 w-full h-3 sm:h-4 text-sky-300" viewBox="0 0 200 8" preserveAspectRatio="none">
                                <path d="M0,4 Q50,0 100,4 T200,4" stroke="currentColor" stroke-width="3" fill="none"/>
                            </svg>
                        </span>
                        <br><span class="gradient-text">Future.</span>
                    </h1>

                    <p class="text-base sm:text-lg text-slate-600 max-w-lg leading-relaxed">
                        Platform pembelajaran bahasa Inggris yang <span class="font-bold text-navy-900">terstruktur</span>, <span class="font-bold text-navy-900">interaktif</span>, dan <span class="font-bold text-navy-900">menyenangkan</span> untuk anggota English Club.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 items-stretch sm:items-center">
                        <a href="/login" class="group relative px-6 sm:px-8 py-3.5 sm:py-4 bg-navy-800 text-white font-bold rounded-full overflow-hidden shadow-2xl shadow-navy-800/30 hover:shadow-navy-800/50 transition-all text-center">
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                Mulai Belajar
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </span>
                            <div class="absolute inset-0 bg-sky-300 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                        </a>

                        <a href="#fitur" class="group flex items-center justify-center gap-3 px-6 py-3 sm:py-4 font-semibold text-navy-900 hover:text-sky-300 transition">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full border-2 border-navy-900 flex items-center justify-center group-hover:border-sky-300 group-hover:rotate-90 transition-all shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                            </div>
                            <span class="text-sm sm:text-base">Tonton Video</span>
                        </a>
                    </div>

                    <!-- Mini Stats -->
                    <div class="grid grid-cols-3 gap-3 sm:flex sm:flex-wrap sm:gap-8 pt-6 sm:pt-8 border-t border-navy-900/10">
                        <div>
                            <div class="font-display font-bold text-2xl sm:text-3xl text-navy-900">100+</div>
                            <div class="text-[10px] sm:text-xs text-slate-500 uppercase tracking-wider">Member Aktif</div>
                        </div>
                        <div>
                            <div class="font-display font-bold text-2xl sm:text-3xl text-navy-900">40+</div>
                            <div class="text-[10px] sm:text-xs text-slate-500 uppercase tracking-wider">Materi</div>
                        </div>
                        <div>
                            <div class="font-display font-bold text-2xl sm:text-3xl text-navy-900">4</div>
                            <div class="text-[10px] sm:text-xs text-slate-500 uppercase tracking-wider">Divisi</div>
                        </div>
                    </div>
                </div>

                <!-- Right: Floating Cards Composition -->
                <div class="lg:col-span-5 relative h-[500px] hidden lg:block">
                    <!-- Main Card -->
                    <div class="absolute top-10 right-0 w-72 bg-white rounded-3xl p-6 shadow-2xl shadow-navy-900/20 border border-navy-100 animate-float">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-sky-200 to-sky-300 rounded-2xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-navy-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <div>
                                <div class="font-display font-bold text-navy-900">Speaking</div>
                                <div class="text-xs text-slate-500">Bab 1 • 12 Materi</div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="h-2 bg-navy-50 rounded-full overflow-hidden">
                                <div class="h-full w-3/4 bg-gradient-to-r from-navy-800 to-sky-300 rounded-full"></div>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-slate-500">Progress</span>
                                <span class="font-bold text-navy-900">75%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Badge 1 -->
                    <div class="absolute top-0 left-0 bg-navy-800 text-white rounded-2xl p-4 shadow-xl animate-float-delayed">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </div>
                            <div>
                                <div class="text-xs font-bold">Quiz Selesai!</div>
                                <div class="text-[10px] text-sky-200">Skor: 90/100</div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Badge 2 -->
                    <div class="absolute bottom-20 right-10 bg-white rounded-2xl p-4 shadow-xl border border-navy-100 animate-float">
                        <div class="flex items-center gap-3">
                            <div class="flex -space-x-2">
                                <div class="w-8 h-8 rounded-full bg-sky-200 border-2 border-white flex items-center justify-center text-[10px] font-bold text-navy-900">NA</div>
                                <div class="w-8 h-8 rounded-full bg-navy-200 border-2 border-white flex items-center justify-center text-[10px] font-bold text-navy-900">RP</div>
                                <div class="w-8 h-8 rounded-full bg-sky-300 border-2 border-white flex items-center justify-center text-[10px] font-bold text-white">+5</div>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-navy-900">Online Now</div>
                                <div class="text-[10px] text-slate-500">8 siswa belajar</div>
                            </div>
                        </div>
                    </div>

                    <!-- Rotating Badge -->
                    <div class="absolute bottom-0 left-10">
                        <div class="relative w-24 h-24 animate-spin-slow">
                            <svg viewBox="0 0 100 100" class="w-full h-full">
                                <defs>
                                    <path id="circle" d="M 50,50 m -37,0 a 37,37 0 1,1 74,0 a 37,37 0 1,1 -74,0" />
                                </defs>
                                <text class="font-display font-bold text-[11px] fill-navy-800">
                                    <textPath href="#circle">ENGLISH • CLUB • LEARNING • 2025 • </textPath>
                                </text>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-12 h-12 bg-sky-300 rounded-full flex items-center justify-center text-navy-900 font-bold text-lg">🐱</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-navy-900/40">
            <span class="text-[10px] font-bold uppercase tracking-widest">Scroll</span>
            <div class="w-6 h-10 border-2 border-navy-900/30 rounded-full flex justify-center pt-2">
                <div class="w-1 h-2 bg-navy-900 rounded-full animate-bounce"></div>
            </div>
        </div>
    </section>

    <!-- ============ TICKER TAPE ============ -->
    <div class="bg-navy-800 text-white py-3 sm:py-4 overflow-hidden border-y-2 sm:border-y-4 border-navy-900">
        <div class="ticker-tape">
            <div class="marquee-track animate-marquee">
                <div class="flex items-center gap-6 sm:gap-8 px-4 font-display font-bold text-sm sm:text-lg">
                    <span>✦ SPEAKING</span>
                    <span class="text-sky-300">✦ WRITING</span>
                    <span>✦ LISTENING</span>
                    <span class="text-sky-300">✦ READING</span>
                    <span>✦ GRAMMAR</span>
                    <span class="text-sky-300">✦ VOCABULARY</span>
                    <span>✦ PRONUNCIATION</span>
                    <span class="text-sky-300">✦ CONVERSATION</span>
                </div>
                <div class="flex items-center gap-6 sm:gap-8 px-4 font-display font-bold text-sm sm:text-lg">
                    <span>✦ SPEAKING</span>
                    <span class="text-sky-300">✦ WRITING</span>
                    <span>✦ LISTENING</span>
                    <span class="text-sky-300">✦ READING</span>
                    <span>✦ GRAMMAR</span>
                    <span class="text-sky-300">✦ VOCABULARY</span>
                    <span>✦ PRONUNCIATION</span>
                    <span class="text-sky-300">✦ CONVERSATION</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ============ BENTO GRID FEATURES ============ -->
    <section id="fitur" class="py-16 sm:py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10 sm:mb-16 reveal">
                <div class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-1.5 sm:py-2 bg-sky-50 border border-sky-200 rounded-full mb-4">
                    <span class="w-2 h-2 bg-sky-300 rounded-full"></span>
                    <span class="text-xs font-bold text-navy-900 uppercase tracking-wider">Kenapa Englify?</span>
                </div>
                <h2 class="font-display font-bold text-3xl sm:text-5xl lg:text-6xl leading-tight text-navy-900 max-w-3xl">
                    Bukan cuma belajar.<br>
                    <span class="italic text-sky-300">Tapi berkembang.</span>
                </h2>
            </div>

            <!-- Bento Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 auto-rows-auto md:auto-rows-[200px]">

                <!-- Card 1: Large -->
                <div class="bento-card md:col-span-2 md:row-span-2 bg-gradient-to-br from-navy-800 to-navy-900 rounded-3xl p-6 sm:p-8 text-white relative overflow-hidden group min-h-[380px] md:min-h-0 flex flex-col justify-between">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-sky-300/20 rounded-full blur-3xl group-hover:bg-sky-300/30 transition"></div>
                    <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-navy-600/30 rounded-full blur-2xl"></div>

                    <div class="relative z-10 h-full flex flex-col justify-between">
                        <!-- Card Header -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 bg-white/10 backdrop-blur rounded-2xl flex items-center justify-center border border-white/20 shadow-inner">
                                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-sky-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur border border-white/15 text-xs font-semibold text-sky-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                4 Divisi Lengkap
                            </span>
                        </div>

                        <!-- Visual Showcase: 4 Divisi Preview Grid -->
                        <div class="grid grid-cols-2 gap-2.5 sm:gap-3 my-4 sm:my-5">
                            <!-- Divisi Speaking -->
                            <div class="bg-white/10 hover:bg-white/15 backdrop-blur-md border border-white/15 rounded-2xl p-3 sm:p-3.5 transition group/item">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-bold text-sky-200 flex items-center gap-1.5">
                                        <span class="text-sm">🎙️</span> Speaking
                                    </span>
                                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-400/20 text-emerald-300 font-bold">Bab 1</span>
                                </div>
                                <p class="text-[11px] sm:text-xs text-white font-medium truncate">Daily Conversation</p>
                                <div class="w-full bg-white/10 h-1.5 rounded-full mt-2.5 overflow-hidden">
                                    <div class="bg-gradient-to-r from-sky-400 to-emerald-400 h-full rounded-full w-[85%]"></div>
                                </div>
                            </div>

                            <!-- Divisi Writing -->
                            <div class="bg-white/10 hover:bg-white/15 backdrop-blur-md border border-white/15 rounded-2xl p-3 sm:p-3.5 transition group/item">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-bold text-amber-200 flex items-center gap-1.5">
                                        <span class="text-sm">✍️</span> Writing
                                    </span>
                                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-amber-400/20 text-amber-300 font-bold">Bab 2</span>
                                </div>
                                <p class="text-[11px] sm:text-xs text-white font-medium truncate">Paragraph Crafting</p>
                                <div class="w-full bg-white/10 h-1.5 rounded-full mt-2.5 overflow-hidden">
                                    <div class="bg-gradient-to-r from-amber-400 to-sky-300 h-full rounded-full w-[60%]"></div>
                                </div>
                            </div>

                            <!-- Divisi Listening -->
                            <div class="bg-white/10 hover:bg-white/15 backdrop-blur-md border border-white/15 rounded-2xl p-3 sm:p-3.5 transition group/item">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-bold text-teal-200 flex items-center gap-1.5">
                                        <span class="text-sm">🎧</span> Listening
                                    </span>
                                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-teal-400/20 text-teal-300 font-bold">Audio HD</span>
                                </div>
                                <p class="text-[11px] sm:text-xs text-white font-medium truncate">Native Accents Lab</p>
                                <div class="w-full bg-white/10 h-1.5 rounded-full mt-2.5 overflow-hidden">
                                    <div class="bg-gradient-to-r from-teal-400 to-sky-400 h-full rounded-full w-[92%]"></div>
                                </div>
                            </div>

                            <!-- Divisi Reading -->
                            <div class="bg-white/10 hover:bg-white/15 backdrop-blur-md border border-white/15 rounded-2xl p-3 sm:p-3.5 transition group/item">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-bold text-indigo-200 flex items-center gap-1.5">
                                        <span class="text-sm">📚</span> Reading
                                    </span>
                                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-indigo-400/20 text-indigo-300 font-bold">Kuis</span>
                                </div>
                                <p class="text-[11px] sm:text-xs text-white font-medium truncate">Comprehension & Vocab</p>
                                <div class="w-full bg-white/10 h-1.5 rounded-full mt-2.5 overflow-hidden">
                                    <div class="bg-gradient-to-r from-indigo-400 to-sky-300 h-full rounded-full w-[75%]"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div>
                            <h3 class="font-display font-bold text-2xl sm:text-3xl mb-2">Materi Terstruktur</h3>
                            <p class="text-sky-100 text-xs sm:text-sm leading-relaxed">Materi dikelompokkan berdasarkan 4 divisi: Speaking, Writing, Listening, dan Reading. Belajar jadi lebih terarah.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bento-card bg-sky-50 rounded-3xl p-6 relative overflow-hidden group min-h-[160px] md:min-h-0">
                    <div class="absolute -bottom-8 -right-8 w-32 h-32 bg-sky-200 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="text-4xl sm:text-5xl mb-3 sm:mb-4">🎯</div>
                        <h3 class="font-display font-bold text-lg sm:text-xl text-navy-900 mb-1">Belajar Terarah</h3>
                        <p class="text-xs text-slate-600">Fokus pada level kemampuanmu</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bento-card bg-navy-50 rounded-3xl p-6 relative overflow-hidden group min-h-[160px] md:min-h-0">
                    <div class="absolute top-4 right-4 font-display font-bold text-5xl sm:text-6xl text-navy-900/10 group-hover:text-navy-900/20 transition">01</div>
                    <div class="relative z-10 h-full flex flex-col justify-between">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white rounded-xl flex items-center justify-center shadow-lg mb-4 md:mb-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-navy-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-display font-bold text-base sm:text-lg text-navy-900">Quiz Interaktif</h3>
                            <p class="text-xs text-slate-600 mt-1">Uji pemahaman setiap bab</p>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="bento-card md:col-span-2 bg-gradient-to-br from-sky-100 to-white rounded-3xl p-6 relative overflow-hidden group border border-sky-200 min-h-[180px] md:min-h-0">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 h-full items-center">
                        <div>
                            <div class="text-3xl sm:text-4xl mb-2 sm:mb-3">📊</div>
                            <h3 class="font-display font-bold text-lg sm:text-xl text-navy-900 mb-1">Progress Tracking</h3>
                            <p class="text-xs text-slate-600">Pantau perkembangan belajarmu secara real-time</p>
                        </div>
                        <div class="bg-white rounded-2xl p-4 shadow-lg border border-sky-100">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-bold text-navy-900">Minggu Ini</span>
                                <span class="text-xs font-bold text-emerald-600">+23%</span>
                            </div>
                            <div class="flex items-end gap-1 h-16">
                                <div class="flex-1 bg-sky-100 rounded-t" style="height: 40%"></div>
                                <div class="flex-1 bg-sky-200 rounded-t" style="height: 60%"></div>
                                <div class="flex-1 bg-sky-300 rounded-t" style="height: 45%"></div>
                                <div class="flex-1 bg-navy-800 rounded-t" style="height: 85%"></div>
                                <div class="flex-1 bg-sky-300 rounded-t" style="height: 70%"></div>
                                <div class="flex-1 bg-sky-200 rounded-t" style="height: 90%"></div>
                                <div class="flex-1 bg-sky-100 rounded-t" style="height: 55%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="bento-card bg-white border-2 border-navy-900 rounded-3xl p-6 relative overflow-hidden group hover:bg-navy-900 hover:text-white transition-colors min-h-[160px] md:min-h-0">
                    <div class="h-full flex flex-col justify-between">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-navy-50 group-hover:bg-white/10 rounded-xl flex items-center justify-center transition mb-4 md:mb-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-navy-900 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-display font-bold text-base sm:text-lg">Gratis untuk Member</h3>
                            <p class="text-xs text-slate-600 group-hover:text-slate-300 transition">Semua fitur tanpa biaya tambahan</p>
                        </div>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="bento-card bg-gradient-to-br from-navy-100 to-sky-50 rounded-3xl p-6 relative overflow-hidden group min-h-[160px] md:min-h-0">
                    <div class="h-full flex flex-col justify-between">
                        <div class="flex items-center gap-2 mb-4 md:mb-0">
                            <div class="flex -space-x-2">
                                <div class="w-8 h-8 rounded-full bg-sky-300 border-2 border-white"></div>
                                <div class="w-8 h-8 rounded-full bg-navy-800 border-2 border-white"></div>
                                <div class="w-8 h-8 rounded-full bg-sky-200 border-2 border-white"></div>
                            </div>
                            <span class="text-xs font-bold text-navy-900">100+ users</span>
                        </div>
                        <div>
                            <h3 class="font-display font-bold text-base sm:text-lg text-navy-900">Komunitas Aktif</h3>
                            <p class="text-xs text-slate-600 mt-1">Belajar bareng teman-teman</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ DIVISI SHOWCASE (Horizontal Scroll) ============ -->
    <section class="py-16 sm:py-24 bg-navy-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8 sm:mb-12 reveal">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 sm:gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-1.5 sm:py-2 bg-white border border-navy-200 rounded-full mb-3 sm:mb-4">
                        <span class="text-xs font-bold text-navy-900 uppercase tracking-wider">4 Divisi Pembelajaran</span>
                    </div>
                    <h2 class="font-display font-bold text-3xl sm:text-5xl lg:text-6xl text-navy-900 leading-tight">
                        Pilih jalur<br>belajarmu.
                    </h2>
                </div>
                <p class="text-slate-600 text-sm sm:text-base max-w-md">Setiap divisi punya materi, latihan, dan quiz yang disesuaikan dengan skill yang ingin kamu kuasai.</p>
            </div>
        </div>

        <!-- Horizontal Scroll Cards -->
        <div class="no-scrollbar overflow-x-auto pb-6 sm:pb-8">
            <div class="flex gap-4 sm:gap-6 px-4 sm:px-6 lg:px-8 min-w-max">

                <!-- Divisi 1 -->
                <div class="w-72 sm:w-80 bg-white rounded-3xl p-6 sm:p-8 border border-navy-100 hover:border-navy-900 transition-all group hover:-translate-y-2 duration-300">
                    <div class="flex items-center justify-between mb-6 sm:mb-8">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-sky-200 to-sky-300 rounded-2xl flex items-center justify-center text-2xl sm:text-3xl group-hover:rotate-12 transition-transform">🎤</div>
                        <span class="font-display font-bold text-4xl sm:text-5xl text-navy-100 group-hover:text-navy-200 transition">01</span>
                    </div>
                    <h3 class="font-display font-bold text-xl sm:text-2xl text-navy-900 mb-2">Speaking</h3>
                    <p class="text-xs sm:text-sm text-slate-600 mb-6">Latih kemampuan berbicaramu dengan materi pronunciation dan conversation.</p>
                    <div class="flex items-center justify-between pt-4 border-t border-navy-50">
                        <span class="text-xs font-bold text-navy-900">12 Materi</span>
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-navy-50 group-hover:bg-navy-900 flex items-center justify-center transition">
                            <svg class="w-4 h-4 text-navy-900 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Divisi 2 -->
                <div class="w-72 sm:w-80 bg-navy-800 rounded-3xl p-6 sm:p-8 text-white hover:-translate-y-2 transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-6 sm:mb-8">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 bg-white/10 backdrop-blur rounded-2xl flex items-center justify-center text-2xl sm:text-3xl group-hover:rotate-12 transition-transform border border-white/20">✍️</div>
                        <span class="font-display font-bold text-4xl sm:text-5xl text-white/10 group-hover:text-white/20 transition">02</span>
                    </div>
                    <h3 class="font-display font-bold text-xl sm:text-2xl mb-2">Writing</h3>
                    <p class="text-xs sm:text-sm text-sky-100 mb-6">Tingkatkan kemampuan menulis dari paragraph hingga essay.</p>
                    <div class="flex items-center justify-between pt-4 border-t border-white/10">
                        <span class="text-xs font-bold">10 Materi</span>
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white/10 group-hover:bg-white group-hover:text-navy-900 flex items-center justify-center transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Divisi 3 -->
                <div class="w-72 sm:w-80 bg-white rounded-3xl p-6 sm:p-8 border border-navy-100 hover:border-navy-900 transition-all group hover:-translate-y-2 duration-300">
                    <div class="flex items-center justify-between mb-6 sm:mb-8">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-navy-100 to-navy-200 rounded-2xl flex items-center justify-center text-2xl sm:text-3xl group-hover:rotate-12 transition-transform">🎧</div>
                        <span class="font-display font-bold text-4xl sm:text-5xl text-navy-100 group-hover:text-navy-200 transition">03</span>
                    </div>
                    <h3 class="font-display font-bold text-xl sm:text-2xl text-navy-900 mb-2">Listening</h3>
                    <p class="text-xs sm:text-sm text-slate-600 mb-6">Asah pendengaran dengan audio native speaker dan transcript.</p>
                    <div class="flex items-center justify-between pt-4 border-t border-navy-50">
                        <span class="text-xs font-bold text-navy-900">8 Materi</span>
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-navy-50 group-hover:bg-navy-900 flex items-center justify-center transition">
                            <svg class="w-4 h-4 text-navy-900 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Divisi 4 -->
                <div class="w-72 sm:w-80 bg-gradient-to-br from-sky-200 to-sky-100 rounded-3xl p-6 sm:p-8 hover:-translate-y-2 transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-6 sm:mb-8">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 bg-white rounded-2xl flex items-center justify-center text-2xl sm:text-3xl group-hover:rotate-12 transition-transform shadow-lg">📖</div>
                        <span class="font-display font-bold text-4xl sm:text-5xl text-navy-900/10 group-hover:text-navy-900/20 transition">04</span>
                    </div>
                    <h3 class="font-display font-bold text-xl sm:text-2xl text-navy-900 mb-2">Reading</h3>
                    <p class="text-xs sm:text-sm text-navy-700 mb-6">Baca teks berbagai genre dan tingkatkan comprehension skill.</p>
                    <div class="flex items-center justify-between pt-4 border-t border-navy-900/10">
                        <span class="text-xs font-bold text-navy-900">10 Materi</span>
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white group-hover:bg-navy-900 flex items-center justify-center transition shadow-lg">
                            <svg class="w-4 h-4 text-navy-900 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ============ TESTIMONIALS (Marquee) ============ -->
    <section class="py-16 sm:py-24 bg-white overflow-hidden" id="ulasan">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8 sm:mb-12 reveal">
            <div class="text-center">
                <div class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-1.5 sm:py-2 bg-sky-50 border border-sky-200 rounded-full mb-3 sm:mb-4">
                    <span class="text-xs font-bold text-navy-900 uppercase tracking-wider">Apa Kata Mereka</span>
                </div>
                <h2 class="font-display font-bold text-3xl sm:text-5xl lg:text-6xl text-navy-900 leading-tight mb-3 sm:mb-4">
                    Loved by <span class="italic text-sky-400">100+ students</span>
                </h2>
                <p class="text-slate-600 max-w-xl mx-auto text-xs sm:text-base mb-6">
                    Cerita dan ulasan nyata dari siswa yang belajar, berproses, dan berkembang bersama komunitas English Club.
                </p>

                <!-- Tombol Beri Ulasan & Rating Badge -->
                <div class="flex flex-wrap items-center justify-center gap-2.5 sm:gap-4">
                    <div class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 sm:py-2.5 bg-amber-50 border border-amber-200 rounded-full text-xs sm:text-sm font-semibold text-amber-900 shadow-sm">
                        <span class="text-amber-500">★★★★★</span>
                        <span>4.9 / 5.0 Rating Kepuasan</span>
                    </div>

                    <button type="button" onclick="openReviewModal()" class="inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 bg-navy-900 hover:bg-navy-800 text-white font-bold text-xs sm:text-sm rounded-full shadow-lg shadow-navy-900/20 hover:scale-105 active:scale-95 transition-all cursor-pointer">
                        <svg class="w-4 h-4 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        <span>Tulis Review Kamu</span>
                    </button>
                </div>
            </div>
        </div>

        @if(session('review_success'))
            <div class="max-w-xl mx-auto px-6 mb-8 reveal active">
                <div class="bg-emerald-50 border-2 border-emerald-300 text-emerald-900 rounded-3xl p-5 shadow-xl space-y-3">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-white flex items-center justify-center flex-shrink-0 text-2xl font-bold shadow-md">✓</div>
                        <div class="text-sm">
                            <p class="font-bold text-emerald-950 text-base">Ulasan Berhasil Dikirim! 🎉</p>
                            <p class="text-emerald-800 mt-0.5">{{ session('review_success') }}</p>
                        </div>
                    </div>

                    @if(session('latest_review'))
                        @php $lr = session('latest_review'); @endphp
                        <div class="mt-3 pt-3 border-t border-emerald-200/80 bg-white/70 rounded-2xl p-4 border border-emerald-100 shadow-inner">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-bold text-emerald-900 flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                                    Ulasan Terbarumu (Aktif di Paling Depan):
                                </span>
                                <div class="text-amber-400 text-xs font-bold">
                                    @for($s = 1; $s <= 5; $s++)
                                        <span>{{ $s <= ($lr->rating ?? 5) ? '★' : '☆' }}</span>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-xs sm:text-sm text-navy-900 italic font-medium leading-relaxed">
                                "{{ $lr->pesan }}"
                            </p>
                            <div class="flex items-center gap-2 mt-2 pt-2 border-t border-emerald-100 text-[11px] text-slate-600">
                                <span class="font-bold text-navy-900">{{ $lr->nama }}</span>
                                <span>•</span>
                                <span>{{ $lr->role }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @php
            $allReviews = isset($reviews) && $reviews->isNotEmpty() ? $reviews : collect([
                (object)[
                    'nama' => 'Nur Aprilia',
                    'role' => 'Siswa English Club',
                    'rating' => 5,
                    'pesan' => 'Englify sangat membantu aku dalam belajar bahasa Inggris. Materinya lebih mudah dipahami karena sudah dikelompokkan berdasarkan divisi.',
                    'initials' => 'NA',
                    'created_at' => null,
                ],
                (object)[
                    'nama' => 'Ricky Pratama',
                    'role' => 'Siswa English Club',
                    'rating' => 5,
                    'pesan' => 'Platform yang sangat membantu untuk meningkatkan kemampuan bahasa Inggris. Fitur-fiturnya lengkap dan mudah digunakan.',
                    'initials' => 'RP',
                    'created_at' => null,
                ],
                (object)[
                    'nama' => 'Siti Rahma',
                    'role' => 'Siswa English Club',
                    'rating' => 5,
                    'pesan' => 'Saya jadi lebih percaya diri dalam menggunakan bahasa Inggris, terutama untuk speaking. Terima kasih Englify!',
                    'initials' => 'SR',
                    'created_at' => null,
                ],
                (object)[
                    'nama' => 'Andi Firmansyah',
                    'role' => 'Siswa English Club',
                    'rating' => 5,
                    'pesan' => 'Quiz-quiznya seru dan menantang. Bikin belajar jadi nggak bosen sama sekali!',
                    'initials' => 'AF',
                    'created_at' => null,
                ],
                (object)[
                    'nama' => 'Dewi Fitriani',
                    'role' => 'Siswa English Club',
                    'rating' => 5,
                    'pesan' => 'Materinya lengkap dan up-to-date. Recommended banget buat yang mau improve English skill!',
                    'initials' => 'DF',
                    'created_at' => null,
                ],
                (object)[
                    'nama' => 'Budi Hartono',
                    'role' => 'Siswa English Club',
                    'rating' => 5,
                    'pesan' => 'Progress tracking-nya bikin aku termotivasi buat terus belajar setiap hari!',
                    'initials' => 'BH',
                    'created_at' => null,
                ],
                (object)[
                    'nama' => 'Lina Marlina',
                    'role' => 'Siswa English Club',
                    'rating' => 5,
                    'pesan' => 'UI-nya clean dan mudah dipakai. Nggak ribet buat navigate antar materi.',
                    'initials' => 'LM',
                    'created_at' => null,
                ],
                (object)[
                    'nama' => 'Rudi Santoso',
                    'role' => 'Siswa English Club',
                    'rating' => 5,
                    'pesan' => 'Referensi pembelajarannya lengkap banget. Jadi gampang buat deep dive ke topik tertentu.',
                    'initials' => 'RS',
                    'created_at' => null,
                ],
            ]);

            $row1Reviews = $allReviews->filter(fn($r, $k) => $k % 2 === 0)->values();
            $row2Reviews = $allReviews->filter(fn($r, $k) => $k % 2 === 1)->values();

            // Minimal 4 cards per row agar seamless loop tidak kosong
            while ($row1Reviews->count() < 4) {
                $row1Reviews = $row1Reviews->concat($row1Reviews);
            }
            while ($row2Reviews->count() < 4) {
                $row2Reviews = $row2Reviews->concat($row2Reviews);
            }

            $avatarGradients = [
                ['from' => 'from-sky-200', 'to' => 'to-sky-300', 'text' => 'text-navy-900'],
                ['from' => 'from-navy-200', 'to' => 'to-navy-300', 'text' => 'text-navy-900'],
                ['from' => 'from-sky-300', 'to' => 'to-sky-400', 'text' => 'text-white'],
                ['from' => 'from-navy-800', 'to' => 'to-navy-900', 'text' => 'text-white'],
                ['from' => 'from-amber-200', 'to' => 'to-amber-300', 'text' => 'text-navy-900'],
            ];
        @endphp

        <!-- Marquee Row 1 -->
        <div class="relative mb-4 sm:mb-6">
            <div class="absolute left-0 top-0 bottom-0 w-12 sm:w-32 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"></div>
            <div class="absolute right-0 top-0 bottom-0 w-12 sm:w-32 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"></div>
            <div class="ticker-tape">
                <div class="marquee-track animate-marquee">
                    <!-- Set 1 -->
                    <div class="flex gap-4 sm:gap-6 px-2 sm:px-3">
                        @foreach($row1Reviews as $idx => $item)
                            @php
                                $grad = $avatarGradients[$idx % count($avatarGradients)];
                                $isSkyCard = ($idx % 2 === 1);
                                $cardBg = $isSkyCard ? 'bg-sky-50/70 border-sky-100' : 'bg-navy-50/70 border-navy-100';
                            @endphp
                            <div class="testimonial-card w-[280px] sm:w-88 min-h-[200px] sm:min-h-[220px] {{ $cardBg }} rounded-2xl sm:rounded-3xl p-5 sm:p-6 border flex-shrink-0 flex flex-col justify-between whitespace-normal break-words shadow-sm hover:shadow-md transition">
                                <div>
                                    <div class="flex items-center justify-between gap-2 mb-2.5 sm:mb-3">
                                        <div class="flex items-center gap-0.5 text-amber-400 text-xs sm:text-sm">
                                            @for($s = 1; $s <= 5; $s++)
                                                <span class="{{ $s <= $item->rating ? 'text-amber-400' : 'text-slate-300' }}">★</span>
                                            @endfor
                                        </div>
                                        @if($item->created_at && \Carbon\Carbon::parse($item->created_at)->gt(now()->subDays(3)))
                                            <span class="inline-flex items-center gap-1 text-[9px] sm:text-[10px] font-bold px-2 py-0.5 rounded-full bg-sky-200 text-navy-900 shadow-xs">
                                                <span class="w-1.5 h-1.5 rounded-full bg-sky-600 animate-pulse"></span>
                                                Baru
                                            </span>
                                        @endif
                                    </div>
                                    <p class="review-text text-xs sm:text-sm text-navy-900 mb-3 sm:mb-4 leading-relaxed whitespace-normal break-words">
                                        "{{ $item->pesan }}"
                                    </p>
                                </div>
                                <div class="flex items-center gap-3 pt-3 border-t border-navy-900/5">
                                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br {{ $grad['from'] }} {{ $grad['to'] }} flex items-center justify-center {{ $grad['text'] }} font-bold text-xs sm:text-sm flex-shrink-0 shadow-xs">
                                        {{ $item->initials }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="font-bold text-xs sm:text-sm text-navy-900 truncate">{{ $item->nama }}</div>
                                        <div class="text-[11px] sm:text-xs text-slate-500 truncate">{{ $item->role }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Set 2 (Duplicate for seamless loop) -->
                    <div class="flex gap-4 sm:gap-6 px-2 sm:px-3">
                        @foreach($row1Reviews as $idx => $item)
                            @php
                                $grad = $avatarGradients[$idx % count($avatarGradients)];
                                $isSkyCard = ($idx % 2 === 1);
                                $cardBg = $isSkyCard ? 'bg-sky-50/70 border-sky-100' : 'bg-navy-50/70 border-navy-100';
                            @endphp
                            <div class="testimonial-card w-[280px] sm:w-88 min-h-[200px] sm:min-h-[220px] {{ $cardBg }} rounded-2xl sm:rounded-3xl p-5 sm:p-6 border flex-shrink-0 flex flex-col justify-between whitespace-normal break-words shadow-sm hover:shadow-md transition">
                                <div>
                                    <div class="flex items-center justify-between gap-2 mb-2.5 sm:mb-3">
                                        <div class="flex items-center gap-0.5 text-amber-400 text-xs sm:text-sm">
                                            @for($s = 1; $s <= 5; $s++)
                                                <span class="{{ $s <= $item->rating ? 'text-amber-400' : 'text-slate-300' }}">★</span>
                                            @endfor
                                        </div>
                                        @if($item->created_at && \Carbon\Carbon::parse($item->created_at)->gt(now()->subDays(3)))
                                            <span class="inline-flex items-center gap-1 text-[9px] sm:text-[10px] font-bold px-2 py-0.5 rounded-full bg-sky-200 text-navy-900 shadow-xs">
                                                <span class="w-1.5 h-1.5 rounded-full bg-sky-600 animate-pulse"></span>
                                                Baru
                                            </span>
                                        @endif
                                    </div>
                                    <p class="review-text text-xs sm:text-sm text-navy-900 mb-3 sm:mb-4 leading-relaxed whitespace-normal break-words">
                                        "{{ $item->pesan }}"
                                    </p>
                                </div>
                                <div class="flex items-center gap-3 pt-3 border-t border-navy-900/5">
                                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br {{ $grad['from'] }} {{ $grad['to'] }} flex items-center justify-center {{ $grad['text'] }} font-bold text-xs sm:text-sm flex-shrink-0 shadow-xs">
                                        {{ $item->initials }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="font-bold text-xs sm:text-sm text-navy-900 truncate">{{ $item->nama }}</div>
                                        <div class="text-[11px] sm:text-xs text-slate-500 truncate">{{ $item->role }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Marquee Row 2 (Reverse) -->
        <div class="relative">
            <div class="absolute left-0 top-0 bottom-0 w-12 sm:w-32 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"></div>
            <div class="absolute right-0 top-0 bottom-0 w-12 sm:w-32 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"></div>
            <div class="ticker-tape">
                <div class="marquee-track" style="animation: marquee 35s linear infinite reverse;">
                    <!-- Set 1 -->
                    <div class="flex gap-4 sm:gap-6 px-2 sm:px-3">
                        @foreach($row2Reviews as $idx => $item)
                            @php
                                $grad = $avatarGradients[($idx + 2) % count($avatarGradients)];
                            @endphp
                            <div class="testimonial-card w-[280px] sm:w-88 min-h-[200px] sm:min-h-[220px] bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 border-2 border-navy-900 flex-shrink-0 shadow-[4px_4px_0_0_#182B4B] sm:shadow-[6px_6px_0_0_#182B4B] flex flex-col justify-between whitespace-normal break-words hover:translate-y-[-2px] transition">
                                <div>
                                    <div class="flex items-center justify-between gap-2 mb-2.5 sm:mb-3">
                                        <div class="flex items-center gap-0.5 text-amber-400 text-xs sm:text-sm">
                                            @for($s = 1; $s <= 5; $s++)
                                                <span class="{{ $s <= $item->rating ? 'text-amber-400' : 'text-slate-300' }}">★</span>
                                            @endfor
                                        </div>
                                        @if($item->created_at && \Carbon\Carbon::parse($item->created_at)->gt(now()->subDays(3)))
                                            <span class="inline-flex items-center gap-1 text-[9px] sm:text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-200 text-navy-900 shadow-xs">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-600 animate-pulse"></span>
                                                Baru
                                            </span>
                                        @endif
                                    </div>
                                    <p class="review-text text-xs sm:text-sm text-navy-900 mb-3 sm:mb-4 leading-relaxed whitespace-normal break-words">
                                        "{{ $item->pesan }}"
                                    </p>
                                </div>
                                <div class="flex items-center gap-3 pt-3 border-t border-navy-900/10">
                                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br {{ $grad['from'] }} {{ $grad['to'] }} flex items-center justify-center {{ $grad['text'] }} font-bold text-xs sm:text-sm flex-shrink-0 shadow-xs">
                                        {{ $item->initials }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="font-bold text-xs sm:text-sm text-navy-900 truncate">{{ $item->nama }}</div>
                                        <div class="text-[11px] sm:text-xs text-slate-500 truncate">{{ $item->role }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Set 2 (Duplicate for seamless loop) -->
                    <div class="flex gap-4 sm:gap-6 px-2 sm:px-3">
                        @foreach($row2Reviews as $idx => $item)
                            @php
                                $grad = $avatarGradients[($idx + 2) % count($avatarGradients)];
                            @endphp
                            <div class="testimonial-card w-[280px] sm:w-88 min-h-[200px] sm:min-h-[220px] bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 border-2 border-navy-900 flex-shrink-0 shadow-[4px_4px_0_0_#182B4B] sm:shadow-[6px_6px_0_0_#182B4B] flex flex-col justify-between whitespace-normal break-words hover:translate-y-[-2px] transition">
                                <div>
                                    <div class="flex items-center justify-between gap-2 mb-2.5 sm:mb-3">
                                        <div class="flex items-center gap-0.5 text-amber-400 text-xs sm:text-sm">
                                            @for($s = 1; $s <= 5; $s++)
                                                <span class="{{ $s <= $item->rating ? 'text-amber-400' : 'text-slate-300' }}">★</span>
                                            @endfor
                                        </div>
                                        @if($item->created_at && \Carbon\Carbon::parse($item->created_at)->gt(now()->subDays(3)))
                                            <span class="inline-flex items-center gap-1 text-[9px] sm:text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-200 text-navy-900 shadow-xs">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-600 animate-pulse"></span>
                                                Baru
                                            </span>
                                        @endif
                                    </div>
                                    <p class="review-text text-xs sm:text-sm text-navy-900 mb-3 sm:mb-4 leading-relaxed whitespace-normal break-words">
                                        "{{ $item->pesan }}"
                                    </p>
                                </div>
                                <div class="flex items-center gap-3 pt-3 border-t border-navy-900/10">
                                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br {{ $grad['from'] }} {{ $grad['to'] }} flex items-center justify-center {{ $grad['text'] }} font-bold text-xs sm:text-sm flex-shrink-0 shadow-xs">
                                        {{ $item->initials }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="font-bold text-xs sm:text-sm text-navy-900 truncate">{{ $item->nama }}</div>
                                        <div class="text-[11px] sm:text-xs text-slate-500 truncate">{{ $item->role }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ BIG STATS SECTION (Tentang) ============ -->
    <section class="py-16 sm:py-24 bg-navy-900 text-white relative overflow-hidden scroll-mt-20" id="tentang">
        <div class="absolute inset-0 grid-pattern opacity-10"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-sky-300/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-navy-700/30 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-8 sm:gap-12 items-center mb-8 sm:mb-16">
                <div>
                    <div class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-1.5 sm:py-2 bg-white/10 backdrop-blur border border-white/20 rounded-full mb-4 sm:mb-6">
                        <span class="w-2 h-2 bg-sky-300 rounded-full"></span>
                        <span class="text-xs font-bold text-white uppercase tracking-wider">Tentang Englify</span>
                    </div>
                    <h2 class="font-display font-bold text-3xl sm:text-5xl lg:text-7xl leading-[1.0] sm:leading-[0.9] mb-4 sm:mb-6">
                        Built for<br>
                        <span class="italic text-sky-300">learners</span>,<br>
                        by learners.
                    </h2>
                    <p class="text-sky-100 text-sm sm:text-lg max-w-md">Englify dibuat oleh dan untuk anggota English Club yang pengen belajar English dengan cara yang lebih fun.</p>
                </div>
                <div class="grid grid-cols-2 gap-3 sm:gap-6">
                    <div class="bg-white/5 backdrop-blur border border-white/10 rounded-2xl sm:rounded-3xl p-4 sm:p-8 hover:bg-white/10 transition group">
                        <div class="font-display font-bold text-3xl sm:text-5xl lg:text-6xl mb-1 sm:mb-2 group-hover:text-sky-300 transition">100+</div>
                        <div class="text-xs sm:text-sm text-sky-100">Member Aktif</div>
                    </div>
                    <div class="bg-white/5 backdrop-blur border border-white/10 rounded-2xl sm:rounded-3xl p-4 sm:p-8 hover:bg-white/10 transition group sm:mt-8">
                        <div class="font-display font-bold text-3xl sm:text-5xl lg:text-6xl mb-1 sm:mb-2 group-hover:text-sky-300 transition">4</div>
                        <div class="text-xs sm:text-sm text-sky-100">Divisi Belajar</div>
                    </div>
                    <div class="bg-white/5 backdrop-blur border border-white/10 rounded-2xl sm:rounded-3xl p-4 sm:p-8 hover:bg-white/10 transition group">
                        <div class="font-display font-bold text-3xl sm:text-5xl lg:text-6xl mb-1 sm:mb-2 group-hover:text-sky-300 transition">40+</div>
                        <div class="text-xs sm:text-sm text-sky-100">Materi Lengkap</div>
                    </div>
                    <div class="bg-white/5 backdrop-blur border border-white/10 rounded-2xl sm:rounded-3xl p-4 sm:p-8 hover:bg-white/10 transition group sm:mt-8">
                        <div class="font-display font-bold text-3xl sm:text-5xl lg:text-6xl mb-1 sm:mb-2 group-hover:text-sky-300 transition">10</div>
                        <div class="text-xs sm:text-sm text-sky-100">Quiz per Bab</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ FAQ SECTION ============ -->
    <section id="faq" class="py-16 sm:py-24 bg-navy-50/60 relative overflow-hidden scroll-mt-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-10 sm:mb-14">
                <div class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-1.5 sm:py-2 bg-white border border-navy-200 rounded-full mb-3 sm:mb-4 shadow-xs">
                    <span class="w-2 h-2 bg-sky-400 rounded-full"></span>
                    <span class="text-xs font-bold text-navy-900 uppercase tracking-wider">Frequently Asked Questions</span>
                </div>
                <h2 class="font-display font-bold text-3xl sm:text-5xl text-navy-900 leading-tight">
                    Pertanyaan yang Sering<br><span class="italic text-sky-400">Diajukan.</span>
                </h2>
                <p class="text-slate-600 text-sm sm:text-base max-w-lg mx-auto mt-3">Punya pertanyaan seputar akun, materi, atau kegiatan pembelajaran? Temukan jawabannya di sini.</p>
            </div>

            <!-- FAQ Accordions -->
            <div class="space-y-3.5 sm:space-y-4">
                <!-- FAQ 1 -->
                <details class="group bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 border border-navy-100/80 shadow-xs hover:border-navy-200 transition">
                    <summary class="flex justify-between items-center font-bold text-base sm:text-lg text-navy-900 cursor-pointer list-none select-none">
                        <span>Bagaimana cara mendapatkan akun Englify?</span>
                        <span class="w-8 h-8 rounded-full bg-navy-50 flex items-center justify-center shrink-0 ml-4 group-open:rotate-180 group-hover:bg-navy-100 transition-all duration-300">
                            <svg class="w-4 h-4 text-navy-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <p class="text-slate-600 text-xs sm:text-sm mt-3 leading-relaxed border-t border-slate-100 pt-3">
                        Akun pembelajaran Englify dibuat dan disediakan langsung oleh <b>Administrator</b> sekolah atau pengurus English Club. Kamu dapat menghubungi admin divisi atau guru pembina untuk memperoleh username dan kata sandi akunmu.
                    </p>
                </details>

                <!-- FAQ 2 -->
                <details class="group bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 border border-navy-100/80 shadow-xs hover:border-navy-200 transition">
                    <summary class="flex justify-between items-center font-bold text-base sm:text-lg text-navy-900 cursor-pointer list-none select-none">
                        <span>Apakah seluruh materi 4 divisi dapat diakses gratis?</span>
                        <span class="w-8 h-8 rounded-full bg-navy-50 flex items-center justify-center shrink-0 ml-4 group-open:rotate-180 group-hover:bg-navy-100 transition-all duration-300">
                            <svg class="w-4 h-4 text-navy-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <p class="text-slate-600 text-xs sm:text-sm mt-3 leading-relaxed border-t border-slate-100 pt-3">
                        Ya, betul! Seluruh modul di 4 divisi (Speaking, Writing, Listening, Reading) beserta kuis interaktifnya bebas diakses tanpa biaya bagi setiap siswa anggota English Club yang telah terdaftar.
                    </p>
                </details>

                <!-- FAQ 3 -->
                <details class="group bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 border border-navy-100/80 shadow-xs hover:border-navy-200 transition">
                    <summary class="flex justify-between items-center font-bold text-base sm:text-lg text-navy-900 cursor-pointer list-none select-none">
                        <span>Bagaimana jika saya lupa kata sandi akun saya?</span>
                        <span class="w-8 h-8 rounded-full bg-navy-50 flex items-center justify-center shrink-0 ml-4 group-open:rotate-180 group-hover:bg-navy-100 transition-all duration-300">
                            <svg class="w-4 h-4 text-navy-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <p class="text-slate-600 text-xs sm:text-sm mt-3 leading-relaxed border-t border-slate-100 pt-3">
                        Silakan hubungi administrator sekolah atau admin divisi kamu. Admin memiliki akses untuk mereset kata sandi akunmu, dan setelahnya kamu dapat login lalu membuat password baru yang aman.
                    </p>
                </details>

                <!-- FAQ 4 -->
                <details class="group bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 border border-navy-100/80 shadow-xs hover:border-navy-200 transition">
                    <summary class="flex justify-between items-center font-bold text-base sm:text-lg text-navy-900 cursor-pointer list-none select-none">
                        <span>Apakah progres dan kuis tersimpan secara otomatis?</span>
                        <span class="w-8 h-8 rounded-full bg-navy-50 flex items-center justify-center shrink-0 ml-4 group-open:rotate-180 group-hover:bg-navy-100 transition-all duration-300">
                            <svg class="w-4 h-4 text-navy-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <p class="text-slate-600 text-xs sm:text-sm mt-3 leading-relaxed border-t border-slate-100 pt-3">
                        Ya. Setiap kali kamu menyelesaikan materi atau kuis, skor dan persentase progresmu akan langsung tersimpan di sistem, dapat dilihat di dashboard siswa, dan dipantau oleh admin divisi.
                    </p>
                </details>
            </div>
        </div>
    </section>

    <!-- ============ CTA SECTION (Bold) ============ -->
    <section class="py-16 sm:py-28 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="bg-gradient-to-br from-navy-800 via-navy-700 to-navy-900 rounded-3xl sm:rounded-[3rem] p-6 sm:p-12 lg:p-20 relative overflow-hidden">
                <!-- Decorative -->
                <div class="absolute top-0 right-0 w-96 h-96 bg-sky-300/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-72 h-72 bg-white/5 rounded-full blur-3xl"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] border border-white/5 rounded-full"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] border border-white/5 rounded-full"></div>

                <div class="relative z-10 text-center max-w-3xl mx-auto">
                    <div class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-1.5 sm:py-2 bg-white/10 backdrop-blur border border-white/20 rounded-full mb-6 sm:mb-8">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                        <span class="text-xs font-bold text-white uppercase tracking-wider">Ready to start?</span>
                    </div>

                    <h2 class="font-display font-bold text-3xl sm:text-5xl lg:text-7xl text-white leading-[1.05] sm:leading-[0.95] mb-4 sm:mb-6">
                        Siap mulai<br>
                        <span class="italic text-sky-300">perjalanan</span><br>
                        belajarmu?
                    </h2>

                    <p class="text-sky-100 text-sm sm:text-lg mb-8 sm:mb-10 max-w-xl mx-auto">Jangan cuma tahu. Yuk mulai belajar dan tingkatkan kemampuan Bahasa Inggrismu bersama Englify.</p>

                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center items-stretch sm:items-center">
                        <a href="/login" class="group relative px-6 sm:px-8 py-3.5 sm:py-4 bg-white text-navy-900 font-bold rounded-full overflow-hidden shadow-2xl hover:shadow-white/20 transition-all text-center">
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                Masuk & Mulai Belajar
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </span>
                        </a>
                        <a href="#fitur" class="px-6 sm:px-8 py-3.5 sm:py-4 bg-white/10 backdrop-blur text-white font-bold rounded-full border border-white/20 hover:bg-white/20 transition text-center">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ FOOTER (Asymmetric) ============ -->
    <footer class="bg-navy-950 text-white pt-14 sm:pt-20 pb-8 relative overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-sky-300/5 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-12 gap-8 lg:gap-12 mb-12 sm:mb-16">
                <!-- Big Logo -->
                <div class="col-span-2 md:col-span-4 lg:col-span-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white rounded-2xl flex items-center justify-center">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-navy-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="font-display font-bold text-2xl sm:text-3xl">englify</span>
                    </div>
                    <p class="text-slate-400 text-xs sm:text-sm max-w-md leading-relaxed mb-6 sm:mb-8">Platform pembelajaran bahasa Inggris untuk English Club. Belajar lebih mudah, terstruktur, dan menyenangkan.</p>
                    <div class="flex gap-2.5 sm:gap-3">
                        <a href="#" class="w-10 h-10 sm:w-12 sm:h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center hover:bg-white hover:text-navy-900 transition">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 sm:w-12 sm:h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center hover:bg-white hover:text-navy-900 transition">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 sm:w-12 sm:h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center hover:bg-white hover:text-navy-900 transition">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Links -->
                <div class="col-span-1 md:col-span-1 lg:col-span-2">
                    <h4 class="font-display font-bold mb-4 sm:mb-6 text-xs sm:text-sm uppercase tracking-wider text-sky-300">Product</h4>
                    <ul class="space-y-2 sm:space-y-3 text-xs sm:text-sm text-slate-400">
                        <li><a href="#fitur" class="hover:text-white transition">Features</a></li>
                        <li><a href="#" class="hover:text-white transition">Materi</a></li>
                        <li><a href="#" class="hover:text-white transition">Quiz</a></li>
                        <li><a href="#" class="hover:text-white transition">Progress</a></li>
                    </ul>
                </div>

                <div class="col-span-1 md:col-span-1 lg:col-span-2">
                    <h4 class="font-display font-bold mb-4 sm:mb-6 text-xs sm:text-sm uppercase tracking-wider text-sky-300">Company</h4>
                    <ul class="space-y-2 sm:space-y-3 text-xs sm:text-sm text-slate-400">
                        <li><a href="#tentang" class="hover:text-white transition">About</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>

                <div class="col-span-2 sm:col-span-1 md:col-span-1 lg:col-span-2">
                    <h4 class="font-display font-bold mb-4 sm:mb-6 text-xs sm:text-sm uppercase tracking-wider text-sky-300">Legal</h4>
                    <ul class="space-y-2 sm:space-y-3 text-xs sm:text-sm text-slate-400">
                        <li><a href="#" class="hover:text-white transition">Privacy</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms</a></li>
                        <li><a href="#" class="hover:text-white transition">Security</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-6 sm:pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4 text-center md:text-left">
                <p class="text-xs sm:text-sm text-slate-500">© 2025 Englify. Made with 💙 for English Club.</p>
                <div class="flex items-center gap-4 sm:gap-6 text-xs sm:text-sm text-slate-500">
                    <a href="#" class="hover:text-white transition">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ============ MODAL TULIS REVIEW ============ -->
    <div id="reviewModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-navy-950/70 backdrop-blur-sm p-3 sm:p-4 overflow-y-auto">
        <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border-2 border-navy-900 overflow-hidden transform transition-all my-auto max-h-[94vh] flex flex-col animate-modal-enter">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-navy-900 via-navy-800 to-navy-900 p-4 sm:p-6 text-white relative shrink-0">
                <button type="button" onclick="closeReviewModal()" class="absolute top-4 right-4 sm:top-5 sm:right-5 w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-sky-300/20 border border-sky-300/30 flex items-center justify-center text-xl sm:text-2xl shadow-inner shrink-0">
                        ⭐
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-lg sm:text-xl text-white">Tulis Review Englify</h3>
                        <p class="text-[11px] sm:text-xs text-sky-200">Bagikan kesan & pengalaman belajarmu di platform ini</p>
                    </div>
                </div>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('review.store') }}" method="POST" class="p-4 sm:p-6 space-y-3.5 sm:space-y-4 overflow-y-auto flex-1" id="formReview">
                @csrf

                @if($errors->any())
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl p-3 text-xs space-y-1">
                        <div class="font-bold flex items-center gap-1.5 text-rose-900">
                            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Terjadi kesalahan input:</span>
                        </div>
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Interactive Star Rating -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-navy-900 mb-1.5">Penilaian Kamu (Bintang)</label>
                    <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                        <div class="flex items-center gap-1 bg-slate-50 px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-2xl border border-slate-200" id="starRatingContainer">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" onclick="setRating({{ $i }})" class="star-btn text-2xl sm:text-3xl text-amber-400 hover:scale-125 transition-transform focus:outline-none cursor-pointer" data-value="{{ $i }}">
                                    ★
                                </button>
                            @endfor
                        </div>
                        <span id="ratingLabel" class="text-xs font-bold text-navy-900 bg-amber-50 px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-full border border-amber-200">5 / 5 - Sangat Puas! ⭐</span>
                        <input type="hidden" name="rating" id="ratingInput" value="5">
                    </div>
                </div>

                <!-- Nama -->
                <div>
                    <label for="review_nama" class="block text-xs font-bold uppercase tracking-wider text-navy-900 mb-1.5">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="review_nama" name="nama" required maxlength="70"
                        value="{{ auth()->check() ? auth()->user()->nama : old('nama') }}"
                        placeholder="Contoh: Nadia Safira"
                        class="w-full px-4 py-2 sm:py-2.5 rounded-2xl border-2 border-slate-200 focus:border-navy-900 focus:ring-0 text-sm font-medium text-navy-900 outline-none transition">
                    @if(auth()->check())
                        <p class="text-[11px] text-sky-600 mt-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span>Login sebagai <b>{{ auth()->user()->nama }}</b></span>
                        </p>
                    @endif
                </div>

                <!-- Role / Status -->
                <div>
                    <label for="review_role" class="block text-xs font-bold uppercase tracking-wider text-navy-900 mb-1.5">
                        Status / Sekolah / Divisi <span class="text-slate-400 text-[11px] font-normal">(Opsional)</span>
                    </label>
                    <input type="text" id="review_role" name="role" maxlength="70"
                        value="{{ old('role', auth()->check() ? 'Siswa English Club' : '') }}"
                        placeholder="Contoh: Siswa English Club / Siswa Kelas 10"
                        class="w-full px-4 py-2 sm:py-2.5 rounded-2xl border-2 border-slate-200 focus:border-navy-900 focus:ring-0 text-sm font-medium text-navy-900 outline-none transition">
                </div>

                <!-- Pesan Ulasan -->
                <div>
                    <label for="review_pesan" class="block text-xs font-bold uppercase tracking-wider text-navy-900 mb-1.5">
                        Ulasan Kamu <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="review_pesan" name="pesan" required rows="3" minlength="5" maxlength="500"
                        placeholder="Ceritakan apa yang kamu sukai dari Englify, materi favorit, atau seberapa seru kuisnya..."
                        class="w-full px-4 py-2 sm:py-2.5 rounded-2xl border-2 border-slate-200 focus:border-navy-900 focus:ring-0 text-sm text-navy-900 outline-none transition resize-none">{{ old('pesan') }}</textarea>
                    <div class="flex justify-between items-center text-[11px] text-slate-400 mt-1">
                        <span>Minimal 5 karakter</span>
                        <span id="charCounter">0 / 500</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-2.5 sm:gap-3 pt-3 border-t border-slate-100">
                    <button type="button" onclick="closeReviewModal()" class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm font-semibold text-slate-600 hover:bg-slate-100 transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 sm:px-6 py-2 sm:py-2.5 bg-navy-900 hover:bg-navy-800 text-white rounded-full text-xs sm:text-sm font-bold shadow-lg shadow-navy-900/20 hover:scale-105 active:scale-95 transition-all flex items-center gap-2 cursor-pointer">
                        <span>Kirim Ulasan</span>
                        <svg class="w-4 h-4 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ============ JAVASCRIPT ============ -->
    <script>
        // Mobile Navigation Toggle
        function toggleMobileMenu() {
            const dropdown = document.getElementById('mobileMenuDropdown');
            const hamburger = document.getElementById('hamburgerIcon');
            const closeIcon = document.getElementById('closeMenuIcon');
            if (dropdown) {
                const isHidden = dropdown.classList.contains('hidden');
                if (isHidden) {
                    dropdown.classList.remove('hidden');
                    if (hamburger) hamburger.classList.add('hidden');
                    if (closeIcon) closeIcon.classList.remove('hidden');
                } else {
                    dropdown.classList.add('hidden');
                    if (hamburger) hamburger.classList.remove('hidden');
                    if (closeIcon) closeIcon.classList.add('hidden');
                }
            }
        }

        // Scroll Reveal Animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href === '#' || href === '') return;
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Navbar scroll effect
        const nav = document.querySelector('nav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                nav.classList.add('shadow-2xl');
            } else {
                nav.classList.remove('shadow-2xl');
            }
        });

        // Review Modal Functions
        function openReviewModal() {
            const modal = document.getElementById('reviewModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            }
        }

        function closeReviewModal() {
            const modal = document.getElementById('reviewModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
            }
        }

        function setRating(rating) {
            document.getElementById('ratingInput').value = rating;
            const labels = {
                1: '1 / 5 - Kurang Puas',
                2: '2 / 5 - Cukup',
                3: '3 / 5 - Bagus',
                4: '4 / 5 - Sangat Bagus!',
                5: '5 / 5 - Sangat Puas! ⭐'
            };
            const labelEl = document.getElementById('ratingLabel');
            if (labelEl) {
                labelEl.textContent = labels[rating] || (rating + ' / 5');
            }

            const stars = document.querySelectorAll('#starRatingContainer .star-btn');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('text-amber-400');
                    star.classList.remove('text-slate-300');
                } else {
                    star.classList.remove('text-amber-400');
                    star.classList.add('text-slate-300');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const pesanInput = document.getElementById('review_pesan');
            const counter = document.getElementById('charCounter');
            if (pesanInput && counter) {
                counter.textContent = `${pesanInput.value.length} / 500`;
                pesanInput.addEventListener('input', () => {
                    counter.textContent = `${pesanInput.value.length} / 500`;
                });
            }

            // Close on Escape or backdrop click
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeReviewModal();
            });

            const modal = document.getElementById('reviewModal');
            if (modal) {
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) closeReviewModal();
                });
            }

            @if($errors->any())
                openReviewModal();
            @endif
        });
    </script>

    @include('layouts.partials.loading-modal')
</body>
</html>

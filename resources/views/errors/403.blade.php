<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak | Englify</title>
    <!-- Favicon & Brand Icons -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=20261102b">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=20261102b">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=20261102b">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=20261102b">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=20261102b">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Caveat:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .font-cute {
            font-family: 'Caveat', cursive;
        }
        
        /* Animasi floating untuk kucing */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        /* Animasi sparkle */
        @keyframes sparkle {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(1.15); }
        }
        .animate-sparkle {
            animation: sparkle 2s ease-in-out infinite;
        }
        
        /* Gradient background */
        .bg-englify-gradient {
            background: radial-gradient(circle at 20% 20%, #E0F2FE 0%, #F0F9FF 40%, #D6EBEE 100%);
        }
    </style>
</head>
<body class="bg-englify-gradient min-h-screen lg:h-screen flex flex-col items-center justify-center p-3 sm:p-4 overflow-y-auto lg:overflow-hidden select-none">

    <!-- Decorative Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-12 left-16 w-36 h-36 bg-[#018ABE]/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-12 right-16 w-44 h-44 bg-[#97CADB]/20 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-8 w-24 h-24 bg-[#02457A]/10 rounded-full blur-2xl"></div>
    </div>

    <div class="relative z-10 max-w-lg w-full my-auto">
        
        <!-- Main Card -->
        <div class="bg-white/95 backdrop-blur-md rounded-2xl sm:rounded-3xl shadow-xl shadow-[#001B48]/10 border border-[#97CADB]/40 overflow-hidden">
            
            <!-- Top Gradient Bar -->
            <div class="h-1.5 bg-gradient-to-r from-amber-500 via-rose-500 to-[#018ABE]"></div>

            <div class="p-5 sm:p-6 text-center">
                
                <!-- 403 Mascot Centerpiece -->
                <div class="flex items-center justify-center gap-2 sm:gap-3 mb-2">
                    <span class="text-6xl sm:text-7xl font-black text-[#001B48] leading-none tracking-tight">4</span>
                    
                    <!-- Cute Englify Guardian Cat Avatar (Center 0 with Shield) -->
                    <div class="relative animate-float mx-1">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-amber-50 via-white to-rose-50 border-3 border-amber-300 flex items-center justify-center shadow-md shadow-amber-500/15 relative">
                            <!-- Cat Mascot SVG -->
                            <svg class="w-11 h-11 sm:w-14 sm:h-14" viewBox="0 0 100 100" fill="none">
                                <!-- Cat Ears -->
                                <path d="M22 36 L30 14 L46 28 Z" fill="#001B48"/>
                                <path d="M78 36 L70 14 L54 28 Z" fill="#001B48"/>
                                <!-- Inner Ears -->
                                <path d="M26 33 L32 18 L43 27 Z" fill="#97CADB"/>
                                <path d="M74 33 L68 18 L57 27 Z" fill="#97CADB"/>
                                <!-- Cat Head -->
                                <circle cx="50" cy="50" r="34" fill="#001B48"/>
                                <!-- Eyes (Alert & Winking) -->
                                <ellipse cx="38" cy="46" rx="5" ry="6.5" fill="white"/>
                                <circle cx="39" cy="47" r="3.2" fill="#018ABE"/>
                                <circle cx="37.5" cy="45" r="1.3" fill="white"/>
                                
                                <path d="M57 46 Q62 42 67 46" stroke="white" stroke-width="3" stroke-linecap="round"/>
                                
                                <!-- Nose -->
                                <polygon points="47,54 53,54 50,57" fill="#97CADB"/>
                                <!-- Mouth (Cute) -->
                                <path d="M44 59 Q50 63 56 59" stroke="white" stroke-width="2" fill="none" stroke-linecap="round"/>
                                <!-- Cheeks (Blush) -->
                                <ellipse cx="30" cy="54" rx="4" ry="2" fill="#F472B6" opacity="0.6"/>
                                <ellipse cx="70" cy="54" rx="4" ry="2" fill="#F472B6" opacity="0.6"/>
                            </svg>
                        </div>
                        <!-- Shield Badge -->
                        <div class="absolute -top-2 -right-2 w-7 h-7 rounded-xl bg-gradient-to-tr from-amber-500 to-rose-500 text-white flex items-center justify-center text-xs shadow-md">
                            🛡️
                        </div>
                        <div class="absolute -bottom-1 -left-1.5 text-xs animate-sparkle" style="animation-delay: 0.5s">🐾</div>
                    </div>
                    
                    <span class="text-6xl sm:text-7xl font-black text-[#001B48] leading-none tracking-tight">3</span>
                </div>

                <!-- Text Headings -->
                <h1 class="text-lg sm:text-xl font-extrabold text-[#001B48] tracking-tight">
                    Akses Dibatasi
                </h1>
                
                <p class="font-cute text-sm sm:text-base text-rose-600 font-semibold mt-0.5">
                    Hanya untuk peran yang berwenang! 🔒
                </p>

                <!-- Detailed Description -->
                <p class="text-xs text-slate-500 max-w-sm mx-auto mt-2 leading-relaxed">
                    Oops! Akunmu tidak memiliki hak akses untuk membuka halaman ini. Super Admin, Admin Divisi, dan Siswa bekerja sesuai perannya masing-masing.
                </p>

                @auth
                    <div class="mt-3 inline-flex items-center gap-2 px-3 py-1 bg-slate-100 rounded-full border border-slate-200 text-xs">
                        <span class="text-slate-500">Akun login saat ini:</span>
                        <span class="font-bold text-[#001B48]">
                            {{ auth()->user()->nama ?? auth()->user()->username }}
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ auth()->user()->id_role == 1 ? 'bg-purple-100 text-purple-700' : (auth()->user()->id_role == 2 ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700') }}">
                            {{ auth()->user()->id_role == 1 ? 'Super Admin' : (auth()->user()->id_role == 2 ? 'Admin Divisi' : 'Siswa') }}
                        </span>
                    </div>
                @endauth

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-2.5 mt-4">
                    
                    <!-- Tombol Kembali -->
                    <button onclick="window.history.back()" 
                            class="w-full sm:w-auto px-4 py-2 sm:px-5 sm:py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs sm:text-sm font-bold rounded-xl transition flex items-center justify-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Kembali</span>
                    </button>

                    <!-- Tombol Dashboard Sesuai Peran -->
                    @auth
                        @if(auth()->user()->id_role == 1)
                            <a href="{{ route('superadmin.dashboard') }}" 
                               class="w-full sm:w-auto px-5 py-2 sm:px-6 sm:py-2.5 bg-gradient-to-r from-[#018ABE] to-[#02457A] hover:from-[#02457A] hover:to-[#001B48] text-white text-xs sm:text-sm font-bold rounded-xl transition flex items-center justify-center gap-1.5 shadow-md shadow-[#018ABE]/25">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <span>Dashboard Superadmin</span>
                            </a>
                        @elseif(auth()->user()->id_role == 2)
                            <a href="{{ route('admin.dashboard') }}" 
                               class="w-full sm:w-auto px-5 py-2 sm:px-6 sm:py-2.5 bg-gradient-to-r from-[#018ABE] to-[#02457A] hover:from-[#02457A] hover:to-[#001B48] text-white text-xs sm:text-sm font-bold rounded-xl transition flex items-center justify-center gap-1.5 shadow-md shadow-[#018ABE]/25">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <span>Dashboard Admin</span>
                            </a>
                        @else
                            <a href="{{ route('siswa.dashboard') }}" 
                               class="w-full sm:w-auto px-5 py-2 sm:px-6 sm:py-2.5 bg-gradient-to-r from-[#018ABE] to-[#02457A] hover:from-[#02457A] hover:to-[#001B48] text-white text-xs sm:text-sm font-bold rounded-xl transition flex items-center justify-center gap-1.5 shadow-md shadow-[#018ABE]/25">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <span>Dashboard Siswa</span>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" 
                           class="w-full sm:w-auto px-5 py-2 sm:px-6 sm:py-2.5 bg-gradient-to-r from-[#018ABE] to-[#02457A] hover:from-[#02457A] hover:to-[#001B48] text-white text-xs sm:text-sm font-bold rounded-xl transition flex items-center justify-center gap-1.5 shadow-md shadow-[#018ABE]/25">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            <span>Masuk ke Akun</span>
                        </a>
                    @endauth
                </div>

                <!-- Helpful Quick Links -->
                <div class="mt-3.5 pt-3 border-t border-slate-100 flex items-center justify-center gap-2 text-xs text-slate-500">
                    <span class="text-slate-400">Pintasan:</span>
                    <a href="/" class="hover:text-[#018ABE] font-semibold transition">
                        🏠 Beranda
                    </a>
                    @auth
                        @if(auth()->user()->id_role == 3)
                            <span class="text-slate-300">•</span>
                            <a href="{{ route('siswa.materi') }}" class="hover:text-[#018ABE] font-semibold transition">
                                📚 Materi Siswa
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Bottom Branding Bar -->
            <div class="px-5 py-2.5 bg-gradient-to-r from-[#D6EBEE]/70 to-white border-t border-[#97CADB]/30 flex items-center justify-between text-xs">
                <div class="flex items-center gap-1.5">
                    <div class="w-5 h-5 rounded-md bg-[#001B48] flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                        </svg>
                    </div>
                    <span class="font-extrabold text-[#001B48] text-xs">englify</span>
                </div>
                <p class="font-cute text-xs text-[#018ABE] font-semibold">Keamanan Akun & Hak Akses Terlindungi 🛡️</p>
            </div>
        </div>

        <!-- Sleek Footer Note -->
        <p class="text-center text-[11px] text-slate-400 mt-2">
            Error 403 • Akses Ditolak • Englify App
        </p>
    </div>

</body>
</html>

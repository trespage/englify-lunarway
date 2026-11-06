<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error | Englify</title>
    <!-- Favicon & Brand Icons -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=2">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=2">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=2">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Caveat:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-cute { font-family: 'Caveat', cursive; }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        .animate-float { animation: float 3s ease-in-out infinite; }
        .bg-englify-gradient {
            background: radial-gradient(circle at 20% 20%, #FFF1F2 0%, #FFE4E6 40%, #FEE2E2 100%);
        }
    </style>
</head>
<body class="bg-englify-gradient min-h-screen lg:h-screen flex flex-col items-center justify-center p-3 sm:p-4 overflow-y-auto lg:overflow-hidden select-none">

    <!-- Decorative Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-12 left-16 w-36 h-36 bg-rose-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-12 right-16 w-44 h-44 bg-red-400/15 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-lg w-full my-auto">
        <div class="bg-white/95 backdrop-blur-md rounded-2xl sm:rounded-3xl shadow-xl shadow-rose-900/10 border border-rose-200/60 overflow-hidden">
            
            <div class="h-1.5 bg-gradient-to-r from-rose-500 via-red-500 to-orange-500"></div>

            <div class="p-5 sm:p-6 text-center">
                
                <!-- 500 Number with Warning Mascot -->
                <div class="flex items-center justify-center gap-2 sm:gap-3 mb-2">
                    <span class="text-6xl sm:text-7xl font-black text-rose-600 leading-none tracking-tight">5</span>
                    
                    <div class="relative animate-float mx-1">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-rose-100 via-white to-red-100 border-3 border-rose-300 flex items-center justify-center shadow-md shadow-rose-500/15">
                            <svg class="w-9 h-9 sm:w-11 sm:h-11 text-rose-600" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                            </svg>
                        </div>
                        <div class="absolute -top-1.5 -right-1.5 text-base">⚠️</div>
                    </div>
                    
                    <span class="text-6xl sm:text-7xl font-black text-rose-600 leading-none tracking-tight">0</span>
                </div>

                <!-- Cute Status Pill -->
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-100/70 border border-rose-200 text-xs font-semibold text-rose-700 mb-2.5">
                    <span>⚙️</span>
                    <span>Server sedang mengalami kendala</span>
                </div>

                <div class="space-y-1 mb-4">
                    <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">
                        Terjadi Kesalahan Server
                    </h1>
                    <p class="text-slate-500 text-xs sm:text-sm max-w-sm mx-auto leading-relaxed">
                        Ada kendala teknis internal pada sistem. Tim Englify sedang memperbaikinya. Silakan coba beberapa saat lagi!
                    </p>
                    <p class="font-cute text-base sm:text-lg text-rose-500 font-semibold pt-0.5">
                        “Don't worry, we'll fix it soon!” 💪
                    </p>
                </div>

                <div class="flex items-center justify-center gap-2.5 sm:gap-3">
                    <button onclick="location.reload()" 
                            class="px-4 py-2 sm:px-5 sm:py-2.5 bg-white border border-slate-200 text-slate-700 text-xs sm:text-sm font-bold rounded-xl hover:bg-slate-50 hover:border-slate-300 transition flex items-center justify-center gap-1.5 shadow-xs">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span>Coba Lagi</span>
                    </button>

                    @php
                        $safeUser = null;
                        try {
                            if (\Illuminate\Support\Facades\Auth::check()) {
                                $safeUser = \Illuminate\Support\Facades\Auth::user();
                            }
                        } catch (\Throwable $ignored) {
                            $safeUser = null;
                        }
                    @endphp

                    @if($safeUser)
                        @if((int) ($safeUser->id_role ?? 0) === 1)
                            <a href="{{ route('superadmin.dashboard') }}" 
                               class="px-5 py-2 sm:px-6 sm:py-2.5 bg-gradient-to-r from-rose-500 to-red-600 hover:from-red-600 hover:to-rose-700 text-white text-xs sm:text-sm font-bold rounded-xl transition flex items-center justify-center gap-1.5 shadow-md shadow-rose-500/25">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <span>Dashboard Superadmin</span>
                            </a>
                        @elseif((int) ($safeUser->id_role ?? 0) === 2)
                            <a href="{{ route('admin.dashboard') }}" 
                               class="px-5 py-2 sm:px-6 sm:py-2.5 bg-gradient-to-r from-rose-500 to-red-600 hover:from-red-600 hover:to-rose-700 text-white text-xs sm:text-sm font-bold rounded-xl transition flex items-center justify-center gap-1.5 shadow-md shadow-rose-500/25">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <span>Dashboard Admin</span>
                            </a>
                        @else
                            <a href="{{ route('siswa.dashboard') }}" 
                               class="px-5 py-2 sm:px-6 sm:py-2.5 bg-gradient-to-r from-rose-500 to-red-600 hover:from-red-600 hover:to-rose-700 text-white text-xs sm:text-sm font-bold rounded-xl transition flex items-center justify-center gap-1.5 shadow-md shadow-rose-500/25">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <span>Dashboard Siswa</span>
                            </a>
                        @endif
                    @else
                        <a href="{{ url('/') }}" 
                           class="px-5 py-2 sm:px-6 sm:py-2.5 bg-gradient-to-r from-rose-500 to-red-600 hover:from-red-600 hover:to-rose-700 text-white text-xs sm:text-sm font-bold rounded-xl transition flex items-center justify-center gap-1.5 shadow-md shadow-rose-500/25">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Halaman Utama</span>
                        </a>
                    @endif
                </div>
            </div>

            <div class="px-5 py-2.5 bg-gradient-to-r from-rose-50/70 to-white border-t border-rose-200/50 flex items-center justify-between text-xs">
                <div class="flex items-center gap-1.5">
                    <div class="w-5 h-5 rounded-md bg-[#001B48] flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                        </svg>
                    </div>
                    <span class="font-extrabold text-[#001B48] text-xs">englify</span>
                </div>
                <p class="font-cute text-xs text-rose-500 font-semibold">We'll be back soon! 🐾</p>
            </div>
        </div>

        <p class="text-center text-[11px] text-slate-400 mt-2">
            Error 500 • Server Error • Englify App
        </p>
    </div>

</body>
</html>
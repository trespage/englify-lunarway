<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galat Basis Data | Englify</title>
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
            background: radial-gradient(circle at 20% 20%, #FFFBEB 0%, #FEF3C7 40%, #EDE9FE 100%);
        }
    </style>
</head>
<body class="bg-englify-gradient min-h-screen lg:h-screen flex flex-col items-center justify-center p-3 sm:p-4 overflow-y-auto lg:overflow-hidden select-none">

    <!-- Decorative Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-12 left-16 w-36 h-36 bg-amber-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-12 right-16 w-44 h-44 bg-purple-500/15 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-8 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl"></div>
    </div>

    <div class="relative z-10 max-w-lg w-full my-auto">
        <div class="bg-white/95 backdrop-blur-md rounded-2xl sm:rounded-3xl shadow-xl shadow-amber-900/10 border border-amber-200/60 overflow-hidden">
            
            <div class="h-1.5 bg-gradient-to-r from-amber-500 via-orange-500 to-rose-500"></div>

            <div class="p-5 sm:p-6 text-center">
                
                <!-- Mascot & Database Icon -->
                <div class="flex items-center justify-center gap-2 sm:gap-3 mb-2">
                    <div class="relative animate-float mx-1">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-amber-100 via-white to-orange-100 border-3 border-amber-300 flex items-center justify-center shadow-md shadow-amber-500/15">
                            <svg class="w-9 h-9 sm:w-11 sm:h-11 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                            </svg>
                        </div>
                        <div class="absolute -top-1.5 -right-1.5 text-base">🔌</div>
                    </div>
                </div>

                <!-- Status Pill -->
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100/80 border border-amber-200 text-xs font-semibold text-amber-800 mb-2.5">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    <span>Koneksi Basis Data Terputus</span>
                </div>

                <div class="space-y-1 mb-4">
                    <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">
                        Basis Data Sedang Tidak Tersedia
                    </h1>
                    <p class="text-slate-600 text-xs sm:text-sm font-semibold max-w-sm mx-auto leading-relaxed">
                        Terjadi kendala koneksi server. Silakan hubungi admin.
                    </p>
                    <p class="font-cute text-base sm:text-lg text-amber-600 font-semibold pt-0.5">
                        “Hold on tight, our database will be right back!” 🐾
                    </p>
                </div>

                <!-- Developer Debug Info (Hanya aktif saat APP_DEBUG=true) -->
                @if(config('app.debug') && isset($exception))
                <div class="mb-4 text-left p-3 bg-slate-900 text-amber-300 rounded-xl text-[11px] font-mono overflow-x-auto max-h-32 border border-slate-800">
                    <p class="font-bold text-white mb-1">🛠️ DEBUG INFO (Hanya terlihat dalam mode debug):</p>
                    <p class="truncate text-rose-300">{{ $exception->getMessage() }}</p>
                    <p class="text-slate-400 mt-0.5 text-[10px]">File: {{ basename($exception->getFile()) }} : Line {{ $exception->getLine() }}</p>
                </div>
                @endif

                <div class="flex items-center justify-center gap-2.5 sm:gap-3">
                    <button onclick="location.reload()" 
                            class="px-4 py-2 sm:px-5 sm:py-2.5 bg-white border border-slate-200 text-slate-700 text-xs sm:text-sm font-bold rounded-xl hover:bg-slate-50 hover:border-slate-300 transition flex items-center justify-center gap-1.5 shadow-xs">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span>Coba Hubungkan Lagi</span>
                    </button>

                    <a href="{{ url('/') }}" 
                       class="px-5 py-2 sm:px-6 sm:py-2.5 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-orange-600 hover:to-amber-700 text-white text-xs sm:text-sm font-bold rounded-xl transition flex items-center justify-center gap-1.5 shadow-md shadow-amber-500/25">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Halaman Utama</span>
                    </a>
                </div>
            </div>

            <div class="px-5 py-2.5 bg-gradient-to-r from-amber-50/70 to-white border-t border-amber-200/50 flex items-center justify-between text-xs">
                <div class="flex items-center gap-1.5">
                    <div class="w-5 h-5 rounded-md bg-[#001B48] flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                        </svg>
                    </div>
                    <span class="font-extrabold text-[#001B48] text-xs">englify</span>
                </div>
                <p class="font-cute text-xs text-amber-600 font-semibold">Database Connection Shield 🛡️</p>
            </div>
        </div>

        <p class="text-center text-[11px] text-slate-400 mt-2">
            Galat Basis Data • Database Connection Exception • Englify App
        </p>
    </div>

</body>
</html>

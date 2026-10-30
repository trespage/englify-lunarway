<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Siswa') - Englify</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                        handwritten: ['"Caveat"', 'cursive']
                    },
                    colors: {
                        navy: { 800: '#001B48', 850: '#02457A', 900: '#001B48' }
                    }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }
        .font-cute { font-family: 'Caveat', cursive; }
        html, body, .siswa-bg { 
            background: linear-gradient(135deg, #C2DCF9 0%, #D4E6FA 50%, #E6F1FC 100%) !important; 
            background-attachment: fixed !important; 
        }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }

        /* Utility Scrollbar Hide untuk Carousel & Tab Mobile */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

        /* Utility agar teks materi panjang tidak meluap keluar box container */
        .content-text-wrap {
            overflow-wrap: anywhere !important;
            word-break: break-word !important;
            word-wrap: break-word !important;
            max-width: 100% !important;
        }

        /* Sidebar active - BIRU GLOW */
        .sidebar-item-active {
            background: linear-gradient(135deg, #018ABE 0%, #02457A 100%);
            color: #FFFFFF !important;
            box-shadow: 0 4px 15px rgba(1, 138, 190, 0.5), 0 0 20px rgba(1, 138, 190, 0.3);
            transform: scale(1.02);
        }
        .sidebar-item-active svg { color: #FFFFFF !important; filter: drop-shadow(0 0 4px rgba(255,255,255,0.5)); }

        /* Animasi klik menu */
        .sidebar-link {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar-link::before {
            content: '';
            position: absolute;
            top: 50%; left: 50%;
            width: 0; height: 0;
            border-radius: 50%;
            background: rgba(1, 138, 190, 0.4);
            transform: translate(-50%, -50%);
            transition: width 0.5s, height 0.5s;
        }
        .sidebar-link:active::before { width: 200px; height: 200px; }
        .sidebar-link:active { transform: scale(0.97); }
        .sidebar-link:hover {
            background: rgba(1, 138, 190, 0.15) !important;
            box-shadow: inset 0 0 15px rgba(1, 138, 190, 0.2);
        }
        .sidebar-link:hover svg { transform: scale(1.1); color: #97CADB; }
        .sidebar-link svg { transition: all 0.3s ease; }

        /* Paw Button & Animated Cat Paw */
        @keyframes pawTap {
            0%, 100% { transform: rotate(0deg) scale(1); }
            18% { transform: rotate(-18deg) scale(1.24); }
            38% { transform: rotate(14deg) scale(1.18); }
            58% { transform: rotate(-10deg) scale(1.14); }
            78% { transform: rotate(6deg) scale(1.08); }
        }
        .paw-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .paw-btn:hover {
            background: linear-gradient(135deg, rgba(244, 63, 94, 0.22), rgba(251, 113, 133, 0.12)) !important;
            border-color: rgba(251, 113, 133, 0.45) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 18px -2px rgba(244, 63, 94, 0.28);
        }
        .paw-btn:active {
            transform: scale(0.97);
        }
        .paw-icon {
            transform-origin: 50% 85%;
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), color 0.3s ease, filter 0.3s ease;
        }
        .paw-btn:hover .paw-icon {
            animation: pawTap 0.7s cubic-bezier(0.34, 1.56, 0.64, 1) both;
            color: #fda4af !important;
            filter: drop-shadow(0 0 6px rgba(251, 113, 133, 0.6));
        }

        /* Englify Cat Loading Keyframes */
        @keyframes catBob {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-7px) rotate(3deg); }
        }
        @keyframes pulseRing {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.14); opacity: 0.25; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }
        @keyframes progressIndeterminate {
            0% { transform: translateX(-100%); }
            50% { transform: translateX(35%); }
            100% { transform: translateX(120%); }
        }
        .cat-bob { animation: catBob 1.6s ease-in-out infinite; }
        .pulse-ring { animation: pulseRing 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }

        #sidebar.collapsed { width: 4.75rem; }
        #sidebar.collapsed .sidebar-text,
        #sidebar.collapsed .sidebar-cat-quote { display: none; }
        #sidebar.collapsed .sidebar-link { justify-content: center; padding-left: 0.5rem; padding-right: 0.5rem; }

        /* ==========================================================
           ENGLIFY NOTIFICATION THEME (SweetAlert2 Custom Styling)
           ========================================================== */
        .swal2-container:not(.swal2-toast-container):not(.swal2-backdrop-hide) {
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }
        .swal2-container.swal2-toast-container {
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
            pointer-events: none !important;
            background: transparent !important;
        }
        .swal2-container.swal2-toast-container .swal2-toast {
            pointer-events: auto !important;
        }
        @media (max-width: 640px) {
            .swal2-container.swal2-toast-container {
                inset: 0.75rem auto auto 0 !important;
                width: 100% !important;
                display: flex !important;
                justify-content: center !important;
            }
            .swal2-popup.swal2-toast.englify-toast {
                margin: 0 auto !important;
                width: calc(100% - 2rem) !important;
                max-width: 380px !important;
            }
        }
        .swal2-popup.englify-swal {
            border-radius: 28px !important;
            padding: 2rem 1.75rem 1.75rem 1.75rem !important;
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif !important;
            box-shadow: 0 25px 60px -15px rgba(2, 69, 122, 0.28), 0 0 0 1px rgba(151, 202, 219, 0.4) !important;
            background: #ffffff !important;
        }
        .swal2-popup.englify-swal .swal2-title {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif !important;
            color: #001B48 !important;
            font-weight: 800 !important;
            font-size: 1.3rem !important;
            letter-spacing: -0.01em !important;
            margin-bottom: 0.35rem !important;
        }
        .swal2-popup.englify-swal .swal2-html-container {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif !important;
            color: #475569 !important;
            font-size: 0.93rem !important;
            line-height: 1.5 !important;
            margin: 0.5rem 0 1.25rem 0 !important;
        }
        .swal2-popup.englify-swal .swal2-actions {
            margin-top: 0.75rem !important;
            gap: 0.75rem !important;
        }
        .swal2-confirm.englify-swal-confirm {
            background: linear-gradient(135deg, #018ABE 0%, #02457A 100%) !important;
            color: #ffffff !important;
            border-radius: 14px !important;
            padding: 0.75rem 2rem !important;
            font-weight: 700 !important;
            font-size: 0.875rem !important;
            box-shadow: 0 4px 14px rgba(2, 69, 122, 0.35) !important;
            border: none !important;
            cursor: pointer !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .swal2-confirm.englify-swal-confirm:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 8px 20px rgba(2, 69, 122, 0.45) !important;
        }
        .swal2-confirm.englify-swal-confirm:active {
            transform: translateY(0) scale(0.98) !important;
        }
        .swal2-confirm.englify-swal-danger {
            background: linear-gradient(135deg, #e11d48 0%, #be123c 100%) !important;
            color: #ffffff !important;
            border-radius: 14px !important;
            padding: 0.75rem 2rem !important;
            font-weight: 700 !important;
            font-size: 0.875rem !important;
            box-shadow: 0 4px 14px rgba(225, 29, 72, 0.35) !important;
            border: none !important;
            cursor: pointer !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .swal2-confirm.englify-swal-danger:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 8px 20px rgba(225, 29, 72, 0.45) !important;
        }
        .swal2-confirm.englify-swal-danger:active {
            transform: translateY(0) scale(0.98) !important;
        }
        .swal2-cancel.englify-swal-cancel {
            background: #f1f5f9 !important;
            color: #64748b !important;
            border-radius: 14px !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 600 !important;
            font-size: 0.875rem !important;
            border: 1px solid #e2e8f0 !important;
            cursor: pointer !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .swal2-cancel.englify-swal-cancel:hover {
            background: #e2e8f0 !important;
            color: #1e293b !important;
        }
        /* Toast Notification Styling */
        .swal2-popup.swal2-toast.englify-toast {
            border-radius: 20px !important;
            box-shadow: 0 12px 35px -5px rgba(2, 69, 122, 0.2), 0 0 0 1px rgba(151, 202, 219, 0.35) !important;
            padding: 0.85rem 1.25rem !important;
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(12px) !important;
        }
        .swal2-popup.swal2-toast.englify-toast .swal2-title {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif !important;
            font-size: 0.9rem !important;
            color: #001B48 !important;
            font-weight: 700 !important;
            margin: 0 !important;
        }
        .swal2-popup.swal2-toast.englify-toast .swal2-html-container {
            font-size: 0.8rem !important;
            color: #475569 !important;
            margin: 0.2rem 0 0 0 !important;
        }
    </style>
</head>
<body class="siswa-bg bg-[#D4E6FA] text-slate-800 antialiased min-h-screen flex flex-col">

<div class="flex h-screen overflow-hidden">

    <!-- ============================================================== -->
    <!-- DESKTOP LEFT SIDEBAR                                           -->
    <!-- ============================================================== -->
    <aside id="sidebar" class="w-64 shrink-0 bg-[#001B48] hidden lg:flex flex-col shadow-2xl transition-all duration-300 z-30 select-none relative">

        <div class="p-6 pb-5 flex items-center justify-between border-b border-white/10">
            <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-[#D6EBEE] flex items-center justify-center shadow-md p-1.5 transition-transform group-hover:scale-105 shrink-0">
                    <svg viewBox="0 0 36 36" class="w-full h-full text-[#001B48]" fill="currentColor">
                        <polygon points="6,15 11,3 17,9" fill="#001B48"/>
                        <polygon points="30,15 25,3 19,9" fill="#001B48"/>
                        <polygon points="8,13 11,6 15,10" fill="#93C5FD"/>
                        <polygon points="28,13 25,6 21,10" fill="#93C5FD"/>
                        <circle cx="18" cy="19" r="13" fill="#001B48"/>
                        <path d="M10 20 C10 13, 26 13, 26 20 C26 27, 10 27, 10 20 Z" fill="#FFFFFF"/>
                        <ellipse cx="14" cy="19" rx="1.8" ry="2.2" fill="#001B48"/>
                        <ellipse cx="22" cy="19" rx="1.8" ry="2.2" fill="#001B48"/>
                        <circle cx="13.4" cy="18.2" r="0.6" fill="#FFFFFF"/>
                        <circle cx="21.4" cy="18.2" r="0.6" fill="#FFFFFF"/>
                        <polygon points="17,22 19,22 18,23" fill="#001B48"/>
                        <path d="M18 23 L18 24.5 M16.5 24.5 C17.2 25, 18 24.5, 18 24.5 C18 24.5, 18.8 25, 19.5 24.5" stroke="#001B48" stroke-width="0.8" fill="none" stroke-linecap="round"/>
                    </svg>
                </div>
                <div class="sidebar-text">
                    <span class="text-2xl font-extrabold text-white tracking-tight leading-none">englify</span>
                </div>
            </a>
            <button onclick="toggleSidebarCollapse()" class="text-slate-400 hover:text-white p-1 rounded-lg hover:bg-white/5 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/></svg>
            </button>
        </div>

        <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto overflow-x-hidden">
            <a href="{{ route('siswa.dashboard') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('siswa.dashboard') ? 'sidebar-item-active' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="sidebar-text">Dashboard</span>
            </a>

            <a href="{{ route('siswa.materi') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('siswa.materi*') ? 'sidebar-item-active' : 'text-slate-300 hover:text-white hover:bg-white/10' }}"
               title="Materi Pembelajaran & Latihan Quiz">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <div class="sidebar-text flex-1 flex items-center justify-between">
                    <span>Materi</span>
                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-md bg-sky-400/20 text-sky-200 border border-sky-300/30">Materi & Quiz</span>
                </div>
            </a>

            <a href="{{ route('siswa.peta-quiz') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('siswa.peta-quiz') ? 'sidebar-item-active' : 'text-slate-300 hover:text-white hover:bg-white/10' }}"
               title="Peta Alur & Riwayat Skor Quiz">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                <div class="sidebar-text flex-1 flex items-center justify-between">
                    <span>Peta Quiz</span>
                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-md bg-emerald-400/20 text-emerald-200 border border-emerald-300/30">Rute Skor</span>
                </div>
            </a>

            <a href="{{ route('siswa.progres') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('siswa.progres*') ? 'sidebar-item-active' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span class="sidebar-text">Progress Belajar</span>
            </a>

            <a href="{{ route('siswa.reminder') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('siswa.reminder') ? 'sidebar-item-active' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="sidebar-text">Reminder</span>

                @php
                    $unreadCount = \App\Models\PesanAdmin::where('id_user', auth()->user()->id_user)->where('is_read', false)->count();
                @endphp
                @if($unreadCount > 0)
                    <span class="ml-auto bg-rose-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow-sm">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>

            <a href="{{ route('siswa.profil') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('siswa.profil') ? 'sidebar-item-active' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="sidebar-text">Profil</span>
            </a>
        </nav>

        <div class="p-4 pt-1 border-t border-white/10 relative overflow-hidden mt-auto">
            <div class="sidebar-cat-quote text-left pl-1 pt-2">
                <p class="font-cute text-base text-sky-200/90 leading-tight">Learn</p>
                <p class="font-cute text-base text-sky-200/90 leading-tight">Practice</p>
                <p class="font-cute text-base text-sky-200/90 leading-tight">Grow</p>
                <p class="font-cute text-base text-sky-200/90 leading-tight">Together <span class="text-amber-300">✦</span></p>
            </div>
            <div class="relative flex justify-end -mt-10 pr-1 pointer-events-none">
                <img src="{{ asset('images/cat-welcome.png') }}" alt="Englify Cat" class="w-16 h-auto object-contain transform translate-y-1 opacity-90 drop-shadow-md">
            </div>
            <form method="POST" action="{{ route('logout') }}" class="pt-1">
                @csrf
                <button type="submit" class="paw-btn w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-white/10 hover:bg-rose-500/20 text-slate-200 hover:text-white border border-white/15 transition text-sm font-medium group">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-lg bg-sky-400/15 group-hover:bg-rose-500/25 flex items-center justify-center transition-colors shrink-0">
                            <svg class="paw-icon w-4 h-4 text-sky-300 group-hover:text-rose-300" viewBox="0 0 512 512" fill="currentColor">
                                <path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C120.3 358.3 189 320 256 320s135.7 38.3 186.8 81.2c12.8 10.8 10.6 30.5-3.8 40.8-28.7 20.6-67.6 36-111 36-28.7 0-54.6-6.6-72-19.3-17.4 12.7-43.3 19.3-72 19.3-43.4 0-82.3-15.4-111-36-14.4-10.4-16.6-30.1-3.8-40.8zM440.3 165.3c24.5 14 29.1 51.7 10.2 84.1s-54.1 47.3-78.5 33.3-29.1-51.7-10.2-84.1 54.1-47.3 78.5-33.3zM318.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5 46.9 53.9 32.6 96.8-52.1 69.1-84.4 58.5z"/>
                            </svg>
                        </div>
                        <span class="sidebar-text font-semibold">Logout</span>
                    </div>
                    <span class="sidebar-text text-[11px] font-bold text-rose-300 opacity-0 group-hover:opacity-100 transition duration-200">
                        Bye! 🐾
                    </span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Mobile Backdrop -->
    <div id="mobile-backdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 hidden lg:hidden" onclick="toggleMobileSidebar()"></div>

    <!-- Mobile Drawer -->
    <div id="mobile-sidebar" class="fixed inset-y-0 left-0 w-72 bg-[#001B48] z-50 transform -translate-x-full transition-transform duration-300 lg:hidden flex flex-col shadow-2xl">
        <div class="p-5 border-b border-white/10 flex items-center justify-between">
            <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-[#D6EBEE] flex items-center justify-center p-1.5 shrink-0">
                    <svg viewBox="0 0 36 36" class="w-full h-full text-[#001B48]" fill="currentColor">
                        <polygon points="6,15 11,3 17,9" fill="#001B48"/>
                        <polygon points="30,15 25,3 19,9" fill="#001B48"/>
                        <polygon points="8,13 11,6 15,10" fill="#93C5FD"/>
                        <polygon points="28,13 25,6 21,10" fill="#93C5FD"/>
                        <circle cx="18" cy="19" r="13" fill="#001B48"/>
                        <path d="M10 20 C10 13, 26 13, 26 20 C26 27, 10 27, 10 20 Z" fill="#FFFFFF"/>
                        <ellipse cx="14" cy="19" rx="1.8" ry="2.2" fill="#001B48"/>
                        <ellipse cx="22" cy="19" rx="1.8" ry="2.2" fill="#001B48"/>
                        <circle cx="13.4" cy="18.2" r="0.6" fill="#FFFFFF"/>
                        <circle cx="21.4" cy="18.2" r="0.6" fill="#FFFFFF"/>
                        <polygon points="17,22 19,22 18,23" fill="#001B48"/>
                        <path d="M18 23 L18 24.5 M16.5 24.5 C17.2 25, 18 24.5, 18 24.5 C18 24.5, 18.8 25, 19.5 24.5" stroke="#001B48" stroke-width="0.8" fill="none" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-white leading-none">englify</p>
                    <p class="text-[10px] text-sky-200 uppercase tracking-wider mt-1 font-semibold">Siswa Panel</p>
                </div>
            </a>
            <button onclick="toggleMobileSidebar()" class="text-slate-400 hover:text-white p-2 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto text-sm font-semibold text-slate-200">
            <a href="{{ route('siswa.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('siswa.dashboard') ? 'sidebar-item-active' : 'hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="{{ route('siswa.materi') }}" class="sidebar-link flex items-center justify-between px-4 py-3 rounded-xl {{ request()->routeIs('siswa.materi*') ? 'sidebar-item-active' : 'hover:bg-white/10' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span>Materi</span>
                </div>
                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-md bg-sky-400/20 text-sky-200 border border-sky-300/30">Materi & Quiz</span>
            </a>
            <a href="{{ route('siswa.peta-quiz') }}" class="sidebar-link flex items-center justify-between px-4 py-3 rounded-xl {{ request()->routeIs('siswa.peta-quiz') ? 'sidebar-item-active' : 'hover:bg-white/10' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    <span>Peta Quiz</span>
                </div>
                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-md bg-emerald-400/20 text-emerald-200 border border-emerald-300/30">Rute Skor</span>
            </a>
            <a href="{{ route('siswa.progres') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('siswa.progres*') ? 'sidebar-item-active' : 'hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Progress Belajar
            </a>
            <a href="{{ route('siswa.reminder') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('siswa.reminder') ? 'sidebar-item-active' : 'hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                Reminder
                @php
                    $unreadCount = \App\Models\PesanAdmin::where('id_user', auth()->user()->id_user)->where('is_read', false)->count();
                @endphp
                @if($unreadCount > 0)
                    <span class="ml-auto bg-rose-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow-sm">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>
            <a href="{{ route('siswa.profil') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('siswa.profil') ? 'sidebar-item-active' : 'hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Profil
            </a>
        </nav>
        <div class="p-5 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="paw-btn w-full flex items-center justify-center gap-2.5 py-2.5 rounded-xl bg-white/10 text-white text-sm font-semibold border border-white/15 transition group">
                    <div class="w-7 h-7 rounded-lg bg-sky-400/15 group-hover:bg-rose-500/25 flex items-center justify-center transition-colors shrink-0">
                        <svg class="paw-icon w-4 h-4 text-sky-300 group-hover:text-rose-300" viewBox="0 0 512 512" fill="currentColor">
                            <path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C120.3 358.3 189 320 256 320s135.7 38.3 186.8 81.2c12.8 10.8 10.6 30.5-3.8 40.8-28.7 20.6-67.6 36-111 36-28.7 0-54.6-6.6-72-19.3-17.4 12.7-43.3 19.3-72 19.3-43.4 0-82.3-15.4-111-36-14.4-10.4-16.6-30.1-3.8-40.8zM440.3 165.3c24.5 14 29.1 51.7 10.2 84.1s-54.1 47.3-78.5 33.3-29.1-51.7-10.2-84.1 54.1-47.3 78.5-33.3zM318.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5 46.9 53.9 32.6 96.8-52.1 69.1-84.4 58.5z"/>
                        </svg>
                    </div>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- MAIN COLUMN                                                    -->
    <!-- ============================================================== -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden relative siswa-bg">

        <!-- TOP NAVIGATION BAR -->
        <header class="bg-white/80 backdrop-blur-md px-4 sm:px-8 py-3.5 flex items-center justify-between gap-4 sticky top-0 z-20 border-b border-blue-200/60 shadow-xs">
            <div class="flex items-center gap-3 lg:hidden">
                <button onclick="toggleMobileSidebar()" class="p-2 text-slate-700 hover:bg-white rounded-xl shadow-xs transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-2 group">
                    <div class="w-9 h-9 rounded-xl bg-[#D6EBEE] flex items-center justify-center p-1.5 shadow-xs transition-transform group-hover:scale-105 shrink-0">
                        <svg viewBox="0 0 36 36" class="w-full h-full text-[#001B48]" fill="currentColor">
                            <polygon points="6,15 11,3 17,9" fill="#001B48"/>
                            <polygon points="30,15 25,3 19,9" fill="#001B48"/>
                            <polygon points="8,13 11,6 15,10" fill="#93C5FD"/>
                            <polygon points="28,13 25,6 21,10" fill="#93C5FD"/>
                            <circle cx="18" cy="19" r="13" fill="#001B48"/>
                            <path d="M10 20 C10 13, 26 13, 26 20 C26 27, 10 27, 10 20 Z" fill="#FFFFFF"/>
                            <ellipse cx="14" cy="19" rx="1.8" ry="2.2" fill="#001B48"/>
                            <ellipse cx="22" cy="19" rx="1.8" ry="2.2" fill="#001B48"/>
                            <circle cx="13.4" cy="18.2" r="0.6" fill="#FFFFFF"/>
                            <circle cx="21.4" cy="18.2" r="0.6" fill="#FFFFFF"/>
                            <polygon points="17,22 19,22 18,23" fill="#001B48"/>
                            <path d="M18 23 L18 24.5 M16.5 24.5 C17.2 25, 18 24.5, 18 24.5 C18 24.5, 18.8 25, 19.5 24.5" stroke="#001B48" stroke-width="0.8" fill="none" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <span class="font-extrabold text-xl text-[#001B48] tracking-tight leading-none">englify</span>
                </a>
            </div>

            <!-- SEARCH BAR DESKTOP (DYNAMIC IN-PAGE LIVE SEARCH) -->
            <div class="relative max-w-md w-full hidden md:block" id="pageLiveSearchContainer">
                <div class="relative">
                    <input type="text" 
                           id="pageLiveSearchInput"
                           placeholder="Cari materi, bab, kuis di halaman ini..."
                           autocomplete="off"
                           class="w-full pl-11 pr-24 py-2.5 bg-white border border-slate-200/90 rounded-full text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#018ABE]/40 focus:border-[#018ABE] shadow-xs transition">
                    <svg class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>

                    <!-- Match Count Badge & Clear Button & Keyboard Shortcut -->
                    <div class="absolute right-3.5 top-1/2 -translate-y-1/2 flex items-center gap-1.5">
                        <span id="pageLiveSearchCountBadge" class="hidden text-[11px] font-bold px-2 py-0.5 rounded-full bg-blue-50 text-[#018ABE] border border-blue-200 shadow-2xs">
                            0
                        </span>
                        <button type="button" 
                                id="pageLiveSearchClearBtn" 
                                onclick="clearLivePageSearch()" 
                                class="hidden w-5 h-5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 items-center justify-center text-xs transition"
                                title="Hapus pencarian (Esc)">
                            &times;
                        </button>
                        <span id="pageLiveSearchKbd" class="hidden lg:inline-flex items-center px-1.5 py-0.5 text-[10px] text-slate-400 bg-slate-100 border border-slate-200 rounded font-mono pointer-events-none shadow-2xs">
                            Ctrl+K
                        </span>
                    </div>
                </div>

                <!-- DROPDOWN HASIL PENCARIAN LIVE -->
                <div id="pageLiveSearchResultsDropdown" 
                     class="hidden absolute left-0 right-0 top-full mt-2 bg-white rounded-2xl shadow-xl border border-slate-200/90 overflow-hidden z-50 divide-y divide-slate-100 max-h-96 overflow-y-auto">
                    <div class="px-4 py-2.5 bg-slate-50/90 flex items-center justify-between text-xs text-slate-500 border-b border-slate-100 sticky top-0 backdrop-blur-xs">
                        <span class="font-bold flex items-center gap-1.5 text-slate-700">
                            <span class="w-2 h-2 rounded-full bg-[#018ABE]"></span>
                            Hasil di Halaman Ini
                        </span>
                        <span id="pageLiveSearchDropdownCount" class="font-semibold text-slate-500 text-[11px]">0 ditemukan</span>
                    </div>
                    <div id="pageLiveSearchResultsList" class="p-2 space-y-1">
                        <!-- Diisi secara dinamis oleh JavaScript -->
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2.5 sm:gap-4 ml-auto">
                <!-- Mobile Search Toggle Button -->
                <button type="button" 
                        onclick="toggleMobileSearch()"
                        class="md:hidden w-10 h-10 rounded-full bg-white border border-slate-200/80 flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-50 shadow-xs transition"
                        title="Cari di halaman ini">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>

                <!-- NOTIFICATION BELL & POPUP DROPDOWN -->
                <div class="relative" id="siswaNotificationContainer">
                    <button type="button" 
                            onclick="toggleSiswaNotification()" 
                            id="siswaNotificationBellBtn"
                            class="w-10 h-10 rounded-full bg-white border border-slate-200/80 flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-50 shadow-xs transition relative" 
                            title="Notifikasi & Reminder">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @if(($notifUnreadCount ?? 0) > 0)
                            <span id="siswaNotifDot" class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-white animate-pulse"></span>
                            <script>
                                (function() {
                                    try {
                                        var clearedAt = parseInt(localStorage.getItem('englify_notifs_cleared_at') || '0', 10);
                                        var seenAt = parseInt(localStorage.getItem('englify_last_seen_notif') || '0', 10);
                                        var latestTime = {{ !empty($notifikasiTerbaru[0]['time']) ? strtotime($notifikasiTerbaru[0]['time']) : 0 }};
                                        if (clearedAt >= latestTime || seenAt >= latestTime) {
                                            var dot = document.getElementById('siswaNotifDot');
                                            if (dot) dot.style.display = 'none';
                                        }
                                    } catch(e) {}
                                })();
                            </script>
                        @endif
                    </button>

                    <!-- POPUP NOTIFIKASI DROPDOWN -->
                    <div id="siswaNotificationDropdown" 
                         class="hidden absolute right-0 top-full mt-2 w-[calc(100vw-2rem)] max-w-sm sm:w-96 bg-white rounded-2xl shadow-xl border border-slate-200/90 overflow-hidden z-50 divide-y divide-slate-100">
                        <!-- Header Popup -->
                        <div class="px-4 py-3 bg-gradient-to-r from-slate-50 to-[#D6EBEE]/20 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="text-base">🔔</span>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">Notifikasi & Pengingat</h4>
                                    <p id="notifTotalCountText" class="text-[10px] text-slate-500">{{ count($notifikasiTerbaru ?? []) }} notifikasi baru (7 hari)</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                @if(($notifUnreadCount ?? 0) > 0)
                                    <span id="notifUnreadBadge" class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-rose-50 text-rose-600 border border-rose-200">
                                        {{ $notifUnreadCount }} Baru
                                    </span>
                                @endif
                                <button type="button" 
                                        onclick="clearAllSiswaNotifications(event)" 
                                        class="text-[11px] font-bold text-slate-400 hover:text-rose-600 px-2 py-1 rounded-lg hover:bg-rose-50 border border-transparent hover:border-rose-200 transition flex items-center gap-1 shadow-2xs"
                                        title="Bersihkan semua notifikasi">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    <span>Bersihkan</span>
                                </button>
                            </div>
                        </div>

                        <!-- List Notifikasi -->
                        <div id="siswaNotificationList" class="max-h-80 overflow-y-auto divide-y divide-slate-100 p-1">
                            @forelse($notifikasiTerbaru ?? [] as $n)
                                <div data-notif-id="{{ $n['id'] }}"
                                     class="siswa-notif-item flex items-start gap-2.5 p-2.5 hover:bg-slate-50/90 rounded-xl transition group relative">
                                    <a href="{{ $n['url'] }}" class="flex items-start gap-3 flex-1 min-w-0">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 text-base shadow-2xs {{ $n['badge_color'] }}">
                                            @if($n['type'] === 'reminder')
                                                🔔
                                            @elseif($n['type'] === 'materi')
                                                📖
                                            @elseif($n['type'] === 'bab')
                                                📚
                                            @else
                                                ✨
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between gap-1 mb-0.5">
                                                <span class="text-xs font-bold text-slate-800 group-hover:text-[#018ABE] transition truncate">
                                                    {{ $n['title'] }}
                                                </span>
                                                <span class="text-[10px] text-slate-400 shrink-0">{{ $n['time_label'] }}</span>
                                            </div>
                                            <p class="text-[11px] text-slate-600 line-clamp-2 leading-relaxed">
                                                {{ $n['desc'] }}
                                            </p>
                                            <div class="mt-1 flex items-center gap-1.5">
                                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded {{ $n['badge_color'] }}">
                                                    {{ $n['badge'] }}
                                                </span>
                                                <span class="text-[10px] text-[#018ABE] font-semibold opacity-0 group-hover:opacity-100 transition flex items-center gap-0.5">
                                                    Buka
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                                </span>
                                            </div>
                                        </div>
                                    </a>

                                    <!-- Tombol Hapus / Sampah Notifikasi Satuan -->
                                    <button type="button" 
                                            onclick="deleteSingleNotification('{{ $n['id'] }}', '{{ $n['delete_url'] ?? '' }}', event)" 
                                            class="w-7 h-7 rounded-lg text-slate-300 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center shrink-0 opacity-40 group-hover:opacity-100 transition mt-1" 
                                            title="Hapus notifikasi ini">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            @empty
                                <div id="siswaNotificationEmptyState" class="py-8 px-4 text-center">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2 text-base">📭</div>
                                    <p class="text-xs font-bold text-slate-700">Tidak ada notifikasi baru</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Semua pengingat dan materi baru akan muncul di sini.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Footer Popup -->
                        <div class="p-2.5 bg-slate-50/80 text-center flex items-center justify-between px-4">
                            <a href="{{ route('siswa.reminder') }}" class="text-[11px] font-bold text-[#018ABE] hover:text-[#02457A] transition flex items-center gap-1">
                                Semua Pesan Admin
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                            <a href="{{ route('siswa.materi') }}" class="text-[11px] font-bold text-slate-500 hover:text-slate-800 transition">
                                Jelajahi Materi
                            </a>
                        </div>
                    </div>
                </div>

                <div class="relative" id="profileDropdownContainer">
                    <button type="button"
                            id="profileDropdownBtn"
                            onclick="toggleProfileDropdown()" 
                            class="flex items-center gap-2.5 bg-white border border-slate-200/90 rounded-full py-1.5 pl-1.5 pr-3 shadow-xs hover:border-[#018ABE]/40 hover:bg-slate-50 transition cursor-pointer">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 border border-indigo-200 flex items-center justify-center overflow-hidden shrink-0 text-white font-bold text-sm shadow-2xs">
                            {{ substr(auth()->user()->nama ?? auth()->user()->name ?? 'S', 0, 1) }}
                        </div>
                        <div class="text-left hidden sm:block">
                            <p class="text-xs font-bold text-slate-800 leading-tight">{{ auth()->user()->nama ?? auth()->user()->name ?? 'Siswa' }}</p>
                            <p class="text-[10px] font-semibold text-slate-400 leading-none">Siswa</p>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" id="profileDropdownChevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Dropdown Popup Menu Profile -->
                    <div id="profile-dropdown" class="hidden absolute right-0 top-full mt-2 w-64 bg-white rounded-2xl shadow-xl border border-slate-200/90 py-1.5 z-50 overflow-hidden divide-y divide-slate-100">
                        <!-- Header User -->
                        <div class="px-4 py-3 bg-gradient-to-br from-slate-50 to-blue-50/40">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white font-bold text-sm flex items-center justify-center shadow-2xs shrink-0">
                                    {{ substr(auth()->user()->nama ?? auth()->user()->name ?? 'S', 0, 1) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-bold text-slate-800 truncate">{{ auth()->user()->nama ?? auth()->user()->name ?? 'Siswa' }}</p>
                                    <p class="text-[11px] text-slate-400 truncate">{{ auth()->user()->email ?? '' }}</p>
                                    <span class="inline-block mt-1 text-[9px] font-extrabold uppercase tracking-wider bg-blue-100 text-[#02457A] px-2 py-0.5 rounded-full">
                                        Siswa Aktif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Menu Links -->
                        <div class="p-1.5 space-y-0.5">
                            <a href="{{ route('siswa.profil') }}" class="flex items-center gap-2.5 px-3 py-2 text-xs font-bold text-slate-700 hover:text-[#018ABE] hover:bg-slate-50 rounded-xl transition group">
                                <div class="w-7 h-7 rounded-lg bg-blue-50 group-hover:bg-[#018ABE]/10 text-[#018ABE] flex items-center justify-center transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span>Profil Saya</span>
                                    <p class="text-[10px] text-slate-400 font-normal truncate">Edit akun & kata sandi</p>
                                </div>
                                <svg class="w-3.5 h-3.5 text-slate-300 group-hover:text-[#018ABE] group-hover:translate-x-0.5 transition shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>

                            <a href="{{ route('siswa.progres') }}" class="flex items-center gap-2.5 px-3 py-2 text-xs font-bold text-slate-700 hover:text-emerald-600 hover:bg-emerald-50/50 rounded-xl transition group">
                                <div class="w-7 h-7 rounded-lg bg-emerald-50 group-hover:bg-emerald-100 text-emerald-600 flex items-center justify-center transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span>Progress Belajar</span>
                                    <p class="text-[10px] text-slate-400 font-normal truncate">Statistik materi & kuis</p>
                                </div>
                                <svg class="w-3.5 h-3.5 text-slate-300 group-hover:text-emerald-600 group-hover:translate-x-0.5 transition shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>

                            <a href="{{ route('siswa.peta-quiz') }}" class="flex items-center gap-2.5 px-3 py-2 text-xs font-bold text-slate-700 hover:text-amber-600 hover:bg-amber-50/50 rounded-xl transition group">
                                <div class="w-7 h-7 rounded-lg bg-amber-50 group-hover:bg-amber-100 text-amber-600 flex items-center justify-center transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span>Peta Kuis & Bab</span>
                                    <p class="text-[10px] text-slate-400 font-normal truncate">Jalur belajar interaktif</p>
                                </div>
                                <svg class="w-3.5 h-3.5 text-slate-300 group-hover:text-amber-600 group-hover:translate-x-0.5 transition shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>

                        <!-- Logout in Dropdown -->
                        <div class="p-1.5">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="paw-btn w-full flex items-center justify-between px-3 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-xl transition group">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-lg bg-rose-50 group-hover:bg-rose-100 text-rose-500 flex items-center justify-center transition">
                                            <svg class="paw-icon w-3.5 h-3.5 text-rose-500" viewBox="0 0 512 512" fill="currentColor">
                                                <path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C120.3 358.3 189 320 256 320s135.7 38.3 186.8 81.2c12.8 10.8 10.6 30.5-3.8 40.8-28.7 20.6-67.6 36-111 36-28.7 0-54.6-6.6-72-19.3-17.4 12.7-43.3 19.3-72 19.3-43.4 0-82.3-15.4-111-36-14.4-10.4-16.6-30.1-3.8-40.8zM440.3 165.3c24.5 14 29.1 51.7 10.2 84.1s-54.1 47.3-78.5 33.3-29.1-51.7-10.2-84.1 54.1-47.3 78.5-33.3zM318.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5 46.9 53.9 32.6 96.8-52.1 69.1-84.4 58.5z"/>
                                            </svg>
                                        </div>
                                        <span>Logout</span>
                                    </div>
                                    <span class="text-[10px] text-rose-400 group-hover:text-rose-600 font-semibold opacity-0 group-hover:opacity-100 transition">
                                        Bye! 🐾
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- MOBILE SEARCH BAR SLIDEOUT -->
        <div id="mobileSearchWrapper" class="hidden md:hidden px-4 py-3 bg-white/95 backdrop-blur-md border-b border-blue-200/60 shadow-xs sticky top-[57px] z-20">
            <div class="relative">
                <input type="text" 
                       id="pageLiveSearchInputMobile"
                       placeholder="Cari materi, bab, kuis di halaman ini..."
                       autocomplete="off"
                       class="w-full pl-10 pr-9 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#018ABE]/40 focus:border-[#018ABE] transition">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <button type="button" 
                        id="pageLiveSearchClearBtnMobile" 
                        onclick="clearLivePageSearch()" 
                        class="hidden absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-xs">
                    &times;
                </button>
            </div>
            <!-- Mobile Search Results Dropdown -->
            <div id="pageLiveSearchResultsDropdownMobile" 
                 class="hidden absolute left-4 right-4 top-full mt-2 bg-white rounded-2xl shadow-xl border border-slate-200/90 overflow-hidden z-50 divide-y divide-slate-100 max-h-80 overflow-y-auto">
                <div class="px-4 py-2.5 bg-slate-50/90 flex items-center justify-between text-xs text-slate-500 border-b border-slate-100 sticky top-0 backdrop-blur-xs">
                    <span class="font-bold flex items-center gap-1.5 text-slate-700">
                        <span class="w-2 h-2 rounded-full bg-[#018ABE]"></span>
                        Hasil di Halaman Ini
                    </span>
                    <span id="pageLiveSearchDropdownCountMobile" class="font-semibold text-slate-500 text-[11px]">0 ditemukan</span>
                </div>
                <div id="pageLiveSearchResultsListMobile" class="p-2 space-y-1"></div>
            </div>
        </div>

        <!-- MAIN SCROLLABLE CONTENT -->
        <main class="flex-1 overflow-y-auto px-3.5 sm:px-8 pb-28 lg:pb-12">
            <div class="max-w-[1400px] mx-auto py-2 sm:py-3">
                @if(session('success'))
                <div class="mb-5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold px-4 py-3 rounded-2xl flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs">✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">&times;</button>
                </div>
                @endif

                @include('layouts.partials.breadcrumbs')

                @yield('content')
            </div>

            <footer class="mt-8 text-center text-xs font-semibold text-slate-400 py-4 border-t border-slate-200/60">
                Englify &nbsp;&mdash;&nbsp; Learn &nbsp;&bull;&nbsp; Grow &nbsp;&bull;&nbsp; Achieve <span class="text-amber-400">&#10023;</span>
            </footer>
        </main>
    </div>
</div>

<!-- ============================================================== -->
<!-- MOBILE DOCKED BOTTOM NAVIGATION (LG:HIDDEN)                    -->
<!-- ============================================================== -->
@php
    $mobileNavUnreadCount = \App\Models\PesanAdmin::where('id_user', auth()->user()->id_user)->where('is_read', false)->count();
@endphp
<nav class="fixed bottom-0 inset-x-0 z-30 lg:hidden bg-white/95 backdrop-blur-md border-t border-[#97CADB]/40 shadow-lg px-2 py-1.5 flex justify-around items-center" style="padding-bottom: max(0.45rem, env(safe-area-inset-bottom));">
    <!-- 1. Beranda / Dashboard -->
    <a href="{{ route('siswa.dashboard') }}" 
       class="flex flex-col items-center justify-center py-1 px-2 rounded-xl transition-all duration-200 min-w-[54px] {{ request()->routeIs('siswa.dashboard') ? 'text-[#018ABE] font-extrabold scale-105' : 'text-slate-500 hover:text-slate-800 font-semibold' }}">
        <div class="relative {{ request()->routeIs('siswa.dashboard') ? 'p-1 rounded-lg bg-[#D6EBEE]/80' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('siswa.dashboard') ? '2.5' : '2' }}" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
        </div>
        <span class="text-[10px] tracking-tight mt-0.5">Beranda</span>
    </a>

    <!-- 2. Materi -->
    <a href="{{ route('siswa.materi') }}" 
       class="flex flex-col items-center justify-center py-1 px-2 rounded-xl transition-all duration-200 min-w-[54px] {{ request()->routeIs('siswa.materi*') ? 'text-[#018ABE] font-extrabold scale-105' : 'text-slate-500 hover:text-slate-800 font-semibold' }}">
        <div class="relative {{ request()->routeIs('siswa.materi*') ? 'p-1 rounded-lg bg-[#D6EBEE]/80' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('siswa.materi*') ? '2.5' : '2' }}" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
        </div>
        <span class="text-[10px] tracking-tight mt-0.5">Materi</span>
    </a>

    <!-- 3. Peta Quiz -->
    <a href="{{ route('siswa.peta-quiz') }}" 
       class="flex flex-col items-center justify-center py-1 px-2 rounded-xl transition-all duration-200 min-w-[54px] {{ request()->routeIs('siswa.peta-quiz*') || request()->routeIs('siswa.quiz*') ? 'text-[#018ABE] font-extrabold scale-105' : 'text-slate-500 hover:text-slate-800 font-semibold' }}">
        <div class="relative {{ request()->routeIs('siswa.peta-quiz*') || request()->routeIs('siswa.quiz*') ? 'p-1 rounded-lg bg-[#D6EBEE]/80' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('siswa.peta-quiz*') || request()->routeIs('siswa.quiz*') ? '2.5' : '2' }}" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
        </div>
        <span class="text-[10px] tracking-tight mt-0.5">Peta Quiz</span>
    </a>

    <!-- 4. Progress -->
    <a href="{{ route('siswa.progres') }}" 
       class="flex flex-col items-center justify-center py-1 px-2 rounded-xl transition-all duration-200 min-w-[54px] {{ request()->routeIs('siswa.progres*') ? 'text-[#018ABE] font-extrabold scale-105' : 'text-slate-500 hover:text-slate-800 font-semibold' }}">
        <div class="relative {{ request()->routeIs('siswa.progres*') ? 'p-1 rounded-lg bg-[#D6EBEE]/80' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('siswa.progres*') ? '2.5' : '2' }}" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
        </div>
        <span class="text-[10px] tracking-tight mt-0.5">Progress</span>
    </a>

    <!-- 5. Reminder -->
    <a href="{{ route('siswa.reminder') }}" 
       class="flex flex-col items-center justify-center py-1 px-2 rounded-xl transition-all duration-200 min-w-[54px] relative {{ request()->routeIs('siswa.reminder') ? 'text-[#018ABE] font-extrabold scale-105' : 'text-slate-500 hover:text-slate-800 font-semibold' }}">
        <div class="relative {{ request()->routeIs('siswa.reminder') ? 'p-1 rounded-lg bg-[#D6EBEE]/80' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('siswa.reminder') ? '2.5' : '2' }}" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            @if($mobileNavUnreadCount > 0)
                <span class="absolute -top-1 -right-1.5 w-4 h-4 bg-rose-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center shadow-xs">
                    {{ $mobileNavUnreadCount > 9 ? '9+' : $mobileNavUnreadCount }}
                </span>
            @endif
        </div>
        <span class="text-[10px] tracking-tight mt-0.5">Reminder</span>
    </a>
</nav>

<script>
function toggleSidebarCollapse() {
    document.getElementById('sidebar').classList.toggle('collapsed');
}
function toggleMobileSidebar() {
    const sb = document.getElementById('mobile-sidebar');
    const bd = document.getElementById('mobile-backdrop');
    const open = sb.classList.contains('-translate-x-full');
    sb.classList.toggle('-translate-x-full', !open);
    bd.classList.toggle('hidden', !open);
}
function toggleSiswaNotification() {
    const dropdown = document.getElementById('siswaNotificationDropdown');
    if (!dropdown) return;
    const isOpening = dropdown.classList.contains('hidden');
    dropdown.classList.toggle('hidden');

    if (isOpening) {
        // Hapus titik merah notifikasi seketika dan simpan state seen
        const dot = document.getElementById('siswaNotifDot');
        if (dot) dot.remove();

        const unreadBadge = document.getElementById('notifUnreadBadge');
        if (unreadBadge) unreadBadge.remove();

        const now = Math.floor(Date.now() / 1000);
        try {
            localStorage.setItem('englify_last_seen_notif', now.toString());
            document.cookie = "englify_last_seen_notif=" + now + "; path=/; max-age=2592000; SameSite=Lax";
        } catch(e) {}
    }
}

// Close notification & profile dropdown on outside click
document.addEventListener('click', function(e) {
    const notifContainer = document.getElementById('siswaNotificationContainer');
    const notifDropdown = document.getElementById('siswaNotificationDropdown');
    if (notifContainer && notifDropdown && !notifContainer.contains(e.target)) {
        notifDropdown.classList.add('hidden');
    }

    const profContainer = document.getElementById('profileDropdownContainer');
    const profDropdown = document.getElementById('profile-dropdown');
    const chevron = document.getElementById('profileDropdownChevron');
    if (profContainer && profDropdown && !profContainer.contains(e.target)) {
        profDropdown.classList.add('hidden');
        if (chevron) chevron.classList.remove('rotate-180');
    }
});

// ==========================================
// NOTIFICATION CLEANUP ENGINE (TRASH & CLEAR ALL)
// ==========================================
function getDismissedNotifs() {
    try {
        return JSON.parse(localStorage.getItem('englify_dismissed_notifs') || '[]');
    } catch(e) {
        return [];
    }
}

function saveDismissedNotifs(list) {
    try {
        localStorage.setItem('englify_dismissed_notifs', JSON.stringify(list));
        document.cookie = "englify_dismissed_ids=" + encodeURIComponent(JSON.stringify(list)) + "; path=/; max-age=2592000; SameSite=Lax";
    } catch(e) {}
}

function updateNotifCounts(count) {
    const list = document.getElementById('siswaNotificationList');
    const totalCountText = document.getElementById('notifTotalCountText');
    const unreadBadge = document.getElementById('notifUnreadBadge');
    const bellDot = document.getElementById('siswaNotifDot');

    if (totalCountText) {
        totalCountText.textContent = `${count} notifikasi baru (7 hari)`;
    }

    if (count <= 0) {
        if (unreadBadge) unreadBadge.remove();
        if (bellDot) bellDot.remove();
        if (list && !document.getElementById('siswaNotificationEmptyState')) {
            list.innerHTML = `
                <div id="siswaNotificationEmptyState" class="py-8 px-4 text-center">
                    <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center mx-auto mb-2 text-base">✨</div>
                    <p class="text-xs font-bold text-slate-700">Kotak Notifikasi Bersih</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">Semua notifikasi dan pengingat sudah dibersihkan.</p>
                </div>
            `;
        }
    }
}

function initSiswaNotifications() {
    const dismissed = getDismissedNotifs();
    const now = Math.floor(Date.now() / 1000);
    const clearedAt = parseInt(localStorage.getItem('englify_notifs_cleared_at') || '0', 10);
    const seenAt = parseInt(localStorage.getItem('englify_last_seen_notif') || '0', 10);

    let visibleCount = 0;
    document.querySelectorAll('.siswa-notif-item').forEach(item => {
        const id = item.dataset.notifId;
        if (dismissed.includes(id)) {
            item.remove();
        } else {
            visibleCount++;
        }
    });

    if (clearedAt > 0 || seenAt > 0) {
        const dot = document.getElementById('siswaNotifDot');
        if (dot) dot.remove();
    }

    updateNotifCounts(visibleCount);
}

function deleteSingleNotification(notifId, deleteUrl, event) {
    if (event) {
        event.stopPropagation();
        event.preventDefault();
    }

    // Persist dismissed id in localStorage and cookie
    const dismissed = getDismissedNotifs();
    if (!dismissed.includes(notifId)) {
        dismissed.push(notifId);
        saveDismissedNotifs(dismissed);
    }

    // If it's a database reminder, delete on backend
    if (deleteUrl) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        fetch(deleteUrl, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        }).catch(err => console.log('Error deleting reminder:', err));
    }

    // Animate item removal
    const item = document.querySelector(`.siswa-notif-item[data-notif-id="${notifId}"]`);
    if (item) {
        item.style.transition = 'all 0.25s ease';
        item.style.opacity = '0';
        item.style.transform = 'translateX(20px)';
        setTimeout(() => {
            item.remove();
            const remaining = document.querySelectorAll('.siswa-notif-item').length;
            updateNotifCounts(remaining);
        }, 250);
    }
}

function clearAllSiswaNotifications(event) {
    if (event) {
        event.stopPropagation();
        event.preventDefault();
    }

    // Collect all visible item IDs
    const dismissed = getDismissedNotifs();
    document.querySelectorAll('.siswa-notif-item').forEach(item => {
        const id = item.dataset.notifId;
        if (id && !dismissed.includes(id)) dismissed.push(id);
    });
    saveDismissedNotifs(dismissed);

    const now = Math.floor(Date.now() / 1000);
    try {
        localStorage.setItem('englify_notifs_cleared_at', now.toString());
        document.cookie = "englify_notifs_cleared_at=" + now + "; path=/; max-age=2592000; SameSite=Lax";
    } catch(e) {}

    // Call backend to clear all student reminders
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    fetch('{{ route("siswa.reminder.clearAll") }}', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    }).catch(err => console.log('Error clearing reminders:', err));

    updateNotifCounts(0);
}

document.addEventListener('DOMContentLoaded', initSiswaNotifications);

function toggleProfileDropdown() {
    const dd = document.getElementById('profile-dropdown');
    const chevron = document.getElementById('profileDropdownChevron');
    if (!dd) return;
    const isClosed = dd.classList.contains('hidden');
    dd.classList.toggle('hidden');
    if (chevron) {
        if (isClosed) {
            chevron.classList.add('rotate-180');
        } else {
            chevron.classList.remove('rotate-180');
        }
    }
}

// ==========================================
// DYNAMIC IN-PAGE LIVE SEARCH ENGINE
// ==========================================
const pageLiveSearchInput = document.getElementById('pageLiveSearchInput');
const pageLiveSearchInputMobile = document.getElementById('pageLiveSearchInputMobile');
const pageLiveSearchClearBtn = document.getElementById('pageLiveSearchClearBtn');
const pageLiveSearchClearBtnMobile = document.getElementById('pageLiveSearchClearBtnMobile');
const pageLiveSearchCountBadge = document.getElementById('pageLiveSearchCountBadge');
const pageLiveSearchKbd = document.getElementById('pageLiveSearchKbd');
const pageLiveSearchResultsDropdown = document.getElementById('pageLiveSearchResultsDropdown');
const pageLiveSearchResultsList = document.getElementById('pageLiveSearchResultsList');
const pageLiveSearchDropdownCount = document.getElementById('pageLiveSearchDropdownCount');
const pageLiveSearchResultsDropdownMobile = document.getElementById('pageLiveSearchResultsDropdownMobile');
const pageLiveSearchResultsListMobile = document.getElementById('pageLiveSearchResultsListMobile');
const pageLiveSearchDropdownCountMobile = document.getElementById('pageLiveSearchDropdownCountMobile');
const mobileSearchWrapper = document.getElementById('mobileSearchWrapper');

function toggleMobileSearch() {
    if (!mobileSearchWrapper) return;
    const isHidden = mobileSearchWrapper.classList.contains('hidden');
    mobileSearchWrapper.classList.toggle('hidden', !isHidden);
    if (isHidden && pageLiveSearchInputMobile) {
        setTimeout(() => pageLiveSearchInputMobile.focus(), 60);
    }
}

function clearLivePageSearch() {
    if (pageLiveSearchInput) pageLiveSearchInput.value = '';
    if (pageLiveSearchInputMobile) pageLiveSearchInputMobile.value = '';
    executePageLiveSearch('');
    if (pageLiveSearchInput && window.innerWidth >= 768) {
        pageLiveSearchInput.focus();
    } else if (pageLiveSearchInputMobile && window.innerWidth < 768) {
        pageLiveSearchInputMobile.focus();
    }
}

// Global Keyboard Shortcut: Ctrl+K or / focuses search, Esc clears search
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && (e.key === 'k' || e.key === 'K')) {
        e.preventDefault();
        const input = window.innerWidth >= 768 ? pageLiveSearchInput : pageLiveSearchInputMobile;
        if (input) {
            if (window.innerWidth < 768 && mobileSearchWrapper && mobileSearchWrapper.classList.contains('hidden')) {
                toggleMobileSearch();
            }
            input.focus();
            input.select();
        }
    } else if (e.key === 'Escape') {
        const query = (pageLiveSearchInput?.value || pageLiveSearchInputMobile?.value || '').trim();
        if (query) {
            clearLivePageSearch();
        } else if (pageLiveSearchResultsDropdown) {
            pageLiveSearchResultsDropdown.classList.add('hidden');
        }
    }
});

// Close dropdown on outside click
document.addEventListener('click', function(e) {
    const container = document.getElementById('pageLiveSearchContainer');
    if (container && !container.contains(e.target) && mobileSearchWrapper && !mobileSearchWrapper.contains(e.target)) {
        if (pageLiveSearchResultsDropdown) pageLiveSearchResultsDropdown.classList.add('hidden');
        if (pageLiveSearchResultsDropdownMobile) pageLiveSearchResultsDropdownMobile.classList.add('hidden');
    }
});

let searchDebounceTimer = null;
function handleSearchInput(e) {
    const query = e.target.value;
    if (e.target === pageLiveSearchInput && pageLiveSearchInputMobile) {
        pageLiveSearchInputMobile.value = query;
    } else if (e.target === pageLiveSearchInputMobile && pageLiveSearchInput) {
        pageLiveSearchInput.value = query;
    }

    clearTimeout(searchDebounceTimer);
    searchDebounceTimer = setTimeout(() => {
        executePageLiveSearch(query);
    }, 100);
}

if (pageLiveSearchInput) pageLiveSearchInput.addEventListener('input', handleSearchInput);
if (pageLiveSearchInputMobile) pageLiveSearchInputMobile.addEventListener('input', handleSearchInput);

function highlightText(text, query) {
    if (!query) return text;
    const escaped = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    const regex = new RegExp(`(${escaped})`, 'gi');
    return text.replace(regex, '<mark class="bg-amber-200 text-slate-900 rounded px-0.5 font-bold">$1</mark>');
}

function executePageLiveSearch(rawQuery) {
    const query = (rawQuery || '').trim().toLowerCase();
    const hasQuery = query.length > 0;

    // Toggle UI controls
    if (pageLiveSearchClearBtn) pageLiveSearchClearBtn.classList.toggle('hidden', !hasQuery);
    if (pageLiveSearchClearBtn) pageLiveSearchClearBtn.classList.toggle('flex', hasQuery);
    if (pageLiveSearchClearBtnMobile) pageLiveSearchClearBtnMobile.classList.toggle('hidden', !hasQuery);
    if (pageLiveSearchClearBtnMobile) pageLiveSearchClearBtnMobile.classList.toggle('flex', hasQuery);
    if (pageLiveSearchKbd) pageLiveSearchKbd.classList.toggle('hidden', hasQuery);

    if (!hasQuery) {
        if (pageLiveSearchCountBadge) pageLiveSearchCountBadge.classList.add('hidden');
        if (pageLiveSearchResultsDropdown) pageLiveSearchResultsDropdown.classList.add('hidden');
        if (pageLiveSearchResultsDropdownMobile) pageLiveSearchResultsDropdownMobile.classList.add('hidden');
        restoreAllPageElements();
        return;
    }

    const matches = [];

    // 1. DASHBOARD PAGE
    const isDashboard = window.location.pathname.includes('/siswa/dashboard') || window.location.pathname === '/siswa';
    if (isDashboard) {
        // A) Bab Cards
        document.querySelectorAll('.dashboard-bab-card').forEach(card => {
            const babTitle = card.querySelector('h4')?.textContent || '';
            const katBadge = card.querySelector('span')?.textContent || '';
            let cardMatches = babTitle.toLowerCase().includes(query) || katBadge.toLowerCase().includes(query);

            const circleNodes = card.querySelectorAll('[data-quiz]');
            circleNodes.forEach(btn => {
                let quizData = {};
                try { quizData = JSON.parse(btn.dataset.quiz || '{}'); } catch(e){}
                const mTitle = quizData.judul_materi || btn.title || '';
                if (mTitle.toLowerCase().includes(query)) {
                    cardMatches = true;
                    matches.push({
                        type: '🎯 Quiz & Materi',
                        badgeClass: 'bg-blue-100 text-[#018ABE]',
                        title: mTitle,
                        subtitle: `${babTitle} • ${katBadge}`,
                        element: btn,
                        action: () => btn.click()
                    });
                }
            });

            if (cardMatches && !circleNodes.length) {
                matches.push({
                    type: '📚 Bab Pembelajaran',
                    badgeClass: 'bg-rose-100 text-rose-700',
                    title: babTitle,
                    subtitle: `${katBadge} • Kuis Bab`,
                    element: card
                });
            }

            card.style.display = cardMatches ? '' : 'none';
        });

        // B) Materi Pembelajaran Terbaru Cards
        document.querySelectorAll('.dashboard-materi-card').forEach(card => {
            const titleEl = card.querySelector('h4');
            const title = titleEl ? titleEl.textContent.trim() : '';
            const desc = card.textContent.toLowerCase();
            const matchesMateri = title.toLowerCase().includes(query) || desc.includes(query);

            card.style.display = matchesMateri ? '' : 'none';
            if (matchesMateri) {
                matches.push({
                    type: '📖 Materi Terbaru',
                    badgeClass: 'bg-emerald-100 text-emerald-700',
                    title: title,
                    subtitle: 'Materi Pembelajaran Terbaru',
                    element: card
                });
            }
        });

        // C) Reminder Items in Sidebar
        document.querySelectorAll('#pesanAdminContainer .p-3').forEach(item => {
            const text = item.textContent.toLowerCase();
            const match = text.includes(query);
            item.style.display = match ? '' : 'none';
        });
    }

    // 2. MATERI PAGE (/siswa/materi)
    const isMateriPage = window.location.pathname.includes('/siswa/materi');
    if (isMateriPage) {
        document.querySelectorAll('.kategori-section').forEach(section => {
            let sectionMatches = false;
            const katName = section.dataset.category || '';

            section.querySelectorAll('.materi-bab-item').forEach(babItem => {
                const babTitle = babItem.dataset.babTitle || babItem.querySelector('h3')?.textContent || '';
                let babMatches = babTitle.toLowerCase().includes(query) || katName.toLowerCase().includes(query);
                let hasMatchingChild = false;

                babItem.querySelectorAll('.materi-item-row').forEach(row => {
                    const rowTitle = row.dataset.materiTitle || row.querySelector('p')?.textContent || '';
                    const rowMatches = rowTitle.toLowerCase().includes(query) || row.textContent.toLowerCase().includes(query);
                    row.style.display = rowMatches ? '' : 'none';

                    if (rowMatches) {
                        hasMatchingChild = true;
                        babMatches = true;
                        sectionMatches = true;
                        matches.push({
                            type: '📖 Materi',
                            badgeClass: 'bg-emerald-100 text-emerald-700',
                            title: rowTitle,
                            subtitle: `${katName} • ${babTitle}`,
                            element: row
                        });
                    }
                });

                if (babMatches) {
                    sectionMatches = true;
                    babItem.style.display = '';
                    const container = babItem.querySelector('[id^="materi-container-"]');
                    if (container && hasMatchingChild) {
                        container.classList.remove('hidden');
                        container.style.display = 'block';
                    }
                } else {
                    babItem.style.display = 'none';
                }
            });

            section.style.display = sectionMatches ? '' : 'none';
        });
    }

    // 3. PETA QUIZ PAGE (/siswa/peta-quiz)
    const isPetaQuizPage = window.location.pathname.includes('/siswa/peta-quiz');
    if (isPetaQuizPage) {
        document.querySelectorAll('.peta-bab-card').forEach(card => {
            const babTitle = card.querySelector('h3')?.textContent || '';
            const kat = card.dataset.category || '';
            let cardMatches = babTitle.toLowerCase().includes(query) || kat.toLowerCase().includes(query);

            card.querySelectorAll('[data-quiz]').forEach(node => {
                let quizData = {};
                try { quizData = JSON.parse(node.dataset.quiz || '{}'); } catch(e){}
                const mTitle = quizData.judul_materi || node.title || '';
                if (mTitle.toLowerCase().includes(query)) {
                    cardMatches = true;
                    matches.push({
                        type: '🎯 Peta Quiz',
                        badgeClass: 'bg-purple-100 text-purple-700',
                        title: mTitle,
                        subtitle: `${babTitle} • ${kat}`,
                        element: node,
                        action: () => node.click()
                    });
                }
            });

            card.style.display = cardMatches ? '' : 'none';
        });
    }

    // 4. REMINDER PAGE (/siswa/reminder)
    const isReminderPage = window.location.pathname.includes('/siswa/reminder');
    if (isReminderPage) {
        document.querySelectorAll('.space-y-4 > div').forEach(card => {
            const text = card.textContent.toLowerCase();
            const match = text.includes(query);
            card.style.display = match ? '' : 'none';
            if (match) {
                const title = card.querySelector('h4')?.textContent.trim() || 'Pesan Admin';
                matches.push({
                    type: '🔔 Reminder',
                    badgeClass: 'bg-amber-100 text-amber-700',
                    title: title,
                    subtitle: 'Pesan dari Admin',
                    element: card
                });
            }
        });
    }

    // 5. GENERIC FALLBACK FOR OTHER PAGES
    if (!isDashboard && !isMateriPage && !isPetaQuizPage && !isReminderPage) {
        const cards = document.querySelectorAll('main .bg-white.rounded-2xl, main .bg-white.rounded-xl, main tbody tr');
        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            const match = text.includes(query);
            card.style.display = match ? '' : 'none';
            if (match) {
                const heading = card.querySelector('h1, h2, h3, h4, th, td strong')?.textContent.trim() || 'Konten Halaman';
                matches.push({
                    type: '📄 Konten',
                    badgeClass: 'bg-slate-100 text-slate-700',
                    title: heading,
                    subtitle: 'Konten yang cocok di halaman ini',
                    element: card
                });
            }
        });
    }

    // Update match count badge
    const totalCount = matches.length;
    if (pageLiveSearchCountBadge) {
        pageLiveSearchCountBadge.textContent = totalCount;
        pageLiveSearchCountBadge.classList.remove('hidden');
    }
    if (pageLiveSearchDropdownCount) {
        pageLiveSearchDropdownCount.textContent = `${totalCount} item ditemukan`;
    }
    if (pageLiveSearchDropdownCountMobile) {
        pageLiveSearchDropdownCountMobile.textContent = `${totalCount} item ditemukan`;
    }

    renderSearchDropdownList(matches, query);
}

function renderSearchDropdownList(matches, query) {
    const isMobile = window.innerWidth < 768;
    const targetDropdown = isMobile ? pageLiveSearchResultsDropdownMobile : pageLiveSearchResultsDropdown;
    const targetList = isMobile ? pageLiveSearchResultsListMobile : pageLiveSearchResultsList;

    if (!targetDropdown || !targetList) return;

    if (matches.length === 0) {
        targetList.innerHTML = `
            <div class="py-6 px-4 text-center">
                <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2 text-base">🔍</div>
                <p class="text-xs font-bold text-slate-700">Tidak ada hasil cocok</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Tidak ditemukan konten dengan kata kunci "<b>${query}</b>" di halaman ini.</p>
                <button type="button" onclick="clearLivePageSearch()" class="mt-2.5 px-3 py-1 bg-[#018ABE] hover:bg-[#02457A] text-white text-xs font-semibold rounded-lg transition shadow-2xs">Reset Pencarian</button>
            </div>
        `;
        targetDropdown.classList.remove('hidden');
        return;
    }

    const maxItems = matches.slice(0, 8);
    let html = '';
    maxItems.forEach((m, idx) => {
        html += `
            <div onclick="jumpToSearchResult(${idx})" 
                 class="search-result-item flex items-center justify-between p-2.5 hover:bg-slate-50 rounded-xl cursor-pointer transition group border border-transparent hover:border-slate-200">
                <div class="flex items-center gap-2.5 min-w-0 flex-1">
                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-md ${m.badgeClass} shrink-0">
                        ${m.type}
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-bold text-slate-800 truncate group-hover:text-[#018ABE] transition">
                            ${highlightText(m.title, query)}
                        </p>
                        <p class="text-[10px] text-slate-400 truncate mt-0.5">
                            ${m.subtitle}
                        </p>
                    </div>
                </div>
                <svg class="w-3.5 h-3.5 text-slate-300 group-hover:text-[#018ABE] group-hover:translate-x-0.5 transition shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
        `;
    });

    if (matches.length > 8) {
        html += `
            <div class="p-2 text-center text-[10px] text-slate-400 border-t border-slate-100">
                +${matches.length - 8} hasil lainnya terlihat di halaman
            </div>
        `;
    }

    window._currentSearchMatches = matches;
    targetList.innerHTML = html;
    targetDropdown.classList.remove('hidden');
}

window.jumpToSearchResult = function(index) {
    if (!window._currentSearchMatches || !window._currentSearchMatches[index]) return;
    const match = window._currentSearchMatches[index];

    if (pageLiveSearchResultsDropdown) pageLiveSearchResultsDropdown.classList.add('hidden');
    if (pageLiveSearchResultsDropdownMobile) pageLiveSearchResultsDropdownMobile.classList.add('hidden');

    if (match.element) {
        match.element.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        match.element.classList.add('ring-4', 'ring-[#018ABE]', 'ring-offset-2', 'transition-all', 'duration-500');
        setTimeout(() => {
            match.element.classList.remove('ring-4', 'ring-[#018ABE]', 'ring-offset-2');
        }, 2200);

        if (typeof match.action === 'function') {
            match.action();
        }
    }
};

function restoreAllPageElements() {
    // Dashboard
    document.querySelectorAll('.dashboard-bab-card, .dashboard-materi-card, #pesanAdminContainer .p-3').forEach(el => el.style.display = '');
    // Materi
    document.querySelectorAll('.kategori-section, .materi-bab-item, .materi-item-row').forEach(el => el.style.display = '');
    // Peta Quiz
    document.querySelectorAll('.peta-bab-card').forEach(el => el.style.display = '');
    // Reminder
    document.querySelectorAll('.space-y-4 > div').forEach(el => el.style.display = '');
    // Generic
    document.querySelectorAll('main .bg-white.rounded-2xl, main .bg-white.rounded-xl, main tbody tr').forEach(el => el.style.display = '');
}

// ==========================================
// ENGLIFY NOTIFICATION SYSTEM (SweetAlert2)
// ==========================================
window.showToast = function(title, type = 'success', text = '') {
    if (typeof Swal === 'undefined') return;
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        customClass: {
            popup: 'englify-toast'
        },
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    return Toast.fire({
        icon: type,
        title: title,
        html: text ? `<div class="text-xs text-slate-500 mt-0.5">${text}</div>` : undefined
    });
};

window.showAlert = function(title, text = '', type = 'info') {
    if (typeof Swal === 'undefined') {
        console.warn(title + (text ? ': ' + text : ''));
        return Promise.resolve();
    }
    return Swal.fire({
        icon: type,
        title: title,
        html: text ? `<p class="text-sm text-slate-600">${text}</p>` : '',
        confirmButtonText: 'Oke, Mengerti',
        buttonsStyling: false,
        customClass: {
            popup: 'englify-swal',
            confirmButton: 'englify-swal-confirm'
        }
    });
};

window.showSuccessAlert = function(title, text = '') {
    if (typeof Swal === 'undefined') {
        console.warn(title + (text ? ': ' + text : ''));
        return Promise.resolve();
    }
    return Swal.fire({
        icon: 'success',
        title: title,
        html: text ? `<p class="text-sm text-slate-600">${text}</p>` : '',
        confirmButtonText: 'Lanjutkan',
        buttonsStyling: false,
        customClass: {
            popup: 'englify-swal',
            confirmButton: 'englify-swal-confirm'
        }
    });
};

window.showConfirmDialog = function(title, text, confirmButtonText = 'Ya, Lanjutkan') {
    if (typeof Swal === 'undefined') {
        return Promise.resolve({ isConfirmed: true });
    }
    return Swal.fire({
        icon: 'warning',
        title: title,
        html: text ? `<p class="text-sm text-slate-600">${text}</p>` : '',
        showCancelButton: true,
        confirmButtonText: confirmButtonText,
        cancelButtonText: 'Batal',
        buttonsStyling: false,
        customClass: {
            popup: 'englify-swal',
            confirmButton: 'englify-swal-confirm',
            cancelButton: 'englify-swal-cancel'
        }
    });
};

// Override window.alert to Englify SweetAlert popup
window.alert = function(message) {
    if (!message) return Promise.resolve();
    if (typeof Swal === 'undefined') {
        console.warn(message);
        return Promise.resolve();
    }
    const isSuccess = /berhasil|sukses|success/i.test(message);
    const isError = /gagal|error|salah|maksimal|tidak ditemukan/i.test(message);
    const icon = isSuccess ? 'success' : (isError ? 'warning' : 'info');

    return Swal.fire({
        icon: icon,
        title: isSuccess ? 'Berhasil!' : (isError ? 'Perhatian' : 'Informasi'),
        html: `<p class="text-sm text-slate-600">${message}</p>`,
        confirmButtonText: 'Lanjutkan',
        buttonsStyling: false,
        customClass: {
            popup: 'englify-swal',
            confirmButton: 'englify-swal-confirm'
        }
    });
};

// Auto display session toast if flashed
@if(session('success'))
document.addEventListener('DOMContentLoaded', function() {
    if (!window.__suppressGlobalToast) {
        window.showToast("{{ session('success') }}", 'success');
    }
});
@endif
@if(session('error'))
document.addEventListener('DOMContentLoaded', function() {
    window.showAlert("Perhatian", "{{ session('error') }}", 'error');
});
@endif
// ==========================================
// ENGLIFY AESTHETIC CAT LOADING SYSTEM
// ==========================================
window.showLoading = function(title = 'Memuat Data...', desc = 'Tunggu sebentar ya, sedang memproses permintaanmu! 🐾') {
    const modal = document.getElementById('englify-loading-modal');
    const card = document.getElementById('englify-loading-card');
    const titleEl = document.getElementById('englify-loading-title');
    const descEl = document.getElementById('englify-loading-desc');
    if (titleEl) titleEl.textContent = title;
    if (descEl) descEl.textContent = desc;
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            if (card) {
                card.classList.remove('scale-95');
                card.classList.add('scale-100');
            }
        }, 10);
    }
};

window.hideLoading = function() {
    const modal = document.getElementById('englify-loading-modal');
    const card = document.getElementById('englify-loading-card');
    if (card) {
        card.classList.remove('scale-100');
        card.classList.add('scale-95');
    }
    if (modal) {
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 150);
    }
};

window.startPageLoader = function() {
    const loader = document.getElementById('englify-page-loader');
    const bar = document.getElementById('englify-page-loader-bar');
    if (!loader || !bar) return;
    loader.classList.remove('opacity-0');
    bar.style.width = '30%';
    setTimeout(() => { if (bar.style.width === '30%') bar.style.width = '70%'; }, 200);
    setTimeout(() => { if (bar.style.width === '70%') bar.style.width = '88%'; }, 450);
};

window.finishPageLoader = function() {
    const loader = document.getElementById('englify-page-loader');
    const bar = document.getElementById('englify-page-loader-bar');
    if (!loader || !bar) return;
    bar.style.width = '100%';
    setTimeout(() => {
        loader.classList.add('opacity-0');
        setTimeout(() => { bar.style.width = '0%'; }, 300);
    }, 200);
};

// Auto attach page loader on link navigations & form submits
document.addEventListener('DOMContentLoaded', function() {
    window.finishPageLoader();

    document.querySelectorAll('a[href]:not([target="_blank"]):not([href^="#"]):not([href^="javascript:"])').forEach(a => {
        a.addEventListener('click', function(e) {
            if (e.defaultPrevented || e.metaKey || e.ctrlKey || e.shiftKey) return;
            const href = a.getAttribute('href');
            if (href && !href.startsWith('#') && !href.startsWith('mailto:') && !href.startsWith('tel:')) {
                window.startPageLoader();
            }
        });
    });

    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (e.defaultPrevented) return;
            window.startPageLoader();
        });
    });
});

window.addEventListener('pageshow', function() {
    window.finishPageLoader();
});

// Konfirmasi Pop Up Sebelum Siswa Membaca Materi
window.confirmBukaMateri = function(event, url) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan Membaca Materi 📚',
            html: '<p class="text-sm text-slate-600 leading-relaxed">Jika kamu mulai membaca materi, kamu <strong>tidak akan bisa keluar</strong> dari halaman materi sebelum selesai membaca dan mengerjakan kuis.</p><p class="text-xs text-slate-400 mt-2">Apakah kamu siap melanjutkan membaca sekarang? 🐾</p>',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Batal',
            buttonsStyling: false,
            reverseButtons: true,
            customClass: {
                popup: 'englify-swal',
                confirmButton: 'englify-swal-confirm',
                cancelButton: 'englify-swal-cancel mr-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                if (typeof window.startPageLoader === 'function') {
                    window.startPageLoader();
                }
                window.location.href = url;
            }
        });
    } else {
        if (confirm('Perhatian! Jika mulai membaca materi, kamu tidak akan bisa keluar sebelum selesai membaca dan mengerjakan kuis. Lanjutkan?')) {
            window.location.href = url;
        }
    }
    return false;
};
</script>

@include('layouts.partials.loading-modal')
@include('layouts.partials.password-eye-toggle')
@stack('scripts')
</body>
</html>

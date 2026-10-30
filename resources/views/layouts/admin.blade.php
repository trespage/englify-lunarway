<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin') - Englify</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Chart.js CDN -->
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
                        navy: {
                            800: '#001B48',
                            850: '#02457A',
                            900: '#001B48',
                        },
                        brand: {
                            50: '#D6EBEE',
                            100: '#97CADB',
                            200: '#97CADB',
                            500: '#018ABE',
                            600: '#018ABE',
                            700: '#02457A'
                        }
                    },
                    boxShadow: {
                        card: '0 4px 20px -2px rgba(0, 27, 72, 0.05), 0 2px 6px -1px rgba(0, 27, 72, 0.03)',
                        hover: '0 10px 25px -4px rgba(0, 27, 72, 0.08), 0 4px 10px -2px rgba(0, 27, 72, 0.04)',
                        bottomNav: '0 -4px 20px rgba(0, 0, 0, 0.06)'
                    }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }
        .font-cute { font-family: 'Caveat', cursive; }
        html, body, .admin-bg { 
            background: linear-gradient(135deg, #C2DCF9 0%, #D4E6FA 50%, #E6F1FC 100%) !important; 
            background-attachment: fixed !important; 
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Utility agar teks materi panjang tidak meluap keluar box container */
        .content-text-wrap {
            overflow-wrap: anywhere !important;
            word-break: break-word !important;
            word-wrap: break-word !important;
            max-width: 100% !important;
        }

        /* Sidebar link active state - BIRU GLOW */
        .sidebar-item-active {
            background: linear-gradient(135deg, #018ABE 0%, #02457A 100%);
            color: #FFFFFF !important;
            box-shadow: 0 4px 15px rgba(1, 138, 190, 0.5), 0 0 20px rgba(1, 138, 190, 0.3);
            transform: scale(1.02);
        }
        .sidebar-item-active svg {
            color: #FFFFFF !important;
            filter: drop-shadow(0 0 4px rgba(255,255,255,0.5));
        }

        /* Animasi klik menu - efek ripple biru */
        .sidebar-link {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar-link::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(1, 138, 190, 0.4);
            transform: translate(-50%, -50%);
            transition: width 0.5s, height 0.5s;
        }
        .sidebar-link:active::before {
            width: 200px;
            height: 200px;
        }
        .sidebar-link:active {
            transform: scale(0.97);
        }
        .sidebar-link:hover {
            background: rgba(1, 138, 190, 0.15) !important;
            box-shadow: inset 0 0 15px rgba(1, 138, 190, 0.2);
        }
        .sidebar-link:hover svg {
            transform: scale(1.1);
            color: #97CADB;
        }
        .sidebar-link svg {
            transition: all 0.3s ease;
        }

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

        /* Sidebar collapsed style for desktop toggle */
        #sidebar.collapsed { width: 4.75rem; }
        #sidebar.collapsed .sidebar-text,
        #sidebar.collapsed .sidebar-cat-quote,
        #sidebar.collapsed .sidebar-subitems { display: none; }
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
<body class="admin-bg bg-[#D4E6FA] text-slate-800 antialiased min-h-screen flex flex-col">

<div class="flex h-screen overflow-hidden">

    <!-- ============================================================== -->
    <!-- DESKTOP LEFT SIDEBAR                                           -->
    <!-- ============================================================== -->
    <aside id="sidebar" class="w-64 shrink-0 bg-[#001B48] hidden lg:flex flex-col shadow-2xl transition-all duration-300 z-30 select-none relative">
        
        <!-- Sidebar Brand / Logo -->
        <div class="p-6 pb-5 flex items-center justify-between border-b border-white/10">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
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
            <button onclick="toggleSidebarCollapse()" class="text-slate-400 hover:text-white p-1 rounded-lg hover:bg-white/5 transition" title="Toggle Sidebar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/></svg>
            </button>
        </div>

        <!-- Sidebar Navigation List -->
        <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto overflow-x-hidden">
            <!-- 1. Dashboard -->
            <a href="{{ route('admin.dashboard') }}" 
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'sidebar-item-active' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="sidebar-text">Dashboard</span>
            </a>

            <!-- 2. Kelola Bab -->
            <a href="{{ route('admin.bab') }}" 
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.bab*') ? 'sidebar-item-active' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <span class="sidebar-text">Kelola Bab</span>
            </a>

            <!-- 3. Kelola Materi -->
            <a href="{{ route('admin.materi') }}" 
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.materi*') ? 'sidebar-item-active' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span class="sidebar-text">Kelola Materi</span>
            </a>

            <!-- 3. Kelola Quiz -->
            <a href="{{ route('admin.quiz') }}" 
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.quiz*') ? 'sidebar-item-active' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                <span class="sidebar-text">Kelola Quiz</span>
            </a>

            <!-- 4. Hasil Quiz -->
            <a href="{{ route('admin.hasil-quiz') }}" 
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.hasil-quiz*') ? 'sidebar-item-active' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span class="sidebar-text">Hasil Quiz</span>
            </a>

            <!-- 5. Monitoring Per Siswa -->
            <a href="{{ route('admin.monitoring-siswa') }}" 
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.monitoring-siswa*') ? 'sidebar-item-active' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span class="sidebar-text">Monitoring Siswa</span>
            </a>

            <!-- Kirim Reminder -->
            <a href="{{ route('admin.kirim-reminder') }}" 
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.kirim-reminder') ? 'sidebar-item-active' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="sidebar-text">Kirim Reminder</span>
            </a>

            <!-- 6. Profil Saya -->
            <a href="{{ route('admin.profil') }}" 
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.profil') ? 'sidebar-item-active' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="sidebar-text">Profil Saya</span>
            </a>
        </nav>

        <!-- Sidebar Bottom -->
        <div class="p-4 pt-1 border-t border-white/10 relative overflow-hidden mt-auto">
            <div class="sidebar-cat-quote text-left pl-1 pt-2">
                <p class="font-cute text-base text-sky-200/90 leading-tight">Learn</p>
                <p class="font-cute text-base text-sky-200/90 leading-tight">Practice</p>
                <p class="font-cute text-base text-sky-200/90 leading-tight">Grow</p>
                <p class="font-cute text-base text-sky-200/90 leading-tight">Together <span class="text-amber-300">✦</span></p>
            </div>

            <div class="relative flex justify-end -mt-10 pr-1 pointer-events-none">
                <img src="{{ asset('images/cat-welcome.png') }}" alt="Englify Cat Peeking" class="w-16 h-auto object-contain transform translate-y-1 opacity-90 drop-shadow-md">
            </div>

            <form method="POST" action="{{ route('logout') }}" class="pt-1">
                @csrf
                <button type="submit" class="paw-btn w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-white/10 hover:bg-rose-500/20 text-slate-200 hover:text-white border border-white/15 transition text-sm font-medium group">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-lg bg-sky-400/15 group-hover:bg-rose-500/25 flex items-center justify-center transition-colors shrink-0">
                            <!-- PAW ICON (Cakar Kucing) -->
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

    <!-- Mobile Drawer (Offcanvas Menu) -->
    <div id="mobile-sidebar" class="fixed inset-y-0 left-0 w-72 bg-[#001B48] z-50 transform -translate-x-full transition-transform duration-300 lg:hidden flex flex-col shadow-2xl">
        <div class="p-5 border-b border-white/10 flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
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
                    <p class="text-[10px] text-sky-200 uppercase tracking-wider mt-1 font-semibold">Admin Panel</p>
                </div>
            </a>
            <button onclick="toggleMobileSidebar()" class="text-slate-400 hover:text-white p-2 rounded-lg" aria-label="Tutup">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto text-sm font-semibold text-slate-200">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'sidebar-item-active' : 'hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.bab') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.bab*') ? 'sidebar-item-active' : 'hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                Kelola Bab
            </a>
            <a href="{{ route('admin.materi') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.materi*') ? 'sidebar-item-active' : 'hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Kelola Materi
            </a>
            <a href="{{ route('admin.quiz') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.quiz*') ? 'sidebar-item-active' : 'hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Kelola Quiz
            </a>
            <a href="{{ route('admin.hasil-quiz') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.hasil-quiz*') ? 'sidebar-item-active' : 'hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Hasil Quiz
            </a>
            <a href="{{ route('admin.monitoring-siswa') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.monitoring-siswa*') ? 'sidebar-item-active' : 'hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Monitoring Siswa
            </a>
            <a href="{{ route('admin.kirim-reminder') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.kirim-reminder') ? 'sidebar-item-active' : 'hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                Kirim Reminder
            </a>
            <a href="{{ route('admin.profil') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.profil') ? 'sidebar-item-active' : 'hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Profil Saya
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
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden relative admin-bg">

        <!-- TOP NAVIGATION BAR -->
        <header class="bg-white/80 backdrop-blur-md px-4 sm:px-8 py-3.5 flex items-center justify-between gap-4 sticky top-0 z-20 border-b border-blue-200/60 shadow-xs">
            <div class="flex items-center gap-3 lg:hidden">
                <button onclick="toggleMobileSidebar()" class="p-2 text-slate-700 hover:bg-white rounded-xl shadow-xs transition" aria-label="Toggle Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 group">
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
                           placeholder="Cari materi, bab, kuis, siswa di halaman ini..."
                           autocomplete="off"
                           class="w-full pl-11 pr-24 py-2.5 bg-white border border-[#97CADB]/40 rounded-full text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#018ABE]/40 focus:border-[#018ABE] shadow-xs transition">
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

                <div class="relative">
                    <button onclick="toggleNotifDropdown()" class="w-10 h-10 rounded-full bg-white border border-slate-200/80 flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-50 shadow-xs transition relative" aria-label="Notifikasi">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
                    </button>
                    <div id="notif-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-slate-200 py-3 z-50">
                        <div class="px-4 pb-2 border-b border-slate-100 flex items-center justify-between">
                            <p class="text-xs font-bold text-slate-800 uppercase tracking-wider">Notifikasi</p>
                            <span class="text-[10px] bg-[#D6EBEE] text-[#02457A] font-bold px-2 py-0.5 rounded-full">Baru</span>
                        </div>
                        <div class="divide-y divide-slate-100 max-h-64 overflow-y-auto">
                            @forelse($notifikasiTerbaru ?? [] as $notif)
                            <div class="p-3.5 hover:bg-slate-50 transition flex gap-3 items-start">
                                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 text-xs font-bold">
                                    {{ substr($notif['title'] ?? 'N', 0, 1) }}
                                </div>
                                <div class="text-xs min-w-0">
                                    <p class="font-bold text-slate-700 truncate">{{ $notif['title'] ?? '' }}</p>
                                    <p class="text-slate-400 text-[11px] truncate">{{ $notif['desc'] ?? '' }} - {{ $notif['time_label'] ?? '' }}</p>
                                </div>
                            </div>
                            @empty
                            <div class="p-4 text-center">
                                <p class="text-xs text-slate-400">Belum ada notifikasi</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <button onclick="toggleProfileDropdown()" class="flex items-center gap-2.5 bg-white border border-slate-200/90 rounded-full py-1.5 pl-1.5 pr-3 shadow-xs hover:bg-slate-50 transition">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#018ABE] to-[#02457A] border border-[#97CADB] flex items-center justify-center overflow-hidden shrink-0 text-white font-bold text-sm">
                            {{ substr(auth()->user()->nama ?? auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="text-left hidden sm:block">
                            <p class="text-xs font-bold text-slate-800 leading-tight">{{ auth()->user()->nama ?? auth()->user()->name ?? 'Admin' }}</p>
                            <p class="text-[10px] font-semibold text-slate-400 leading-none">Administrator</p>
                        </div>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-200 py-2 z-50">
                        <div class="px-4 py-2.5 border-b border-slate-100">
                            <p class="text-xs font-bold text-slate-800">{{ auth()->user()->nama ?? auth()->user()->name ?? 'Admin' }}</p>
                            <p class="text-[11px] text-slate-400 truncate">{{ auth()->user()->email ?? 'admin@englify.com' }}</p>
                            <span class="inline-block mt-1 text-[9px] font-bold uppercase tracking-wider bg-[#D6EBEE] text-[#02457A] px-2 py-0.5 rounded-full">Administrator</span>
                        </div>
                        <a href="{{ route('admin.profil') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Profil Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="border-t border-slate-100 mt-1 pt-1">
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
        </header>

        <!-- MOBILE SEARCH BAR DRAWER -->
        <div id="mobileSearchWrapper" class="hidden md:hidden px-4 py-2.5 bg-white border-b border-slate-200/80 shadow-xs sticky top-[61px] z-19">
            <div class="relative">
                <input type="text" 
                       id="pageLiveSearchInputMobile"
                       placeholder="Cari materi, bab, kuis, siswa di halaman ini..."
                       autocomplete="off"
                       class="w-full pl-10 pr-10 py-2 bg-slate-50 border border-slate-200 rounded-full text-xs text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#018ABE]/40 focus:border-[#018ABE] transition">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <button type="button" 
                        id="pageLiveSearchClearBtnMobile"
                        onclick="clearLivePageSearch()" 
                        class="hidden w-5 h-5 rounded-full bg-slate-200 text-slate-500 absolute right-3 top-1/2 -translate-y-1/2 items-center justify-center text-xs transition">
                    &times;
                </button>
            </div>
        </div>

        <!-- MAIN SCROLLABLE CONTENT -->
        <main class="flex-1 overflow-y-auto px-4 sm:px-8 pb-24 lg:pb-12">
            <div class="max-w-[1400px] mx-auto py-3">
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
function toggleNotifDropdown() {
    document.getElementById('notif-dropdown').classList.toggle('hidden');
}
function toggleProfileDropdown() {
    document.getElementById('profile-dropdown').classList.toggle('hidden');
}
document.addEventListener('click', function(e) {
    ['notif-dropdown', 'profile-dropdown'].forEach(function(id) {
        const el = document.getElementById(id);
        if (el && !el.classList.contains('hidden') && !el.parentElement.contains(e.target)) {
            el.classList.add('hidden');
        }
    });
});

// ==========================================
// DYNAMIC LIVE IN-PAGE & MENU SEARCH SYSTEM (ADMIN)
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

// Global Keyboard Shortcut: Ctrl+K / Cmd+K focuses search, Esc clears search
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

// Admin Navigation Quick Links for fast menu discovery
const adminQuickNavMenus = [
    { name: 'Dashboard', desc: 'Ringkasan & statistik aktivitas', url: '{{ route("admin.dashboard") }}', icon: '🏠', tags: ['dashboard', 'beranda', 'home', 'statistik', 'ringkasan'] },
    { name: 'Materi Pembelajaran', desc: 'Kelola isi materi modul siswa', url: '{{ route("admin.materi") }}', icon: '📖', tags: ['materi', 'modul', 'reading', 'writing', 'teks', 'konten'] },
    { name: 'Manajemen Bab', desc: 'Kelola bab kurikulum & kategori', url: '{{ route("admin.bab") }}', icon: '📚', tags: ['bab', 'unit', 'kurikulum', 'kategori', 'chapter'] },
    { name: 'Manajemen Kuis', desc: 'Kelola soal & kuis latihan siswa', url: '{{ route("admin.quiz") }}', icon: '🎯', tags: ['kuis', 'quiz', 'soal', 'latihan', 'skor', 'pertanyaan'] },
    { name: 'Hasil Quiz', desc: 'Daftar riwayat nilai quiz siswa', url: '{{ route("admin.hasil-quiz") }}', icon: '📈', tags: ['hasil', 'nilai', 'skor', 'riwayat', 'jawaban'] },
    { name: 'Monitoring Siswa', desc: 'Pantau kemajuan & skor belajar siswa', url: '{{ route("admin.monitoring-siswa") }}', icon: '📊', tags: ['monitoring', 'siswa', 'pantau', 'progress', 'nilai', 'poin', 'skor'] },
    { name: 'Kirim Reminder', desc: 'Kirim pengingat belajar ke siswa', url: '{{ route("admin.kirim-reminder") }}', icon: '🔔', tags: ['reminder', 'pengingat', 'notifikasi', 'pesan', 'kirim'] },
    { name: 'Profil Saya', desc: 'Pengaturan akun & ganti sandi admin', url: '{{ route("admin.profil") }}', icon: '👤', tags: ['profil', 'profile', 'akun', 'password', 'sandi', 'keamanan'] },
];

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
        restoreAllPageElements();
        return;
    }

    const matches = [];

    // Check menu quick navigation matches
    adminQuickNavMenus.forEach(menu => {
        const matchesTag = menu.tags.some(t => t.includes(query) || query.includes(t));
        const matchesName = menu.name.toLowerCase().includes(query) || menu.desc.toLowerCase().includes(query);
        if (matchesTag || matchesName) {
            matches.push({
                type: '🚀 Menu Pintasan',
                badgeClass: 'bg-sky-100 text-[#018ABE]',
                title: menu.name,
                subtitle: menu.desc,
                action: () => { window.location.href = menu.url; }
            });
        }
    });

    // 1. Table Rows in Main Area
    const tableRows = document.querySelectorAll('main table tbody tr:not(.empty-state-row)');
    if (tableRows.length > 0) {
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const isMatch = text.includes(query);
            row.style.display = isMatch ? '' : 'none';

            if (isMatch) {
                // Determine title & subtitle from row
                const cells = row.querySelectorAll('td');
                let rowTitle = '';
                let rowSubtitle = '';

                // Try to find primary name / title cell
                const nameEl = row.querySelector('.font-bold, .font-semibold, td:nth-child(2)');
                rowTitle = nameEl ? nameEl.textContent.trim() : (cells[1]?.textContent.trim() || cells[0]?.textContent.trim() || 'Baris Tabel');
                
                // Secondary text
                const subEl = row.querySelector('.text-xs.text-slate-400, .text-xs.text-slate-500, td:nth-child(3)');
                rowSubtitle = subEl ? subEl.textContent.trim() : (cells[2]?.textContent.trim() || 'Data di tabel');

                // Determine badge type based on current page
                let typeBadge = '📋 Baris Data';
                let badgeClass = 'bg-blue-100 text-[#018ABE]';
                const path = window.location.pathname;
                if (path.includes('materi')) {
                    typeBadge = '📖 Materi';
                    badgeClass = 'bg-emerald-100 text-emerald-700';
                } else if (path.includes('bab')) {
                    typeBadge = '📚 Bab';
                    badgeClass = 'bg-amber-100 text-amber-700';
                } else if (path.includes('quiz')) {
                    typeBadge = '🎯 Kuis';
                    badgeClass = 'bg-purple-100 text-purple-700';
                } else if (path.includes('monitoring')) {
                    typeBadge = '👤 Siswa';
                    badgeClass = 'bg-sky-100 text-[#018ABE]';
                }

                matches.push({
                    type: typeBadge,
                    badgeClass: badgeClass,
                    title: rowTitle,
                    subtitle: rowSubtitle,
                    element: row
                });
            }
        });
    }

    // 2. Cards in Main Area (Cards, Sections, Grids)
    const cards = document.querySelectorAll('main .bg-white.rounded-2xl, main .bg-white.rounded-xl, main .rounded-3xl.p-6, main .rounded-2xl.border');
    cards.forEach(card => {
        // Skip table containers to avoid redundant hiding of tables
        if (card.querySelector('table')) return;
        const text = card.textContent.toLowerCase();
        const isMatch = text.includes(query);
        card.style.display = isMatch ? '' : 'none';

        if (isMatch) {
            const heading = card.querySelector('h1, h2, h3, h4, .font-bold')?.textContent.trim() || 'Kartu Informasi';
            const snippet = card.querySelector('p')?.textContent.trim() || 'Konten cocok di halaman ini';
            matches.push({
                type: '📄 Konten Halaman',
                badgeClass: 'bg-slate-100 text-slate-700',
                title: heading,
                subtitle: snippet,
                element: card
            });
        }
    });

    // Update match count badge
    const totalCount = matches.length;
    if (pageLiveSearchCountBadge) {
        pageLiveSearchCountBadge.textContent = totalCount;
        pageLiveSearchCountBadge.classList.remove('hidden');
    }
    if (pageLiveSearchDropdownCount) {
        pageLiveSearchDropdownCount.textContent = `${totalCount} item ditemukan`;
    }

    renderSearchDropdownList(matches, query);
}

function renderSearchDropdownList(matches, query) {
    if (!pageLiveSearchResultsDropdown || !pageLiveSearchResultsList) return;

    if (matches.length === 0) {
        pageLiveSearchResultsList.innerHTML = `
            <div class="py-6 px-4 text-center">
                <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2 text-base">🔍</div>
                <p class="text-xs font-bold text-slate-700">Tidak ada hasil cocok</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Tidak ditemukan data dengan kata kunci "<b>${query}</b>" di halaman ini.</p>
                <button type="button" onclick="clearLivePageSearch()" class="mt-2.5 px-3 py-1 bg-[#018ABE] hover:bg-[#02457A] text-white text-xs font-semibold rounded-lg transition shadow-2xs">Reset Pencarian</button>
            </div>
        `;
        pageLiveSearchResultsDropdown.classList.remove('hidden');
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
    pageLiveSearchResultsList.innerHTML = html;
    pageLiveSearchResultsDropdown.classList.remove('hidden');
}

window.jumpToSearchResult = function(index) {
    if (!window._currentSearchMatches || !window._currentSearchMatches[index]) return;
    const match = window._currentSearchMatches[index];

    if (pageLiveSearchResultsDropdown) {
        pageLiveSearchResultsDropdown.classList.add('hidden');
    }

    if (typeof match.action === 'function') {
        match.action();
        return;
    }

    if (match.element) {
        match.element.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        match.element.classList.add('ring-4', 'ring-[#018ABE]', 'ring-offset-2', 'transition-all', 'duration-500');
        setTimeout(() => {
            match.element.classList.remove('ring-4', 'ring-[#018ABE]', 'ring-offset-2');
        }, 2200);
    }
};

function restoreAllPageElements() {
    document.querySelectorAll('main table tbody tr').forEach(el => el.style.display = '');
    document.querySelectorAll('main .bg-white.rounded-2xl, main .bg-white.rounded-xl, main .rounded-3xl.p-6, main .rounded-2xl.border').forEach(el => el.style.display = '');
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
    window.showToast("{{ session('success') }}", 'success');
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
</script>

@include('layouts.partials.loading-modal')
@include('layouts.partials.password-eye-toggle')
@stack('scripts')
</body>
</html>
@extends('layouts.admin')

@section('title', 'Kelola Materi')

@section('content')
<style>
    /* Styling Word-style Rich Text Editor & Live POV Preview */
    .rich-text-editor:empty:before {
        content: attr(data-placeholder);
        color: #94a3b8;
        pointer-events: none;
        display: block;
    }
    .rich-text-editor:focus {
        outline: none;
    }
    .rich-text-editor h1:not([style*="font-size"]), .materi-rendered h1:not([style*="font-size"]) {
        font-size: 1.5rem !important;
        font-weight: 800 !important;
        color: #0f172a !important;
        margin-top: 1.25rem !important;
        margin-bottom: 0.5rem !important;
        line-height: 1.3 !important;
    }
    .rich-text-editor h2:not([style*="font-size"]), .materi-rendered h2:not([style*="font-size"]) {
        font-size: 1.25rem !important;
        font-weight: 700 !important;
        color: #1e293b !important;
        margin-top: 1rem !important;
        margin-bottom: 0.375rem !important;
        line-height: 1.35 !important;
    }
    .rich-text-editor h3:not([style*="font-size"]), .materi-rendered h3:not([style*="font-size"]) {
        font-size: 1.1rem !important;
        font-weight: 600 !important;
        color: #334155 !important;
        margin-top: 0.75rem !important;
        margin-bottom: 0.25rem !important;
        line-height: 1.4 !important;
    }
    .rich-text-editor p, .materi-rendered p {
        margin-bottom: 0.75rem !important;
        line-height: 1.7 !important;
    }
    .rich-text-editor strong, .rich-text-editor b, .materi-rendered strong, .materi-rendered b {
        font-weight: 700 !important;
        color: #0f172a !important;
    }
    .rich-text-editor em, .rich-text-editor i, .materi-rendered em, .materi-rendered i {
        font-style: italic !important;
    }
    .rich-text-editor u, .materi-rendered u {
        text-decoration: underline !important;
        text-underline-offset: 3px !important;
    }
    .rich-text-editor s, .rich-text-editor strike, .materi-rendered s, .materi-rendered strike {
        text-decoration: line-through !important;
    }
    .rich-text-editor ul, .materi-rendered ul {
        list-style-type: disc !important;
        padding-left: 1.5rem !important;
        margin-top: 0.5rem !important;
        margin-bottom: 0.75rem !important;
    }
    .rich-text-editor ol, .materi-rendered ol {
        list-style-type: decimal;
        padding-left: 1.75rem !important;
        margin-top: 0.5rem !important;
        margin-bottom: 0.75rem !important;
    }
    .rich-text-editor ol[type="A"], .materi-rendered ol[type="A"],
    .rich-text-editor ol[style*="upper-alpha"], .materi-rendered ol[style*="upper-alpha"],
    .rich-text-editor ol.list-upper-alpha, .materi-rendered ol.list-upper-alpha {
        list-style-type: upper-alpha !important;
    }
    .rich-text-editor ol[type="a"], .materi-rendered ol[type="a"],
    .rich-text-editor ol[style*="lower-alpha"], .materi-rendered ol[style*="lower-alpha"],
    .rich-text-editor ol.list-lower-alpha, .materi-rendered ol.list-lower-alpha {
        list-style-type: lower-alpha !important;
    }
    .rich-text-editor ol[type="I"], .materi-rendered ol[type="I"],
    .rich-text-editor ol[style*="upper-roman"], .materi-rendered ol[style*="upper-roman"],
    .rich-text-editor ol.list-upper-roman, .materi-rendered ol.list-upper-roman {
        list-style-type: upper-roman !important;
    }
    .rich-text-editor ol[type="i"], .materi-rendered ol[type="i"],
    .rich-text-editor ol[style*="lower-roman"], .materi-rendered ol[style*="lower-roman"],
    .rich-text-editor ol.list-lower-roman, .materi-rendered ol.list-lower-roman {
        list-style-type: lower-roman !important;
    }
    .rich-text-editor ol[type="1"], .materi-rendered ol[type="1"],
    .rich-text-editor ol[style*="decimal"], .materi-rendered ol[style*="decimal"],
    .rich-text-editor ol.list-decimal, .materi-rendered ol.list-decimal {
        list-style-type: decimal !important;
    }
    .rich-text-editor ol ol:not([type]), .materi-rendered ol ol:not([type]) {
        list-style-type: lower-alpha !important;
    }
    .rich-text-editor ol ol ol:not([type]), .materi-rendered ol ol ol:not([type]) {
        list-style-type: lower-roman !important;
    }
    .rich-text-editor li, .materi-rendered li {
        margin-bottom: 0.35rem !important;
        line-height: 1.6 !important;
    }
    /* Marker penomoran / huruf (A. B. C. atau 1. 2. 3.) otomatis ikut bold jika teks di sampingnya berformat bold (anak judul) */
    .rich-text-editor li:has(strong)::marker,
    .rich-text-editor li:has(b)::marker,
    .rich-text-editor li:has([style*="font-weight: bold"])::marker,
    .rich-text-editor li:has([style*="font-weight: 700"])::marker,
    .rich-text-editor li.li-marker-bold::marker,
    .materi-rendered li:has(strong)::marker,
    .materi-rendered li:has(b)::marker,
    .materi-rendered li:has([style*="font-weight: bold"])::marker,
    .materi-rendered li:has([style*="font-weight: 700"])::marker,
    .materi-rendered li.li-marker-bold::marker {
        font-weight: 700 !important;
        color: #0f172a !important;
    }
    .rich-text-editor blockquote, .materi-rendered blockquote {
        border-left: 4px solid #0284c7;
        background: rgba(2, 132, 199, 0.06);
        padding: 0.6rem 1rem !important;
        margin: 0.85rem 0 !important;
        color: #334155 !important;
        font-style: italic;
        border-radius: 0 0.75rem 0.75rem 0 !important;
        transition: border-color 0.2s ease, background-color 0.2s ease;
    }
    .rich-text-editor blockquote.callout-green, .materi-rendered blockquote.callout-green,
    .rich-text-editor blockquote[data-color="green"], .materi-rendered blockquote[data-color="green"] {
        border-left-color: #16a34a !important;
        background-color: rgba(22, 163, 74, 0.08) !important;
    }
    .rich-text-editor blockquote.callout-red, .materi-rendered blockquote.callout-red,
    .rich-text-editor blockquote[data-color="red"], .materi-rendered blockquote[data-color="red"] {
        border-left-color: #dc2626 !important;
        background-color: rgba(220, 38, 38, 0.08) !important;
    }
    .rich-text-editor blockquote.callout-blue, .materi-rendered blockquote.callout-blue,
    .rich-text-editor blockquote[data-color="blue"], .materi-rendered blockquote[data-color="blue"] {
        border-left-color: #0284c7 !important;
        background-color: rgba(2, 132, 199, 0.08) !important;
    }
    .rich-text-editor blockquote.callout-amber, .materi-rendered blockquote.callout-amber,
    .rich-text-editor blockquote[data-color="amber"], .materi-rendered blockquote[data-color="amber"] {
        border-left-color: #d97706 !important;
        background-color: rgba(217, 119, 6, 0.08) !important;
    }
    .rich-text-editor blockquote.callout-purple, .materi-rendered blockquote.callout-purple,
    .rich-text-editor blockquote[data-color="purple"], .materi-rendered blockquote[data-color="purple"] {
        border-left-color: #9333ea !important;
        background-color: rgba(147, 51, 234, 0.08) !important;
    }
    .rich-text-editor blockquote.callout-gray, .materi-rendered blockquote.callout-gray,
    .rich-text-editor blockquote[data-color="gray"], .materi-rendered blockquote[data-color="gray"] {
        border-left-color: #64748b !important;
        background-color: rgba(100, 116, 139, 0.08) !important;
    }
    .rich-text-editor hr, .materi-rendered hr {
        border: 0 !important;
        border-top: 2px dashed #cbd5e1 !important;
        margin: 1.25rem 0 !important;
    }
    .rich-text-editor mark, .materi-rendered mark {
        background-color: #fef08a !important;
        padding: 0.1rem 0.3rem !important;
        border-radius: 0.25rem !important;
    }
    .rich-text-editor a, .materi-rendered a {
        color: #0284c7 !important;
        text-decoration: underline !important;
    }
    /* Ukuran Font Presisi (10px, 12px Kecil, 14px Normal, 16px Sedang, 18px Besar, 24px Ekstra, 36px Jumbo) */
    .rich-text-editor font[size="1"], .materi-rendered font[size="1"] { font-size: 0.625rem !important; line-height: 1.4 !important; }
    .rich-text-editor font[size="2"], .materi-rendered font[size="2"] { font-size: 0.75rem !important; line-height: 1.5 !important; }
    .rich-text-editor font[size="3"], .materi-rendered font[size="3"] { font-size: 0.875rem !important; line-height: 1.6 !important; }
    .rich-text-editor font[size="4"], .materi-rendered font[size="4"] { font-size: 1rem !important; line-height: 1.6 !important; }
    .rich-text-editor font[size="5"], .materi-rendered font[size="5"] { font-size: 1.125rem !important; line-height: 1.5 !important; }
    .rich-text-editor font[size="6"], .materi-rendered font[size="6"] { font-size: 1.5rem !important; line-height: 1.4 !important; }
    .rich-text-editor font[size="7"], .materi-rendered font[size="7"] { font-size: 2.25rem !important; line-height: 1.3 !important; }
    .rich-text-editor span[style*="font-size: 10px"], .materi-rendered span[style*="font-size: 10px"] { font-size: 0.625rem !important; }
    .rich-text-editor span[style*="font-size: 12px"], .materi-rendered span[style*="font-size: 12px"] { font-size: 0.75rem !important; }
    .rich-text-editor span[style*="font-size: 14px"], .materi-rendered span[style*="font-size: 14px"] { font-size: 0.875rem !important; }
    .rich-text-editor span[style*="font-size: 16px"], .materi-rendered span[style*="font-size: 16px"] { font-size: 1rem !important; }
    .rich-text-editor span[style*="font-size: 18px"], .materi-rendered span[style*="font-size: 18px"] { font-size: 1.125rem !important; }
    .rich-text-editor span[style*="font-size: 24px"], .materi-rendered span[style*="font-size: 24px"] { font-size: 1.5rem !important; }
    .rich-text-editor span[style*="font-size: 36px"], .materi-rendered span[style*="font-size: 36px"] { font-size: 2.25rem !important; }
    .rich-text-editor figure, .materi-rendered figure {
        margin: 1.25rem 0 !important;
        display: block !important;
    }
    .rich-text-editor figure[style*="text-align: left"], .materi-rendered figure[style*="text-align: left"] {
        text-align: left !important;
    }
    .rich-text-editor figure[style*="text-align: center"], .materi-rendered figure[style*="text-align: center"] {
        text-align: center !important;
    }
    .rich-text-editor figure[style*="text-align: right"], .materi-rendered figure[style*="text-align: right"] {
        text-align: right !important;
    }
    .rich-text-editor img, .materi-rendered img {
        max-width: 100% !important;
        height: auto !important;
        border-radius: 0.75rem !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
        display: inline-block !important;
    }
    .rich-text-editor figcaption, .materi-rendered figcaption {
        font-size: 0.8125rem !important;
        color: #64748b !important;
        margin-top: 0.375rem !important;
        font-style: italic !important;
        text-align: inherit !important;
    }
    .rich-text-editor figcaption:empty:before {
        content: attr(data-placeholder);
        color: #94a3b8;
    }
    /* Mode Luas Word Paper Styling */
    .word-paper-mode {
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04) !important;
        border-radius: 0.75rem !important;
        max-width: 880px !important;
        width: 100% !important;
        min-height: 820px !important;
        padding: 3.5rem 4rem !important;
        margin: 0 auto !important;
        font-size: 1rem !important;
        line-height: 1.85 !important;
        color: #1e293b !important;
        transition: box-shadow 0.2s ease, border-color 0.2s ease;
    }
    .word-paper-mode:focus {
        outline: none !important;
        border-color: #93c5fd !important;
        box-shadow: 0 12px 28px -5px rgba(59, 130, 246, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.05) !important;
    }
    @media (max-width: 768px) {
        .word-paper-mode {
            padding: 1.5rem 1.25rem !important;
            min-height: 480px !important;
        }
    }
</style>
<div class="space-y-6">

    <!-- ===================================================== -->
    <!-- HEADER                                                 -->
    <!-- ===================================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Kelola Materi</h1>
                <p class="text-slate-500 text-sm mt-0.5">Buat dan kelola konten pembelajaran per Kategori dan Bab.</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.bab') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm transition-all">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                Kelola Bab
            </a>
            <button type="button" onclick="checkAndOpenModal('add')" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/30 transition-all active:scale-95 text-sm cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Materi Baru
            </button>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- STATS CARDS                                            -->
    <!-- ===================================================== -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500">Total Materi</p>
            <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalMateri }}</p>
        </div>

        @foreach($statistikKategori as $stat)
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="w-11 h-11 rounded-xl {{ $stat['bg'] }} flex items-center justify-center mb-3">
                <svg class="w-5 h-5 {{ $stat['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500">{{ $stat['nama'] }}</p>
            <p class="text-3xl font-extrabold {{ $stat['text'] }} mt-1">{{ $stat['jumlah'] }}</p>
        </div>
        @endforeach
    </div>

    <!-- ===================================================== -->
    <!-- FILTER BAR                                             -->
    <!-- ===================================================== -->
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200">
        <form method="GET" action="{{ route('admin.materi') }}" class="flex flex-col lg:flex-row gap-3">
            <div class="relative flex-1">
                <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="searchInput" name="q" value="{{ request('q') }}" placeholder="Cari judul materi..."
                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
            </div>
            <select id="kategoriFilter" name="kategori" onchange="filterBabDropdown(this.value)" class="w-full lg:w-auto px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 cursor-pointer">
                <option value="">Semua Kategori</option>
                @foreach($kategoriList as $kategori)
                    <option value="{{ $kategori->id_kategori }}" @selected(request('kategori') == $kategori->id_kategori)>{{ $kategori->nama_kategori }}</option>
                @endforeach
            </select>
            <select id="babFilter" name="bab" class="w-full lg:w-auto px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 cursor-pointer">
                <option value="">Semua Bab</option>
                @foreach($babList as $bab)
                    @php
                        $katPrefix = $bab->kategori?->nama_kategori ? '[' . $bab->kategori->nama_kategori . '] ' : '';
                        $labelBab  = $katPrefix . $bab->formatted_judul;
                    @endphp
                    <option value="{{ $bab->judul }}" data-kategori="{{ $bab->id_kategori }}" @selected(request('bab') == $bab->judul || request('bab') == $bab->id)>{{ $labelBab }}</option>
                @endforeach
            </select>
            <button type="submit" class="w-full lg:w-auto px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition">
                Terapkan
            </button>
            @if(request()->hasAny(['q', 'kategori', 'bab']))
                <a href="{{ route('admin.materi') }}" class="w-full lg:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold rounded-xl transition text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- ===================================================== -->
    <!-- PENGELOMPOKAN MATERI BERDASARKAN BAB                   -->
    <!-- ===================================================== -->
    @php
        $catBadgeColors = [
            'Speaking'  => ['bg' => 'bg-rose-500', 'bg_light' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-200', 'icon_bg' => 'bg-rose-100 text-rose-600'],
            'Writing'   => ['bg' => 'bg-blue-500', 'bg_light' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'icon_bg' => 'bg-blue-100 text-blue-600'],
            'Reading'   => ['bg' => 'bg-emerald-500', 'bg_light' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'icon_bg' => 'bg-emerald-100 text-emerald-600'],
            'Listening' => ['bg' => 'bg-purple-500', 'bg_light' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-200', 'icon_bg' => 'bg-purple-100 text-purple-600'],
        ];
    @endphp

    <div class="space-y-5">
        @forelse($babsGrouped as $babGroup)
            @php
                $c = $catBadgeColors[$babGroup['nama_kategori']] ?? [
                    'bg' => 'bg-slate-500', 'bg_light' => 'bg-slate-50', 'text' => 'text-slate-700', 'border' => 'border-slate-200', 'icon_bg' => 'bg-slate-100 text-slate-600'
                ];
            @endphp
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/90 overflow-hidden transition hover:shadow-md">
                <!-- Bab Header -->
                <div class="px-5 sm:px-6 py-4 bg-slate-50/80 border-b border-slate-200/80 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-3.5 min-w-0">
                        <div class="w-10 h-10 rounded-xl {{ $c['icon_bg'] }} flex items-center justify-center shrink-0 font-extrabold text-sm shadow-xs">
                            {{ $babGroup['urutan'] }}
                        </div>
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="font-extrabold text-slate-800 text-sm sm:text-base break-words">
                                    Bab {{ $babGroup['urutan'] }}: {{ $babGroup['judul'] }}
                                </h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold border {{ $c['bg_light'] }} {{ $c['text'] }} {{ $c['border'] }}">
                                    {{ $babGroup['nama_kategori'] }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">
                                {{ $babGroup['total'] }} Materi terdaftar di bab ini
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 self-start sm:self-auto shrink-0">
                        <button type="button" onclick="openModalWithBab({{ $babGroup['id_kategori'] }}, {{ $babGroup['id'] }})"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold rounded-xl text-xs transition active:scale-95 cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            <span>Materi ke Bab Ini</span>
                        </button>
                        <button type="button" onclick="toggleBabSection('bab-section-{{ $babGroup['id'] }}', this)"
                                class="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-200/60 transition cursor-pointer" title="Ciutkan / Rentangkan Bab">
                            <svg class="w-5 h-5 transition-transform duration-200 chevron-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Bab Content (List / Table of Materi) -->
                <div id="bab-section-{{ $babGroup['id'] }}" class="bab-content-area">
                    @if($babGroup['total'] > 0)
                        <!-- Desktop Table View -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-white border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                    <tr>
                                        <th class="px-6 py-3.5 text-left w-14">No</th>
                                        <th class="px-6 py-3.5 text-left">Judul Materi</th>
                                        <th class="px-6 py-3.5 text-center">Urutan</th>
                                        <th class="px-6 py-3.5 text-center">Lampiran</th>
                                        <th class="px-6 py-3.5 text-center">Status</th>
                                        <th class="px-6 py-3.5 text-left">Tanggal Dibuat</th>
                                        <th class="px-6 py-3.5 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($babGroup['materi'] as $mIndex => $item)
                                    <tr class="hover:bg-slate-50/80 transition group">
                                        <td class="px-6 py-4 text-sm font-semibold text-slate-500">{{ $mIndex + 1 }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-xs">
                                                    {{ substr($item['judul'], 0, 1) }}
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="font-bold text-slate-800 text-sm truncate max-w-xs sm:max-w-md">{{ $item['judul'] }}</p>
                                                    <p class="text-[11px] text-slate-400 mt-0.5">ID: #{{ $item['id'] }} • {{ $item['quiz_count'] }} Soal Kuis</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-700">
                                                Urutan {{ $item['urutan'] ?: ($mIndex + 1) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="inline-flex items-center gap-1">
                                                @if(!empty($item['file']))
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 text-[10px] font-semibold" title="File dokumen">
                                                        📄 File
                                                    </span>
                                                @endif
                                                @if(!empty($item['gambar']))
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 text-[10px] font-semibold" title="Cover gambar">
                                                        🖼️ Gambar
                                                    </span>
                                                @endif
                                                @if(!empty($item['url']))
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-purple-50 text-purple-700 text-[10px] font-semibold" title="URL video/eksternal">
                                                        🔗 Link
                                                    </span>
                                                @endif
                                                @if(empty($item['file']) && empty($item['gambar']) && empty($item['url']))
                                                    <span class="text-xs text-slate-400">-</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if(strtolower($item['status']) === 'published')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    Published
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-50 text-amber-700 border border-amber-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                    Draft
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-xs text-slate-500 whitespace-nowrap">{{ $item['tanggal'] }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="inline-flex items-center justify-center gap-1.5">
                                                <button onclick="openPreviewPOV({{ $item['id'] }})" class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition cursor-pointer flex items-center gap-1" title="Lihat POV Siswa">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                    <span class="text-xs font-bold">POV</span>
                                                </button>
                                                <button onclick="editMateri({{ $item['id'] }})" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition cursor-pointer" title="Edit Materi">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </button>
                                                <button onclick="deleteMateri({{ $item['id'] }})" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition cursor-pointer" title="Hapus Materi">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View per Bab -->
                        <div class="md:hidden divide-y divide-slate-100 p-3.5 space-y-3">
                            @foreach($babGroup['materi'] as $mIndex => $item)
                            <div class="p-3 bg-slate-50/70 rounded-xl border border-slate-200/70 space-y-2">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <div class="w-8 h-8 rounded-lg bg-blue-600 text-white font-bold text-xs flex items-center justify-center shrink-0">
                                            {{ substr($item['judul'], 0, 1) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-slate-800 text-sm truncate">{{ $item['judul'] }}</p>
                                            <p class="text-[10px] text-slate-400">Urutan {{ $item['urutan'] ?: ($mIndex + 1) }} • {{ $item['quiz_count'] }} Kuis</p>
                                        </div>
                                    </div>
                                    @if(strtolower($item['status']) === 'published')
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200 shrink-0">Published</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-amber-50 text-amber-700 border border-amber-200 shrink-0">Draft</span>
                                    @endif
                                </div>
                                <div class="flex items-center justify-between pt-2 border-t border-slate-200/60 text-xs">
                                    <span class="text-[10px] text-slate-400">{{ $item['tanggal'] }}</span>
                                    <div class="flex items-center gap-1.5">
                                        <button onclick="openPreviewPOV({{ $item['id'] }})" class="px-2 py-1 bg-emerald-50 text-emerald-700 font-bold rounded-lg text-[11px] flex items-center gap-1">
                                            <span>POV</span>
                                        </button>
                                        <button onclick="editMateri({{ $item['id'] }})" class="px-2.5 py-1 bg-blue-50 text-blue-600 font-bold rounded-lg text-[11px]">Edit</button>
                                        <button onclick="deleteMateri({{ $item['id'] }})" class="px-2.5 py-1 bg-rose-50 text-rose-600 font-bold rounded-lg text-[11px]">Hapus</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <!-- State jika bab belum ada materi -->
                        <div class="px-6 py-8 text-center text-slate-400 bg-white">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center mx-auto mb-2 text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                            <p class="text-xs font-semibold text-slate-500">Belum ada materi pembelajaran pada bab ini.</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">Materi yang ditambahkan ke bab ini akan tersusun rapi secara berurutan.</p>
                            <button type="button" onclick="openModalWithBab({{ $babGroup['id_kategori'] }}, {{ $babGroup['id'] }})"
                                    class="mt-3 inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-sm shadow-blue-600/30 transition cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                <span>Tambah Materi Pertama</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl p-10 text-center border border-slate-200">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <h4 class="text-base font-extrabold text-slate-800">Belum Ada Bab atau Materi</h4>
                <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">
                    Materi harus memiliki Bab dan tidak bisa dibuat tanpa Bab. Silakan buat Bab kurikulum terlebih dahulu sebelum menambahkan materi.
                </p>
                <div class="mt-4 flex items-center justify-center gap-3">
                    <button type="button" onclick="openQuickAddBabModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-md shadow-blue-600/20 transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        <span>Buat Bab Sekarang</span>
                    </button>
                    <a href="{{ route('admin.bab') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                        Kelola Bab
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- ===================================================== -->
<!-- MODAL TAMBAH/EDIT MATERI (KATEGORI -> BAB -> MATERI)   -->
<!-- ===================================================== -->
<div id="materiModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-3 sm:p-4 transition-all duration-200">
    <div id="materiModalContainer" class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto transition-all duration-300">
        <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between sticky top-0 bg-white z-20 rounded-t-3xl shadow-2xs">
            <div>
                <h3 id="modalTitle" class="text-lg sm:text-xl font-bold text-slate-800">Tambah Materi Baru</h3>
                <p id="modalSubtitle" class="text-xs text-slate-500 mt-0.5">Isi detail materi pembelajaran</p>
            </div>
            
            <!-- Controls di Header Modal: Pilihan 2 Mode (Standar vs Luas) & Tutup -->
            <div class="flex items-center gap-2">
                <!-- Dual Mode Toggle (Standar vs Mode Luas Word) -->
                <div class="inline-flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200 text-xs font-semibold">
                    <button type="button" onclick="setMateriModalMode('compact')" id="btnModeCompact" class="px-2.5 py-1.5 rounded-lg transition flex items-center gap-1.5 bg-white text-slate-800 shadow-xs font-bold cursor-pointer" title="Mode Standar (Tampilkan Semua Isian)">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                        <span class="hidden sm:inline">Standar</span>
                    </button>
                    <button type="button" onclick="setMateriModalMode('large')" id="btnModeLarge" class="px-2.5 py-1.5 rounded-lg transition flex items-center gap-1.5 text-slate-500 hover:text-slate-800 cursor-pointer" title="Mode Luas (Fokus Konten Materi Saja)">
                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                        <span class="hidden sm:inline font-bold text-blue-700">Mode Luas</span>
                    </button>
                </div>

                <button type="button" onclick="closeModal()" class="p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition cursor-pointer" title="Tutup Modal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <form id="materiForm" class="p-5 sm:p-6 space-y-4" method="POST" action="{{ route('admin.materi.store') }}" enctype="multipart/form-data" novalidate>
            @csrf
            <input type="hidden" name="_method" id="materiMethod" value="">
            <input type="hidden" id="materiId" name="id">

            @if($errors->any())
                <div class="rounded-xl bg-rose-50 border border-rose-200 p-4">
                    <p class="text-sm font-bold text-rose-700 mb-1">Periksa kembali isian berikut:</p>
                    <ul class="text-xs text-rose-600 list-disc pl-5 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Metadata Form (Judul, Kategori, Bab, Urutan, Status, URL, Deskripsi) - Tersembunyi saat Mode Luas -->
            <div id="materiSectionMeta" class="space-y-4">
            <!-- Judul -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Materi <span class="text-rose-500">*</span></label>
                <input type="text" id="inputJudul" name="judul" required value="{{ old('judul') }}"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"
                       placeholder="Contoh: Daily Greetings">
            </div>

            <!-- Kategori & Bab (Struktur Langsung) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori <span class="text-rose-500">*</span></label>
                    <select id="inputKategori" name="id_kategori" required onchange="onKategoriChanged(this.value)"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoriList as $kategori)
                            <option value="{{ $kategori->id_kategori }}" @selected(old('id_kategori') == $kategori->id_kategori)>{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-sm font-semibold text-slate-700">Bab <span class="text-rose-500">*</span></label>
                        <button type="button" onclick="openQuickAddBabModal()" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition">
                            + Buat Bab Baru
                        </button>
                    </div>
                    <select id="inputBab" name="id_bab" required onchange="onBabSelected(this.value)"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        <option value="">Pilih Kategori terlebih dahulu</option>
                    </select>
                </div>
            </div>

            <!-- Alert jika kategori belum memiliki bab -->
            <div id="noBabWarning" class="hidden p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs flex items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <span class="text-base shrink-0">⚠️</span>
                    <span>Kategori ini belum memiliki Bab. Materi <strong>tidak bisa dibuat</strong> jika tidak memiliki Bab.</span>
                </div>
                <button type="button" onclick="openQuickAddBabModal()" class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white rounded-lg font-bold text-xs shrink-0 cursor-pointer shadow-xs transition">
                    + Buat Bab Sekarang
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Urutan (Opsional)</label>
                    <input type="number" id="inputUrutan" name="urutan" min="1" value="{{ old('urutan') }}"
                           placeholder="Otomatis"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                    <select id="inputStatus" name="status"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        <option value="Draft">Draft</option>
                        <option value="Published">Published</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center justify-between">
                        <span>Batas Waktu Quiz <span class="text-rose-500">*</span></span>
                        <span class="text-[10px] text-amber-600 font-medium">Auto-submit</span>
                    </label>
                    <div class="relative">
                        <input type="number" id="inputDurasiMenit" name="durasi_menit" min="1" max="300" required value="15" placeholder="15"
                               class="w-full pl-9 pr-14 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition font-semibold text-slate-800">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="absolute right-3.5 top-2.5 text-xs font-bold text-slate-400">Menit</span>
                    </div>
                </div>
            </div>

            <!-- Multiple Sumber URL -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-sm font-semibold text-slate-700">
                        Sumber URL / Tautan Materi <span class="text-slate-400 font-normal">(Video YouTube / Tautan Referensi)</span>
                    </label>
                    <button type="button" onclick="addUrlInputRow()" class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 hover:text-blue-800 transition cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah URL Lain</span>
                    </button>
                </div>
                <div id="urlInputsContainer" class="space-y-2.5">
                    <!-- Dynamic URL Rows via JS -->
                </div>
                <p class="text-[11px] text-slate-400 mt-1.5">Mendukung input lebih dari 1 link (YouTube dan referensi belajar online).</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Singkat</label>
                <textarea id="inputDeskripsi" name="deskripsi" rows="2"
                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition resize-none"
                          placeholder="Ringkasan singkat isi materi...">{{ old('deskripsi') }}</textarea>
            </div>
            </div> <!-- End materiSectionMeta -->

            <!-- Konten Materi (Word Editor) -->
            <div id="sectionEditor">
                <div id="labelKontenWrapper" class="flex items-center justify-between mb-2">
                    <label class="block text-sm font-semibold text-slate-700">Konten Materi <span class="text-rose-500">*</span></label>
                    <span class="text-[11px] font-medium text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md flex items-center gap-1">
                        <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Editor Word
                    </span>
                </div>

                <div id="materiEditorWrapper" class="border border-slate-200 rounded-2xl overflow-hidden bg-white shadow-xs focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-500 transition">
                    <!-- Word-style Ribbon Toolbar (Diem / Pinned di Atas) -->
                    <div id="materiEditorToolbar" class="bg-slate-50/95 border-b border-slate-200 px-2.5 py-1.5 flex flex-wrap items-center gap-1.5 text-slate-700 select-none sticky top-0 z-30 shadow-2xs backdrop-blur-xs shrink-0">
                        <!-- Jenis Font (Font Family) -->
                        <select id="editorFontFamily" onmousedown="saveSelection()" onfocus="saveSelection()" onchange="applyFontName(this.value)" class="text-xs font-semibold px-2 py-1.5 bg-white border border-slate-200 rounded-lg hover:border-slate-300 focus:outline-hidden focus:ring-1 focus:ring-blue-500 text-slate-700 cursor-pointer shadow-2xs" title="Jenis Huruf / Font">
                            <option value="">Font: Default</option>
                            <option value="Arial, sans-serif">Arial</option>
                            <option value="'Poppins', sans-serif">Poppins</option>
                            <option value="'Times New Roman', serif">Times New Roman</option>
                            <option value="Georgia, serif">Georgia</option>
                            <option value="'Courier New', monospace">Courier New</option>
                            <option value="'Comic Sans MS', cursive">Comic Sans</option>
                        </select>

                        <!-- Ukuran Font (Font Size) -->
                        <select id="editorFontSize" onmousedown="saveSelection()" onfocus="saveSelection()" onchange="applyFontSize(this.value)" class="text-xs font-semibold px-2 py-1.5 bg-white border border-slate-200 rounded-lg hover:border-slate-300 focus:outline-hidden focus:ring-1 focus:ring-blue-500 text-slate-700 cursor-pointer shadow-2xs" title="Ukuran Font">
                            <option value="">Ukuran Font</option>
                            <option value="1">10px (Sangat Kecil)</option>
                            <option value="2">12px (Kecil)</option>
                            <option value="3">14px (Normal)</option>
                            <option value="4">16px (Sedang)</option>
                            <option value="5">18px (Besar)</option>
                            <option value="6">24px (Ekstra)</option>
                            <option value="7">36px (Jumbo)</option>
                        </select>

                        <!-- Gaya Teks (Heading / Paragraf) -->
                        <select id="editorFormatBlock" onmousedown="saveSelection()" onfocus="saveSelection()" onchange="applyFormatBlock(this.value)" class="text-xs font-semibold px-2 py-1.5 bg-white border border-slate-200 rounded-lg hover:border-slate-300 focus:outline-hidden focus:ring-1 focus:ring-blue-500 text-slate-700 cursor-pointer shadow-2xs" title="Format Paragraf & Judul">
                            <option value="p">Normal (P)</option>
                            <option value="h1">Judul Utama (H1)</option>
                            <option value="h2">Sub Judul (H2)</option>
                            <option value="h3">Topik Kecil (H3)</option>
                        </select>

                        <div class="w-px h-5 bg-slate-200 mx-0.5"></div>

                        <!-- Basic Styles: Bold, Italic, Underline, Strike -->
                        <button type="button" onmousedown="event.preventDefault()" onclick="formatDoc('bold')" class="editor-btn p-1.5 rounded-lg hover:bg-slate-200/70 text-slate-700 transition" title="Tebal (Ctrl+B)" data-cmd="bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 4h8a4 4 0 014 4 4 4 0 01-4 4H6z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 12h9a4 4 0 014 4 4 4 0 01-4 4H6z"/></svg>
                        </button>
                        <button type="button" onmousedown="event.preventDefault()" onclick="formatDoc('italic')" class="editor-btn p-1.5 rounded-lg hover:bg-slate-200/70 text-slate-700 transition" title="Miring (Ctrl+I)" data-cmd="italic">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 4h4m-2 0l-4 16m-2 0h4"/></svg>
                        </button>
                        <button type="button" onmousedown="event.preventDefault()" onclick="formatDoc('underline')" class="editor-btn p-1.5 rounded-lg hover:bg-slate-200/70 text-slate-700 transition" title="Garis Bawah (Ctrl+U)" data-cmd="underline">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 3v7a6 6 0 0012 0V3M4 21h16"/></svg>
                        </button>
                        <button type="button" onmousedown="event.preventDefault()" onclick="formatDoc('strikeThrough')" class="editor-btn p-1.5 rounded-lg hover:bg-slate-200/70 text-slate-700 transition" title="Coret Teks (Strikethrough)" data-cmd="strikeThrough">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4H9a3 3 0 00-3 3c0 2 2 3 5 3h2a3 3 0 010 6H8m-4-6h16"/></svg>
                        </button>

                        <div class="w-px h-5 bg-slate-200 mx-0.5"></div>

                        <!-- Text Color Picker -->
                        <label class="editor-btn p-1.5 rounded-lg hover:bg-slate-200/70 text-slate-700 transition cursor-pointer flex items-center justify-center relative" title="Ubah Warna Huruf / Teks" onmousedown="saveSelection()">
                            <span class="font-black text-xs flex flex-col items-center leading-none">
                                <span>A</span>
                                <span id="textColorIndicator" class="w-3.5 h-0.5 bg-rose-600 rounded-full mt-0.5"></span>
                            </span>
                            <input type="color" id="editorTextColor" value="#dc2626" onchange="applyTextColor(this.value)" class="sr-only">
                        </label>

                        <!-- Highlighter (Stabilo) -->
                        <button type="button" onmousedown="event.preventDefault()" onclick="toggleHighlight()" class="editor-btn p-1.5 rounded-lg hover:bg-slate-200/70 text-slate-700 transition" title="Stabilo / Sorot Kuning">
                            <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zm1 14a1 1 0 100-2 1 1 0 000 2zm5-1.757l4.9-4.9a2 2 0 000-2.828L13.485 5.1a2 2 0 00-2.828 0L10 5.757v8.486zM16 18H9.071l6-6H16a2 2 0 012 2v2a2 2 0 01-2 2z" clip-rule="evenodd"/></svg>
                        </button>

                        <div class="w-px h-5 bg-slate-200 mx-0.5"></div>

                        <!-- Lists & Numbering (Word-Style 123, ABC, abc, Romawi) -->
                        <button type="button" onmousedown="event.preventDefault()" onclick="formatDoc('insertUnorderedList')" class="editor-btn p-1.5 rounded-lg hover:bg-slate-200/70 text-slate-700 transition" title="Daftar Poin (Peluru •)" data-cmd="insertUnorderedList">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16M2 6h.01M2 12h.01M2 18h.01"/></svg>
                        </button>

                        <!-- Numbered 1, 2, 3 -->
                        <button type="button" onmousedown="event.preventDefault()" onclick="applyListStyle('1')" class="editor-btn p-1.5 rounded-lg hover:bg-slate-200/70 text-slate-700 transition" title="Daftar Angka: 1, 2, 3..." data-list-type="1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 6h13M7 12h13M7 18h13M3 5v3m-1 0h2m-1 4a1 1 0 111 1c-.5.5-1 1-1 1h2m-2 4a1 1 0 111-1c0-.5-.5-1-1-1h-.5"/></svg>
                        </button>

                        <!-- Alphabet A, B, C -->
                        <button type="button" onmousedown="event.preventDefault()" onclick="applyListStyle('A')" class="editor-btn px-2 py-1 rounded-lg hover:bg-slate-200/70 text-slate-700 transition flex items-center gap-1 font-bold text-xs" title="Daftar Huruf Kapital: A, B, C..." data-list-type="A">
                            <span class="text-[11px] font-black tracking-tight text-blue-700 bg-blue-50 px-1 py-0.5 rounded border border-blue-200">A.B.C</span>
                        </button>

                        <!-- Dropdown Pilihan Format Penomoran Lengkap -->
                        <div class="relative inline-block text-left" id="listDropdownWrapper">
                            <button type="button" onmousedown="event.preventDefault()" onclick="toggleListDropdown(event)" class="editor-btn p-1.5 rounded-lg hover:bg-slate-200/70 text-slate-600 transition flex items-center" title="Pilihan Penomoran: a, b, c / Romawi I, II, III">
                                <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                            </button>

                            <!-- Dropdown Popup -->
                            <div id="listDropdownMenu" class="hidden absolute left-0 sm:left-auto sm:right-0 mt-1 w-64 bg-white rounded-xl shadow-xl border border-slate-200 py-1.5 z-50 divide-y divide-slate-100">
                                <div class="px-3 py-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                    Format Penomoran
                                </div>
                                <div class="p-1 space-y-0.5">
                                    <button type="button" onmousedown="event.preventDefault()" onclick="applyListStyle('1')" class="w-full flex items-center gap-3 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition text-left cursor-pointer group">
                                        <span class="w-12 px-1.5 py-0.5 bg-slate-100 group-hover:bg-blue-100 text-slate-700 group-hover:text-blue-700 rounded text-[11px] font-mono font-bold text-center">1, 2, 3</span>
                                        <div class="flex-1">
                                            <p class="leading-tight font-bold">Angka Standar (1, 2, 3)</p>
                                            <p class="text-[10px] text-slate-400 leading-none mt-0.5">1. Materi, 2. Contoh</p>
                                        </div>
                                    </button>

                                    <button type="button" onmousedown="event.preventDefault()" onclick="applyListStyle('A')" class="w-full flex items-center gap-3 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition text-left cursor-pointer group">
                                        <span class="w-12 px-1.5 py-0.5 bg-blue-50 text-blue-700 rounded text-[11px] font-mono font-bold text-center border border-blue-200">A, B, C</span>
                                        <div class="flex-1">
                                            <p class="leading-tight font-bold text-blue-800">Huruf Besar (A, B, C)</p>
                                            <p class="text-[10px] text-slate-400 leading-none mt-0.5">A. Opsi, B. Opsi</p>
                                        </div>
                                    </button>

                                    <button type="button" onmousedown="event.preventDefault()" onclick="applyListStyle('a')" class="w-full flex items-center gap-3 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition text-left cursor-pointer group">
                                        <span class="w-12 px-1.5 py-0.5 bg-slate-100 group-hover:bg-blue-100 text-slate-700 group-hover:text-blue-700 rounded text-[11px] font-mono font-bold text-center">a, b, c</span>
                                        <div class="flex-1">
                                            <p class="leading-tight font-bold">Huruf Kecil (a, b, c)</p>
                                            <p class="text-[10px] text-slate-400 leading-none mt-0.5">a. Sub-poin, b. Sub-poin</p>
                                        </div>
                                    </button>

                                    <button type="button" onmousedown="event.preventDefault()" onclick="applyListStyle('I')" class="w-full flex items-center gap-3 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition text-left cursor-pointer group">
                                        <span class="w-12 px-1.5 py-0.5 bg-slate-100 group-hover:bg-blue-100 text-slate-700 group-hover:text-blue-700 rounded text-[11px] font-mono font-bold text-center">I, II, III</span>
                                        <div class="flex-1">
                                            <p class="leading-tight font-bold">Romawi Kapital</p>
                                            <p class="text-[10px] text-slate-400 leading-none mt-0.5">I. Bab, II. Subbab</p>
                                        </div>
                                    </button>

                                    <button type="button" onmousedown="event.preventDefault()" onclick="applyListStyle('i')" class="w-full flex items-center gap-3 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition text-left cursor-pointer group">
                                        <span class="w-12 px-1.5 py-0.5 bg-slate-100 group-hover:bg-blue-100 text-slate-700 group-hover:text-blue-700 rounded text-[11px] font-mono font-bold text-center">i, ii, iii</span>
                                        <div class="flex-1">
                                            <p class="leading-tight font-bold">Romawi Kecil</p>
                                            <p class="text-[10px] text-slate-400 leading-none mt-0.5">i. Catatan, ii. Poin kecil</p>
                                        </div>
                                    </button>
                                </div>

                                <div class="px-3 py-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50 border-t border-slate-100">
                                    Urutan Penomoran (Lanjutkan / Ulang)
                                </div>
                                <div class="p-1 space-y-0.5">
                                    <button type="button" onmousedown="event.preventDefault()" onclick="continueListNumbering()" class="w-full flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 transition text-left cursor-pointer group" title="Sambung penomoran dari bagian sebelumnya (B, C, D...)">
                                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
                                        <div class="flex-1">
                                            <p class="leading-tight font-bold text-emerald-800">Lanjutkan Penomoran (B, C, D...)</p>
                                            <p class="text-[10px] text-slate-400 leading-none mt-0.5">Otomatis sambung huruf/nomor berikutnya</p>
                                        </div>
                                    </button>

                                    <button type="button" onmousedown="event.preventDefault()" onclick="restartListNumbering()" class="w-full flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-slate-700 hover:bg-amber-50 hover:text-amber-700 transition text-left cursor-pointer group" title="Mulai ulang dari A atau 1">
                                        <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                        <div class="flex-1">
                                            <p class="leading-tight font-bold text-amber-800">Mulai Ulang dari A / 1</p>
                                            <p class="text-[10px] text-slate-400 leading-none mt-0.5">Mulai penomoran baru dari awal</p>
                                        </div>
                                    </button>

                                    <button type="button" onmousedown="event.preventDefault()" onclick="setListCustomStart()" class="w-full flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-slate-700 hover:bg-purple-50 hover:text-purple-700 transition text-left cursor-pointer group" title="Tentukan huruf atau angka awal">
                                        <svg class="w-4 h-4 text-purple-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        <div class="flex-1">
                                            <p class="leading-tight font-bold text-purple-800">Atur Huruf / Angka Awal...</p>
                                            <p class="text-[10px] text-slate-400 leading-none mt-0.5">Ketik huruf atau angka awal yang diinginkan</p>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Indent & Outdent (Word-Style List Nesting) -->
                        <button type="button" onmousedown="event.preventDefault()" onclick="formatDoc('outdent')" class="editor-btn p-1.5 rounded-lg hover:bg-slate-200/70 text-slate-700 transition" title="Kurangi Indensasi / Geser Kiri (Shift+Tab)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-4-4 4-4m-4 4h14M3 6h18M3 18h4"/></svg>
                        </button>
                        <button type="button" onmousedown="event.preventDefault()" onclick="formatDoc('indent')" class="editor-btn p-1.5 rounded-lg hover:bg-slate-200/70 text-slate-700 transition" title="Tambah Indensasi / Masuk ke Dalam (Tab)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l4 4-4 4m4-4H3m18 9h-4M3 19h18"/></svg>
                        </button>

                        <!-- Blok Catatan / Kutipan (Callout) dengan Pilihan Warna -->
                        <div class="relative inline-flex items-center" id="quoteDropdownWrapper">
                            <button type="button" id="btnQuoteFormat" onmousedown="event.preventDefault()" onclick="toggleQuoteDropdown(event)" 
                                    class="editor-btn px-1.5 py-1.5 rounded-lg hover:bg-slate-200/70 text-slate-700 transition flex items-center gap-1" 
                                    title="Kutipan / Blok Catatan (Pilih Warna)" data-cmd="blockquote">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                <span id="quoteColorIndicator" class="w-2 h-2 rounded-full bg-sky-500 shrink-0 border border-white shadow-2xs"></span>
                                <svg class="w-2.5 h-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <!-- Dropdown Menu Warna Blok Catatan -->
                            <div id="quoteDropdownMenu" class="hidden absolute left-0 sm:left-auto sm:right-0 top-full mt-1 w-64 bg-white rounded-xl shadow-xl border border-slate-200 py-1.5 z-50 divide-y divide-slate-100">
                                <div class="px-3 py-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                    Pilih Warna Blok Catatan
                                </div>
                                <div class="p-1.5 grid grid-cols-2 gap-1">
                                    <!-- Hijau: Benar / Correct / Tips -->
                                    <button type="button" onmousedown="event.preventDefault()" onclick="applyQuoteColor('green')" 
                                            class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-emerald-50 text-slate-700 transition text-left cursor-pointer group">
                                        <span class="w-4 h-4 rounded-full bg-emerald-500 border border-emerald-600 shrink-0 shadow-2xs"></span>
                                        <span class="text-xs font-semibold group-hover:text-emerald-700">Hijau (Benar)</span>
                                    </button>

                                    <!-- Merah: Salah / Incorrect / Warning -->
                                    <button type="button" onmousedown="event.preventDefault()" onclick="applyQuoteColor('red')" 
                                            class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-rose-50 text-slate-700 transition text-left cursor-pointer group">
                                        <span class="w-4 h-4 rounded-full bg-rose-500 border border-rose-600 shrink-0 shadow-2xs"></span>
                                        <span class="text-xs font-semibold group-hover:text-rose-700">Merah (Salah)</span>
                                    </button>

                                    <!-- Biru: Info / Standar -->
                                    <button type="button" onmousedown="event.preventDefault()" onclick="applyQuoteColor('blue')" 
                                            class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-sky-50 text-slate-700 transition text-left cursor-pointer group">
                                        <span class="w-4 h-4 rounded-full bg-sky-500 border border-sky-600 shrink-0 shadow-2xs"></span>
                                        <span class="text-xs font-semibold group-hover:text-sky-700">Biru (Info)</span>
                                    </button>

                                    <!-- Kuning: Penting / Perhatian -->
                                    <button type="button" onmousedown="event.preventDefault()" onclick="applyQuoteColor('amber')" 
                                            class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-amber-50 text-slate-700 transition text-left cursor-pointer group">
                                        <span class="w-4 h-4 rounded-full bg-amber-500 border border-amber-600 shrink-0 shadow-2xs"></span>
                                        <span class="text-xs font-semibold group-hover:text-amber-700">Kuning (Penting)</span>
                                    </button>

                                    <!-- Ungu: Rumus / Formula -->
                                    <button type="button" onmousedown="event.preventDefault()" onclick="applyQuoteColor('purple')" 
                                            class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-purple-50 text-slate-700 transition text-left cursor-pointer group">
                                        <span class="w-4 h-4 rounded-full bg-purple-500 border border-purple-600 shrink-0 shadow-2xs"></span>
                                        <span class="text-xs font-semibold group-hover:text-purple-700">Ungu (Rumus)</span>
                                    </button>

                                    <!-- Abu-abu: Netral -->
                                    <button type="button" onmousedown="event.preventDefault()" onclick="applyQuoteColor('gray')" 
                                            class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-slate-100 text-slate-700 transition text-left cursor-pointer group">
                                        <span class="w-4 h-4 rounded-full bg-slate-400 border border-slate-500 shrink-0 shadow-2xs"></span>
                                        <span class="text-xs font-semibold group-hover:text-slate-800">Abu (Netral)</span>
                                    </button>
                                </div>

                                <!-- Custom Color Picker & Remove Option -->
                                <div class="p-1.5 space-y-1">
                                    <label class="flex items-center justify-between px-2 py-1.5 rounded-lg hover:bg-slate-50 transition cursor-pointer text-xs font-semibold text-slate-700">
                                        <span class="flex items-center gap-2">
                                            <span class="w-4 h-4 rounded-full bg-gradient-to-tr from-pink-500 via-purple-500 to-indigo-500 shrink-0 border border-slate-200"></span>
                                            <span>Pilih Warna Bebas...</span>
                                        </span>
                                        <input type="color" id="customQuoteColor" onchange="applyCustomQuoteColor(this.value)" class="w-6 h-6 rounded cursor-pointer border border-slate-200">
                                    </label>

                                    <button type="button" onmousedown="event.preventDefault()" onclick="removeQuoteFormat()" 
                                            class="w-full flex items-center gap-2 px-2 py-1.5 rounded-lg text-xs font-semibold text-rose-600 hover:bg-rose-50 transition text-left cursor-pointer">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <span>Hapus Blok Catatan (Kembali Normal)</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="w-px h-5 bg-slate-200 mx-0.5"></div>

                        <!-- Alignment -->
                        <button type="button" onmousedown="event.preventDefault()" onclick="formatDoc('justifyLeft')" class="editor-btn p-1.5 rounded-lg hover:bg-slate-200/70 text-slate-700 transition" title="Rata Kiri" data-cmd="justifyLeft">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h10M4 18h14"/></svg>
                        </button>
                        <button type="button" onmousedown="event.preventDefault()" onclick="formatDoc('justifyCenter')" class="editor-btn p-1.5 rounded-lg hover:bg-slate-200/70 text-slate-700 transition" title="Rata Tengah" data-cmd="justifyCenter">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M7 12h10M5 18h14"/></svg>
                        </button>
                        <button type="button" onmousedown="event.preventDefault()" onclick="formatDoc('justifyRight')" class="editor-btn p-1.5 rounded-lg hover:bg-slate-200/70 text-slate-700 transition" title="Rata Kanan" data-cmd="justifyRight">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M10 12h10M6 18h14"/></svg>
                        </button>

                        <div class="w-px h-5 bg-slate-200 mx-0.5"></div>

                        <!-- Sisipkan Foto (Word-style Inline Image) -->
                        <button type="button" onmousedown="saveSelection(); event.preventDefault();" onclick="triggerInlineImageUpload()" class="editor-btn px-2.5 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 transition flex items-center gap-1.5 shadow-2xs cursor-pointer active:scale-95" title="Sisipkan Foto / Gambar di Posisi Kursor (Bisa di atas, tengah antar paragraf, atau bawah teks)">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="text-xs font-bold text-emerald-800">Sisipkan Foto</span>
                        </button>
                        <input type="file" id="editorInlineFileInput" accept="image/*" class="hidden" onchange="handleInlineImageUpload(this)">

                        <div class="w-px h-5 bg-slate-200 mx-0.5"></div>

                        <!-- Horizontal Divider & Remove Format -->
                        <button type="button" onmousedown="event.preventDefault()" onclick="formatDoc('insertHorizontalRule')" class="editor-btn p-1.5 rounded-lg hover:bg-slate-200/70 text-slate-700 transition" title="Garis Pemisah (Horizontal Rule)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12h16"/></svg>
                        </button>
                        <button type="button" onmousedown="event.preventDefault()" onclick="formatDoc('removeFormat')" class="editor-btn p-1.5 rounded-lg hover:bg-slate-200/70 text-slate-700 transition" title="Hapus Format">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>

                        <!-- Undo / Redo & Mode Toggle on the right -->
                        <div class="ml-auto flex items-center gap-1.5">
                            <button type="button" onmousedown="event.preventDefault()" onclick="formatDoc('undo')" class="p-1.5 rounded-lg hover:bg-slate-200/70 text-slate-500 hover:text-slate-700 transition" title="Batalkan (Ctrl+Z)">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a5 5 0 015 5v2m-15-7l4-4m-4 4l4 4"/></svg>
                            </button>
                            <button type="button" onmousedown="event.preventDefault()" onclick="formatDoc('redo')" class="p-1.5 rounded-lg hover:bg-slate-200/70 text-slate-500 hover:text-slate-700 transition" title="Ulangi (Ctrl+Y)">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10H11a5 5 0 00-5 5v2m15-7l-4-4m4 4l-4 4"/></svg>
                            </button>
                            <div class="w-px h-4 bg-slate-200 mx-0.5"></div>
                            <button type="button" id="btnToggleModeInToolbar" onmousedown="event.preventDefault()" onclick="toggleMateriModalMode()" class="editor-btn px-2 py-1 rounded-lg bg-blue-50/90 hover:bg-blue-100 text-blue-700 border border-blue-200/80 transition flex items-center gap-1 text-[11px] font-bold cursor-pointer shadow-2xs" title="Ganti Mode Tampilan (Standar / Luas)">
                                <svg class="w-3.5 h-3.5 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                <span class="hidden sm:inline">Mode Luas</span>
                            </button>
                            <button type="button" id="btnToolbarSave" onclick="submitMateriDirectly()" class="hidden px-2.5 py-1 rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition flex items-center gap-1 text-[11px] font-bold cursor-pointer shadow-xs active:scale-95" title="Simpan Materi (Ctrl+S)">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                                <span>Simpan</span>
                            </button>
                        </div>
                    </div>

                    <!-- Sub-toolbar Konteks Foto (Tampil Otomatis Saat Foto Diklik) -->
                    <div id="imageContextBar" class="hidden bg-emerald-50 border-b border-emerald-200/80 px-3 py-1.5 flex flex-wrap items-center justify-between gap-2 text-xs text-emerald-950 transition">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-1 font-bold text-emerald-800 text-xs">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Posisi Foto:
                            </span>
                            <div class="inline-flex items-center bg-white border border-emerald-200 rounded-lg p-0.5 shadow-2xs">
                                <button type="button" onmousedown="event.preventDefault()" onclick="setInlineImageAlignment('left')" id="btnAlignLeft" class="px-2 py-0.5 rounded text-xs font-semibold text-slate-700 hover:bg-emerald-100 transition" title="Rata Kiri">⬅️ Kiri</button>
                                <button type="button" onmousedown="event.preventDefault()" onclick="setInlineImageAlignment('center')" id="btnAlignCenter" class="px-2 py-0.5 rounded text-xs font-bold bg-emerald-600 text-white shadow-2xs transition" title="Rata Tengah">⏺️ Tengah</button>
                                <button type="button" onmousedown="event.preventDefault()" onclick="setInlineImageAlignment('right')" id="btnAlignRight" class="px-2 py-0.5 rounded text-xs font-semibold text-slate-700 hover:bg-emerald-100 transition" title="Rata Kanan">➡️ Kanan</button>
                            </div>
                            <div class="inline-flex items-center bg-white border border-emerald-200 rounded-lg p-0.5 shadow-2xs">
                                <span class="text-[10px] text-slate-400 font-bold px-1.5 uppercase">Ukuran:</span>
                                <button type="button" onmousedown="event.preventDefault()" onclick="setInlineImageSize('35%')" class="px-2 py-0.5 rounded text-xs font-semibold text-slate-700 hover:bg-emerald-50">35%</button>
                                <button type="button" onmousedown="event.preventDefault()" onclick="setInlineImageSize('65%')" class="px-2 py-0.5 rounded text-xs font-semibold text-slate-700 hover:bg-emerald-50">65%</button>
                                <button type="button" onmousedown="event.preventDefault()" onclick="setInlineImageSize('100%')" class="px-2 py-0.5 rounded text-xs font-bold bg-emerald-100 text-emerald-800">100%</button>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" onmousedown="event.preventDefault()" onclick="deleteSelectedInlineImage()" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs border border-rose-200 transition cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus Foto
                            </button>
                            <button type="button" onmousedown="event.preventDefault()" onclick="deselectInlineImage()" class="text-slate-400 hover:text-slate-600 p-1 text-sm font-bold" title="Tutup Toolbar Foto">✕</button>
                        </div>
                    </div>

                    <!-- Sub-toolbar Konteks Blok Catatan / Komen (Tampil Otomatis Saat Kursor di Blok Catatan) -->
                    <div id="blockquoteContextBar" class="hidden bg-slate-50 border-b border-slate-200/90 px-3 py-1.5 flex flex-wrap items-center justify-between gap-2 text-xs text-slate-800 transition">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-1 font-bold text-slate-700 text-xs">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                Warna Blok Catatan:
                            </span>
                            <div class="inline-flex items-center bg-white border border-slate-200 rounded-lg p-0.5 shadow-2xs gap-1">
                                <button type="button" onmousedown="event.preventDefault()" onclick="applyQuoteColor('green')" class="px-2 py-0.5 rounded text-xs font-semibold text-emerald-800 hover:bg-emerald-50 transition flex items-center gap-1 cursor-pointer" title="Ubah ke Hijau (Benar / Correct / Tips)">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Hijau (Benar)
                                </button>
                                <button type="button" onmousedown="event.preventDefault()" onclick="applyQuoteColor('red')" class="px-2 py-0.5 rounded text-xs font-semibold text-rose-800 hover:bg-rose-50 transition flex items-center gap-1 cursor-pointer" title="Ubah ke Merah (Salah / Incorrect / Peringatan)">
                                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span> Merah (Salah)
                                </button>
                                <button type="button" onmousedown="event.preventDefault()" onclick="applyQuoteColor('blue')" class="px-2 py-0.5 rounded text-xs font-semibold text-sky-800 hover:bg-sky-50 transition flex items-center gap-1 cursor-pointer" title="Ubah ke Biru (Info / Standar)">
                                    <span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span> Biru (Info)
                                </button>
                                <button type="button" onmousedown="event.preventDefault()" onclick="applyQuoteColor('amber')" class="px-2 py-0.5 rounded text-xs font-semibold text-amber-800 hover:bg-amber-50 transition flex items-center gap-1 cursor-pointer" title="Ubah ke Kuning (Penting / Warning)">
                                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Kuning
                                </button>
                                <button type="button" onmousedown="event.preventDefault()" onclick="applyQuoteColor('purple')" class="px-2 py-0.5 rounded text-xs font-semibold text-purple-800 hover:bg-purple-50 transition flex items-center gap-1 cursor-pointer" title="Ubah ke Ungu (Rumus / Formula)">
                                    <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span> Ungu
                                </button>
                                <button type="button" onmousedown="event.preventDefault()" onclick="applyQuoteColor('gray')" class="px-2 py-0.5 rounded text-xs font-semibold text-slate-700 hover:bg-slate-100 transition flex items-center gap-1 cursor-pointer" title="Ubah ke Abu-abu (Netral)">
                                    <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span> Abu
                                </button>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" onmousedown="event.preventDefault()" onclick="removeQuoteFormat()" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs border border-rose-200 transition cursor-pointer" title="Hapus garis blok catatan dan kembalikan ke teks biasa">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus Garis Blok
                            </button>
                        </div>
                    </div>

                    <!-- Editable Content Area (Lembar Kertas Word) -->
                    <div id="editorContent" contenteditable="true" 
                         class="rich-text-editor min-h-[190px] max-h-[360px] overflow-y-auto px-4 py-3 text-slate-800 text-sm focus:outline-hidden leading-relaxed transition-all duration-300"
                         data-placeholder="Tulis konten teks lengkap materi di sini... Anda bisa mengetik langsung dan memformat teks (tebal, miring, garis bawah, poin, judul, dll) seperti di Microsoft Word."></div>

                    <!-- Hidden Textarea for Form Submit -->
                    <textarea id="inputKonten" name="isi_materi" class="hidden" required>{{ old('isi_materi') }}</textarea>

                    <!-- Bottom Status Bar -->
                    <div id="editorStatusBar" class="bg-slate-50/70 border-t border-slate-200 px-3 py-1.5 flex items-center justify-between text-[11px] text-slate-500">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center gap-1 font-medium text-slate-600">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                                Word Mode Aktif
                            </span>
                            <span class="hidden sm:inline text-slate-300">|</span>
                            <span class="hidden sm:inline text-slate-400">Pintasan: <kbd class="px-1 py-0.5 rounded bg-slate-200 text-slate-600 font-mono text-[10px]">Ctrl+B</kbd> Tebal, <kbd class="px-1 py-0.5 rounded bg-slate-200 text-slate-600 font-mono text-[10px]">Ctrl+I</kbd> Miring, <kbd class="px-1 py-0.5 rounded bg-slate-200 text-slate-600 font-mono text-[10px]">Ctrl+U</kbd> Garis Bawah</span>
                        </div>
                        <div id="editorWordCount" class="font-medium text-slate-500">
                            0 kata • 0 karakter
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gambar Ilustrasi Materi -->
            <div id="materiSectionCover" class="border-t border-slate-200 pt-4 mt-2">
                <!-- UPLOAD GAMBAR -->
                <div class="mb-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 mb-2">
                        <label class="block text-sm font-semibold text-slate-700">
                            Upload Cover / Sampul Materi <span class="text-slate-400 font-normal">(Opsional - Max 2MB)</span>
                        </label>
                        <span class="text-[11px] font-medium text-emerald-700 bg-emerald-50 border border-emerald-200/80 px-2 py-0.5 rounded-md flex items-center gap-1 w-fit">
                            💡 Posisi foto bebas: Gunakan tombol <strong>Sisipkan Foto</strong> di toolbar teks
                        </span>
                    </div>
                    <div class="flex items-center gap-3">
                        <label class="flex-1 cursor-pointer group">
                            <div id="imageUploadArea" class="border-2 border-dashed border-slate-300 rounded-xl p-3 hover:border-blue-500 hover:bg-blue-50/50 transition text-center">
                                <svg class="w-8 h-8 text-slate-400 group-hover:text-blue-500 mx-auto mb-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-xs text-slate-500 font-medium">Klik untuk upload gambar cover</p>
                            </div>
                            <input type="file" id="inputGambar" name="gambar" accept="image/*" class="hidden" onchange="previewImage(this)">
                        </label>

                        <div id="imagePreview" class="hidden relative w-24 h-24 rounded-xl overflow-hidden border border-slate-200 shadow-sm">
                            <img src="" alt="Preview" class="w-full h-full object-cover">
                            <button type="button" onclick="removeImage()" class="absolute top-1 right-1 w-5 h-5 bg-rose-500 text-white rounded-full flex items-center justify-center hover:bg-rose-600 transition shadow-md">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <p class="text-[11px] text-slate-500 mt-2 leading-relaxed">
                        Foto di atas adalah cover utama. Jika Anda ingin menaruh foto di <strong>awal sebelum teks, di tengah-tengah antar paragraf, atau di akhir teks seperti di Microsoft Word</strong>, gunakan tombol <span class="font-bold text-emerald-700">"Sisipkan Foto"</span> pada toolbar editor atau cukup tekan <kbd class="px-1 py-0.5 rounded bg-slate-200 font-mono text-[10px]">Ctrl+V</kbd> langsung di dalam teks materi.
                    </p>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div id="materiModalFooter" class="pt-4 flex gap-3 border-t border-slate-100 shrink-0">
                <button type="button" onclick="closeModal()" class="flex-1 px-4 py-2.5 border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" id="btnSubmitMateri" class="flex-1 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/30 transition cursor-pointer">
                    Simpan Materi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full p-6 text-center">
        <div class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-slate-800 mb-1">Hapus Materi Ini?</h3>
        <p class="text-xs text-slate-500 mb-6">Tindakan ini permanen dan akan menghapus data materi dari database.</p>
        <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex gap-3">
                <button type="button" onclick="closeDeleteModal()" class="flex-1 py-2.5 border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition text-sm">
                    Batal
                </button>
                <button type="submit" class="flex-1 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-xl transition text-sm">
                    Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ===================================================== -->
<!-- MODAL CEPAT TAMBAH BAB                                -->
<!-- ===================================================== -->
<div id="quickAddBabModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-200">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/75">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                <h3 class="text-base font-extrabold text-slate-800">Tambah Bab Baru</h3>
            </div>
            <button type="button" onclick="closeQuickAddBabModal()" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-200 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="quickAddBabForm" onsubmit="submitQuickAddBab(event)" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Kategori / Divisi <span class="text-rose-500">*</span></label>
                <select id="quickBabKategori" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoriList as $kategori)
                        <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Judul Bab <span class="text-rose-500">*</span></label>
                <input type="text" id="quickBabJudul" required placeholder="Contoh: Daily Small Talk, Simple Present"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Nomor Urutan (Opsional)</label>
                <input type="number" id="quickBabUrutan" min="1" placeholder="Otomatis nomor selanjutnya jika dikosongkan"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
            </div>
            <div id="quickBabAlert" class="hidden p-3 rounded-xl text-xs"></div>
            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeQuickAddBabModal()" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 text-xs font-bold hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="submit" id="btnSubmitQuickBab" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-lg shadow-blue-600/30 transition">
                    Simpan Bab
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL PREVIEW POV SISWA                                        -->
<!-- ============================================================== -->
<div id="previewPovModal" class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm z-50 hidden items-center justify-center p-2 sm:p-4 overflow-y-auto">
    <div id="previewModalContainer" class="bg-slate-100 rounded-3xl shadow-2xl border-2 border-slate-300 w-full max-w-5xl overflow-hidden my-auto transform transition-all duration-300 flex flex-col max-h-[92vh]">
        
        <!-- Modal Top Bar -->
        <div class="bg-white border-b border-slate-200 px-5 py-3.5 flex items-center justify-between shrink-0 shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-300 flex items-center justify-center font-bold">
                    👁️
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-extrabold text-slate-800">Pratinjau Materi (POV Siswa)</span>
                        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-300">Live Simulation</span>
                    </div>
                    <p class="text-[11px] text-slate-600 font-medium">Simulasi bagaimana siswa melihat konten materi ini di layar mereka.</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <!-- Device View Switcher -->
                <div class="flex items-center bg-slate-100 border border-slate-200 p-1 rounded-xl text-xs font-semibold">
                    <button type="button" onclick="setPreviewDevice('desktop')" id="btnDeviceDesktop" class="px-2.5 py-1 rounded-lg bg-white text-slate-800 font-bold shadow-xs transition flex items-center gap-1 cursor-pointer">
                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Desktop</span>
                    </button>
                    <button type="button" onclick="setPreviewDevice('mobile')" id="btnDeviceMobile" class="px-2.5 py-1 rounded-lg text-slate-600 hover:text-slate-900 transition flex items-center gap-1 cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        <span>Mobile</span>
                    </button>
                </div>

                <button type="button" onclick="closePreviewPOV()" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition cursor-pointer" title="Tutup Pratinjau">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <!-- Scrollable POV Viewport -->
        <div class="p-4 sm:p-6 overflow-y-auto flex-1 flex justify-center bg-slate-200/60">
            <div id="previewDeviceFrame" class="w-full max-w-4xl transition-all duration-300">
                <div class="bg-white rounded-2xl border border-[#97CADB]/40 shadow-md overflow-hidden">
                    
                    <!-- Banner -->
                    <div id="povBanner" class="w-full h-40 bg-gradient-to-br from-[#D6EBEE] via-[#97CADB]/20 to-[#97CADB]/40 flex items-center justify-center relative overflow-hidden transition-all duration-300">
                        <div id="povSparkle1" class="absolute top-3 right-6 text-[#97CADB] text-xs opacity-60">✧</div>
                        <div id="povSparkle2" class="absolute bottom-3 left-8 text-[#97CADB] text-xs opacity-60">✦</div>
                        <div class="text-center relative z-10">
                            <div class="w-16 h-16 mx-auto mb-2 rounded-2xl bg-white/80 backdrop-blur flex items-center justify-center shadow-md">
                                <svg id="povBannerSvg" class="w-8 h-8 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path id="povBannerPath" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <p id="povBannerText" class="font-cute text-xl text-[#018ABE]">Let's Learn! 📚</p>
                        </div>
                    </div>

                    <!-- Body Content -->
                    <div class="p-5 sm:p-7 space-y-5">
                        <!-- Badges -->
                        <div class="flex flex-wrap items-center gap-2 pb-4 border-b border-slate-100">
                            <span id="povKategoriBadge" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border">
                                Kategori
                            </span>
                            <span id="povBabBadge" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-[#D6EBEE] text-[#02457A] border border-[#97CADB]/40">
                                Bab
                            </span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                ~10 menit baca
                            </span>
                        </div>

                        <!-- Title -->
                        <h2 id="povJudul" class="text-xl sm:text-2xl font-extrabold text-slate-800 tracking-tight break-words content-text-wrap" style="overflow-wrap: anywhere; word-break: break-word;">Judul Materi</h2>

                        <!-- Deskripsi -->
                        <div id="povDeskripsiWrapper" class="p-4 rounded-2xl bg-blue-50/70 border border-blue-100 flex items-start gap-3 max-w-full overflow-hidden">
                            <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 font-bold text-sm">💬</div>
                            <div class="min-w-0 flex-1">
                                <h4 class="text-[11px] font-bold uppercase tracking-wider text-blue-900 mb-0.5">Deskripsi & Pengantar</h4>
                                <p id="povDeskripsi" class="text-xs sm:text-sm text-slate-700 leading-relaxed font-normal break-words content-text-wrap" style="overflow-wrap: anywhere; word-break: break-word;"></p>
                            </div>
                        </div>

                        <!-- Gambar -->
                        <div id="povGambarWrapper" class="rounded-2xl overflow-hidden border border-slate-200 bg-slate-50">
                            <div class="px-4 py-2 bg-slate-100 border-b border-slate-200 text-xs font-semibold text-slate-600">
                                🖼️ Gambar Ilustrasi Materi
                            </div>
                            <div class="p-3 flex justify-center bg-slate-100/30">
                                <img id="povGambar" src="" alt="Ilustrasi" class="max-h-80 w-auto max-w-full rounded-xl object-contain shadow-xs">
                            </div>
                        </div>

                        <!-- Isi Materi -->
                        <div class="space-y-1.5">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Isi Materi Pembelajaran</h4>
                            <div id="povKonten" class="text-slate-800 leading-relaxed text-sm sm:text-base whitespace-pre-line break-words content-text-wrap bg-slate-50/70 rounded-2xl p-4 sm:p-5 border border-slate-200/80 max-w-full overflow-hidden" style="overflow-wrap: anywhere; word-break: break-word;"></div>
                        </div>

                        <!-- Video / Multiple URLs -->
                        <div id="povUrlWrapper" class="space-y-3"></div>

                        <!-- File Dokumen (Legacy) -->
                        <div id="povFileWrapper" class="hidden"></div>

                        <!-- Contoh -->
                        <div id="povContohWrapper" class="p-4 bg-[#D6EBEE] border-l-4 border-[#018ABE] rounded-r-2xl max-w-full overflow-hidden">
                            <p class="text-xs font-bold text-[#001B48] mb-1 flex items-center gap-1"><span>💡</span> Contoh:</p>
                            <div id="povContoh" class="text-xs sm:text-sm text-[#02457A] leading-relaxed whitespace-pre-line break-words content-text-wrap" style="overflow-wrap: anywhere; word-break: break-word;"></div>
                        </div>

                        <!-- Tips -->
                        <div id="povTipsWrapper" class="p-4 bg-amber-50 border-l-4 border-amber-500 rounded-r-2xl max-w-full overflow-hidden">
                            <p class="text-xs font-bold text-amber-800 mb-1 flex items-center gap-1"><span>⭐</span> Tips Belajar:</p>
                            <div id="povTips" class="text-xs sm:text-sm text-amber-800 leading-relaxed whitespace-pre-line break-words content-text-wrap" style="overflow-wrap: anywhere; word-break: break-word;"></div>
                        </div>

                        <!-- Kuis Mandiri -->
                        <div class="p-5 bg-gradient-to-br from-[#02457A] via-[#018ABE] to-[#45B69C] rounded-2xl text-white shadow-md flex items-center justify-between gap-4">
                            <div>
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[9px] font-extrabold uppercase tracking-wider bg-white/20 mb-1">
                                    🎯 Kuis Mandiri Siswa
                                </span>
                                <h4 class="text-base font-bold">Kuis Materi Ini</h4>
                                <p class="text-xs text-sky-100 mt-0.5">Siswa akan diarahkan untuk mengerjakan kuis setelah membaca materi ini.</p>
                            </div>
                            <span class="px-4 py-2 bg-white text-[#001B48] font-bold text-xs rounded-xl shadow shrink-0">Mulai Kuis</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function escapeHtml(text) {
    if (!text) return '';
    return text.toString()
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

const DAFTAR_MATERI = @json($materiList);
const URL_STORE     = @json(route('admin.materi.store'));
const URL_UPDATE    = @json(route('admin.materi.update', ['__ID__']));
let TOTAL_BABS      = {{ $babList->count() }};

// =============================================
// VALIDASI SEBELUM BUKA MODAL (BAB WAJIB ADA)
// =============================================
function checkAndOpenModal(type = 'add') {
    if (type === 'add' && TOTAL_BABS === 0) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Bab Kurikulum Belum Ada',
                html: '<p class="text-sm text-slate-600">Materi harus memiliki Bab dan tidak bisa dibuat tanpa Bab.<br>Silakan buat Bab terlebih dahulu.</p>',
                showCancelButton: true,
                confirmButtonText: '+ Buat Bab Sekarang',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    popup: 'englify-swal',
                    confirmButton: 'englify-swal-confirm',
                    cancelButton: 'englify-swal-cancel'
                }
            }).then((res) => {
                if (res.isConfirmed) {
                    openQuickAddBabModal();
                }
            });
        } else {
            openQuickAddBabModal();
        }
        return;
    }
    openModal(type);
}

// =============================================
// DROPDOWN BAB DINAMIS DARI KATEGORI (AJAX)
// =============================================
function fetchBabs(kategoriId, selectedBabId = null) {
    const babSelect = document.getElementById('inputBab');
    const warningEl = document.getElementById('noBabWarning');
    const submitBtn = document.getElementById('btnSubmitMateri');

    babSelect.innerHTML = '<option value="">Memuat daftar bab...</option>';
    babSelect.disabled = true;

    if (!kategoriId) {
        babSelect.innerHTML = '<option value="">Pilih Kategori terlebih dahulu</option>';
        babSelect.disabled = false;
        if (warningEl) warningEl.classList.add('hidden');
        return;
    }

    fetch(`/admin/api/babs-by-kategori/${kategoriId}`)
        .then(res => res.json())
        .then(data => {
            if (data.length === 0) {
                babSelect.innerHTML = '<option value="">-- Belum ada Bab di kategori ini --</option>';
                if (warningEl) warningEl.classList.remove('hidden');
            } else {
                babSelect.innerHTML = '<option value="">-- Pilih Bab --</option>';
                data.forEach(bab => {
                    const isSelected = selectedBabId && Number(bab.id) === Number(selectedBabId) ? 'selected' : '';
                    const cleanJudul = (bab.judul || '').replace(/^bab\s*(\d+)?\s*[:.-]?\s*/i, '').trim() || bab.judul;
                    babSelect.innerHTML += `<option value="${bab.id}" ${isSelected}>Bab ${bab.urutan}: ${cleanJudul}</option>`;
                });
                if (warningEl) warningEl.classList.add('hidden');
            }
            babSelect.disabled = false;
        })
        .catch(err => {
            console.error('Error fetching babs:', err);
            babSelect.innerHTML = '<option value="">Gagal memuat bab</option>';
            babSelect.disabled = false;
        });
}

function filterBabDropdown(kategoriId) {
    const babSelect = document.getElementById('babFilter');
    if (!babSelect) return;
    const options = babSelect.querySelectorAll('option');
    let hasVisibleSelected = false;
    options.forEach(opt => {
        if (!opt.value) {
            opt.hidden = false;
            return;
        }
        const kat = opt.getAttribute('data-kategori');
        if (!kategoriId || kat === String(kategoriId)) {
            opt.hidden = false;
            if (opt.selected) hasVisibleSelected = true;
        } else {
            opt.hidden = true;
        }
    });
    if (kategoriId && !hasVisibleSelected) {
        babSelect.value = '';
    }
}

function onKategoriChanged(kategoriId) {
    fetchBabs(kategoriId);
}

function onBabSelected(babId) {
    const submitBtn = document.getElementById('btnSubmitMateri');
    if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        submitBtn.title = '';
    }
}

// =============================================
// MODAL FUNCTIONS
// =============================================
function openModal(type = 'add', materi = null) {
    const modal = document.getElementById('materiModal');
    const title = document.getElementById('modalTitle');
    const form  = document.getElementById('materiForm');
    const warningEl = document.getElementById('noBabWarning');
    const submitBtn = document.getElementById('btnSubmitMateri');

    removeImage();
    if (warningEl) warningEl.classList.add('hidden');

    if (type === 'edit' && materi) {
        title.textContent = 'Edit Materi';
        form.action = URL_UPDATE.replace('__ID__', materi.id);
        document.getElementById('materiMethod').value = 'PUT';
        document.getElementById('materiId').value     = materi.id;
        document.getElementById('inputJudul').value    = materi.judul || '';
        document.getElementById('inputKategori').value = materi.id_kategori || '';
        document.getElementById('inputStatus').value   = materi.status || 'Draft';
        if (document.getElementById('inputUrutan')) {
            document.getElementById('inputUrutan').value = materi.urutan || '';
        }
        if (document.getElementById('inputDurasiMenit')) {
            document.getElementById('inputDurasiMenit').value = materi.durasi_menit || 15;
        }
        document.getElementById('inputDeskripsi').value= materi.deskripsi || '';
        document.getElementById('inputKonten').value   = materi.konten || '';

        // Muat konten ke editor Word
        const editor = document.getElementById('editorContent');
        if (editor) {
            const rawKonten = materi.konten || '';
            const isHtml = /<[a-z][\s\S]*>/i.test(rawKonten);
            if (isHtml) {
                editor.innerHTML = rawKonten;
            } else if (rawKonten) {
                editor.innerHTML = rawKonten.split('\n\n').map(p => `<p>${p.replace(/\n/g, '<br>')}</p>`).join('');
            } else {
                editor.innerHTML = '';
            }
            syncEditorToInput();
        }

        // Muat URL-URL materi
        const initialUrls = (Array.isArray(materi.urls) && materi.urls.length > 0)
            ? materi.urls
            : (materi.url ? [materi.url] : ['']);
        renderUrlInputs(initialUrls);

        // Muat bab dari kategori materi ini dan pilih id_bab
        fetchBabs(materi.id_kategori, materi.id_bab);

        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            submitBtn.title = '';
        }

        if (materi.gambar) {
            document.getElementById('imagePreview').querySelector('img').src = `/${materi.gambar}`;
            document.getElementById('imagePreview').classList.remove('hidden');
            document.getElementById('imageUploadArea').classList.add('hidden');
        }
    } else {
        title.textContent = 'Tambah Materi Baru';
        form.reset();
        form.action = URL_STORE;
        document.getElementById('materiMethod').value = '';
        document.getElementById('materiId').value     = '';
        if (document.getElementById('inputUrutan')) {
            document.getElementById('inputUrutan').value = '';
        }
        if (document.getElementById('inputDurasiMenit')) {
            document.getElementById('inputDurasiMenit').value = 15;
        }
        renderUrlInputs(['']);
        document.getElementById('inputBab').innerHTML = '<option value="">Pilih Kategori terlebih dahulu</option>';

        const editor = document.getElementById('editorContent');
        if (editor) {
            editor.innerHTML = '';
            syncEditorToInput();
        }

        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            submitBtn.title = '';
        }
    }

    updateDocTitlePreview(document.getElementById('inputJudul') ? document.getElementById('inputJudul').value : '');
    setMateriModalMode(currentModalMode);
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function openModalWithBab(kategoriId, babId) {
    openModal('add');
    const katSelect = document.getElementById('inputKategori');
    if (katSelect) {
        katSelect.value = kategoriId;
        fetchBabs(kategoriId, babId);
    }
}

function toggleBabSection(sectionId, btn) {
    const el = document.getElementById(sectionId);
    if (!el) return;
    el.classList.toggle('hidden');
    const chevron = btn ? btn.querySelector('.chevron-icon') : null;
    if (chevron) {
        chevron.classList.toggle('rotate-180');
    }
}

function closeModal() {
    document.getElementById('materiModal').classList.add('hidden');
    document.getElementById('materiModal').classList.remove('flex');
    document.getElementById('materiForm').reset();
    updateDocTitlePreview('');
    const editor = document.getElementById('editorContent');
    if (editor) {
        editor.innerHTML = '';
        syncEditorToInput();
    }
    removeImage();
}

function editMateri(id) {
    const materi = DAFTAR_MATERI.find(item => item.id == id);
    if (!materi) {
        if (typeof window.showAlert === 'function') {
            window.showAlert('Data Tidak Ditemukan', 'Data materi yang dipilih tidak ditemukan.', 'warning');
        } else if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Data Tidak Ditemukan',
                html: '<p class="text-sm text-slate-600">Data materi yang dipilih tidak ditemukan.</p>',
                customClass: { popup: 'englify-swal', confirmButton: 'englify-swal-confirm' }
            });
        }
        return;
    }
    openModal('edit', materi);
}

function deleteMateri(id) {
    document.getElementById('deleteForm').action = `/admin/materi/${id}`;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
}

// =============================================
// MULTIPLE URLS MANAGEMENT
// =============================================
function renderUrlInputs(urls = []) {
    const container = document.getElementById('urlInputsContainer');
    if (!container) return;
    container.innerHTML = '';

    const list = Array.isArray(urls) && urls.length > 0 ? urls : [''];
    list.forEach(u => addUrlInputRow(u));
}

function addUrlInputRow(value = '') {
    const container = document.getElementById('urlInputsContainer');
    if (!container) return;

    const row = document.createElement('div');
    row.className = 'flex items-center gap-2 url-row';
    row.innerHTML = `
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            </div>
            <input type="url" name="urls[]" value="${escapeHtml(value)}" placeholder="https://youtube.com/watch?v=... atau https://..."
                   class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
        </div>
        <button type="button" onclick="removeUrlInputRow(this)" class="p-2.5 rounded-xl border border-slate-200 text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer" title="Hapus URL ini">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </button>
    `;
    container.appendChild(row);
}

function removeUrlInputRow(button) {
    const container = document.getElementById('urlInputsContainer');
    const rows = container.querySelectorAll('.url-row');
    if (rows.length > 1) {
        button.closest('.url-row').remove();
    } else {
        const input = button.closest('.url-row').querySelector('input');
        if (input) input.value = '';
    }
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// =============================================
// IMAGE UPLOAD PREVIEW
// =============================================
function previewImage(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const maxSize = 2 * 1024 * 1024;

        if (file.size > maxSize) {
            if (typeof window.showAlert === 'function') {
                window.showAlert('Ukuran Terlalu Besar', 'Ukuran gambar cover maksimal 2MB!', 'warning');
            } else if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Ukuran Terlalu Besar',
                    html: '<p class="text-sm text-slate-600">Ukuran gambar cover maksimal 2MB!</p>',
                    customClass: { popup: 'englify-swal', confirmButton: 'englify-swal-confirm' }
                });
            }
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').querySelector('img').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
            document.getElementById('imageUploadArea').classList.add('hidden');
        }
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    document.getElementById('inputGambar').value = '';
    document.getElementById('imagePreview').classList.add('hidden');
    document.getElementById('imagePreview').querySelector('img').src = '';
    document.getElementById('imageUploadArea').classList.remove('hidden');
}

// =============================================
// FORM SUBMISSION
// =============================================
document.getElementById('materiForm').addEventListener('submit', function(e) {
    const inputJudul = document.getElementById('inputJudul');
    const inputKategori = document.getElementById('inputKategori');
    const inputBab = document.getElementById('inputBab');
    const editor = document.getElementById('editorContent');
    const inputKonten = document.getElementById('inputKonten');

    // Sinkronkan editor ke input sebelum submit
    syncEditorToInput();

    const judul = (inputJudul?.value || '').trim();
    const kategori = inputKategori?.value || '';
    const bab = inputBab?.value || '';
    const konten = (inputKonten?.value || '').trim();
    const isKontenEmpty = !konten || konten === '<p><br></p>' || konten === '<br>' || (editor && editor.innerText.trim() === '');

    if (!judul || !kategori || !bab || isKontenEmpty) {
        e.preventDefault();

        // Jika metadata belum lengkap dan sedang dalam Mode Luas, otomatis beralih ke Mode Standar agar field terlihat
        if (!judul || !kategori || !bab) {
            setMateriModalMode('compact');
        }

        let pesan = '';
        if (!judul) {
            pesan = 'Judul materi wajib diisi.';
            inputJudul?.focus();
        } else if (!kategori) {
            pesan = 'Kategori materi wajib dipilih.';
            inputKategori?.focus();
        } else if (!bab) {
            pesan = 'Bab materi wajib dipilih. Jika belum ada bab, klik "+ Buat Bab Baru".';
            inputBab?.focus();
        } else if (isKontenEmpty) {
            pesan = 'Konten materi masih kosong. Tulis isi materi pada editor terlebih dahulu.';
            editor?.focus();
        }

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Isian Belum Lengkap',
                text: pesan,
                confirmButtonColor: '#2563eb'
            });
        } else {
            alert(pesan);
        }
        return false;
    }

    const button = this.querySelector('button[type="submit"]');
    if (button) {
        button.disabled = true;
        button.innerHTML = 'Menyimpan...';
    }
    const headerBtn = document.getElementById('btnHeaderSaveMateri');
    if (headerBtn) {
        headerBtn.disabled = true;
        headerBtn.innerHTML = 'Menyimpan...';
    }
});

// =============================================
// QUICK ADD BAB (AJAX)
// =============================================
// MODAL CEPAT TAMBAH BAB DARI MODAL MATERI
// =============================================
let quickBabExistingUrutans = [];

async function fetchQuickBabNextUrutan(kategoriId) {
    if (!kategoriId) {
        quickBabExistingUrutans = [];
        const input = document.getElementById('quickBabUrutan');
        if (input) {
            input.value = '';
            input.placeholder = 'Pilih kategori terlebih dahulu';
        }
        return;
    }
    try {
        const res = await fetch(`/admin/bab/next-urutan/${kategoriId}`);
        if (!res.ok) return;
        const data = await res.json();
        quickBabExistingUrutans = data.existing_urutans || [];
        const input = document.getElementById('quickBabUrutan');
        if (input) {
            input.value = data.next_urutan;
            input.placeholder = `Contoh: ${data.next_urutan} (Otomatis Bersusun)`;
        }
    } catch(err) {
        console.error('Error fetching quick bab next urutan:', err);
    }
}

function openQuickAddBabModal() {
    const activeKat = document.getElementById('inputKategori') ? document.getElementById('inputKategori').value : '';
    const katSelect = document.getElementById('quickBabKategori');
    if (activeKat && katSelect) {
        katSelect.value = activeKat;
        fetchQuickBabNextUrutan(activeKat);
    } else {
        fetchQuickBabNextUrutan(katSelect ? katSelect.value : '');
    }
    document.getElementById('quickBabJudul').value = '';
    document.getElementById('quickBabAlert').classList.add('hidden');
    document.getElementById('quickAddBabModal').classList.remove('hidden');
    document.getElementById('quickAddBabModal').classList.add('flex');
}

function closeQuickAddBabModal() {
    document.getElementById('quickAddBabModal').classList.add('hidden');
    document.getElementById('quickAddBabModal').classList.remove('flex');
}

document.addEventListener('DOMContentLoaded', () => {
    const qKat = document.getElementById('quickBabKategori');
    if (qKat) {
        qKat.addEventListener('change', (e) => {
            fetchQuickBabNextUrutan(e.target.value);
        });
    }
});

function submitQuickAddBab(e) {
    e.preventDefault();
    const btn = document.getElementById('btnSubmitQuickBab');
    btn.disabled = true;
    btn.textContent = 'Menyimpan...';

    const kategoriId = document.getElementById('quickBabKategori').value;
    const judul = document.getElementById('quickBabJudul').value;
    const urutan = document.getElementById('quickBabUrutan').value;
    const durasi = document.getElementById('quickBabDurasi') ? document.getElementById('quickBabDurasi').value : 15;

    fetch("{{ route('admin.bab.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            id_kategori: kategoriId,
            judul: judul,
            urutan: urutan || null,
            durasi_menit: durasi || 15
        })
    })
    .then(async res => {
        const data = await res.json();
        btn.disabled = false;
        btn.textContent = 'Simpan Bab';

        if (res.ok && data.success) {
            TOTAL_BABS++;
            closeQuickAddBabModal();
            // Jika modal materi sedang terbuka, update dropdown kategori & bab
            const inputKategori = document.getElementById('inputKategori');
            const isMateriModalOpen = document.getElementById('materiModal') && document.getElementById('materiModal').classList.contains('flex');

            if (isMateriModalOpen) {
                if (inputKategori) {
                    inputKategori.value = kategoriId;
                    fetchBabs(kategoriId, data.data.id);
                }
                const submitBtn = document.getElementById('btnSubmitMateri');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    submitBtn.title = '';
                }
                if (typeof window.showToast === 'function') {
                    window.showToast('Bab "' + data.data.judul + '" berhasil ditambahkan!', 'success');
                }
            } else {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Bab Berhasil Ditambahkan!',
                        html: `<p class="text-sm text-slate-600">Bab <strong class="text-navy-900 font-bold">"${data.data.judul}"</strong> telah berhasil ditambahkan ke kurikulum.</p>`,
                        confirmButtonText: 'Lanjutkan',
                        buttonsStyling: false,
                        customClass: {
                            popup: 'englify-swal',
                            confirmButton: 'englify-swal-confirm'
                        }
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    window.location.reload();
                }
            }
        } else {
            const alertBox = document.getElementById('quickBabAlert');
            const errorMsg = (data.errors && data.errors.urutan) ? data.errors.urutan[0] : (data.message || 'Gagal menambahkan bab');
            alertBox.textContent = errorMsg;
            alertBox.className = 'p-3 rounded-xl text-xs bg-rose-50 text-rose-700 border border-rose-200 font-medium';
            alertBox.classList.remove('hidden');
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.textContent = 'Simpan Bab';
        const alertBox = document.getElementById('quickBabAlert');
        alertBox.textContent = err.message || 'Terjadi kesalahan saat menyimpan bab.';
        alertBox.className = 'p-3 rounded-xl text-xs bg-rose-50 text-rose-700 border border-rose-200 font-medium';
        alertBox.classList.remove('hidden');
    });
}

// =============================================
// PREVIEW POV SISWA
// =============================================
function openPreviewPOV(dataOrId) {
    let data = dataOrId;
    if (typeof dataOrId === 'number' || typeof dataOrId === 'string') {
        data = DAFTAR_MATERI.find(item => item.id == dataOrId);
    }
    if (!data) return;

    const modal = document.getElementById('previewPovModal');
    if (!modal) return;

    // Badges
    const badgeColors = {
        'Speaking': 'bg-rose-50 text-rose-700 border-rose-200',
        'Writing': 'bg-blue-50 text-blue-700 border-blue-200',
        'Reading': 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'Listening': 'bg-purple-50 text-purple-700 border-purple-200'
    };
    const badgeClass = badgeColors[data.kategori] || 'bg-slate-50 text-slate-700 border-slate-200';
    const katBadge = document.getElementById('povKategoriBadge');
    if (katBadge) {
        katBadge.className = `inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border ${badgeClass}`;
        katBadge.textContent = data.kategori || 'Materi';
    }

    // Dynamic Category Theme for Banner
    const povBannerThemes = {
        'Speaking': {
            bannerClass: 'w-full h-40 bg-gradient-to-br from-rose-100 via-rose-50 to-pink-200/40 flex items-center justify-center relative overflow-hidden transition-all duration-300',
            sparkleClass: 'text-rose-300',
            textColor: 'text-rose-600',
            svgColor: 'text-rose-600',
            iconPath: 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z',
            label: "Let's Learn! 🎙️"
        },
        'Writing': {
            bannerClass: 'w-full h-40 bg-gradient-to-br from-blue-100 via-sky-50 to-blue-200/40 flex items-center justify-center relative overflow-hidden transition-all duration-300',
            sparkleClass: 'text-blue-300',
            textColor: 'text-blue-600',
            svgColor: 'text-blue-600',
            iconPath: 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
            label: "Let's Learn! ✍️"
        },
        'Reading': {
            bannerClass: 'w-full h-40 bg-gradient-to-br from-emerald-100 via-teal-50 to-emerald-200/40 flex items-center justify-center relative overflow-hidden transition-all duration-300',
            sparkleClass: 'text-emerald-300',
            textColor: 'text-emerald-600',
            svgColor: 'text-emerald-600',
            iconPath: 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
            label: "Let's Learn! 📖"
        },
        'Listening': {
            bannerClass: 'w-full h-40 bg-gradient-to-br from-purple-100 via-indigo-50 to-purple-200/40 flex items-center justify-center relative overflow-hidden transition-all duration-300',
            sparkleClass: 'text-purple-300',
            textColor: 'text-purple-600',
            svgColor: 'text-purple-600',
            iconPath: 'M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z',
            label: "Let's Learn! 🎧"
        }
    };
    const povTheme = povBannerThemes[data.kategori] || {
        bannerClass: 'w-full h-40 bg-gradient-to-br from-[#D6EBEE] via-[#97CADB]/20 to-[#97CADB]/40 flex items-center justify-center relative overflow-hidden transition-all duration-300',
        sparkleClass: 'text-[#97CADB]',
        textColor: 'text-[#018ABE]',
        svgColor: 'text-[#018ABE]',
        iconPath: 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
        label: "Let's Learn! 📚"
    };

    const povBannerEl = document.getElementById('povBanner');
    if (povBannerEl) povBannerEl.className = povTheme.bannerClass;

    const sp1 = document.getElementById('povSparkle1');
    if (sp1) sp1.className = `absolute top-3 right-6 ${povTheme.sparkleClass} text-xs opacity-60`;

    const sp2 = document.getElementById('povSparkle2');
    if (sp2) sp2.className = `absolute bottom-3 left-8 ${povTheme.sparkleClass} text-xs opacity-60`;

    const bannerSvg = document.getElementById('povBannerSvg');
    if (bannerSvg) bannerSvg.className = `w-8 h-8 ${povTheme.svgColor}`;

    const bannerPath = document.getElementById('povBannerPath');
    if (bannerPath) bannerPath.setAttribute('d', povTheme.iconPath);

    const bannerText = document.getElementById('povBannerText');
    if (bannerText) {
        bannerText.className = `font-cute text-xl ${povTheme.textColor}`;
        bannerText.textContent = povTheme.label;
    }

    const babBadge = document.getElementById('povBabBadge');
    if (babBadge) babBadge.textContent = data.bab || 'Bab';

    const judulEl = document.getElementById('povJudul');
    if (judulEl) judulEl.textContent = data.judul || 'Judul Materi';

    // Deskripsi
    const descWrap = document.getElementById('povDeskripsiWrapper');
    if (descWrap) {
        if (data.deskripsi && data.deskripsi.trim() !== '') {
            descWrap.classList.remove('hidden');
            document.getElementById('povDeskripsi').textContent = data.deskripsi;
        } else {
            descWrap.classList.add('hidden');
        }
    }

    // Gambar
    const imgWrap = document.getElementById('povGambarWrapper');
    if (imgWrap) {
        if (data.gambar && data.gambar.trim() !== '') {
            imgWrap.classList.remove('hidden');
            const imgEl = document.getElementById('povGambar');
            imgEl.src = data.gambar.startsWith('/') ? data.gambar : `/${data.gambar}`;
        } else {
            imgWrap.classList.add('hidden');
        }
    }

    // Konten
    const kontenEl = document.getElementById('povKonten');
    if (kontenEl) {
        const raw = data.konten || 'Belum ada konten tertulis untuk materi ini.';
        const isHtml = /<[a-z][\s\S]*>/i.test(raw);
        if (isHtml) {
            kontenEl.innerHTML = raw;
            kontenEl.classList.add('materi-rendered');
            kontenEl.classList.remove('whitespace-pre-line');
        } else {
            kontenEl.textContent = raw;
            kontenEl.classList.remove('materi-rendered');
            kontenEl.classList.add('whitespace-pre-line');
        }
    }

    // Multiple URLs / YouTube
    const urlWrap = document.getElementById('povUrlWrapper');
    if (urlWrap) {
        urlWrap.innerHTML = '';
        let urlList = [];
        if (Array.isArray(data.urls) && data.urls.length > 0) {
            urlList = data.urls;
        } else if (data.url && typeof data.url === 'string' && data.url.trim() !== '') {
            try {
                const parsed = JSON.parse(data.url);
                urlList = Array.isArray(parsed) ? parsed : [data.url];
            } catch(e) {
                urlList = [data.url];
            }
        }

        if (urlList.length > 0) {
            urlWrap.classList.remove('hidden');
            urlList.forEach((u, i) => {
                const ytMatch = u.match(/(?:youtube(?:-nocookie)?\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i);
                const isYt = Boolean(ytMatch && ytMatch[1]);
                const card = document.createElement('div');
                card.className = 'rounded-2xl border border-blue-200 p-4 bg-gradient-to-r from-blue-50/50 to-white';
                card.innerHTML = `
                    <div class="flex items-center justify-between gap-3 mb-2">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-8 h-8 rounded-lg ${isYt ? 'bg-red-600' : 'bg-blue-600'} text-white flex items-center justify-center shrink-0">
                                ${isYt ? '▶' : '🔗'}
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-800">${isYt ? 'Video YouTube #' + (i + 1) : 'Tautan Sumber #' + (i + 1)}</p>
                                <p class="text-[11px] text-slate-500 truncate max-w-xs sm:max-w-md">${escapeHtml(u)}</p>
                            </div>
                        </div>
                        <a href="${escapeHtml(u)}" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition shrink-0">Buka Link</a>
                    </div>
                    ${isYt ? `
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden shadow-sm mt-2 bg-black">
                            <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/${ytMatch[1]}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    ` : ''}
                `;
                urlWrap.appendChild(card);
            });
        } else {
            urlWrap.classList.add('hidden');
        }
    }

    // File (Legacy)
    const fileWrap = document.getElementById('povFileWrapper');
    if (fileWrap) {
        fileWrap.classList.add('hidden');
    }

    // Contoh
    const contohWrap = document.getElementById('povContohWrapper');
    if (contohWrap) {
        if (data.contoh && data.contoh.trim() !== '') {
            contohWrap.classList.remove('hidden');
            document.getElementById('povContoh').textContent = data.contoh;
        } else {
            contohWrap.classList.add('hidden');
        }
    }

    // Tips
    const tipsWrap = document.getElementById('povTipsWrapper');
    if (tipsWrap) {
        if (data.tips && data.tips.trim() !== '') {
            tipsWrap.classList.remove('hidden');
            document.getElementById('povTips').textContent = data.tips;
        } else {
            tipsWrap.classList.add('hidden');
        }
    }

    // Default to Desktop frame
    setPreviewDevice('desktop');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.classList.add('overflow-hidden');
}

function closePreviewPOV() {
    const modal = document.getElementById('previewPovModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
        const urlWrap = document.getElementById('povUrlWrapper');
        if (urlWrap) urlWrap.innerHTML = '';
    }
}

function setPreviewDevice(device) {
    const frame = document.getElementById('previewDeviceFrame');
    const btnDesktop = document.getElementById('btnDeviceDesktop');
    const btnMobile = document.getElementById('btnDeviceMobile');
    if (!frame) return;

    if (device === 'mobile') {
        frame.className = 'w-full max-w-sm transition-all duration-300';
        if (btnMobile) btnMobile.className = 'px-2.5 py-1 rounded-lg bg-white text-slate-800 font-bold shadow-xs transition flex items-center gap-1 cursor-pointer';
        if (btnDesktop) btnDesktop.className = 'px-2.5 py-1 rounded-lg text-slate-600 hover:text-slate-900 transition flex items-center gap-1 cursor-pointer';
    } else {
        frame.className = 'w-full max-w-4xl transition-all duration-300';
        if (btnDesktop) btnDesktop.className = 'px-2.5 py-1 rounded-lg bg-white text-slate-800 font-bold shadow-xs transition flex items-center gap-1 cursor-pointer';
        if (btnMobile) btnMobile.className = 'px-2.5 py-1 rounded-lg text-slate-600 hover:text-slate-900 transition flex items-center gap-1 cursor-pointer';
    }
}

// Close on Escape or backdrop click
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closePreviewPOV();
});

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('previewPovModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) closePreviewPOV();
        });
    }

    // Inisialisasi Editor Word
    const editor = document.getElementById('editorContent');
    const form = document.getElementById('materiForm');

    if (editor) {
        try {
            document.execCommand('styleWithCSS', false, true);
        } catch(e) {}

        editor.addEventListener('input', syncEditorToInput);
        editor.addEventListener('keyup', function(e) {
            saveSelection();
            syncEditorToInput();
        });
        editor.addEventListener('mouseup', function() {
            saveSelection();
            updateToolbarActiveState();
        });
        editor.addEventListener('focus', saveSelection);

        // Shortcut keyboard Ctrl+B, Ctrl+I, Ctrl+U, Ctrl+Z, Ctrl+Y & Tab indent/outdent
        editor.addEventListener('keydown', function(e) {
            if (handleListKeyDown(e)) return;

            if (e.key === 'Tab') {
                const sel = window.getSelection();
                if (sel && sel.rangeCount > 0) {
                    let node = sel.anchorNode;
                    if (node && node.nodeType === Node.TEXT_NODE) node = node.parentNode;
                    if (node && (node.closest('li') || node.closest('ol') || node.closest('ul'))) {
                        e.preventDefault();
                        if (e.shiftKey) {
                            formatDoc('outdent');
                        } else {
                            formatDoc('indent');
                        }
                        return;
                    }
                }
            }

            if (e.ctrlKey || e.metaKey) {
                const key = e.key.toLowerCase();
                if (key === 'b') {
                    e.preventDefault();
                    formatDoc('bold');
                } else if (key === 'i') {
                    e.preventDefault();
                    formatDoc('italic');
                } else if (key === 'u') {
                    e.preventDefault();
                    formatDoc('underline');
                }
            }
        });

        // Bersihkan paste HTML atau paste Gambar langsung dari Word / Google Docs / Clipboard
        editor.addEventListener('paste', function(e) {
            // 1. Cek apakah ada file gambar di clipboard (misal screenshot / copy image)
            const items = (e.clipboardData || window.clipboardData)?.items;
            if (items) {
                for (let i = 0; i < items.length; i++) {
                    if (items[i].type.indexOf('image') !== -1) {
                        e.preventDefault();
                        const blob = items[i].getAsFile();
                        uploadAndInsertImage(blob);
                        return;
                    }
                }
            }

            e.preventDefault();
            const clipboard = e.clipboardData || window.clipboardData;
            let html = clipboard.getData('text/html');
            let text = clipboard.getData('text/plain');

            if (html) {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const body = doc.body;

                // 1. Hapus tag sampah dan script non-konten
                body.querySelectorAll('script, style, link, meta, xml, o\\:p, noscript, svg, object, embed, applet').forEach(el => el.remove());

                // 2. Tangani faux-bold dari Google Docs & Microsoft Word:
                // Google Docs: <b id="docs-internal-guid-..." style="font-weight: normal;">
                // Microsoft Word: <b style="mso-bidi-font-weight: normal"> dsb.
                body.querySelectorAll('b, strong').forEach(el => {
                    const style = (el.getAttribute('style') || '').toLowerCase();
                    const isGoogleDocsWrapper = el.id && el.id.startsWith('docs-internal-guid');
                    const isFauxBold = isGoogleDocsWrapper ||
                        /font-weight\s*:\s*(normal|400|300|200|100|lighter)/i.test(style) ||
                        /mso-bidi-font-weight\s*:\s*normal/i.test(style);

                    if (isFauxBold) {
                        const parent = el.parentNode;
                        if (parent) {
                            while (el.firstChild) {
                                parent.insertBefore(el.firstChild, el);
                            }
                            el.remove();
                        }
                    }
                });

                // 3. Tangani span styling sebelum atribut dibersihkan:
                // Jangan jadikan <strong> jika span ini membungkus seluruh kalimat/paragraf
                body.querySelectorAll('span').forEach(el => {
                    const style = (el.getAttribute('style') || '').toLowerCase();
                    const isBold = /font-weight\s*:\s*(bold|600|700|800|900)/i.test(style);
                    const isItalic = /font-style\s*:\s*italic/i.test(style);
                    const isUnderline = /text-decoration(?:-line)?\s*:\s*[^;]*underline/i.test(style);
                    const isStrike = /text-decoration(?:-line)?\s*:\s*[^;]*(line-through|strike)/i.test(style);

                    const parentBlock = el.closest('p, div, h1, h2, h3, li, blockquote');
                    const isEntireBlock = parentBlock && (el.textContent.trim() === parentBlock.textContent.trim());

                    // Hanya pertahankan bold jika ini adalah frasa kata kunci pendek (<= 60 karakter atau ada titik dua ':')
                    if (isBold && !isEntireBlock && !el.closest('strong, b')) {
                        const spanText = el.textContent.trim();
                        if (spanText.length <= 60 || spanText.includes(':')) {
                            const strong = doc.createElement('strong');
                            while (el.firstChild) strong.appendChild(el.firstChild);
                            el.appendChild(strong);
                        }
                    }

                    if (isItalic && !el.closest('em, i')) {
                        const em = doc.createElement('em');
                        while (el.firstChild) em.appendChild(el.firstChild);
                        el.appendChild(em);
                    }
                    if (isUnderline && !el.closest('u')) {
                        const u = doc.createElement('u');
                        while (el.firstChild) u.appendChild(el.firstChild);
                        el.appendChild(u);
                    }
                    if (isStrike && !el.closest('s, strike')) {
                        const s = doc.createElement('s');
                        while (el.firstChild) s.appendChild(el.firstChild);
                        el.appendChild(s);
                    }
                });

                // 4. Bersihkan auto-bold berlebihan pada seluruh blok teks dari platform lain (ChatGPT, Word, Docs):
                // Jika seluruh teks atau mayoritas (>75%) dalam sebuah paragraf/list/heading dibungkus <strong>/<b>,
                // unwrap tag bold tersebut agar teks kembali normal mengikuti struktur font materi yang rapi.
                body.querySelectorAll('p, div, li, h1, h2, h3').forEach(block => {
                    const bolds = block.querySelectorAll('strong, b');
                    if (bolds.length > 0) {
                        const blockText = block.textContent.trim();
                        let boldTextLength = 0;
                        bolds.forEach(b => { boldTextLength += b.textContent.trim().length; });

                        if (blockText.length > 0 && (boldTextLength / blockText.length) >= 0.75) {
                            bolds.forEach(b => {
                                const parent = b.parentNode;
                                if (parent) {
                                    while (b.firstChild) {
                                        parent.insertBefore(b.firstChild, b);
                                    }
                                    b.remove();
                                }
                            });
                        }
                    }
                });

                // 5. Bersihkan atribut eksternal pengganggu:
                // HAPUS font-family asing (agar otomatis seragam mengikuti font materi sebelumnya)
                // HAPUS font-size asing (agar ukuran teks tidak acak-acakan dan normal)
                // HAPUS font-weight eksternal (agar tidak auto-bold)
                // HAPUS color & background-color eksternal (mencegah dark mode/teks tak terbaca)
                // HAPUS class & id eksternal kecuali callout
                body.querySelectorAll('*').forEach(el => {
                    const tag = el.tagName.toLowerCase();
                    const isBq = tag === 'blockquote';

                    if (!isBq) {
                        el.removeAttribute('class');
                        el.removeAttribute('id');
                    } else {
                        const existingClass = el.className || '';
                        const calloutMatch = existingClass.match(/callout-(green|red|blue|amber|purple|gray|custom)/i);
                        if (calloutMatch) {
                            el.className = calloutMatch[0];
                        } else {
                            el.removeAttribute('class');
                        }
                        el.removeAttribute('id');
                    }

                    const style = el.getAttribute('style') || '';
                    const safeStyles = [];

                    // Hanya pertahankan text-align yang valid
                    const alignMatch = style.match(/text-align\s*:\s*(left|center|right|justify)/i);
                    if (alignMatch) {
                        safeStyles.push(alignMatch[0]);
                    }
                    // Pertahankan list-style-type
                    const listMatch = style.match(/list-style-type\s*:\s*[^;]+/i);
                    if (listMatch) {
                        safeStyles.push(listMatch[0]);
                    }
                    // Pertahankan border-left-color dan background-color untuk blockquote
                    if (isBq) {
                        const borderMatch = style.match(/border-left-color\s*:\s*[^;]+/i);
                        if (borderMatch) safeStyles.push(borderMatch[0]);
                        const bgMatch = style.match(/background-color\s*:\s*[^;]+/i);
                        if (bgMatch) safeStyles.push(bgMatch[0]);
                    }

                    if (safeStyles.length > 0) {
                        el.setAttribute('style', safeStyles.join('; '));
                    } else {
                        el.removeAttribute('style');
                    }

                    // Hapus font tag bawaan Word font-face
                    if (tag === 'font') {
                        const parent = el.parentNode;
                        if (parent) {
                            while (el.firstChild) {
                                parent.insertBefore(el.firstChild, el);
                            }
                            el.remove();
                        }
                    }

                    // Unwrap span tanpa atribut
                    if (tag === 'span' && !el.hasAttributes()) {
                        const parent = el.parentNode;
                        if (parent) {
                            while (el.firstChild) {
                                parent.insertBefore(el.firstChild, el);
                            }
                            el.remove();
                        }
                    }
                });

                // 6. Konversi <div> menjadi <p> agar struktur paragraf konsisten
                body.querySelectorAll('div').forEach(div => {
                    const p = doc.createElement('p');
                    while (div.firstChild) {
                        p.appendChild(div.firstChild);
                    }
                    if (div.getAttribute('style')) {
                        p.setAttribute('style', div.getAttribute('style'));
                    }
                    div.parentNode.replaceChild(p, div);
                });

                const cleanHtml = body.innerHTML.trim();
                if (cleanHtml) {
                    document.execCommand('insertHTML', false, cleanHtml);
                } else if (text) {
                    insertCleanPlainText(text);
                }
            } else if (text) {
                insertCleanPlainText(text);
            }
            syncEditorToInput();
        });

        // Drag and Drop Gambar ke Editor
        editor.addEventListener('dragover', function(e) {
            e.preventDefault();
            editor.classList.add('ring-2', 'ring-emerald-400', 'border-emerald-500');
        });
        editor.addEventListener('dragleave', function() {
            editor.classList.remove('ring-2', 'ring-emerald-400', 'border-emerald-500');
        });
        editor.addEventListener('drop', function(e) {
            e.preventDefault();
            editor.classList.remove('ring-2', 'ring-emerald-400', 'border-emerald-500');
            if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files[0]) {
                const file = e.dataTransfer.files[0];
                if (file.type.startsWith('image/')) {
                    uploadAndInsertImage(file);
                }
            }
        });

        // Interaksi klik gambar inline untuk memunculkan context toolbar posisi foto
        editor.addEventListener('click', function(e) {
            const img = e.target.closest('.materi-inline-img, img');
            if (img && editor.contains(img)) {
                selectInlineImage(img);
            } else if (!e.target.closest('#imageContextBar')) {
                deselectInlineImage();
            }
        });
    }

    // Monitor perubahan seleksi teks untuk update tombol aktif & marker list tebal
    document.addEventListener('selectionchange', function() {
        const sel = window.getSelection();
        if (sel && sel.rangeCount > 0) {
            const editorEl = document.getElementById('editorContent');
            if (editorEl && editorEl.contains(sel.anchorNode)) {
                saveSelection();
                updateToolbarActiveState();
                syncListMarkerBoldState();
            }
        }
    });

    const inputJudulEl = document.getElementById('inputJudul');
    if (inputJudulEl) {
        inputJudulEl.addEventListener('input', function() {
            updateDocTitlePreview(this.value);
        });
    }

    if (form) {
        form.addEventListener('submit', function(e) {
            syncEditorToInput();
            const input = document.getElementById('inputKonten');
            if (!input || !input.value.trim()) {
                e.preventDefault();
                const wrapper = document.getElementById('materiEditorWrapper');
                if (wrapper) {
                    wrapper.classList.add('ring-2', 'ring-rose-500', 'border-rose-500');
                }
                if (editor) editor.focus();
                if (typeof window.showAlert === 'function') {
                    window.showAlert('Konten Wajib Diisi', 'Silakan tulis konten materi terlebih dahulu.', 'warning');
                } else if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Konten Wajib Diisi',
                        html: '<p class="text-sm text-slate-600">Silakan tulis konten materi terlebih dahulu.</p>',
                        customClass: { popup: 'englify-swal', confirmButton: 'englify-swal-confirm' }
                    });
                }
                return false;
            }
        });
    }

    // Shortcut Pintasan Keyboard Ctrl+S / Cmd+S untuk Simpan Langsung
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && (e.key === 's' || e.key === 'S')) {
            const modal = document.getElementById('materiModal');
            if (modal && !modal.classList.contains('hidden')) {
                e.preventDefault();
                const formEl = document.getElementById('materiForm');
                if (formEl) formEl.requestSubmit();
            }
        }
    });

    // Inisialisasi awal mode modal
    setMateriModalMode(currentModalMode);
});

function insertCleanPlainText(text) {
    if (!text) return;
    const paragraphs = text.split(/\r?\n\r?\n+/);
    if (paragraphs.length > 1) {
        const html = paragraphs.map(p => {
            const cleanP = escapeHtml(p.trim()).replace(/\r?\n/g, '<br>');
            return cleanP ? `<p>${cleanP}</p>` : '<p><br></p>';
        }).join('');
        document.execCommand('insertHTML', false, html);
    } else {
        const cleanText = escapeHtml(text).replace(/\r?\n/g, '<br>');
        document.execCommand('insertHTML', false, cleanText);
    }
}

// =============================================
// WORD-STYLE RICH TEXT EDITOR LOGIC
// =============================================
let savedSelectionRange = null;

function saveSelection() {
    const sel = window.getSelection();
    if (sel && sel.rangeCount > 0) {
        const range = sel.getRangeAt(0);
        const editor = document.getElementById('editorContent');
        if (editor && editor.contains(range.commonAncestorContainer)) {
            savedSelectionRange = range.cloneRange();
        }
    }
}

function restoreSelection() {
    const editor = document.getElementById('editorContent');
    if (!editor) return;
    editor.focus();
    if (savedSelectionRange) {
        const sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(savedSelectionRange);
    }
}

function formatDoc(cmd, val = null) {
    const editor = document.getElementById('editorContent');
    if (!editor) return;
    editor.focus();

    if (cmd === 'formatBlock' && val) {
        document.execCommand('formatBlock', false, `<${val}>`);
    } else {
        document.execCommand(cmd, false, val);
    }

    // Jika perintah bold, langsung sinkronkan marker list pada li aktif
    if (cmd === 'bold') {
        const sel = window.getSelection();
        if (sel && sel.rangeCount > 0) {
            let node = sel.anchorNode;
            if (node && node.nodeType === Node.TEXT_NODE) node = node.parentNode;
            const li = node ? node.closest('li') : null;
            if (li) {
                if (li.querySelector('strong, b') || document.queryCommandState('bold')) {
                    li.classList.add('li-marker-bold');
                } else {
                    li.classList.remove('li-marker-bold');
                }
            }
        }
    }

    syncEditorToInput();
}

// =============================================
// WORD-STYLE CALLOUT / BLOK CATATAN COLOR PICKER
// =============================================
const QUOTE_COLORS = {
    'green':  { border: '#16a34a', bg: 'rgba(22, 163, 74, 0.08)',  name: 'Hijau (Benar)' },
    'red':    { border: '#dc2626', bg: 'rgba(220, 38, 38, 0.08)',  name: 'Merah (Salah)' },
    'blue':   { border: '#0284c7', bg: 'rgba(2, 132, 199, 0.08)',  name: 'Biru (Info)' },
    'amber':  { border: '#d97706', bg: 'rgba(217, 119, 6, 0.08)',  name: 'Kuning (Penting)' },
    'purple': { border: '#9333ea', bg: 'rgba(147, 51, 234, 0.08)', name: 'Ungu (Rumus)' },
    'gray':   { border: '#64748b', bg: 'rgba(100, 116, 139, 0.08)', name: 'Abu (Netral)' },
};

function toggleQuoteDropdown(e) {
    if (e) {
        e.preventDefault();
        e.stopPropagation();
    }
    const menu = document.getElementById('quoteDropdownMenu');
    if (menu) menu.classList.toggle('hidden');
}

function closeQuoteDropdown() {
    const menu = document.getElementById('quoteDropdownMenu');
    if (menu) menu.classList.add('hidden');
}

function getActiveBlockquote() {
    const sel = window.getSelection();
    if (!sel || !sel.rangeCount) return null;
    let node = sel.anchorNode;
    if (node && node.nodeType === Node.TEXT_NODE) node = node.parentNode;
    const editor = document.getElementById('editorContent');
    if (!editor || !node || !editor.contains(node)) return null;
    return node.closest('blockquote');
}

function applyQuoteColor(colorKey) {
    const editor = document.getElementById('editorContent');
    if (!editor) return;
    editor.focus();

    const config = QUOTE_COLORS[colorKey] || QUOTE_COLORS['blue'];
    let bq = getActiveBlockquote();

    if (bq) {
        bq.setAttribute('data-color', colorKey);
        bq.className = `callout-${colorKey}`;
        bq.style.borderLeftColor = config.border;
        bq.style.backgroundColor = config.bg;
    } else {
        document.execCommand('formatBlock', false, '<blockquote>');
        bq = getActiveBlockquote();
        if (bq) {
            bq.setAttribute('data-color', colorKey);
            bq.className = `callout-${colorKey}`;
            bq.style.borderLeftColor = config.border;
            bq.style.backgroundColor = config.bg;
        }
    }

    const ind = document.getElementById('quoteColorIndicator');
    if (ind) ind.style.backgroundColor = config.border;

    closeQuoteDropdown();
    syncEditorToInput();
    updateToolbarActiveState();
}

function applyCustomQuoteColor(hexColor) {
    const editor = document.getElementById('editorContent');
    if (!editor || !hexColor) return;
    editor.focus();

    const r = parseInt(hexColor.slice(1, 3), 16) || 0;
    const g = parseInt(hexColor.slice(3, 5), 16) || 0;
    const b = parseInt(hexColor.slice(5, 7), 16) || 0;
    const rgbaBg = `rgba(${r}, ${g}, ${b}, 0.08)`;

    let bq = getActiveBlockquote();
    if (bq) {
        bq.removeAttribute('data-color');
        bq.className = 'callout-custom';
        bq.style.borderLeftColor = hexColor;
        bq.style.backgroundColor = rgbaBg;
    } else {
        document.execCommand('formatBlock', false, '<blockquote>');
        bq = getActiveBlockquote();
        if (bq) {
            bq.removeAttribute('data-color');
            bq.className = 'callout-custom';
            bq.style.borderLeftColor = hexColor;
            bq.style.backgroundColor = rgbaBg;
        }
    }

    const ind = document.getElementById('quoteColorIndicator');
    if (ind) ind.style.backgroundColor = hexColor;

    closeQuoteDropdown();
    syncEditorToInput();
    updateToolbarActiveState();
}

function removeQuoteFormat() {
    const editor = document.getElementById('editorContent');
    if (!editor) return;
    editor.focus();

    const bq = getActiveBlockquote();
    if (bq) {
        const parent = bq.parentNode;
        if (parent) {
            while (bq.firstChild) {
                parent.insertBefore(bq.firstChild, bq);
            }
            bq.remove();
        }
    } else {
        document.execCommand('formatBlock', false, '<p>');
    }

    closeQuoteDropdown();
    syncEditorToInput();
    updateToolbarActiveState();
}

// =============================================
// WORD-STYLE LIST & NUMBERING (123, ABC, abc, Romawi)
// =============================================
function toggleListDropdown(e) {
    if (e) {
        e.preventDefault();
        e.stopPropagation();
    }
    const menu = document.getElementById('listDropdownMenu');
    if (menu) menu.classList.toggle('hidden');
}

function closeListDropdown() {
    const menu = document.getElementById('listDropdownMenu');
    if (menu) menu.classList.add('hidden');
}

document.addEventListener('click', function(e) {
    const wrapper = document.getElementById('listDropdownWrapper');
    if (wrapper && !wrapper.contains(e.target)) {
        closeListDropdown();
    }
    const quoteWrapper = document.getElementById('quoteDropdownWrapper');
    if (quoteWrapper && !quoteWrapper.contains(e.target)) {
        closeQuoteDropdown();
    }
});

// =============================================
// TWO VIEW MODES: STANDAR (KOMPAK) & MODE LUAS (WORD)
// =============================================
let currentModalMode = localStorage.getItem('materi_modal_mode') || 'compact';

function setMateriModalMode(mode) {
    currentModalMode = mode;
    localStorage.setItem('materi_modal_mode', mode);

    const container = document.getElementById('materiModalContainer');
    const form = document.getElementById('materiForm');
    const sectionEditor = document.getElementById('sectionEditor');
    const editorWrapper = document.getElementById('materiEditorWrapper');
    const toolbar = document.getElementById('materiEditorToolbar');
    const editor = document.getElementById('editorContent');
    const statusBar = document.getElementById('editorStatusBar');
    const modalFooter = document.getElementById('materiModalFooter');
    const btnCompact = document.getElementById('btnModeCompact');
    const btnLarge = document.getElementById('btnModeLarge');
    const toggleInToolbar = document.getElementById('btnToggleModeInToolbar');
    const btnToolbarSave = document.getElementById('btnToolbarSave');
    const metaSection = document.getElementById('materiSectionMeta');
    const coverSection = document.getElementById('materiSectionCover');
    const labelKonten = document.getElementById('labelKontenWrapper');
    const modalSubtitle = document.getElementById('modalSubtitle');
    const inputJudul = document.getElementById('inputJudul');

    if (!container || !editor) return;

    if (mode === 'large') {
        // Mode Luas: Modal membesar dan menjadi aplikasi dokumen Word penuh (Toolbar DIEM di atas, hanya kertas teks yang scroll)
        container.classList.remove('max-w-2xl', 'max-h-[90vh]', 'overflow-y-auto');
        container.classList.add('max-w-6xl', 'w-[96vw]', 'h-[94vh]', 'max-h-[94vh]', 'flex', 'flex-col', 'overflow-hidden');

        // Sembunyikan metadata & cover
        if (metaSection) metaSection.classList.add('hidden');
        if (coverSection) coverSection.classList.add('hidden');
        if (labelKonten) labelKonten.classList.add('hidden');

        // Jadikan form dan wrapper editor full height flex column tanpa outer scroll
        if (form) {
            form.classList.remove('p-5', 'sm:p-6', 'space-y-4');
            form.classList.add('p-3', 'sm:p-4', 'flex', 'flex-col', 'flex-1', 'overflow-hidden', 'gap-2.5');
        }
        if (sectionEditor) {
            sectionEditor.classList.add('flex', 'flex-col', 'flex-1', 'overflow-hidden');
        }
        if (editorWrapper) {
            editorWrapper.classList.add('flex', 'flex-col', 'flex-1', 'overflow-hidden');
        }

        // Toolbar Ribbon Word: DIEM DI ATAS (Pinned / Sticky Top)
        if (toolbar) {
            toolbar.classList.add('shrink-0', 'sticky', 'top-0', 'z-30', 'bg-slate-50/95', 'backdrop-blur-xs');
        }

        // Lembar Kertas Materi: Mengisi seluruh ruang yang tersisa dan hanya lembar ini yang scroll
        editor.classList.remove('min-h-[190px]', 'max-h-[360px]', 'text-sm', 'text-[14px]', 'px-4', 'py-3');
        editor.classList.add('flex-1', 'overflow-y-auto', 'text-[14px]', 'sm:text-[15px]', 'px-6', 'sm:px-12', 'py-6', 'bg-white', 'leading-relaxed');

        if (statusBar) statusBar.classList.add('shrink-0');
        if (modalFooter) modalFooter.classList.add('shrink-0', 'pt-2.5', 'bg-white');
        if (btnToolbarSave) btnToolbarSave.classList.remove('hidden');

        if (modalSubtitle) {
            const curTitle = inputJudul && inputJudul.value.trim() ? inputJudul.value.trim() : '';
            modalSubtitle.textContent = curTitle ? `Dokumen: ${curTitle} • Mode Word Penuh` : 'Mode Word Penuh • Toolbar Pinned di Atas';
        }

        if (btnCompact) {
            btnCompact.classList.remove('bg-white', 'text-slate-800', 'shadow-xs', 'font-bold');
            btnCompact.classList.add('text-slate-500');
        }
        if (btnLarge) {
            btnLarge.classList.add('bg-white', 'text-blue-700', 'shadow-xs', 'font-bold');
            btnLarge.classList.remove('text-slate-500');
        }
        if (toggleInToolbar) {
            toggleInToolbar.innerHTML = `<svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg><span class="hidden sm:inline font-bold">Mode Standar</span>`;
            toggleInToolbar.title = 'Ubah ke Mode Standar (Tampilkan Semua Isian)';
        }
    } else {
        // Mode Standar: Dialog Kompak dengan scroll form biasa
        container.classList.remove('max-w-6xl', 'w-[96vw]', 'h-[94vh]', 'max-h-[94vh]', 'flex', 'flex-col', 'overflow-hidden');
        container.classList.add('max-w-2xl', 'max-h-[90vh]', 'overflow-y-auto');

        // Munculkan kembali metadata dan cover
        if (metaSection) metaSection.classList.remove('hidden');
        if (coverSection) coverSection.classList.remove('hidden');
        if (labelKonten) labelKonten.classList.remove('hidden');

        // Kembalikan form & editor wrapper
        if (form) {
            form.classList.remove('p-3', 'sm:p-4', 'flex', 'flex-col', 'flex-1', 'overflow-hidden', 'gap-2.5');
            form.classList.add('p-5', 'sm:p-6', 'space-y-4');
        }
        if (sectionEditor) {
            sectionEditor.classList.remove('flex', 'flex-col', 'flex-1', 'overflow-hidden');
        }
        if (editorWrapper) {
            editorWrapper.classList.remove('flex', 'flex-col', 'flex-1', 'overflow-hidden');
        }

        // Kembalikan ukuran editor standar
        editor.classList.remove('flex-1', 'text-base', 'text-[14px]', 'sm:text-[15px]', 'px-6', 'sm:px-12', 'py-6', 'bg-white');
        editor.classList.add('min-h-[190px]', 'max-h-[360px]', 'text-sm', 'px-4', 'py-3');

        if (statusBar) statusBar.classList.remove('shrink-0');
        if (modalFooter) modalFooter.classList.remove('shrink-0', 'pt-2.5', 'bg-white');
        if (btnToolbarSave) btnToolbarSave.classList.add('hidden');

        if (modalSubtitle) {
            modalSubtitle.textContent = 'Isi detail materi pembelajaran';
        }

        if (btnLarge) {
            btnLarge.classList.remove('bg-white', 'text-blue-700', 'shadow-xs', 'font-bold');
            btnLarge.classList.add('text-slate-500');
        }
        if (btnCompact) {
            btnCompact.classList.add('bg-white', 'text-slate-800', 'shadow-xs', 'font-bold');
            btnCompact.classList.remove('text-slate-500');
        }
        if (toggleInToolbar) {
            toggleInToolbar.innerHTML = `<svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg><span class="hidden sm:inline font-bold">Mode Luas</span>`;
            toggleInToolbar.title = 'Ubah ke Mode Layar Luas (Khusus Konten Materi Saja)';
        }
    }
}

function submitMateriDirectly() {
    const form = document.getElementById('materiForm');
    if (form) {
        if (typeof form.requestSubmit === 'function') {
            form.requestSubmit();
        } else {
            const btn = document.getElementById('btnSubmitMateri');
            if (btn) btn.click();
        }
    }
}

function toggleMateriModalMode() {
    setMateriModalMode(currentModalMode === 'large' ? 'compact' : 'large');
}

function updateDocTitlePreview(val) {
    const previewEl = document.getElementById('modalDocTitlePreview');
    if (previewEl) {
        const titleText = (val || '').trim();
        previewEl.textContent = titleText ? `Dokumen: ${titleText}` : 'Isi detail materi pembelajaran';
    }
}

// Tingkat hierarki outline Word
const LIST_LEVELS = {
    'A': 1, // Huruf Besar (A, B, C...)
    'I': 1, // Romawi Besar (I, II, III...)
    '1': 2, // Angka Standar (1, 2, 3...)
    'a': 3, // Huruf Kecil (a, b, c...)
    'i': 4  // Romawi Kecil (i, ii, iii...)
};

function getListLevel(type) {
    return LIST_LEVELS[type] || 2;
}

function hasHigherBoundaryBetween(el1, el2, curLevel) {
    const editor = document.getElementById('editorContent');
    if (!editor) return false;
    const allElements = Array.from(editor.querySelectorAll('h1, h2, h3, ol'));
    const idx1 = allElements.indexOf(el1);
    const idx2 = allElements.indexOf(el2);
    if (idx1 === -1 || idx2 === -1 || idx1 >= idx2) return false;

    for (let i = idx1 + 1; i < idx2; i++) {
        const mid = allElements[i];
        const tag = mid.tagName.toLowerCase();
        if (tag === 'h1' || tag === 'h2') return true;
        if (tag === 'ol') {
            const midType = getEffectiveListType(mid);
            const midLevel = getListLevel(midType);
            if (midLevel < curLevel) {
                // Ada section/list yang lebih tinggi hierarkinya (misal A di antara dua list sub-poin)
                return true;
            }
        }
    }
    return false;
}

function findPreviousList(currentOl, targetType) {
    const editor = document.getElementById('editorContent');
    if (!editor || !currentOl) return null;
    const allOls = Array.from(editor.querySelectorAll('ol'));
    const idx = allOls.indexOf(currentOl);
    if (idx <= 0) return null;

    const curLevel = getListLevel(targetType);

    for (let i = idx - 1; i >= 0; i--) {
        const prev = allOls[i];
        if (prev.contains(currentOl) || currentOl.contains(prev)) continue;

        // Sub-poin (1, a, i) harus mulai baru jika terpotong oleh section/heading baru
        if (curLevel > 1 && hasHigherBoundaryBetween(prev, currentOl, curLevel)) {
            return null;
        }

        const prevType = getEffectiveListType(prev);
        if (prevType === targetType) {
            return prev;
        }
    }
    return null;
}

function applyListStyle(type = '1') {
    const editor = document.getElementById('editorContent');
    if (!editor) return;
    editor.focus();

    const styleMap = {
        '1': 'decimal',
        'A': 'upper-alpha',
        'a': 'lower-alpha',
        'I': 'upper-roman',
        'i': 'lower-roman'
    };
    const targetStyle = styleMap[type] || 'decimal';

    const sel = window.getSelection();
    let currentOl = null;

    if (sel && sel.rangeCount > 0) {
        let node = sel.anchorNode;
        if (node && node.nodeType === Node.TEXT_NODE) node = node.parentNode;
        if (node) {
            currentOl = node.closest('ol');
        }
    }

    if (currentOl) {
        const curType = getEffectiveListType(currentOl);
        const isSameType = (curType === type);

        if (isSameType) {
            const curStart = parseInt(currentOl.getAttribute('start'), 10) || 1;
            const prevOl = findPreviousList(currentOl, type);
            if (prevOl && curStart === 1 && !currentOl.hasAttribute('data-continued') && !currentOl.hasAttribute('data-restart')) {
                const nextStart = calculateNextStart(prevOl);
                currentOl.setAttribute('start', nextStart);
                currentOl.setAttribute('data-continued', 'true');
                cleanRedundantListPrefixes(currentOl, type);
            } else {
                document.execCommand('insertOrderedList', false, null);
            }
        } else {
            // Berganti tipe karakter penomoran (misal dari Huruf Besar ke Huruf Kecil atau Angka)
            currentOl.setAttribute('type', type);
            currentOl.style.listStyleType = targetStyle;
            currentOl.style.setProperty('list-style-type', targetStyle, 'important');
            currentOl.removeAttribute('data-restart');

            // Cek apakah ada list sejenis sebelumnya dalam lingkup section ini
            const prevOl = findPreviousList(currentOl, type);
            if (prevOl) {
                const nextStart = calculateNextStart(prevOl);
                currentOl.setAttribute('start', nextStart);
                currentOl.setAttribute('data-continued', 'true');
            } else {
                // Tipe baru pertama: WAJIB MULAI DARI 1 (a, 1, i, dll)!
                currentOl.setAttribute('start', '1');
                currentOl.removeAttribute('data-continued');
            }
            cleanRedundantListPrefixes(currentOl, type);
        }
    } else {
        document.execCommand('insertOrderedList', false, null);
        const newSel = window.getSelection();
        if (newSel && newSel.rangeCount > 0) {
            let n = newSel.anchorNode;
            if (n && n.nodeType === Node.TEXT_NODE) n = n.parentNode;
            if (n) {
                const newOl = n.closest('ol');
                if (newOl) {
                    newOl.setAttribute('type', type);
                    newOl.style.listStyleType = targetStyle;
                    newOl.style.setProperty('list-style-type', targetStyle, 'important');

                    const prevOl = findPreviousList(newOl, type);
                    if (prevOl) {
                        const nextStart = calculateNextStart(prevOl);
                        newOl.setAttribute('start', nextStart);
                        newOl.setAttribute('data-continued', 'true');
                    } else {
                        // Tipe baru pertama: WAJIB MULAI DARI 1!
                        newOl.setAttribute('start', '1');
                        newOl.removeAttribute('data-continued');
                    }
                    cleanRedundantListPrefixes(newOl, type);
                }
            }
        }
    }

    closeListDropdown();
    syncContinuedLists();
    syncEditorToInput();
    updateToolbarActiveState();
}

function getEffectiveListType(ol) {
    if (!ol) return '1';
    const typeAttr = ol.getAttribute('type');
    if (typeAttr) return typeAttr;
    const listStyle = (ol.style.listStyleType || '').toLowerCase();
    if (listStyle.includes('upper-alpha')) return 'A';
    if (listStyle.includes('lower-alpha')) return 'a';
    if (listStyle.includes('upper-roman')) return 'I';
    if (listStyle.includes('lower-roman')) return 'i';
    return '1';
}

function calculateNextStart(prevOl) {
    if (!prevOl) return 1;
    const prevStart = parseInt(prevOl.getAttribute('start'), 10) || 1;
    const directLis = Array.from(prevOl.children).filter(el => el.tagName && el.tagName.toLowerCase() === 'li');
    return prevStart + Math.max(1, directLis.length);
}

function getSelectedOrActiveOl() {
    const editor = document.getElementById('editorContent');
    if (!editor) return null;
    const sel = window.getSelection();
    if (sel && sel.rangeCount > 0) {
        let node = sel.anchorNode;
        if (node && node.nodeType === Node.TEXT_NODE) node = node.parentNode;
        if (node) {
            const ol = node.closest('ol');
            if (ol && editor.contains(ol)) return ol;
        }
    }
    const allOls = editor.querySelectorAll('ol');
    if (allOls.length > 0) {
        return allOls[allOls.length - 1];
    }
    return null;
}

function continueListNumbering() {
    const editor = document.getElementById('editorContent');
    if (!editor) return;
    editor.focus();

    const ol = getSelectedOrActiveOl();
    if (!ol) {
        applyListStyle('A');
        return;
    }

    const type = getEffectiveListType(ol);
    const prevOl = findPreviousList(ol, type);
    if (prevOl) {
        const nextStart = calculateNextStart(prevOl);
        ol.setAttribute('start', nextStart);
    } else {
        const curStart = parseInt(ol.getAttribute('start'), 10) || 1;
        ol.setAttribute('start', curStart + 1);
    }
    ol.removeAttribute('data-restart');
    ol.setAttribute('data-continued', 'true');
    cleanRedundantListPrefixes(ol, type);
    closeListDropdown();
    syncEditorToInput();
    updateToolbarActiveState();
}

function restartListNumbering() {
    const editor = document.getElementById('editorContent');
    if (!editor) return;
    editor.focus();

    const ol = getSelectedOrActiveOl();
    if (!ol) return;

    ol.setAttribute('data-restart', 'true');
    ol.removeAttribute('data-continued');
    ol.setAttribute('start', '1');
    closeListDropdown();
    syncEditorToInput();
    updateToolbarActiveState();
}

function setListCustomStart() {
    const editor = document.getElementById('editorContent');
    if (!editor) return;
    editor.focus();

    const ol = getSelectedOrActiveOl();
    if (!ol) return;

    const type = getEffectiveListType(ol);
    const curStart = parseInt(ol.getAttribute('start'), 10) || 1;
    let defaultVal = curStart;
    if (type === 'A' || type === 'a') {
        defaultVal = numberToAlpha(curStart, type === 'A');
    }

    const inputVal = prompt('Mulai penomoran dari (contoh: B, C, D atau 2, 3, 4):', defaultVal);
    if (inputVal === null) {
        closeListDropdown();
        return;
    }

    const trimmed = inputVal.trim();
    if (!trimmed) {
        closeListDropdown();
        return;
    }

    let startNum = 1;
    if (/^[0-9]+$/.test(trimmed)) {
        startNum = Math.max(1, parseInt(trimmed, 10));
    } else if (/^[A-Za-z]+$/.test(trimmed)) {
        startNum = Math.max(1, alphaToNumber(trimmed));
    }

    ol.setAttribute('data-restart', 'true');
    ol.removeAttribute('data-continued');
    ol.setAttribute('start', startNum);
    cleanRedundantListPrefixes(ol, type);
    closeListDropdown();
    syncEditorToInput();
    updateToolbarActiveState();
}

function numberToAlpha(num, uppercase = true) {
    let result = '';
    let n = Math.max(1, parseInt(num, 10) || 1);
    while (n > 0) {
        let rem = (n - 1) % 26;
        result = String.fromCharCode((uppercase ? 65 : 97) + rem) + result;
        n = Math.floor((n - 1) / 26);
    }
    return result || (uppercase ? 'A' : 'a');
}

function alphaToNumber(str) {
    if (!str) return 1;
    const clean = str.toUpperCase().replace(/[^A-Z]/g, '');
    let result = 0;
    for (let i = 0; i < clean.length; i++) {
        result = result * 26 + (clean.charCodeAt(i) - 64);
    }
    return Math.max(1, result);
}

function syncContinuedLists() {
    const editor = document.getElementById('editorContent');
    if (!editor) return;

    // Scan semua tag <ol> di dokumen editor untuk sinkronisasi urutan penomoran otomatis
    const allOls = Array.from(editor.querySelectorAll('ol'));
    allOls.forEach(ol => {
        const type = getEffectiveListType(ol);

        // Jangan timpa jika user secara eksplisit memilih "Mulai Ulang dari A / 1" atau custom start
        if (ol.getAttribute('data-restart') === 'true') {
            return;
        }

        const prev = findPreviousList(ol, type);
        if (prev) {
            // Otomatis sambung penomoran dari list sebelumnya (misal A -> B, atau B -> C)
            const nextStart = calculateNextStart(prev);
            ol.setAttribute('start', nextStart);
            ol.setAttribute('type', type);
        } else {
            // Jika tidak ada list sejenis sebelumnya dalam section ini, pastikan mulai dari 1 (a, 1, I, dll)
            if (!ol.hasAttribute('data-restart')) {
                ol.setAttribute('start', '1');
                ol.setAttribute('type', type);
            }
        }
    });
}

function setCursorInNode(targetNode) {
    const sel = window.getSelection();
    if (!sel) return;
    const range = document.createRange();
    range.selectNodeContents(targetNode);
    range.collapse(true);
    sel.removeAllRanges();
    sel.addRange(range);
}

function handleListKeyDown(e) {
    if (e.key === 'Tab') {
        const sel = window.getSelection();
        if (sel && sel.rangeCount > 0) {
            let node = sel.anchorNode;
            if (node && node.nodeType === Node.TEXT_NODE) node = node.parentNode;
            if (node && node.closest('li')) {
                e.preventDefault();
                if (e.shiftKey) {
                    document.execCommand('outdent', false, null);
                } else {
                    document.execCommand('indent', false, null);
                }
                syncContinuedLists();
                syncEditorToInput();
                updateToolbarActiveState();
                return true;
            }
        }
        return false;
    }

    if (e.key !== 'Enter' && e.key !== 'Backspace') return false;

    const sel = window.getSelection();
    if (!sel || sel.rangeCount === 0) return false;

    let node = sel.anchorNode;
    if (node && node.nodeType === Node.TEXT_NODE) node = node.parentNode;
    if (!node) return false;

    const li = node.closest('li');
    if (!li) return false;

    const parentList = li.closest('ol, ul');
    if (!parentList) return false;

    // Cek apakah item list (li) ini kosong (tanpa teks dan tanpa gambar/media)
    const rawText = (li.innerText || '').replace(/[\u200B-\u200D\uFEFF\r\n\t]/g, '').trim();
    const hasMedia = Boolean(li.querySelector('img, iframe, figure, table, ol, ul'));
    const isEmpty = (rawText === '' && !hasMedia);

    if (!isEmpty) return false;

    // User menekan Enter atau Backspace pada item list kosong:
    // Konversikan menjadi paragraf normal untuk menulis materi/penjelasan di bawah poin sebelumnya
    e.preventDefault();

    const isOl = parentList.tagName.toLowerCase() === 'ol';
    const listType = isOl ? getEffectiveListType(parentList) : null;
    const items = Array.from(parentList.children).filter(el => el.tagName && el.tagName.toLowerCase() === 'li');
    const idx = items.indexOf(li);

    const p = document.createElement('p');
    p.innerHTML = '<br>';

    if (items.length <= 1) {
        // List hanya memiliki 1 item kosong ini
        parentList.parentNode.replaceChild(p, parentList);
    } else if (idx === items.length - 1) {
        // Item kosong berada di akhir list (misal baru tekan Enter setelah judul A)
        li.remove();
        if (parentList.nextSibling) {
            parentList.parentNode.insertBefore(p, parentList.nextSibling);
        } else {
            parentList.parentNode.appendChild(p);
        }
    } else if (idx === 0) {
        // Item kosong berada di awal list
        li.remove();
        parentList.parentNode.insertBefore(p, parentList);
    } else {
        // Item kosong berada di TENGAH list (di antara judul A dan B):
        // Pisahkan list menjadi dua bagian:
        // 1. List atas tetap berisi judul A
        // 2. Paragraf <p> di tengah untuk tempat menyelipkan materi
        // 3. List bawah berisi judul B yang otomatis menyambung urutan (start="2")
        const itemsAfter = items.slice(idx + 1);
        li.remove();

        const newList = document.createElement(parentList.tagName.toLowerCase());
        if (isOl) {
            newList.setAttribute('type', listType);
            const style = parentList.style.listStyleType;
            if (style) {
                newList.style.listStyleType = style;
                newList.style.setProperty('list-style-type', style, 'important');
            }
        }

        itemsAfter.forEach(item => newList.appendChild(item));

        if (parentList.nextSibling) {
            parentList.parentNode.insertBefore(p, parentList.nextSibling);
            parentList.parentNode.insertBefore(newList, p.nextSibling);
        } else {
            parentList.parentNode.appendChild(p);
            parentList.parentNode.appendChild(newList);
        }
    }

    setCursorInNode(p);
    syncContinuedLists();
    syncEditorToInput();
    updateToolbarActiveState();

    return true;
}

function cleanRedundantListPrefixes(ol, type) {
    if (!ol || !ol.tagName || ol.tagName.toLowerCase() !== 'ol') return;
    const items = Array.from(ol.children).filter(el => el.tagName && el.tagName.toLowerCase() === 'li');
    // Hanya bersihkan prefix eksplisit dengan titik atau kurung tutup dan spasi (misal: "1. ", "2. ", "A. ", "B. ", "a) ", "I. "):
    // Kata biasa seperti "a", "an", "the", "car", "cat" tidak akan pernah terhapus.
    const explicitPrefixRegex = /^\s*(?:[0-9]+|[A-Za-z]{1,3}|[IVXLCDMivxlcdm]+)[\.\)]\s+/;

    items.forEach(li => {
        let walker = document.createTreeWalker(li, NodeFilter.SHOW_TEXT, null, false);
        let firstText = walker.nextNode();
        while (firstText && firstText.nodeValue.trim().length === 0) {
            firstText = walker.nextNode();
        }
        if (!firstText || !firstText.nodeValue) return;

        if (explicitPrefixRegex.test(firstText.nodeValue)) {
            firstText.nodeValue = firstText.nodeValue.replace(explicitPrefixRegex, '');
        }
    });
}

function applyFontName(font) {
    const editor = document.getElementById('editorContent');
    if (!editor || !font) return;
    restoreSelection();

    const sel = window.getSelection();
    if (sel && sel.rangeCount > 0) {
        const range = sel.getRangeAt(0);
        if (range.collapsed) {
            let node = range.startContainer;
            if (node.nodeType === Node.TEXT_NODE) node = node.parentNode;
            if (node && editor.contains(node) && node !== editor) {
                node.style.fontFamily = font;
            } else {
                editor.style.fontFamily = font;
            }
        }
    }

    document.execCommand('fontName', false, font);
    syncEditorToInput();
}

function applyFontSize(size) {
    const editor = document.getElementById('editorContent');
    if (!editor || !size) return;
    restoreSelection();

    const sizePxMap = {
        '1': '10px',
        '2': '12px',
        '3': '14px',
        '4': '16px',
        '5': '18px',
        '6': '24px',
        '7': '36px'
    };
    const targetPx = sizePxMap[size] || '14px';

    const sel = window.getSelection();
    // Jika kursor berada di heading dan user memilih 14px (Normal), konversi heading langsung ke paragraf normal
    if (sel && sel.rangeCount > 0) {
        const range = sel.getRangeAt(0);
        let node = range.startContainer;
        if (node && node.nodeType === Node.TEXT_NODE) node = node.parentNode;
        const heading = node ? node.closest('h1, h2, h3') : null;
        if (heading && editor.contains(heading) && size === '3') {
            applyFormatBlock('p');
            return;
        }
    }

    document.execCommand('fontSize', false, size);

    // Terapkan inline style font-size untuk memastikan ukuran tampil presisi di semua browser
    const fontEls = editor.querySelectorAll(`font[size="${size}"]`);
    fontEls.forEach(el => {
        el.style.fontSize = targetPx;
    });

    syncEditorToInput();
}

function applyFormatBlock(val) {
    const editor = document.getElementById('editorContent');
    if (!editor || !val) return;

    restoreSelection();

    val = val.toLowerCase();
    const sel = window.getSelection();
    if (!sel || !sel.rangeCount) {
        editor.focus();
    }

    const range = (sel && sel.rangeCount > 0) ? sel.getRangeAt(0) : savedSelectionRange;

    // Helper untuk mencari block pembungkus (H1, H2, H3, P, BLOCKQUOTE, DIV, LI)
    const validBlockTags = ['H1', 'H2', 'H3', 'P', 'BLOCKQUOTE', 'DIV', 'LI'];
    function getEnclosingBlock(node) {
        let curr = node;
        while (curr && curr !== editor) {
            if (curr.nodeType === Node.ELEMENT_NODE && validBlockTags.includes(curr.tagName)) {
                return curr;
            }
            curr = curr.parentNode;
        }
        return null;
    }

    // 1. Coba perintah browser standar execCommand
    try {
        document.execCommand('formatBlock', false, `<${val}>`);
    } catch (e) {
        try {
            document.execCommand('formatBlock', false, val);
        } catch (e2) {}
    }

    // 2. Kumpulkan elemen-elemen blok yang berada di dalam seleksi
    let targetBlocks = [];
    if (range) {
        let startBlock = getEnclosingBlock(range.startContainer.nodeType === Node.TEXT_NODE ? range.startContainer.parentNode : range.startContainer);
        let endBlock = getEnclosingBlock(range.endContainer.nodeType === Node.TEXT_NODE ? range.endContainer.parentNode : range.endContainer);

        if (startBlock && startBlock !== editor) targetBlocks.push(startBlock);
        if (endBlock && endBlock !== editor && !targetBlocks.includes(endBlock)) targetBlocks.push(endBlock);

        if (!range.collapsed) {
            editor.querySelectorAll('h1, h2, h3, p, div').forEach(b => {
                try {
                    if (range.intersectsNode(b) && !targetBlocks.includes(b)) {
                        targetBlocks.push(b);
                    }
                } catch(e) {}
            });
        }
    }

    if (targetBlocks.length === 0 && sel && sel.anchorNode) {
        let node = sel.anchorNode;
        if (node.nodeType === Node.TEXT_NODE) node = node.parentNode;
        let b = getEnclosingBlock(node);
        if (b && b !== editor) targetBlocks.push(b);
    }

    // 3. Konversi langsung di DOM untuk memastikan hasil 100% presisi sesuai pilihan user
    targetBlocks.forEach(oldBlock => {
        if (!oldBlock || oldBlock === editor || oldBlock.tagName === 'LI') return;

        const currentTag = oldBlock.tagName.toLowerCase();
        if (currentTag !== val) {
            const newBlock = document.createElement(val);

            // Pindahkan seluruh isi / child nodes
            while (oldBlock.firstChild) {
                newBlock.appendChild(oldBlock.firstChild);
            }

            // Pertahankan text-align jika ada
            if (oldBlock.style && oldBlock.style.textAlign) {
                newBlock.style.textAlign = oldBlock.style.textAlign;
            }

            // Jika diubah ke format Paragraf Normal (p):
            if (val === 'p') {
                newBlock.style.fontSize = '';
                newBlock.style.fontWeight = '';

                // Bersihkan font-size inline sisa heading di anak elemennya
                newBlock.querySelectorAll('[style*="font-size"]').forEach(el => {
                    el.style.fontSize = '';
                });

                // Jika seluruh teks di dalamnya dibungkus <strong>/<b> bawaan heading, unwrap agar tidak tebal permanen
                const children = Array.from(newBlock.childNodes).filter(n => n.nodeType !== Node.TEXT_NODE || n.textContent.trim() !== '');
                if (children.length === 1 && (children[0].nodeName === 'STRONG' || children[0].nodeName === 'B')) {
                    const st = children[0];
                    while (st.firstChild) {
                        newBlock.insertBefore(st.firstChild, st);
                    }
                    st.remove();
                }
            }

            if (oldBlock.parentNode) {
                oldBlock.parentNode.replaceChild(newBlock, oldBlock);

                // Perbarui posisi seleksi ke elemen baru
                if (sel) {
                    const newRange = document.createRange();
                    newRange.selectNodeContents(newBlock);
                    if (range && range.collapsed) {
                        newRange.collapse(false);
                    }
                    sel.removeAllRanges();
                    sel.addRange(newRange);
                    savedSelectionRange = newRange.cloneRange();
                }
            }
        }
    });

    // Sinkronkan langsung nilai dropdown agar konsisten dengan apa yang dipilih user
    const formatSelect = document.getElementById('editorFormatBlock');
    if (formatSelect) {
        formatSelect.value = val;
    }

    syncEditorToInput();
    updateToolbarActiveState();
}

function applyTextColor(color) {
    const editor = document.getElementById('editorContent');
    if (!editor || !color) return;
    restoreSelection();
    document.execCommand('foreColor', false, color);
    const ind = document.getElementById('textColorIndicator');
    if (ind) ind.style.backgroundColor = color;
    syncEditorToInput();
}

function toggleHighlight() {
    const editor = document.getElementById('editorContent');
    if (!editor) return;
    editor.focus();

    const selection = window.getSelection();
    if (!selection.rangeCount) return;

    try {
        const currentColor = document.queryCommandValue('backColor') || document.queryCommandValue('hiliteColor');
        if (currentColor && currentColor !== 'transparent' && currentColor !== 'rgba(0, 0, 0, 0)') {
            document.execCommand('removeFormat', false, null);
        } else {
            document.execCommand('hiliteColor', false, '#fef08a');
        }
    } catch(e) {
        document.execCommand('hiliteColor', false, '#fef08a');
    }
    syncEditorToInput();
}

function isLiLeadingBold(li) {
    if (!li) return false;

    // 1. Cek seleksi/kursor aktif jika user sedang mengetik di li ini dan tombol Bold aktif
    const sel = window.getSelection();
    if (sel && sel.rangeCount > 0) {
        let node = sel.anchorNode;
        if (node && node.nodeType === Node.TEXT_NODE) node = node.parentNode;
        if (node && (node === li || li.contains(node))) {
            try {
                if (document.queryCommandState('bold')) return true;
            } catch(e) {}
        }
    }

    // 2. Telusuri child nodes untuk melihat apakah konten teks pertama di awal li berformat bold (anak judul)
    for (let child of li.childNodes) {
        if (child.nodeType === Node.TEXT_NODE) {
            const txt = (child.textContent || '').replace(/[\s\u200B\u00A0]+/g, '');
            if (txt.length > 0) {
                // Ada teks biasa sebelum tag tebal
                return false;
            }
            continue;
        }
        if (child.nodeType === Node.ELEMENT_NODE) {
            const tag = child.tagName.toLowerCase();
            const fw = child.style ? child.style.fontWeight : '';
            const isBoldStyle = (fw === 'bold' || fw === '700' || parseInt(fw, 10) >= 600);

            if (tag === 'strong' || tag === 'b' || isBoldStyle) {
                return true;
            }

            // Jika child berupa span, font, a, dsb. periksa elemen bold di dalamnya
            const innerBold = child.querySelector('strong, b, [style*="font-weight: bold"], [style*="font-weight: 700"]');
            if (innerBold) {
                const leadingText = child.innerText ? child.innerText.substring(0, child.innerText.indexOf(innerBold.innerText)) : '';
                if (!leadingText.trim()) return true;
            }

            if ((child.textContent || '').replace(/[\s\u200B\u00A0]+/g, '').length > 0) {
                return false;
            }
        }
    }

    // 3. Jika li didominasi teks tebal / anak judul
    const strongs = li.querySelectorAll('strong, b');
    if (strongs.length > 0) {
        let boldLen = 0;
        strongs.forEach(s => boldLen += (s.textContent || '').trim().length);
        const totalLen = (li.textContent || '').trim().length;
        if (totalLen > 0 && boldLen >= totalLen * 0.7) {
            return true;
        }
    }

    return false;
}

function syncListMarkerBoldState() {
    const editor = document.getElementById('editorContent');
    if (!editor) return;
    const lis = editor.querySelectorAll('li');
    lis.forEach(li => {
        if (isLiLeadingBold(li)) {
            li.classList.add('li-marker-bold');
        } else {
            li.classList.remove('li-marker-bold');
        }
    });
}

function syncEditorToInput() {
    const editor = document.getElementById('editorContent');
    const input = document.getElementById('inputKonten');
    const wrapper = document.getElementById('materiEditorWrapper');
    if (!editor || !input) return;

    syncContinuedLists();
    syncListMarkerBoldState();

    const textOnly = editor.innerText.trim();
    if (textOnly === '') {
        input.value = '';
    } else {
        input.value = editor.innerHTML;
        if (wrapper) wrapper.classList.remove('ring-2', 'ring-rose-500', 'border-rose-500');
    }
    updateWordCount();
    updateToolbarActiveState();
}

function updateWordCount() {
    const editor = document.getElementById('editorContent');
    const countEl = document.getElementById('editorWordCount');
    if (!editor || !countEl) return;

    const text = editor.innerText.trim();
    const words = text ? text.split(/\s+/).filter(Boolean).length : 0;
    const chars = text.length;
    countEl.textContent = `${words} kata • ${chars} karakter`;
}

function updateToolbarActiveState() {
    const cmds = ['bold', 'italic', 'underline', 'strikeThrough', 'insertUnorderedList', 'insertOrderedList', 'justifyLeft', 'justifyCenter', 'justifyRight'];
    cmds.forEach(cmd => {
        const btn = document.querySelector(`.editor-btn[data-cmd="${cmd}"]`);
        if (btn) {
            try {
                if (document.queryCommandState(cmd)) {
                    btn.classList.add('bg-blue-100', 'text-blue-700', 'font-bold');
                    btn.classList.remove('text-slate-700');
                } else {
                    btn.classList.remove('bg-blue-100', 'text-blue-700', 'font-bold');
                    btn.classList.add('text-slate-700');
                }
            } catch (e) {}
        }
    });

    const formatSelect = document.getElementById('editorFormatBlock');
    if (formatSelect) {
        let detectedTag = 'p';
        const sel = window.getSelection();
        if (sel && sel.rangeCount > 0) {
            let node = sel.anchorNode;
            if (node && node.nodeType === Node.TEXT_NODE) node = node.parentNode;
            const editorEl = document.getElementById('editorContent');
            if (node && editorEl && editorEl.contains(node)) {
                const headingEl = node.closest('h1, h2, h3, p');
                if (headingEl) {
                    detectedTag = headingEl.tagName.toLowerCase();
                }
            }
        }
        formatSelect.value = detectedTag;
    }

    // Update active state tombol List 123 dan ABC
    const sel = window.getSelection();
    let currentOl = null;
    if (sel && sel.rangeCount > 0) {
        let node = sel.anchorNode;
        if (node && node.nodeType === Node.TEXT_NODE) node = node.parentNode;
        if (node) currentOl = node.closest('ol');
    }

    const btnNum = document.querySelector(`.editor-btn[data-list-type="1"]`);
    const btnAlpha = document.querySelector(`.editor-btn[data-list-type="A"]`);

    if (currentOl) {
        const t = (currentOl.getAttribute('type') || '').toUpperCase();
        const s = (currentOl.style.listStyleType || '').toLowerCase();
        const isAlpha = (t === 'A' || s === 'upper-alpha');
        const isNum = (t === '1' || s === 'decimal' || (!t && !s));

        if (btnAlpha) {
            if (isAlpha) {
                btnAlpha.classList.add('bg-blue-100', 'text-blue-700', 'ring-1', 'ring-blue-300');
            } else {
                btnAlpha.classList.remove('bg-blue-100', 'text-blue-700', 'ring-1', 'ring-blue-300');
            }
        }
        if (btnNum) {
            if (isNum) {
                btnNum.classList.add('bg-blue-100', 'text-blue-700');
            } else {
                btnNum.classList.remove('bg-blue-100', 'text-blue-700');
            }
        }
    } else {
        if (btnAlpha) btnAlpha.classList.remove('bg-blue-100', 'text-blue-700', 'ring-1', 'ring-blue-300');
        if (btnNum) btnNum.classList.remove('bg-blue-100', 'text-blue-700');
    }

    // Update active state tombol & sub-toolbar Blockquote / Callout
    const bq = getActiveBlockquote();
    const btnQuote = document.getElementById('btnQuoteFormat');
    const quoteIndicator = document.getElementById('quoteColorIndicator');
    const quoteContextBar = document.getElementById('blockquoteContextBar');

    if (bq) {
        if (btnQuote) {
            btnQuote.classList.add('bg-blue-100', 'text-blue-700', 'ring-1', 'ring-blue-300');
            btnQuote.classList.remove('text-slate-700');
        }
        if (quoteContextBar) {
            quoteContextBar.classList.remove('hidden');
        }
        const colorKey = bq.getAttribute('data-color');
        if (colorKey && QUOTE_COLORS[colorKey]) {
            if (quoteIndicator) quoteIndicator.style.backgroundColor = QUOTE_COLORS[colorKey].border;
        } else if (bq.style.borderLeftColor) {
            if (quoteIndicator) quoteIndicator.style.backgroundColor = bq.style.borderLeftColor;
        } else {
            if (quoteIndicator) quoteIndicator.style.backgroundColor = '#0284c7';
        }
    } else {
        if (btnQuote) {
            btnQuote.classList.remove('bg-blue-100', 'text-blue-700', 'ring-1', 'ring-blue-300');
            btnQuote.classList.add('text-slate-700');
        }
        if (quoteContextBar) {
            quoteContextBar.classList.add('hidden');
        }
    }
}

// =============================================
// WORD-STYLE INLINE IMAGE HANDLING
// =============================================
let activeInlineImage = null;

function selectInlineImage(img) {
    activeInlineImage = img;
    document.querySelectorAll('#editorContent img').forEach(el => el.classList.remove('ring-3', 'ring-emerald-500'));
    img.classList.add('ring-3', 'ring-emerald-500');

    const contextBar = document.getElementById('imageContextBar');
    if (contextBar) {
        contextBar.classList.remove('hidden');
        updateImageContextBarState();
    }
}

function deselectInlineImage() {
    activeInlineImage = null;
    document.querySelectorAll('#editorContent img').forEach(el => el.classList.remove('ring-3', 'ring-emerald-500'));
    const contextBar = document.getElementById('imageContextBar');
    if (contextBar) contextBar.classList.add('hidden');
}

function updateImageContextBarState() {
    if (!activeInlineImage) return;
    const figure = activeInlineImage.closest('figure');
    const align = figure?.style?.textAlign || 'center';

    ['left', 'center', 'right'].forEach(a => {
        const btn = document.getElementById('btnAlign' + a.charAt(0).toUpperCase() + a.slice(1));
        if (btn) {
            if (a === align) {
                btn.className = 'px-2 py-0.5 rounded text-xs font-bold bg-emerald-600 text-white shadow-2xs transition';
            } else {
                btn.className = 'px-2 py-0.5 rounded text-xs font-semibold text-slate-700 hover:bg-emerald-100 transition';
            }
        }
    });
}

function setInlineImageAlignment(align) {
    if (!activeInlineImage) return;
    let figure = activeInlineImage.closest('figure');
    if (!figure) {
        figure = document.createElement('figure');
        figure.className = 'materi-img-wrapper my-4 block select-none';
        activeInlineImage.parentNode.insertBefore(figure, activeInlineImage);
        figure.appendChild(activeInlineImage);
    }
    figure.style.textAlign = align;
    activeInlineImage.style.display = 'inline-block';
    if (align === 'left') {
        activeInlineImage.style.marginLeft = '0';
        activeInlineImage.style.marginRight = 'auto';
    } else if (align === 'right') {
        activeInlineImage.style.marginLeft = 'auto';
        activeInlineImage.style.marginRight = '0';
    } else {
        activeInlineImage.style.marginLeft = 'auto';
        activeInlineImage.style.marginRight = 'auto';
    }
    updateImageContextBarState();
    syncEditorToInput();
}

function setInlineImageSize(size) {
    if (!activeInlineImage) return;
    activeInlineImage.style.maxWidth = size;
    activeInlineImage.style.width = size === '100%' ? '100%' : 'auto';
    syncEditorToInput();
}

function deleteSelectedInlineImage() {
    if (!activeInlineImage) return;
    const figure = activeInlineImage.closest('figure');
    if (figure) figure.remove();
    else activeInlineImage.remove();
    deselectInlineImage();
    syncEditorToInput();
}

function triggerInlineImageUpload() {
    saveSelection();
    const input = document.getElementById('editorInlineFileInput');
    if (input) {
        input.value = '';
        input.click();
    }
}

function handleInlineImageUpload(input) {
    if (input.files && input.files[0]) {
        uploadAndInsertImage(input.files[0]);
    }
}

function uploadAndInsertImage(file) {
    if (!file || !file.type.startsWith('image/')) return;

    restoreSelection();
    const editor = document.getElementById('editorContent');
    if (!editor) return;

    const tempId = 'img_loading_' + Date.now();
    const loadingHtml = `<span id="${tempId}" class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-700 font-semibold my-2 select-none animate-pulse">
        <svg class="w-4 h-4 animate-spin text-emerald-600" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
        Mengupload foto ke materi...
    </span>`;
    document.execCommand('insertHTML', false, loadingHtml);
    syncEditorToInput();

    const formData = new FormData();
    formData.append('image', file);

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

    fetch('{{ route("admin.materi.upload-image") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        const placeholder = document.getElementById(tempId);
        if (data.success && data.url) {
            replacePlaceholderWithImage(placeholder, data.url, file.name);
        } else {
            fallbackInsertDataUrl(placeholder, file);
        }
    })
    .catch(err => {
        console.warn('Upload API error, fallback to DataURL:', err);
        const placeholder = document.getElementById(tempId);
        fallbackInsertDataUrl(placeholder, file);
    });
}

function replacePlaceholderWithImage(placeholder, url, alt = 'Gambar Materi') {
    const figure = document.createElement('figure');
    figure.className = 'materi-img-wrapper my-4 block select-none';
    figure.style.textAlign = 'center';
    figure.style.margin = '1.25rem 0';
    figure.setAttribute('contenteditable', 'false');

    const img = document.createElement('img');
    img.src = url;
    img.alt = alt;
    img.className = 'materi-inline-img inline-block rounded-xl shadow-md transition hover:ring-2 hover:ring-emerald-400 cursor-pointer';
    img.style.maxHeight = '480px';
    img.style.maxWidth = '100%';
    img.style.width = 'auto';
    img.style.objectFit = 'contain';

    const caption = document.createElement('figcaption');
    caption.className = 'materi-caption text-xs text-slate-500 mt-1.5 italic';
    caption.setAttribute('contenteditable', 'true');
    caption.textContent = '';
    caption.setAttribute('data-placeholder', 'Tulis keterangan foto di sini (opsional)...');

    figure.appendChild(img);
    figure.appendChild(caption);

    if (placeholder && placeholder.parentNode) {
        placeholder.parentNode.insertBefore(figure, placeholder);
        placeholder.remove();
    } else {
        const editor = document.getElementById('editorContent');
        if (editor) editor.appendChild(figure);
    }

    const p = document.createElement('p');
    p.innerHTML = '<br>';
    if (figure.nextSibling) {
        figure.parentNode.insertBefore(p, figure.nextSibling);
    } else if (figure.parentNode) {
        figure.parentNode.appendChild(p);
    }

    syncEditorToInput();
    selectInlineImage(img);
}

function fallbackInsertDataUrl(placeholder, file) {
    const reader = new FileReader();
    reader.onload = function(e) {
        replacePlaceholderWithImage(placeholder, e.target.result, file.name);
    };
    reader.readAsDataURL(file);
}
</script>
@endpush

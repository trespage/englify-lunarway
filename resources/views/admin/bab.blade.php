@extends('layouts.admin')

@section('title', 'Kelola Bab Kurikulum')

@section('content')
<div class="space-y-6">

    <!-- ===================================================== -->
    <!-- HEADER                                                 -->
    <!-- ===================================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#018ABE] to-[#02457A] flex items-center justify-center text-white shadow-lg shadow-[#018ABE]/20 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Kelola Bab Kurikulum</h1>
                <p class="text-slate-500 text-sm mt-0.5">Atur urutan Bab 1..N untuk setiap divisi kurikulum ({{ $kategoriList->pluck('nama_kategori')->implode(', ') }}).</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.materi') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Kelola Materi
            </a>
            <button onclick="openBabModal('add')" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/30 transition-all active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Bab Baru
            </button>
        </div>
    </div>

    <!-- FLASH MESSAGES -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm space-y-1">
            <p class="font-bold">Terjadi kesalahan input:</p>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- ===================================================== -->
    <!-- STATS CARDS (DINAMIS MENGIKUTI KELOLA KATEGORI)        -->
    <!-- ===================================================== -->
    @php
        $cardStyles = [
            'speaking'  => ['bg' => 'bg-rose-50/70 border-rose-200/80', 'title' => 'text-rose-700', 'dot' => 'bg-rose-500', 'count' => 'text-rose-800', 'unit' => 'text-rose-600', 'desc' => 'text-rose-500', 'default_desc' => 'Praktik Berbicara'],
            'writing'   => ['bg' => 'bg-blue-50/70 border-blue-200/80', 'title' => 'text-blue-700', 'dot' => 'bg-blue-500', 'count' => 'text-blue-800', 'unit' => 'text-blue-600', 'desc' => 'text-blue-500', 'default_desc' => 'Tata Bahasa & Menulis'],
            'reading'   => ['bg' => 'bg-emerald-50/70 border-emerald-200/80', 'title' => 'text-emerald-700', 'dot' => 'bg-emerald-500', 'count' => 'text-emerald-800', 'unit' => 'text-emerald-600', 'desc' => 'text-emerald-500', 'default_desc' => 'Membaca & Memahami'],
            'listening' => ['bg' => 'bg-purple-50/70 border-purple-200/80', 'title' => 'text-purple-700', 'dot' => 'bg-purple-500', 'count' => 'text-purple-800', 'unit' => 'text-purple-600', 'desc' => 'text-purple-500', 'default_desc' => 'Audio & Pemahaman'],
        ];

        $fallbackStyles = [
            ['bg' => 'bg-amber-50/70 border-amber-200/80', 'title' => 'text-amber-700', 'dot' => 'bg-amber-500', 'count' => 'text-amber-800', 'unit' => 'text-amber-600', 'desc' => 'text-amber-500', 'default_desc' => 'Divisi Kurikulum'],
            ['bg' => 'bg-teal-50/70 border-teal-200/80', 'title' => 'text-teal-700', 'dot' => 'bg-teal-500', 'count' => 'text-teal-800', 'unit' => 'text-teal-600', 'desc' => 'text-teal-500', 'default_desc' => 'Divisi Kurikulum'],
            ['bg' => 'bg-indigo-50/70 border-indigo-200/80', 'title' => 'text-indigo-700', 'dot' => 'bg-indigo-500', 'count' => 'text-indigo-800', 'unit' => 'text-indigo-600', 'desc' => 'text-indigo-500', 'default_desc' => 'Divisi Kurikulum'],
            ['bg' => 'bg-cyan-50/70 border-cyan-200/80', 'title' => 'text-cyan-700', 'dot' => 'bg-cyan-500', 'count' => 'text-cyan-800', 'unit' => 'text-cyan-600', 'desc' => 'text-cyan-500', 'default_desc' => 'Divisi Kurikulum'],
        ];
    @endphp

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        <!-- Total Bab -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm col-span-2 sm:col-span-1 flex flex-col justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500">Total Semua Bab</p>
                <p class="text-2xl font-extrabold text-slate-800 mt-1">{{ $stats['total'] }}</p>
            </div>
            <p class="text-[10px] text-slate-400 mt-2">di {{ $kategoriList->count() }} divisi kurikulum</p>
        </div>

        <!-- Kartu per Kategori Dinamis -->
        @foreach($kategoriList as $idx => $kat)
            @php
                $key = strtolower($kat->nama_kategori);
                $style = $cardStyles[$key] ?? $fallbackStyles[$idx % count($fallbackStyles)];
                $descText = !empty($kat->deskripsi) ? $kat->deskripsi : ($style['default_desc'] ?? 'Divisi Kurikulum');
                $babCount = $kat->babs_count ?? $kat->babs()->count();
            @endphp
            <div class="{{ $style['bg'] }} rounded-2xl p-4 border shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold {{ $style['title'] }} uppercase tracking-wider truncate mr-1" title="{{ $kat->nama_kategori }}">
                            {{ $kat->nama_kategori }}
                        </span>
                        <span class="w-2.5 h-2.5 rounded-full {{ $style['dot'] }} shrink-0"></span>
                    </div>
                    <p class="text-2xl font-extrabold {{ $style['count'] }} mt-1">
                        {{ $babCount }} <span class="text-xs font-normal {{ $style['unit'] }}">Bab</span>
                    </p>
                </div>
                <p class="text-[10px] {{ $style['desc'] }} mt-2 truncate" title="{{ $descText }}">
                    {{ $descText }}
                </p>
            </div>
        @endforeach
    </div>

    <!-- ===================================================== -->
    <!-- FILTER BAR                                             -->
    <!-- ===================================================== -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('admin.bab') }}" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="flex-1 w-full relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama bab..."
                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <div class="w-full sm:w-64">
                <select name="kategori" onchange="this.form.submit()"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    <option value="">Semua Kategori Divisi</option>
                    @foreach($kategoriList as $k)
                        <option value="{{ $k->id_kategori }}" {{ request('kategori') == $k->id_kategori ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-semibold rounded-xl text-sm transition">
                Filter
            </button>

            @if(request()->hasAny(['q', 'kategori']))
                <a href="{{ route('admin.bab') }}" class="w-full sm:w-auto px-4 py-2.5 text-slate-500 hover:text-slate-700 text-sm font-semibold text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- ===================================================== -->
    <!-- TABEL DAFTAR BAB                                       -->
    <!-- ===================================================== -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/75 border-b border-slate-200 text-slate-500 text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Nomor Bab</th>
                        <th class="px-6 py-4">Kategori / Divisi</th>
                        <th class="px-6 py-4">Judul Bab</th>
                        <th class="px-6 py-4 text-center">Jumlah Materi</th>
                        <th class="px-6 py-4 text-center">Jumlah Quiz</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($babs as $bab)
                        @php
                            $catColors = [
                                'Speaking'  => 'bg-rose-50 text-rose-700 border-rose-200',
                                'Writing'   => 'bg-blue-50 text-blue-700 border-blue-200',
                                'Reading'   => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'Listening' => 'bg-purple-50 text-purple-700 border-purple-200',
                            ];
                            $badgeColor = $catColors[$bab->kategori?->nama_kategori] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center justify-center px-3 py-1 rounded-lg text-xs font-extrabold bg-slate-100 text-slate-800 border border-slate-200">
                                    Bab {{ $bab->urutan }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {{ $badgeColor }}">
                                    {{ $bab->kategori?->nama_kategori ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-extrabold text-slate-800">{{ $bab->judul }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $bab->materi_count > 0 ? 'bg-blue-50 text-blue-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $bab->materi_count }} Materi
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $bab->quizzes_count > 0 ? 'bg-purple-50 text-purple-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $bab->quizzes_count }} Soal
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($bab->is_active)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <button onclick='editBab(@json($bab))' 
                                            class="p-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-600 transition" 
                                            title="Edit Bab">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button onclick="deleteBab({{ $bab->id }}, '{{ addslashes($bab->judul) }}')" 
                                            class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 transition" 
                                            title="Hapus Bab">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-600">Belum ada data Bab yang sesuai.</p>
                                <p class="text-xs text-slate-400 mt-1">Klik tombol "Tambah Bab Baru" di atas untuk menambahkan bab baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($babs->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $babs->links() }}
            </div>
        @endif
    </div>

</div>

<!-- ===================================================== -->
<!-- MODAL TAMBAH / EDIT BAB                                -->
<!-- ===================================================== -->
<div id="babModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-200">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 id="babModalTitle" class="text-lg font-extrabold text-slate-800">Tambah Bab Baru</h3>
            <button onclick="closeBabModal()" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="babForm" method="POST" action="{{ route('admin.bab.store') }}" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="_method" id="babMethod" value="POST">
            <input type="hidden" name="id" id="babId">

            <!-- Pilih Kategori -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kategori / Divisi <span class="text-rose-500">*</span></label>
                <select name="id_kategori" id="inputBabKategori" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    <option value="">-- Pilih Kategori Divisi --</option>
                    @foreach($kategoriList as $kat)
                        <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Judul Bab -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Judul Bab <span class="text-rose-500">*</span></label>
                <input type="text" name="judul" id="inputBabJudul" required placeholder="Contoh: Daily Small Talk, Simple Present Tense"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                <p class="text-[11px] text-slate-400 mt-1">Nama bab pembelajaran di kategori ini.</p>
            </div>

            <!-- Urutan Bab -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block text-sm font-semibold text-slate-700">Nomor Urutan Bab <span class="text-rose-500">*</span></label>
                    <span id="babUrutanBadge" class="hidden text-[11px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                        Otomatis Bersusun
                    </span>
                </div>
                <input type="number" name="urutan" id="inputBabUrutan" min="1" placeholder="Pilih kategori terlebih dahulu"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                <p id="babUrutanHint" class="text-[11px] text-slate-400 mt-1">Urutan bab di dalam kategori terkait (misal Bab 1, Bab 2, dst).</p>
                <div id="babUrutanWarning" class="hidden mt-2 p-2.5 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-700 font-medium flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span id="babUrutanWarningText">Bab dengan nomor ini sudah ada pada kategori ini. Nomor bab harus bersusun dan tidak boleh sama.</span>
                </div>
            </div>

            <!-- Status Aktif -->
            <div class="pt-2">
                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" id="inputBabActive" value="1" checked class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                    <span class="text-sm font-medium text-slate-700">Aktifkan Bab ini sekarang</span>
                </label>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeBabModal()" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-semibold text-sm hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm transition shadow-lg shadow-blue-600/30">
                    Simpan Bab
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ===================================================== -->
<!-- MODAL DELETE BAB                                       -->
<!-- ===================================================== -->
<div id="deleteBabModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 text-center shadow-2xl border border-slate-100">
        <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <h3 class="text-lg font-bold text-slate-800">Hapus Bab?</h3>
        <p class="text-sm text-slate-500 mt-2">Apakah kamu yakin ingin menghapus bab <strong id="deleteBabJudul" class="text-slate-700"></strong>?</p>
        <div class="mt-3 p-3 bg-amber-50 border border-amber-200/60 rounded-xl text-left flex items-start gap-2.5">
            <svg class="w-4 h-4 text-amber-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <p class="text-xs text-amber-800 leading-relaxed">
                Seluruh materi dan kuis yang ada di dalam bab ini juga akan ikut terhapus otomatis.
            </p>
        </div>

        <form id="deleteBabForm" method="POST" action="" class="mt-6 flex items-center justify-center gap-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeDeleteBabModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition">
                Batal
            </button>
            <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-sm font-semibold transition shadow-lg shadow-rose-600/30">
                Ya, Hapus
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
let currentBabMode = 'add';
let currentOriginalUrutan = null;
let currentKatUrutans = [];

async function fetchNextUrutanForCategory(katId, autoFill = true) {
    if (!katId) {
        currentKatUrutans = [];
        const urutanInput = document.getElementById('inputBabUrutan');
        urutanInput.placeholder = 'Pilih kategori terlebih dahulu';
        document.getElementById('babUrutanBadge').classList.add('hidden');
        document.getElementById('babUrutanHint').textContent = 'Urutan bab di dalam kategori terkait (misal Bab 1, Bab 2, dst).';
        checkUrutanValidity();
        return;
    }

    try {
        const res = await fetch(`/admin/bab/next-urutan/${katId}`);
        if (!res.ok) throw new Error('Gagal mengambil urutan');
        const data = await res.json();
        currentKatUrutans = data.existing_urutans || [];

        const urutanInput = document.getElementById('inputBabUrutan');
        const badge = document.getElementById('babUrutanBadge');
        const hint = document.getElementById('babUrutanHint');

        urutanInput.placeholder = `Contoh: ${data.next_urutan} (Otomatis Bersusun)`;

        if (currentBabMode === 'add' && autoFill) {
            urutanInput.value = data.next_urutan;
            badge.classList.remove('hidden');
            hint.textContent = `Nomor bab otomatis bersusun: Bab ${data.next_urutan}.`;
        }

        checkUrutanValidity();
    } catch (err) {
        console.error('Error fetching next urutan:', err);
    }
}

function checkUrutanValidity() {
    const urutanInput = document.getElementById('inputBabUrutan');
    const warning = document.getElementById('babUrutanWarning');
    const warningText = document.getElementById('babUrutanWarningText');
    const katSelect = document.getElementById('inputBabKategori');
    const submitBtn = document.querySelector('#babForm button[type="submit"]');

    if (!urutanInput || !warning) return true;

    const val = parseInt(urutanInput.value, 10);
    if (!val || !katSelect.value) {
        warning.classList.add('hidden');
        urutanInput.classList.remove('border-rose-400', 'ring-2', 'ring-rose-200');
        if (submitBtn) submitBtn.disabled = false;
        return true;
    }

    // Cek apakah nomor urut ini sudah digunakan pada kategori yang sama
    const isDuplicate = currentKatUrutans.includes(val) && !(currentBabMode === 'edit' && val === currentOriginalUrutan);

    if (isDuplicate) {
        const katName = katSelect.options[katSelect.selectedIndex]?.text || 'kategori ini';
        warningText.textContent = `Nomor Bab ${val} sudah terdaftar pada ${katName}! Setiap bab harus memiliki nomor urut bersusun dan tidak boleh kembar.`;
        warning.classList.remove('hidden');
        urutanInput.classList.add('border-rose-400', 'ring-2', 'ring-rose-200');
        if (submitBtn) submitBtn.disabled = true;
        return false;
    } else {
        warning.classList.add('hidden');
        urutanInput.classList.remove('border-rose-400', 'ring-2', 'ring-rose-200');
        if (submitBtn) submitBtn.disabled = false;
        return true;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const katSelect = document.getElementById('inputBabKategori');
    const urutanInput = document.getElementById('inputBabUrutan');
    const babForm = document.getElementById('babForm');

    if (katSelect) {
        katSelect.addEventListener('change', (e) => {
            fetchNextUrutanForCategory(e.target.value, currentBabMode === 'add');
        });
    }

    if (urutanInput) {
        urutanInput.addEventListener('input', () => {
            document.getElementById('babUrutanBadge').classList.add('hidden');
            checkUrutanValidity();
        });
    }

    if (babForm) {
        babForm.addEventListener('submit', (e) => {
            if (!checkUrutanValidity()) {
                e.preventDefault();
                alert('Nomor urut bab ini sudah terdaftar. Harap gunakan nomor urut yang bersusun!');
            }
        });
    }
});

function openBabModal(type = 'add', data = null) {
    currentBabMode = type;
    const modal = document.getElementById('babModal');
    const title = document.getElementById('babModalTitle');
    const form  = document.getElementById('babForm');
    const warning = document.getElementById('babUrutanWarning');
    const badge = document.getElementById('babUrutanBadge');
    if (warning) warning.classList.add('hidden');

    if (type === 'edit' && data) {
        currentOriginalUrutan = parseInt(data.urutan, 10);
        title.textContent = 'Edit Bab';
        form.action = `/admin/bab/${data.id}`;
        document.getElementById('babMethod').value = 'PUT';
        document.getElementById('babId').value = data.id;
        document.getElementById('inputBabKategori').value = data.id_kategori;
        document.getElementById('inputBabJudul').value = data.judul;
        document.getElementById('inputBabUrutan').value = data.urutan;
        document.getElementById('inputBabActive').checked = Boolean(data.is_active);
        badge.classList.add('hidden');
        fetchNextUrutanForCategory(data.id_kategori, false);
    } else {
        currentOriginalUrutan = null;
        title.textContent = 'Tambah Bab Baru';
        form.action = "{{ route('admin.bab.store') }}";
        form.reset();
        document.getElementById('babMethod').value = 'POST';
        document.getElementById('babId').value = '';
        document.getElementById('inputBabActive').checked = true;
        badge.classList.add('hidden');
        currentKatUrutans = [];
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeBabModal() {
    const modal = document.getElementById('babModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function editBab(data) {
    openBabModal('edit', data);
}

function deleteBab(id, judul) {
    document.getElementById('deleteBabJudul').textContent = `"${judul}"`;
    document.getElementById('deleteBabForm').action = `/admin/bab/${id}`;
    const modal = document.getElementById('deleteBabModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDeleteBabModal() {
    const modal = document.getElementById('deleteBabModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
@endpush
@endsection

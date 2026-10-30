@extends('layouts.siswa')

@section('title', 'Materi Pembelajaran')

@section('content')
<div class="space-y-6">

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-[#97CADB] flex items-center justify-center shrink-0 shadow-sm">
                <svg class="w-6 h-6 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Materi Pembelajaran</h1>
                <p class="text-slate-500 text-sm mt-0.5">Pilih kategori dan pelajari materi terstruktur dari Bab 1 hingga tuntas.</p>
            </div>
        </div>
        <div class="flex items-center gap-2 text-sm bg-white px-4 py-2.5 rounded-xl border border-[#97CADB]/30 shadow-sm">
            <svg class="w-4 h-4 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            <span class="font-semibold text-slate-700">Semangat belajar! ✨</span>
        </div>
    </div>

    <!-- PANDUAN PENGERJAAN MATERI & QUIZ -->
    <div class="bg-gradient-to-r from-[#D6EBEE] via-white to-blue-50/70 rounded-2xl p-5 border border-[#97CADB]/50 shadow-sm relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-start gap-4">
            <div class="w-11 h-11 rounded-2xl bg-[#018ABE] text-white flex items-center justify-center shrink-0 shadow-md shadow-[#018ABE]/20 mt-0.5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-[#018ABE] text-white">
                        Panduan Siswa
                    </span>
                    <h3 class="font-extrabold text-[#001B48] text-base">Alur Pengerjaan Materi & Quiz</h3>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed max-w-2xl">
                    Kerjakan pembelajaranmu di sini: klik <strong class="text-[#02457A]">"Mulai Baca"</strong> untuk mempelajari isi materi, lalu lanjutkan ke kuis di bagian akhir materi untuk menguji pemahaman dan mengumpulkan nilai. Seluruh progress dan peringkat skor juga bisa kamu cek di menu <strong class="text-[#001B48]">Peta Quiz</strong>! 🐾
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('siswa.peta-quiz') }}" class="w-full sm:w-auto px-4 py-2.5 bg-gradient-to-r from-[#018ABE] to-[#02457A] hover:from-[#02457A] hover:to-[#001B48] text-white text-xs font-bold rounded-xl transition shadow-md shadow-[#018ABE]/25 flex items-center justify-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                <span>Lihat Peta Quiz 🎯</span>
            </a>
        </div>
    </div>

    <!-- TABS FILTER KATEGORI (BERWARNA KHAS) -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-hide" id="kategoriFilterContainer">
        <button type="button" 
                data-cat="all"
                onclick="filterKategori('all', this)" 
                class="kat-filter-btn px-4 py-2.5 rounded-xl text-xs whitespace-nowrap shadow-sm transition bg-gradient-to-r from-[#02457A] to-[#018ABE] border-2 border-[#018ABE]/40 text-white shadow-sm shadow-[#018ABE]/25 ring-2 ring-[#018ABE]/30 ring-offset-1 font-extrabold">
            Semua Kategori
        </button>
        @foreach($kategoriList as $kat)
            @php
                $color = $kat->color;
                $catKey = strtolower($kat->nama_kategori);
            @endphp
            <button type="button" 
                    data-cat="{{ $catKey }}"
                    onclick="filterKategori('{{ $kat->nama_kategori }}', this)" 
                    class="kat-filter-btn px-4 py-2.5 bg-white border {{ $color['border'] }} {{ $color['text'] }} hover:bg-slate-50 rounded-xl text-xs font-bold whitespace-nowrap shadow-sm transition flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full {{ $color['bg'] }}"></span>
                {{ $kat->nama_kategori }}
            </button>
        @endforeach
    </div>

    <!-- DAFTAR MATERI PER KATEGORI & BAB -->
    <div class="space-y-6">
        @forelse($kategoriList as $kategori)
            @php
                $c = $kategori->color;
            @endphp
            <div class="kategori-section bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden" data-category="{{ $kategori->nama_kategori }}">
                <!-- Header Kategori -->
                <div class="px-4 sm:px-6 py-3.5 sm:py-4 border-b border-slate-100 flex items-center justify-between gap-3 {{ $c['bg_light'] }}">
                    <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                        <span class="px-2.5 sm:px-3 py-1 rounded-lg text-[10px] sm:text-xs font-extrabold uppercase tracking-wider {{ $c['badge'] }} shrink-0">
                            {{ $kategori->nama_kategori }}
                        </span>
                        <div class="min-w-0">
                            <h2 class="font-extrabold text-slate-800 text-sm sm:text-base truncate">{{ $kategori->nama_kategori }}</h2>
                            <p class="text-[11px] sm:text-xs text-slate-500 truncate">{{ $kategori->babs->count() }} Bab pembelajaran</p>
                        </div>
                    </div>
                    <span class="text-[11px] sm:text-xs font-semibold {{ $c['text'] }} shrink-0">
                        {{ $kategori->babs->sum(fn($b) => $b->materi->count()) }} Materi
                    </span>
                </div>

                <!-- Daftar Bab di Kategori ini -->
                <div class="p-3.5 sm:p-6 space-y-3 sm:space-y-4">
                    @forelse($kategori->babs as $bIndex => $bab)
                        <div class="materi-bab-item border border-slate-200 rounded-xl overflow-hidden hover:border-slate-300 transition" data-bab-title="Bab {{ $bab->urutan }}: {{ $bab->judul }}">
                            <!-- Bab Header (Accordion Click) -->
                            <div class="p-3.5 sm:p-4 bg-slate-50/60 hover:bg-slate-100/60 cursor-pointer flex items-center justify-between transition gap-2"
                                 onclick="toggleBab({{ $bab->id }})">
                                <div class="flex items-center gap-2.5 sm:gap-3 flex-1 min-w-0">
                                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center font-bold text-xs {{ $c['text'] }} shadow-xs shrink-0">
                                        Bab {{ $bab->urutan }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3 class="font-bold text-slate-800 text-xs sm:text-sm truncate">Bab {{ $bab->urutan }}: {{ $bab->judul }}</h3>
                                        <p class="text-[10px] sm:text-[11px] text-slate-500">{{ $bab->materi->count() }} materi di bab ini</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                                    <span class="text-[11px] sm:text-xs font-semibold text-slate-500 hidden sm:inline">Lihat Materi</span>
                                    <svg id="arrow-{{ $bab->id }}" class="w-4 h-4 text-slate-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- List Materi di Dalam Bab Ini -->
                            <div id="materi-container-{{ $bab->id }}" class="p-3 sm:p-4 space-y-2.5 bg-white border-t border-slate-100">
                                @forelse($bab->materi as $mIndex => $m)
                                    @php
                                        $isLocked = $m->is_locked ?? false;
                                        $lockedBy = $m->locked_by ?? 'sebelumnya';
                                        $sudahSelesai = $m->progress->where('status', 'Completed')->isNotEmpty();
                                        $quizList = $m->quiz ?: collect();
                                        $quizCount = $quizList->count();
                                        $targetQuiz = $quizList->first();
                                    @endphp
                                    <div class="materi-item-row flex flex-col sm:flex-row sm:items-center justify-between p-3.5 sm:p-4 {{ $isLocked ? 'bg-slate-50/60 border-slate-200/60 opacity-80' : 'bg-slate-50/80 hover:bg-slate-100/90 border-slate-200/70' }} rounded-2xl transition gap-3.5 border" data-materi-title="{{ $m->judul }}" data-materi-bab="Bab {{ $bab->urutan }}: {{ $bab->judul }}">
                                        <div class="flex items-center gap-3 sm:gap-3.5 min-w-0 flex-1">
                                            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl {{ $isLocked ? 'bg-slate-100 border border-slate-200 text-slate-400' : ($sudahSelesai ? 'bg-emerald-100 text-emerald-600' : 'bg-white border border-slate-200 text-slate-700') }} flex items-center justify-center shrink-0 font-bold text-xs shadow-xs">
                                                @if($isLocked)
                                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                                @elseif($sudahSelesai)
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                @else
                                                    <span>{{ $mIndex + 1 }}</span>
                                                @endif
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
                                                    <p class="text-xs sm:text-sm font-bold {{ $isLocked ? 'text-slate-600' : 'text-slate-800' }} truncate">{{ $m->judul }}</p>
                                                    @if($isLocked)
                                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200 flex items-center gap-1">
                                                            <svg class="w-3 h-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                                            <span>Terkunci</span>
                                                        </span>
                                                    @elseif($quizCount > 0)
                                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-700 border border-purple-200">
                                                            🎯 {{ $quizCount }} Soal Quiz
                                                        </span>
                                                    @else
                                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-500 border border-slate-200">
                                                            📖 Materi Bacaan
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="flex items-center gap-2 mt-1 text-[11px] text-slate-400 flex-wrap">
                                                    @if($isLocked)
                                                        <span class="text-amber-700 font-medium flex items-center gap-1 text-[10px] sm:text-[11px]">
                                                            <span>• Selesaikan materi & kuis '{{ $lockedBy }}' untuk membuka</span>
                                                        </span>
                                                    @elseif($sudahSelesai)
                                                        <span class="text-emerald-600 font-semibold flex items-center gap-1">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Selesai Dibaca
                                                        </span>
                                                    @else
                                                        <span class="text-slate-500 flex items-center gap-1">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Belum Dibaca
                                                        </span>
                                                    @endif
                                                    @if(!$isLocked && $m->file)
                                                        <span>• 📄 Dokumen</span>
                                                    @endif
                                                    @if(!$isLocked && $m->url)
                                                        <span>• 🔗 Tautan/Video</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-2 w-full sm:w-auto shrink-0 justify-end sm:justify-start">
                                            @if($isLocked)
                                                <button type="button" 
                                                        onclick="showMateriLockedAlert('{{ addslashes($lockedBy) }}')"
                                                        class="w-full sm:w-auto justify-center px-4 py-2 bg-slate-100 hover:bg-slate-200/80 text-slate-500 border border-slate-200 text-xs font-bold rounded-xl transition flex items-center gap-1.5 shadow-2xs cursor-pointer"
                                                        title="Materi terkunci">
                                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                                    <span>Terkunci</span>
                                                </button>
                                            @else
                                                <!-- Tombol: Mulai Baca / Baca Lagi Materi -->
                                                <a href="{{ route('siswa.materi.baca', $m->id_materi) }}"
                                                   @if(!$sudahSelesai) onclick="return confirmBukaMateri(event, '{{ route('siswa.materi.baca', $m->id_materi) }}')" @endif
                                                   class="w-full sm:w-auto justify-center px-4 py-2 {{ $sudahSelesai ? 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' : 'bg-[#018ABE] text-white hover:bg-[#02457A] shadow-sm' }} text-xs font-bold rounded-xl transition flex items-center gap-1.5"
                                                   title="Pelajari materi">
                                                    <span>{{ $sudahSelesai ? 'Baca Lagi' : 'Mulai Baca' }}</span>
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-4 text-center text-xs text-slate-400">
                                        Belum ada materi pada bab ini.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @empty
                        <div class="py-6 text-center text-xs text-slate-400">
                            Belum ada bab untuk kategori ini.
                        </div>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl p-12 text-center border border-slate-200">
                <p class="text-slate-500 font-semibold">Belum ada materi pembelajaran</p>
            </div>
        @endforelse
    </div>

</div>
@endsection

@push('scripts')
<script>
function toggleBab(babId) {
    const container = document.getElementById('materi-container-' + babId);
    const arrow = document.getElementById('arrow-' + babId);
    if (!container) return;

    if (container.classList.contains('hidden')) {
        container.classList.remove('hidden');
        if (arrow) arrow.classList.add('rotate-180');
    } else {
        container.classList.add('hidden');
        if (arrow) arrow.classList.remove('rotate-180');
    }
}

const katStyleMap = {
    'speaking': {
        active: ['bg-rose-100', 'border-rose-600', 'border-2', 'text-rose-900', 'ring-2', 'ring-rose-300', 'ring-offset-1', 'font-extrabold'],
        inactive: ['bg-white', 'border', 'border-rose-500', 'text-rose-600', 'font-bold']
    },
    'writing': {
        active: ['bg-blue-100', 'border-blue-600', 'border-2', 'text-blue-900', 'ring-2', 'ring-blue-300', 'ring-offset-1', 'font-extrabold'],
        inactive: ['bg-white', 'border', 'border-blue-500', 'text-blue-600', 'font-bold']
    },
    'reading': {
        active: ['bg-emerald-100', 'border-emerald-600', 'border-2', 'text-emerald-900', 'ring-2', 'ring-emerald-300', 'ring-offset-1', 'font-extrabold'],
        inactive: ['bg-white', 'border', 'border-emerald-500', 'text-emerald-600', 'font-bold']
    },
    'listening': {
        active: ['bg-purple-100', 'border-purple-600', 'border-2', 'text-purple-900', 'ring-2', 'ring-purple-300', 'ring-offset-1', 'font-extrabold'],
        inactive: ['bg-white', 'border', 'border-purple-500', 'text-purple-600', 'font-bold']
    },
    'all': {
        active: ['bg-gradient-to-r', 'from-[#02457A]', 'to-[#018ABE]', 'border-2', 'border-[#018ABE]/40', 'text-white', 'shadow-sm', 'shadow-[#018ABE]/25', 'ring-2', 'ring-[#018ABE]/30', 'ring-offset-1', 'font-extrabold'],
        inactive: ['bg-white', 'border', 'border-slate-300', 'text-slate-700', 'font-bold']
    }
};

function filterKategori(katNama, btn) {
    const targetKey = (katNama || 'all').toLowerCase();

    // Reset all buttons to inactive state
    document.querySelectorAll('.kat-filter-btn').forEach(b => {
        const k = (b.dataset.cat || 'all').toLowerCase();
        const conf = katStyleMap[k] || katStyleMap['all'];
        b.classList.remove(...conf.active);
        b.classList.add(...conf.inactive);
    });

    // Apply active state to clicked button
    const activeConf = katStyleMap[targetKey] || katStyleMap['all'];
    btn.classList.remove(...activeConf.inactive);
    btn.classList.add(...activeConf.active);

    // Filter category sections
    document.querySelectorAll('.kategori-section').forEach(sec => {
        const cat = (sec.getAttribute('data-category') || '').toLowerCase();
        if (targetKey === 'all' || cat === targetKey) {
            sec.style.display = '';
        } else {
            sec.style.display = 'none';
        }
    });
}

function showMateriLockedAlert(prevTitle) {
    Swal.fire({
        icon: 'warning',
        title: 'Materi Masih Terkunci! 🔒',
        html: `Untuk membuka materi ini, kamu harus menyelesaikan kuis pada materi <b>"${prevTitle}"</b> terlebih dahulu. Tetap semangat belajar ya! ✨`,
        confirmButtonText: 'Mengerti',
        customClass: {
            popup: 'englify-swal',
            confirmButton: 'englify-swal-confirm'
        }
    });
}

@if(session('error'))
Swal.fire({
    icon: 'warning',
    title: 'Akses Dibatasi! 🔒',
    text: '{{ session('error') }}',
    confirmButtonText: 'Oke',
    customClass: {
        popup: 'englify-swal',
        confirmButton: 'englify-swal-confirm'
    }
});
@endif
</script>
@endpush

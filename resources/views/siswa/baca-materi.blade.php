@extends('layouts.siswa')

@section('title', $materi->judul ?? 'Materi')

@section('content')
@if(empty($sudahSelesaiQuiz))
<!-- PENGUNCIAN HALAMAN MATERI AGAR USER TIDAK BISA KELUAR / TEKAN NAVBAR SEBELUM QUIZ SELESAI -->
<style>
    /* Sembunyikan & nonaktifkan navbar header, sidebar desktop, mobile drawer, search bar, dan bottom docked nav */
    #sidebar, 
    #mobile-sidebar, 
    #mobile-backdrop, 
    header, 
    nav.fixed.bottom-0, 
    #mobileSearchWrapper,
    footer {
        display: none !important;
    }

    /* Pastikan padding halaman rapi dan fokus */
    main {
        padding-top: 1.5rem !important;
        padding-bottom: 3.5rem !important;
    }
</style>
@endif

<div class="max-w-5xl mx-auto space-y-6">

    <!-- HEADER -->
    <div class="flex items-center gap-3 sm:gap-4">
        <div class="flex-1 min-w-0">
            <h1 class="text-lg sm:text-2xl font-extrabold text-slate-800 break-words leading-tight content-text-wrap" style="overflow-wrap: anywhere; word-break: break-word;">{{ $materi->judul ?? 'Materi' }}</h1>
            <p class="text-slate-500 text-xs sm:text-sm mt-0.5 truncate">{{ $materi->kategori?->nama_kategori ?? '-' }} • {{ $materi->babModel?->judul ?? $materi->bab ?? '' }}</p>
        </div>
        @if(!empty($sudahSelesaiQuiz))
            <div class="hidden sm:flex items-center gap-2 px-4 py-2 bg-emerald-50 border border-emerald-200 rounded-xl shrink-0">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-xs font-bold text-emerald-700">Materi & Quiz Selesai</span>
            </div>
        @else
            <div class="hidden sm:flex items-center gap-2 px-4 py-2 bg-amber-50 border border-amber-200 rounded-xl shrink-0">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                <span class="text-xs font-bold text-amber-700">Mode Belajar Terkunci</span>
            </div>
        @endif
    </div>

    @if(empty($sudahSelesaiQuiz))
        <!-- BANNER MODE FOKUS TERKUNCI -->
        <div class="p-3.5 sm:p-4 rounded-2xl bg-amber-50 border border-amber-200/90 text-amber-900 flex items-center justify-between gap-3 shadow-xs">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 font-bold text-base shadow-xs">
                    🔒
                </div>
                <div class="min-w-0">
                    <p class="text-xs sm:text-sm font-bold leading-tight">Halaman Materi Sedang Terkunci</p>
                    <p class="text-[11px] sm:text-xs text-amber-700 mt-0.5">Selesaikan membaca materi ini dan kerjakan kuis dengan menekan tombol <strong>"Lanjut ke Quiz"</strong> di bawah sebelum kamu dapat keluar.</p>
                </div>
            </div>
            <span class="hidden sm:inline-flex px-3 py-1 rounded-full text-[11px] font-extrabold bg-amber-200/80 text-amber-900 shrink-0">
                Quiz Wajib Selesai
            </span>
        </div>
    @endif

    <!-- MAIN CONTENT CARD -->
    <div class="bg-white rounded-2xl border border-[#97CADB]/30 shadow-sm overflow-hidden">

        <!-- Banner -->
        <div class="w-full h-36 sm:h-48 bg-gradient-to-br from-[#D6EBEE] to-[#97CADB]/30 flex items-center justify-center relative overflow-hidden">
            <div class="absolute top-4 right-8 text-[#97CADB] text-xs opacity-60">✧</div>
            <div class="absolute bottom-4 left-12 text-[#97CADB] text-xs opacity-60">✦</div>
            <div class="text-center relative z-10">
                <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto mb-2 sm:mb-3 rounded-2xl bg-white/80 backdrop-blur flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <p class="font-cute text-xl sm:text-2xl text-[#018ABE]">Let's Learn! 📚</p>
            </div>
        </div>

        <!-- Content -->
        <div class="p-4 sm:p-8">
            <!-- Meta Info -->
            @php
                $catColors = [
                    'Speaking'  => 'bg-rose-50 text-rose-700 border-rose-200',
                    'Writing'   => 'bg-blue-50 text-blue-700 border-blue-200',
                    'Reading'   => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                    'Listening' => 'bg-purple-50 text-purple-700 border-purple-200',
                ];
                $badgeStyle = $catColors[$materi->kategori?->nama_kategori] ?? 'bg-slate-50 text-slate-700 border-slate-200';
            @endphp
            <div class="flex flex-wrap items-center gap-3 mb-6 pb-6 border-b border-[#97CADB]/20">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold border {{ $badgeStyle }}">
                    {{ $materi->kategori?->nama_kategori ?? 'Materi' }}
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-[#D6EBEE] text-[#02457A] border border-[#97CADB]/40">
                    {{ $materi->babModel?->judul ?? $materi->bab ?? 'Bab' }}
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                    ~10 menit baca
                </span>
            </div>

            <!-- Materi Content -->
            <div class="space-y-6">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight break-words content-text-wrap" style="overflow-wrap: anywhere; word-break: break-word;">📚 {{ $materi->judul ?? 'Materi' }}</h2>
                </div>

                <!-- Deskripsi Materi -->
                @if(!empty($materi->deskripsi))
                    <div class="p-4.5 rounded-2xl bg-gradient-to-r from-blue-50/70 via-white to-slate-50 border border-[#97CADB]/40 shadow-2xs max-w-full overflow-hidden">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-xl bg-[#018ABE]/10 text-[#018ABE] flex items-center justify-center shrink-0 mt-0.5 font-bold text-sm">
                                💬
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-[#02457A] mb-1">Deskripsi & Pengantar</h3>
                                <p class="text-sm text-slate-700 leading-relaxed font-normal break-words content-text-wrap" style="overflow-wrap: anywhere; word-break: break-word;">
                                    {{ $materi->deskripsi }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Gambar Ilustrasi Materi -->
                @if(!empty($materi->gambar) && file_exists(public_path($materi->gambar)))
                    <div class="rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm bg-slate-50 group">
                        <div class="px-4 py-2.5 bg-slate-50 border-b border-slate-100 flex items-center justify-between text-xs text-slate-600">
                            <span class="flex items-center gap-1.5 font-semibold text-slate-700">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Gambar Ilustrasi Materi
                            </span>
                            <a href="{{ asset($materi->gambar) }}" target="_blank" class="text-xs text-blue-600 hover:text-blue-800 font-bold transition flex items-center gap-1">
                                <span>Lihat Ukuran Penuh</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
                        <div class="p-2 sm:p-4 bg-slate-100/40 flex items-center justify-center">
                            <img src="{{ asset($materi->gambar) }}" alt="{{ $materi->judul }}" class="max-h-[460px] w-auto max-w-full rounded-xl object-contain shadow-xs">
                        </div>
                    </div>
                @endif

                <!-- Konten Utama Materi -->
                <div class="space-y-2">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Isi Materi Pembelajaran</h3>
                    <div class="text-slate-800 leading-relaxed text-base whitespace-pre-line break-words content-text-wrap bg-slate-50/50 rounded-2xl p-5 sm:p-6 border border-slate-200/60 shadow-2xs max-w-full overflow-hidden" style="overflow-wrap: anywhere; word-break: break-word;">
                        {!! nl2br(e($materi->isi_materi ?? $materi->konten ?? 'Belum ada konten tertulis untuk materi ini.')) !!}
                    </div>
                </div>

                <!-- Video / URL Sumber Pembelajaran (Multiple URLs Support) -->
                @php
                    $urls = $materi->urls_list ?? [];
                @endphp
                @if(!empty($urls))
                    <div class="space-y-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Sumber & Referensi Pembelajaran</h3>
                        @foreach($urls as $idx => $urlItem)
                            @php
                                $youtubeId = null;
                                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $urlItem, $matches)) {
                                    $youtubeId = $matches[1];
                                }
                            @endphp
                            <div class="rounded-2xl border {{ $youtubeId ? 'border-red-200/80 bg-gradient-to-br from-white via-rose-50/20 to-red-50/30' : 'border-[#97CADB]/50 bg-gradient-to-br from-white to-[#D6EBEE]/20' }} p-5 shadow-xs">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl {{ $youtubeId ? 'bg-red-600 text-white shadow-sm shadow-red-500/30' : 'bg-blue-600 text-white shadow-sm' }} flex items-center justify-center shrink-0">
                                            @if($youtubeId)
                                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-extrabold uppercase tracking-wider {{ $youtubeId ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                                                {{ $youtubeId ? 'Video YouTube' : 'Tautan Sumber' }} {{ count($urls) > 1 ? '#' . ($idx + 1) : '' }}
                                            </span>
                                            <h4 class="text-sm font-bold text-slate-800 mt-0.5">
                                                {{ $youtubeId ? 'Video Pembelajaran Pendukung' : 'Referensi Materi Tambahan' }}
                                            </h4>
                                        </div>
                                    </div>
                                    <a href="{{ $urlItem }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-2xs shrink-0">
                                        <span>Buka Tautan Sumber</span>
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </div>

                                @if($youtubeId)
                                    <div class="relative w-full aspect-video rounded-xl overflow-hidden shadow-md mt-3 bg-slate-900 border border-slate-800">
                                        <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/{{ $youtubeId }}" title="{{ $materi->judul }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Lampiran Dokumen File -->
                @if(!empty($materi->file) && file_exists(public_path($materi->file)))
                    @php
                        $ext = strtolower(pathinfo($materi->file, PATHINFO_EXTENSION));
                        $fileName = basename($materi->file);
                    @endphp
                    <div class="p-4 rounded-2xl bg-gradient-to-r from-blue-50/80 to-slate-50 border border-blue-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-11 h-11 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-extrabold uppercase tracking-wider bg-blue-100 text-blue-700">
                                    Dokumen {{ strtoupper($ext) }}
                                </span>
                                <p class="text-sm font-bold text-slate-800 truncate max-w-sm sm:max-w-md mt-0.5">{{ $fileName }}</p>
                            </div>
                        </div>
                        <a href="{{ asset($materi->file) }}" target="_blank" download class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition flex items-center justify-center gap-1.5 shadow-sm shadow-blue-500/20 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Unduh Dokumen</span>
                        </a>
                    </div>
                @endif

                <!-- Dynamic Contoh (Hanya jika admin mengisi contoh) -->
                @if(!empty($materi->contoh))
                    <div class="p-5 bg-[#D6EBEE] border-l-4 border-[#018ABE] rounded-r-2xl shadow-2xs max-w-full overflow-hidden">
                        <p class="text-sm font-bold text-[#001B48] mb-2 flex items-center gap-1.5">
                            <span>💡</span> Contoh:
                        </p>
                        <div class="text-sm text-[#02457A] leading-relaxed whitespace-pre-line break-words content-text-wrap" style="overflow-wrap: anywhere; word-break: break-word;">
                            {!! nl2br(e($materi->contoh)) !!}
                        </div>
                    </div>
                @endif

                <!-- Dynamic Tips (Hanya jika admin mengisi tips) -->
                @if(!empty($materi->tips))
                    <div class="p-5 bg-amber-50 border-l-4 border-amber-500 rounded-r-2xl shadow-2xs max-w-full overflow-hidden">
                        <p class="text-sm font-bold text-amber-800 mb-2 flex items-center gap-1.5">
                            <span>⭐</span> Tips Belajar:
                        </p>
                        <div class="text-sm text-amber-800 leading-relaxed whitespace-pre-line break-words content-text-wrap" style="overflow-wrap: anywhere; word-break: break-word;">
                            {!! nl2br(e($materi->tips)) !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- NAVIGATION BUTTONS -->
    <div class="flex flex-col sm:flex-row items-center {{ !empty($sudahSelesaiQuiz) ? 'justify-between' : 'justify-end' }} gap-4">
        @if(!empty($sudahSelesaiQuiz))
            <a href="{{ route('siswa.materi') }}" class="w-full sm:w-auto px-6 py-3 bg-white border-2 border-[#97CADB]/30 text-slate-700 font-semibold rounded-xl hover:border-slate-300 hover:bg-slate-50 transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Daftar Materi
            </a>
            <!-- Sudah selesai kuis: Cukup buka dan baca materi, TIDAK menayangkan lanjut ke quiz lagi -->
            @if(!empty($hasilQuiz))
                <a href="{{ route('siswa.quiz.hasil', $hasilQuiz->id_quiz) }}" class="w-full sm:w-auto px-5 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-2xs">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Lihat Hasil Quiz ({{ $hasilQuiz->skor_diperoleh ?? 100 }}/100)</span>
                </a>
            @endif
        @elseif($targetQuiz)
            <!-- Belum selesai kuis: Muncul tombol lanjut kuis (satu-satunya tombol navigasi keluar resmi) -->
            <a href="{{ route('siswa.quiz.kerjakan', $targetQuiz->id_quiz) }}" id="btnLanjutKeQuiz" class="btn-lanjut-quiz w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-[#018ABE] to-[#02457A] hover:from-[#02457A] hover:to-[#001B48] text-white font-semibold rounded-xl transition flex items-center justify-center gap-2 shadow-lg shadow-[#018ABE]/30">
                <span>Lanjut ke Quiz</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        @else
            <!-- Materi tanpa kuis -->
            <a href="{{ route('siswa.peta-quiz') }}" id="btnLanjutKeQuiz" class="btn-lanjut-quiz w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-[#018ABE] to-[#02457A] hover:from-[#02457A] hover:to-[#001B48] text-white font-semibold rounded-xl transition flex items-center justify-center gap-2 shadow-lg shadow-[#018ABE]/30">
                <span>Lihat Peta Quiz</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        @endif
    </div>

    <!-- CAT MASCOT -->
    <div class="bg-gradient-to-br from-[#D6EBEE] to-[#97CADB]/30 rounded-2xl p-4 sm:p-6 border border-[#97CADB]/40 flex flex-col sm:flex-row items-center text-center sm:text-left gap-3.5 sm:gap-4">
        <img src="{{ asset('images/cat-welcome.png') }}" alt="Cat" class="w-16 sm:w-20 h-auto shrink-0">
        <div>
            @if(!empty($sudahSelesaiQuiz))
                <p class="font-cute text-base sm:text-lg text-emerald-700 leading-tight">Hebat! Kamu sudah menyelesaikan materi dan quiz ini. 🌟</p>
                <p class="text-xs sm:text-sm text-slate-600 mt-1">Materi ini dapat kamu buka dan baca kembali kapan saja sebagai bahan referensi belajar. ✨</p>
            @elseif($targetQuiz)
                <p class="font-cute text-base sm:text-lg text-[#018ABE] leading-tight">Hebat! Kamu sedang membaca materi ini.</p>
                <p class="text-xs sm:text-sm text-slate-600 mt-1">Selesaikan membaca dan klik <strong>"Lanjut ke Quiz"</strong> untuk menguji pemahamanmu! 💪</p>
            @else
                <p class="font-cute text-base sm:text-lg text-[#018ABE] leading-tight">Hebat! Kamu sudah membaca materi ini.</p>
                <p class="text-xs sm:text-sm text-slate-600 mt-1">Lanjutkan pembelajaranmu ke materi atau bab berikutnya! 📚</p>
            @endif
        </div>
    </div>

</div>

@if(empty($sudahSelesaiQuiz))
@push('scripts')
<script>
(function() {
    let canLeave = false;

    // 1. Tombol resmi "Lanjut ke Quiz" memberi izin navigasi
    const btnQuiz = document.getElementById('btnLanjutKeQuiz');
    if (btnQuiz) {
        btnQuiz.addEventListener('click', function() {
            canLeave = true;
            if (typeof window.startPageLoader === 'function') {
                window.startPageLoader();
            }
        });
    }

    // 2. Blokir tombol Back di browser / history popstate
    history.pushState(null, null, location.href);
    window.addEventListener('popstate', function() {
        history.pushState(null, null, location.href);
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Halaman Terkunci! 🔒',
                html: '<p class="text-sm text-slate-600 leading-relaxed">Kamu tidak bisa keluar dari halaman materi sebelum selesai membaca dan mengerjakan kuis.</p>',
                confirmButtonText: 'Lanjut Membaca Materi',
                buttonsStyling: false,
                customClass: {
                    popup: 'englify-swal',
                    confirmButton: 'englify-swal-confirm'
                }
            });
        }
    });

    // 3. Blokir reload atau berpindah URL langsung dari browser
    window.addEventListener('beforeunload', function(e) {
        if (!canLeave) {
            e.preventDefault();
            e.returnValue = '';
            return '';
        }
    });

    // 4. Blokir klik pada tautan keluar selain kuis atau unduh dokumen materi
    document.addEventListener('click', function(e) {
        const a = e.target.closest('a');
        if (!a) return;

        // Izinkan jika tombol lanjut ke quiz
        if (a.id === 'btnLanjutKeQuiz' || a.classList.contains('btn-lanjut-quiz')) {
            canLeave = true;
            return;
        }

        // Izinkan jika tombol unduh dokumen materi (download file)
        if (a.hasAttribute('download') || a.getAttribute('target') === '_blank') {
            return;
        }

        // Blokir tautan lainnya
        e.preventDefault();
        e.stopPropagation();

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Selesaikan Materi & Kuis 📚',
                html: '<p class="text-sm text-slate-600 leading-relaxed">Kamu tidak bisa keluar dari halaman materi sebelum selesai membaca dan mengerjakan kuis.</p>',
                confirmButtonText: 'Lanjut Membaca',
                buttonsStyling: false,
                customClass: {
                    popup: 'englify-swal',
                    confirmButton: 'englify-swal-confirm'
                }
            });
        }
    }, true);
})();
</script>
@endpush
@endif
@endsection

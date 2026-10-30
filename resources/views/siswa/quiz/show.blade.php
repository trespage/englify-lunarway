@extends('layouts.siswa')

@section('title', 'Kerjakan Quiz')

@section('content')
<!-- PENGUNCIAN HALAMAN KUIS AGAR SISWA TIDAK BISA KELUAR ATAU TEKAN NAVBAR -->
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

    main {
        padding-top: 1.5rem !important;
        padding-bottom: 3.5rem !important;
    }
</style>

<div class="max-w-4xl mx-auto space-y-6">

    @php
        $targetMateri = $quiz->materi ?? ($quiz->id_materi ? \App\Models\Materi::find($quiz->id_materi) : null);
        $judulMateri = $targetMateri?->judul ?? ($quiz->judul ?? 'Materi');
        $durasiMenit = $durasiMenit ?? 15;
        $menitFormatted = str_pad($durasiMenit, 2, '0', STR_PAD_LEFT) . ':00';
    @endphp

    <!-- BANNER MODE KUIS TERKUNCI -->
    <div class="p-3.5 sm:p-4 rounded-2xl bg-amber-50 border border-amber-200/90 text-amber-900 flex items-center justify-between gap-3 shadow-xs">
        <div class="flex items-center gap-3 min-w-0">
            <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 font-bold text-base shadow-xs">
                🔒
            </div>
            <div class="min-w-0">
                <p class="text-xs sm:text-sm font-bold leading-tight">Halaman Kuis Sedang Terkunci</p>
                <p class="text-[11px] sm:text-xs text-amber-700 mt-0.5">Selesaikan seluruh soal dan tekan tombol <strong>"Kirim Jawaban"</strong> untuk mengumpulkan kuis sebelum kamu dapat membuka halaman lain.</p>
            </div>
        </div>
        <span class="hidden sm:inline-flex px-3 py-1 rounded-full text-[11px] font-extrabold bg-amber-200/80 text-amber-900 shrink-0">
            Kuis Wajib Selesai
        </span>
    </div>

    <!-- HEADER + PROGRESS -->
    <div class="bg-white rounded-2xl p-5 sm:p-6 border border-[#97CADB]/30 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-xl bg-[#97CADB] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-[#02457A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <h1 class="text-lg sm:text-xl font-extrabold text-slate-800 truncate">Quiz – {{ $quiz->judul ?? $judulMateri }}</h1>
                    <p class="text-xs text-slate-500 mt-0.5">Materi: <strong class="text-slate-700 font-semibold">{{ $judulMateri }}</strong></p>
                </div>
            </div>
            <div class="flex items-center gap-2 self-end sm:self-center shrink-0">
                <div class="flex items-center gap-2 px-3.5 py-1.5 sm:px-4 sm:py-2 bg-rose-50 border border-rose-200 rounded-xl shrink-0" title="Batas waktu pengerjaan quiz">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-rose-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-base sm:text-lg font-bold text-rose-600 tabular-nums" id="timer">{{ $menitFormatted }}</span>
                </div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold text-slate-600" id="progressText">Soal 1 dari {{ $soal->count() }}</span>
            <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                <div id="progressBar" class="h-full bg-gradient-to-r from-[#018ABE] to-[#02457A] rounded-full transition-all duration-500" style="width: 0%"></div>
            </div>
            <span class="text-xs font-bold text-slate-600" id="progressPercent">0%</span>
        </div>
    </div>

    <!-- FORM QUIZ -->
    <form id="quizForm" method="POST" action="{{ route('siswa.quiz.submit', $quiz->id_quiz ?? 1) }}" class="bg-white rounded-2xl border border-[#97CADB]/30 shadow-sm overflow-hidden">
        @csrf

        <!-- Pertanyaan Area -->
        <div id="questionContainer">
            <!-- Audio Passage Persisten (Tetap jalan jika 1 audio dipakai beberapa soal berturut-turut) -->
            <div id="audioPassageContainer" class="hidden"></div>
            <!-- Konten Pertanyaan & Pilihan Jawaban -->
            <div id="questionBodyContainer"></div>
        </div>

        <!-- Navigation Buttons -->
        <div class="px-4 sm:px-6 py-3.5 sm:py-4 bg-slate-50 border-t border-[#97CADB]/20 flex items-center justify-between gap-2">
            <button type="button" id="btnPrev" onclick="prevQuestion()" class="px-3.5 sm:px-6 py-2 sm:py-2.5 text-xs sm:text-sm bg-white border-2 border-[#97CADB]/30 text-slate-700 font-semibold rounded-xl hover:border-slate-300 hover:bg-slate-50 transition flex items-center gap-1.5 sm:gap-2 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer shrink-0">
                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <span>Sebelumnya</span>
            </button>

            <div class="flex gap-1.5 sm:gap-2 max-w-[130px] sm:max-w-none overflow-x-auto scrollbar-hide py-1 px-1 items-center" id="questionDots">
                <!-- Dots akan di-render via JavaScript -->
            </div>

            <button type="button" id="btnNext" onclick="nextQuestion()" class="px-3.5 sm:px-6 py-2 sm:py-2.5 text-xs sm:text-sm bg-[#018ABE] hover:bg-[#02457A] text-white font-semibold rounded-xl transition flex items-center gap-1.5 sm:gap-2 shadow-lg shadow-[#018ABE]/30 cursor-pointer shrink-0">
                <span id="btnNextText">Selanjutnya</span>
                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </form>

    <!-- INFO BOX -->
    <div class="bg-[#D6EBEE] border border-[#97CADB]/40 rounded-2xl p-4 flex items-start gap-3">
        <svg class="w-5 h-5 text-[#018ABE] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <p class="text-xs font-bold text-[#001B48] mb-1">Tips Mengerjakan Quiz:</p>
            <p class="text-xs text-[#02457A]">
                Baca pertanyaan dengan teliti sebelum memilih jawaban. Kamu bisa kembali ke soal sebelumnya dengan menekan tombol "Sebelumnya".
            </p>
        </div>
    </div>

</div>

<!-- ===================================================== -->
<!-- MODAL KONFIRMASI SUBMIT                                -->
<!-- ===================================================== -->
<div id="confirmModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-5 sm:p-6 text-center">
        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-[#97CADB] flex items-center justify-center mx-auto mb-3 sm:mb-4">
            <svg class="w-7 h-7 sm:w-8 sm:h-8 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h3 class="text-lg sm:text-xl font-bold text-slate-800 mb-2">Kirim Jawaban?</h3>
        <p class="text-slate-500 text-xs sm:text-sm mb-5 sm:mb-6">Pastikan semua jawaban sudah terisi. Kamu tidak bisa mengubah jawaban setelah submit.</p>

        <div class="flex gap-3">
            <button onclick="closeConfirmModal()" class="flex-1 px-4 py-2.5 sm:py-3 border border-[#97CADB]/30 text-slate-700 text-xs sm:text-sm font-semibold rounded-xl hover:bg-slate-50 transition cursor-pointer">
                Batal
            </button>
            <button onclick="submitQuiz()" class="flex-1 px-4 py-2.5 sm:py-3 bg-[#018ABE] text-white text-xs sm:text-sm font-semibold rounded-xl hover:bg-[#02457A] shadow-lg shadow-[#018ABE]/30 transition cursor-pointer">
                Ya, Kirim!
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// =============================================
// DATA SOAL (dari database)
// =============================================
const rawQuestions = @json($questionsPayload ?? []);

// Normalisasi opsi & acak urutan pilihan jawaban per siswa
function getNormalizedOptions(q) {
    if (Array.isArray(q.options)) {
        return q.options.map(o => typeof o === 'object' && o !== null ? o : { key: o, text: o });
    }
    return Object.entries(q.options || {}).map(([key, text]) => ({ key, text }));
}

function shuffleArray(arr) {
    const copy = [...arr];
    for (let i = copy.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [copy[i], copy[j]] = [copy[j], copy[i]];
    }
    return copy;
}

// Inisialisasi setiap pertanyaan dengan opsi yang diacak (bebas label A, B, C, D)
const questions = rawQuestions.map(q => ({
    ...q,
    shuffledOptions: shuffleArray(getNormalizedOptions(q))
}));

// =============================================
// STATE
// =============================================
let currentQuestion = 0;
let answers = {};
let isQuizSubmitted = false;
let currentPlayingAudio = null;

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text || '';
    return div.innerHTML;
}

// =============================================
// RENDER AUDIO PASSAGE (PERSISTEN ANTAR SOAL BERURUTAN)
// =============================================
function renderAudioPassage(q) {
    const audioContainer = document.getElementById('audioPassageContainer');
    if (!audioContainer) return;

    if (!q.audio) {
        audioContainer.classList.add('hidden');
        const existingAudio = document.getElementById('quizAudioPlayer');
        if (existingAudio) {
            existingAudio.pause();
        }
        currentPlayingAudio = null;
        return;
    }

    audioContainer.classList.remove('hidden');

    const isSameAudio = (currentPlayingAudio === q.audio);
    currentPlayingAudio = q.audio;

    if (isSameAudio) {
        // Audio passage sama: JANGAN destroy element audio agar playback tidak terputus!
        const titleEl = document.getElementById('audioPassageTitle');
        const rangeEl = document.getElementById('audioPassageRange');
        const petunjukEl = document.getElementById('audioPassagePetunjuk');
        if (titleEl) titleEl.textContent = q.audio_title || 'Listening Audio Passage';
        if (rangeEl && q.passage_range) rangeEl.textContent = q.passage_range;
        if (petunjukEl) petunjukEl.textContent = q.audio_petunjuk || 'Dengarkan rekaman audio berikut dengan cermat untuk menjawab pertanyaan.';
        return;
    }

    // Audio passage baru: Render player baru
    audioContainer.innerHTML = `
        <div class="p-4 sm:p-5 bg-gradient-to-r from-purple-50 via-indigo-50/40 to-blue-50 border-b border-purple-200/70">
            <div class="flex items-start justify-between gap-3 mb-2.5">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-9 h-9 rounded-xl bg-purple-600 text-white flex items-center justify-center shrink-0 shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M18.364 5.636a9 9 0 010 12.728M12 18.75V5.25L7.5 9.75H4.5v4.5h3L12 18.75z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h4 id="audioPassageTitle" class="text-xs sm:text-sm font-extrabold text-purple-950 truncate">${escapeHtml(q.audio_title || 'Listening Audio Passage')}</h4>
                            ${q.passage_range ? `<span id="audioPassageRange" class="px-2.5 py-0.5 rounded-full bg-purple-200 text-purple-800 text-[10px] font-bold shrink-0">${escapeHtml(q.passage_range)}</span>` : ''}
                            ${q.is_shared_passage ? `<span class="px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-700 text-[10px] font-semibold hidden sm:inline-block shrink-0">Audio Bersama (Dialog Terkait)</span>` : ''}
                        </div>
                        <p id="audioPassagePetunjuk" class="text-[11px] text-purple-700 mt-0.5">${escapeHtml(q.audio_petunjuk || 'Dengarkan rekaman audio berikut dengan cermat untuk menjawab pertanyaan.')}</p>
                    </div>
                </div>
            </div>

            <!-- Audio Player Controller -->
            <div class="mt-2.5 bg-white/95 p-3 rounded-xl border border-purple-200 shadow-2xs">
                <audio id="quizAudioPlayer" controls class="w-full h-9" preload="auto">
                    <source src="${q.audio}" type="audio/mpeg">
                    Browser kamu tidak mendukung pemutar audio HTML5.
                </audio>
            </div>
        </div>
    `;
}

// =============================================
// RENDER SOAL (Tanpa Label Abjad Kaku A, B, C, D)
// =============================================
function renderQuestion() {
    const container = document.getElementById('questionContainer');
    const bodyContainer = document.getElementById('questionBodyContainer');

    if (!questions || questions.length === 0) {
        if (container) {
            container.innerHTML = `
                <div class="p-6 sm:p-8 text-center text-slate-500">
                    <p class="font-bold text-base sm:text-lg mb-1 text-slate-700">Belum Ada Pertanyaan</p>
                    <p class="text-xs">Soal quiz untuk materi ini sedang disiapkan oleh pengajar.</p>
                </div>
            `;
        }
        document.getElementById('btnNext').disabled = true;
        document.getElementById('btnPrev').disabled = true;
        return;
    }

    const q = questions[currentQuestion];

    // Render Audio Passage (persisten jika audio sama dengan soal sebelumnya)
    renderAudioPassage(q);

    // Render Pertanyaan & Pilihan Jawaban
    bodyContainer.innerHTML = `
        <div class="p-4 sm:p-6 border-b border-[#97CADB]/20 bg-gradient-to-r from-[#D6EBEE] to-[#97CADB]/30">
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2.5 py-0.5 sm:py-1 bg-[#97CADB] text-[#02457A] text-[11px] sm:text-xs font-bold rounded-full">Soal ${currentQuestion + 1}</span>
                <span class="text-[11px] sm:text-xs text-slate-500">dari ${questions.length} soal</span>
            </div>
            <h3 class="font-bold text-slate-800 text-base sm:text-lg break-words leading-snug">
                ${q.question}
            </h3>
        </div>

        <!-- DAFTAR OPSI JAWABAN (BERSIH TANPA LABEL A, B, C, D) -->
        <div class="p-4 sm:p-6 space-y-3">
            ${q.shuffledOptions.map((opt) => {
                const isSelected = (answers[q.id] === opt.key);
                return `
                    <label class="quiz-option relative flex items-center justify-between gap-3 p-4 sm:p-4.5 border-2 ${isSelected ? 'border-[#018ABE] bg-[#D6EBEE]/60 shadow-sm ring-2 ring-[#018ABE]/20' : 'border-slate-200 hover:border-[#97CADB] hover:bg-slate-50/80 bg-white'} rounded-2xl cursor-pointer transition-all duration-200 group">
                        <div class="flex items-center gap-3.5 flex-1 min-w-0">
                            <!-- Custom Radio Circle Indicator -->
                            <div class="w-5 h-5 rounded-full border-2 ${isSelected ? 'border-[#018ABE] bg-[#018ABE]' : 'border-slate-300 group-hover:border-[#018ABE]/60 bg-white'} flex items-center justify-center shrink-0 transition-all duration-200">
                                ${isSelected ? '<div class="w-2 h-2 rounded-full bg-white"></div>' : ''}
                            </div>
                            <input type="radio" name="jawaban_${q.id}" value="${opt.key}"
                                   ${isSelected ? 'checked' : ''}
                                   onchange="selectAnswer(${q.id}, '${opt.key}')"
                                   class="sr-only">
                            <span class="text-xs sm:text-sm font-semibold ${isSelected ? 'text-[#001B48]' : 'text-slate-700 group-hover:text-slate-900'} break-words leading-relaxed">
                                ${opt.text}
                            </span>
                        </div>
                        ${isSelected ? `
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-[#018ABE] text-white shrink-0 shadow-xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Pilihanmu</span>
                            </span>
                        ` : ''}
                    </label>
                `;
            }).join('')}
        </div>
    `;

    // Update progress
    const progress = ((currentQuestion + 1) / questions.length) * 100;
    document.getElementById('progressBar').style.width = progress + '%';
    document.getElementById('progressText').textContent = `Soal ${currentQuestion + 1} dari ${questions.length}`;
    document.getElementById('progressPercent').textContent = Math.round(progress) + '%';

    // Update buttons
    document.getElementById('btnPrev').disabled = currentQuestion === 0;

    const btnNext = document.getElementById('btnNext');
    const btnNextText = document.getElementById('btnNextText');

    if (currentQuestion === questions.length - 1) {
        btnNextText.textContent = 'Submit';
        btnNext.onclick = showConfirmModal;
        btnNext.classList.remove('bg-[#018ABE]', 'hover:bg-[#02457A]', 'shadow-[#018ABE]/30');
        btnNext.classList.add('bg-emerald-600', 'hover:bg-emerald-700', 'shadow-emerald-600/30');
    } else {
        btnNextText.textContent = 'Selanjutnya';
        btnNext.onclick = nextQuestion;
        btnNext.classList.add('bg-[#018ABE]', 'hover:bg-[#02457A]', 'shadow-[#018ABE]/30');
        btnNext.classList.remove('bg-emerald-600', 'hover:bg-emerald-700', 'shadow-emerald-600/30');
    }

    // Render dots
    renderDots();
}

function renderDots() {
    const dotsContainer = document.getElementById('questionDots');
    dotsContainer.innerHTML = questions.map((_, idx) => `
        <button type="button" onclick="goToQuestion(${idx})"
                class="w-2.5 h-2.5 rounded-full transition ${idx === currentQuestion ? 'bg-[#018ABE] w-6' : answers[questions[idx].id] ? 'bg-emerald-400' : 'bg-slate-300'}">
        </button>
    `).join('');
}

function selectAnswer(questionId, answerKey) {
    if (isQuizSubmitted) return;
    answers[questionId] = answerKey;
    renderQuestion();
}

function nextQuestion() {
    if (currentQuestion < questions.length - 1) {
        currentQuestion++;
        renderQuestion();
    }
}

function prevQuestion() {
    if (currentQuestion > 0) {
        currentQuestion--;
        renderQuestion();
    }
}

function goToQuestion(idx) {
    currentQuestion = idx;
    renderQuestion();
}

function showConfirmModal() {
    if (isQuizSubmitted) return;
    // Cek apakah semua soal sudah dijawab
    const unanswered = questions.filter(q => !answers[q.id]).length;
    if (unanswered > 0) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Masih Ada Soal Belum Dijawab!',
                html: `<p class="text-sm text-slate-600 leading-relaxed">Masih ada <strong class="text-rose-600 font-bold">${unanswered} soal</strong> yang belum Anda jawab.<br>Apakah Anda yakin ingin menyelesaikan kuis sekarang?</p>`,
                showCancelButton: true,
                confirmButtonText: 'Ya, Lanjutkan Selesai',
                cancelButtonText: 'Lanjut Mengerjakan',
                buttonsStyling: false,
                customClass: {
                    popup: 'englify-swal',
                    confirmButton: 'englify-swal-confirm',
                    cancelButton: 'englify-swal-cancel'
                }
            }).then((res) => {
                if (res.isConfirmed) {
                    document.getElementById('confirmModal').classList.remove('hidden');
                    document.getElementById('confirmModal').classList.add('flex');
                }
            });
            return;
        }
    }
    document.getElementById('confirmModal').classList.remove('hidden');
    document.getElementById('confirmModal').classList.add('flex');
}

function closeConfirmModal() {
    const modal = document.getElementById('confirmModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}

function submitQuiz() {
    if (isQuizSubmitted) return;
    isQuizSubmitted = true;
    const player = document.getElementById('quizAudioPlayer');
    if (player) player.pause();
    executeSubmit();
}

// Eksekusi pengiriman form
function executeSubmit() {
    const form = document.getElementById('quizForm');
    
    // Hapus input hidden sebelumnya agar tidak terduplikasi
    form.querySelectorAll('input[type="hidden"][name^="jawaban_"]').forEach(el => el.remove());

    Object.entries(answers).forEach(([qid, answer]) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'jawaban_' + qid;
        input.value = answer;
        form.appendChild(input);
    });
    form.submit();
}

// =============================================
// PROTEKSI HALAMAN KUIS TERKUNCI (ANTI-EXIT)
// =============================================
// 1. Blokir tombol back di browser / smartphone
history.pushState(null, null, location.href);
window.addEventListener('popstate', function() {
    history.pushState(null, null, location.href);
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'warning',
            title: 'Kuis Sedang Berlangsung! 🔒',
            html: '<p class="text-sm text-slate-600 leading-relaxed">Kamu tidak bisa meninggalkan halaman kuis sebelum menyelesaikan dan mengumpulkan kuis.</p>',
            confirmButtonText: 'Lanjut Mengerjakan Kuis',
            buttonsStyling: false,
            customClass: {
                popup: 'englify-swal',
                confirmButton: 'englify-swal-confirm'
            }
        });
    }
});

// 2. Blokir reload / keluar halaman via browser
window.addEventListener('beforeunload', function(e) {
    if (!isQuizSubmitted) {
        e.preventDefault();
        e.returnValue = '';
        return '';
    }
});

// 3. Blokir semua link keluar selama kuis berjalan
document.addEventListener('click', function(e) {
    const a = e.target.closest('a');
    if (!a) return;
    if (isQuizSubmitted) return;

    e.preventDefault();
    e.stopPropagation();

    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'warning',
            title: 'Kuis Sedang Berlangsung! 🔒',
            html: '<p class="text-sm text-slate-600 leading-relaxed">Kamu harus menyelesaikan dan mengumpulkan kuis ini terlebih dahulu sebelum membuka halaman lain.</p>',
            confirmButtonText: 'Lanjut Mengerjakan',
            buttonsStyling: false,
            customClass: {
                popup: 'englify-swal',
                confirmButton: 'englify-swal-confirm'
            }
        });
    }
}, true);

// =============================================
// COUNTDOWN TIMER & AUTO-SUBMIT LOGIC
// =============================================
const durationMinutes = {{ (int) $durasiMenit }};
let timeLeft = durationMinutes * 60;
const timerElement = document.getElementById('timer');

const timerInterval = setInterval(() => {
    if (isQuizSubmitted) {
        clearInterval(timerInterval);
        return;
    }

    timeLeft--;
    if (timeLeft < 0) timeLeft = 0;

    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    timerElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

    if (timeLeft <= 60) {
        timerElement.classList.remove('text-rose-600');
        timerElement.classList.add('text-red-600', 'animate-pulse');
    }

    if (timeLeft <= 0) {
        clearInterval(timerInterval);
        handleTimeExpired();
    }
}, 1000);

// Penanganan waktu habis: Auto-Submit ke sistem & cegah siswa ubah jawaban
function handleTimeExpired() {
    if (isQuizSubmitted) return;
    isQuizSubmitted = true;

    // 1. Kunci form agar siswa tidak bisa memilih atau melanjutkan
    document.querySelectorAll('.quiz-option input').forEach(el => el.disabled = true);
    document.querySelectorAll('.quiz-option').forEach(el => {
        el.classList.add('pointer-events-none', 'opacity-60');
    });
    document.getElementById('btnNext').disabled = true;
    document.getElementById('btnPrev').disabled = true;
    closeConfirmModal();

    // 2. Beri peringatan otomatis & submit
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'warning',
            title: 'Waktu Kuis Telah Habis!',
            html: '<p class="text-sm text-slate-600 leading-relaxed">Waktu pengerjaan telah berakhir. Kuis otomatis dikumpulkan oleh sistem. Soal yang sempat Anda jawab dengan benar akan tetap dihitung.</p>',
            showConfirmButton: false,
            timer: 2200,
            allowOutsideClick: false,
            allowEscapeKey: false,
            customClass: {
                popup: 'englify-swal'
            }
        }).then(() => {
            executeSubmit();
        });
    } else {
        executeSubmit();
    }
}

// Init
renderQuestion();
</script>
@endpush

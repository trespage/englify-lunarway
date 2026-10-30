<!-- ===================================================== -->
<!-- MODAL DETAIL & HASIL QUIZ                              -->
<!-- ===================================================== -->
<div id="quizDetailModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="onBackdropClick(event)">
    <div class="bg-white rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl border border-slate-100 transform transition-all animate-in fade-in zoom-in-95 duration-200" onclick="event.stopPropagation()">
        
        <!-- Header Modal -->
        <div class="p-4 sm:p-6 bg-gradient-to-br from-[#D6EBEE] via-white to-blue-50/50 border-b border-slate-100 relative">
            <div class="flex items-start justify-between gap-3 sm:gap-4">
                <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                    <div id="modalIconContainer" class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-[#018ABE] text-white flex items-center justify-center shadow-md shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-1.5 sm:gap-2 mb-1 flex-wrap">
                            <span id="modalKategoriBadge" class="px-2 py-0.5 rounded-full text-[9px] sm:text-[10px] font-bold uppercase tracking-wider bg-white text-[#018ABE] border border-[#018ABE]/30 shadow-xs">
                                Kategori
                            </span>
                            <span id="modalBabLabel" class="text-[11px] sm:text-xs text-slate-500 font-semibold truncate max-w-[160px] sm:max-w-[200px]">
                                Bab 1
                            </span>
                        </div>
                        <h3 id="modalMateriJudul" class="text-base sm:text-xl font-extrabold text-[#001B48] leading-snug break-words">
                            Judul Materi
                        </h3>
                    </div>
                </div>
                <button type="button" onclick="closeQuizDetailModal()" class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-white/80 hover:bg-white text-slate-400 hover:text-slate-600 flex items-center justify-center shadow-xs transition shrink-0 cursor-pointer" aria-label="Tutup">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <!-- Body Modal -->
        <div class="p-4 sm:p-6 space-y-4 sm:space-y-5 max-h-[80vh] overflow-y-auto">
            <!-- 1. Ringkasan Total Soal & Total Poin -->
            <div>
                <p class="text-[11px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Informasi Quiz Materi</p>
                <div class="grid grid-cols-3 gap-2 sm:gap-2.5">
                    <div class="p-2 sm:p-3 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center gap-2 sm:gap-2.5">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[9px] sm:text-[10px] text-slate-500 font-medium truncate">Total Soal</p>
                            <p id="modalTotalSoal" class="text-xs sm:text-sm font-extrabold text-slate-800">0 Soal</p>
                        </div>
                    </div>

                    <div class="p-2 sm:p-3 rounded-xl bg-rose-50/70 border border-rose-200/80 flex items-center gap-2 sm:gap-2.5">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[9px] sm:text-[10px] text-rose-600 font-medium truncate">Batas Waktu</p>
                            <p id="modalDurasiKuis" class="text-xs sm:text-sm font-extrabold text-rose-800">15 Menit</p>
                        </div>
                    </div>

                    <div class="p-2 sm:p-3 rounded-xl bg-amber-50/70 border border-amber-200/80 flex items-center gap-2 sm:gap-2.5">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[9px] sm:text-[10px] text-amber-700 font-medium truncate">Total Poin</p>
                            <p id="modalTotalPoin" class="text-xs sm:text-sm font-extrabold text-amber-800">0 Poin</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Status Hasil Quiz Siswa -->
            <div>
                <p class="text-[11px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Hasil Quiz Anda</p>
                
                <!-- Kondisi A: Sudah Selesai -->
                <div id="modalStatusSudah" class="hidden p-3.5 sm:p-4 rounded-xl sm:rounded-2xl bg-emerald-50 border border-emerald-200">
                    <div class="flex items-center justify-between mb-2 flex-wrap gap-1">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 sm:py-1 rounded-full text-[11px] sm:text-xs font-bold bg-emerald-100 text-emerald-800">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Sudah Selesai
                        </span>
                        <span id="modalWaktuSelesai" class="text-[10px] sm:text-[11px] text-emerald-700 font-medium">
                            -
                        </span>
                    </div>
                    <div class="flex items-baseline gap-2 mt-1">
                        <span class="text-xs text-emerald-700 font-semibold">Skor:</span>
                        <span id="modalSkorAngka" class="text-2xl sm:text-3xl font-extrabold text-emerald-700">0</span>
                        <span class="text-xs sm:text-sm font-bold text-emerald-600">/ 100</span>
                    </div>
                </div>

                <!-- Kondisi B: Belum Pernah Dikerjakan -->
                <div id="modalStatusBelum" class="hidden p-3.5 sm:p-4 rounded-xl sm:rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center mx-auto mb-1.5 sm:mb-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p id="modalBelumTitle" class="text-xs sm:text-sm font-bold text-slate-700">Belum Ada Riwayat Quiz</p>
                    <p id="modalBelumDesc" class="text-[11px] sm:text-xs text-slate-500 mt-1">Anda belum mengerjakan quiz untuk materi ini.</p>
                </div>

                <!-- Kondisi C: Belum Ada Soal -->
                <div id="modalStatusKosong" class="hidden p-3.5 sm:p-4 rounded-xl sm:rounded-2xl bg-amber-50/70 border border-amber-200 text-center">
                    <p class="text-xs font-semibold text-amber-800">Quiz untuk materi ini belum ditambahkan oleh Admin.</p>
                </div>

                <!-- Kondisi D: Materi & Kuis Terkunci -->
                <div id="modalStatusTerkunci" class="hidden p-3.5 sm:p-4 rounded-xl sm:rounded-2xl bg-amber-50/80 border border-amber-200 text-center">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mx-auto mb-1.5 sm:mb-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <p class="text-xs sm:text-sm font-bold text-amber-900">Materi & Kuis Ini Masih Terkunci</p>
                    <p id="modalTerkunciDesc" class="text-[11px] sm:text-xs text-amber-700 mt-1">Selesaikan kuis pada materi sebelumnya terlebih dahulu untuk membuka materi ini.</p>
                </div>
            </div>

            <!-- 3. Tombol Aksi -->
            <div class="pt-2 flex flex-col sm:flex-row gap-2 sm:gap-2.5">
                <a id="modalBtnBacaMateri" href="#" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs sm:text-sm font-bold transition flex items-center justify-center gap-2 shadow-xs cursor-pointer">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span id="modalBtnBacaMateriText">Baca Materi</span>
                </a>

                <a id="modalBtnLihatHasil" href="#" class="hidden flex-1 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-bold transition shadow-md shadow-emerald-600/20 flex items-center justify-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Lihat Hasil Quiz
                </a>

                <a id="modalBtnKerjakanQuiz" href="#" class="hidden flex-1 px-4 py-2.5 rounded-xl bg-gradient-to-r from-[#018ABE] to-[#02457A] hover:from-[#02457A] hover:to-[#001B48] text-white text-xs sm:text-sm font-bold transition shadow-md shadow-blue-500/20 flex items-center justify-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span id="modalBtnKerjakanQuizText">Mulai Quiz</span>
                </a>

                <button type="button" id="modalBtnQuizLocked" class="hidden flex-1 px-4 py-2.5 rounded-xl bg-slate-100 border border-slate-200 text-slate-400 text-xs sm:text-sm font-bold transition flex items-center justify-center gap-2 cursor-pointer hover:bg-slate-200/80" onclick="window.showAestheticToast('Silakan baca materi pembelajaran terlebih dahulu untuk membuka quiz ini! 🐾', 'info')">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <span>Mulai Quiz (Terkunci)</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function openQuizDetailModal(target) {
    let data = target;
    if (target && target.dataset && target.dataset.quiz) {
        try {
            data = JSON.parse(target.dataset.quiz);
        } catch (e) {
            data = {};
        }
    } else if (typeof target === 'string') {
        try {
            data = JSON.parse(target);
        } catch (e) {
            data = {};
        }
    }
    data = data || {};

    const titleEl = document.getElementById('modalMateriJudul');
    if (titleEl) titleEl.textContent = data.judul_materi || 'Materi';

    const katBadge = document.getElementById('modalKategoriBadge');
    if (katBadge) katBadge.textContent = data.kategori || 'Kategori';

    const babLabel = document.getElementById('modalBabLabel');
    if (babLabel) babLabel.textContent = data.bab_judul || '';

    const totalSoalEl = document.getElementById('modalTotalSoal');
    if (totalSoalEl) totalSoalEl.textContent = (data.total_soal || 0) + ' Soal';

    const durasiEl = document.getElementById('modalDurasiKuis');
    if (durasiEl) durasiEl.textContent = (data.durasi_menit || 15) + ' Menit';

    const totalPoinEl = document.getElementById('modalTotalPoin');
    if (totalPoinEl) totalPoinEl.textContent = (data.total_poin || 0) + ' Poin';

    const modalStatusSudah = document.getElementById('modalStatusSudah');
    const modalStatusBelum = document.getElementById('modalStatusBelum');
    const modalBelumTitle = document.getElementById('modalBelumTitle');
    const modalBelumDesc = document.getElementById('modalBelumDesc');
    const modalStatusKosong = document.getElementById('modalStatusKosong');
    const modalStatusTerkunci = document.getElementById('modalStatusTerkunci');
    const modalTerkunciDesc = document.getElementById('modalTerkunciDesc');
    const btnLihatHasil = document.getElementById('modalBtnLihatHasil');
    const btnKerjakanQuiz = document.getElementById('modalBtnKerjakanQuiz');
    const btnQuizLocked = document.getElementById('modalBtnQuizLocked');
    const btnKerjakanQuizText = document.getElementById('modalBtnKerjakanQuizText');
    const btnBacaMateri = document.getElementById('modalBtnBacaMateri');
    const btnBacaMateriText = document.getElementById('modalBtnBacaMateriText');

    // Tombol baca materi
    if (btnBacaMateri) {
        if (!data.is_locked && data.url_materi) {
            btnBacaMateri.classList.remove('hidden');
            btnBacaMateri.href = data.url_materi;
            btnBacaMateri.onclick = function(e) {
                if (!data.sudah_selesai && typeof window.confirmBukaMateri === 'function') {
                    return window.confirmBukaMateri(e, data.url_materi);
                }
            };
        } else {
            btnBacaMateri.classList.add('hidden');
            btnBacaMateri.onclick = null;
        }
    }

    if (data.is_locked) {
        if (modalStatusSudah) modalStatusSudah.classList.add('hidden');
        if (modalStatusBelum) modalStatusBelum.classList.add('hidden');
        if (modalStatusKosong) modalStatusKosong.classList.add('hidden');
        if (modalStatusTerkunci) {
            modalStatusTerkunci.classList.remove('hidden');
            if (modalTerkunciDesc) {
                modalTerkunciDesc.innerHTML = `Selesaikan kuis pada materi <b>"${data.locked_by || 'sebelumnya'}"</b> terlebih dahulu untuk membuka materi ini. ✨`;
            }
        }

        if (btnLihatHasil) btnLihatHasil.classList.add('hidden');
        if (btnKerjakanQuiz) btnKerjakanQuiz.classList.add('hidden');
        if (btnQuizLocked) btnQuizLocked.classList.add('hidden');
    } else if (data.sudah_selesai) {
        if (modalStatusTerkunci) modalStatusTerkunci.classList.add('hidden');
        if (modalStatusSudah) modalStatusSudah.classList.remove('hidden');
        if (modalStatusBelum) modalStatusBelum.classList.add('hidden');
        if (modalStatusKosong) modalStatusKosong.classList.add('hidden');

        const skorEl = document.getElementById('modalSkorAngka');
        if (skorEl) skorEl.textContent = data.skor || 0;

        const waktuEl = document.getElementById('modalWaktuSelesai');
        if (waktuEl) waktuEl.textContent = data.waktu_selesai || 'Selesai';

        if (btnLihatHasil) {
            btnLihatHasil.classList.remove('hidden');
            btnLihatHasil.href = data.url_hasil || '#';
        }

        if (btnQuizLocked) btnQuizLocked.classList.add('hidden');

        if (btnKerjakanQuiz) {
            btnKerjakanQuiz.classList.add('hidden');
        }

        if (btnBacaMateri) {
            btnBacaMateri.className = "flex-1 px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-sm font-bold transition flex items-center justify-center gap-2 shadow-xs";
            if (btnBacaMateriText) btnBacaMateriText.textContent = 'Baca Lagi Materi';
        }
    } else if (data.total_soal > 0) {
        if (modalStatusTerkunci) modalStatusTerkunci.classList.add('hidden');
        if (modalStatusSudah) modalStatusSudah.classList.add('hidden');
        if (modalStatusBelum) modalStatusBelum.classList.remove('hidden');
        if (modalStatusKosong) modalStatusKosong.classList.add('hidden');

        if (btnLihatHasil) btnLihatHasil.classList.add('hidden');

        // Jika BELUM BACA MATERI: Quiz terkunci, tombol baca materi disorot
        if (!data.sudah_dibaca) {
            if (modalBelumTitle) modalBelumTitle.textContent = 'Quiz Belum Terbuka';
            if (modalBelumDesc) modalBelumDesc.innerHTML = 'Silakan <span class="font-bold text-[#018ABE]">baca materi pembelajaran</span> terlebih dahulu untuk membuka quiz ini. 🐾';

            if (btnKerjakanQuiz) btnKerjakanQuiz.classList.add('hidden');
            if (btnQuizLocked) btnQuizLocked.classList.remove('hidden');

            if (btnBacaMateri) {
                btnBacaMateri.className = "flex-1 px-4 py-2.5 rounded-xl bg-gradient-to-r from-[#018ABE] to-[#02457A] hover:from-[#02457A] hover:to-[#001B48] text-white text-sm font-bold transition flex items-center justify-center gap-2 shadow-md shadow-blue-500/20";
                if (btnBacaMateriText) btnBacaMateriText.textContent = 'Mulai Baca Materi';
            }
        } else {
            // Sudah baca materi, kuis siap dikerjakan
            if (modalBelumTitle) modalBelumTitle.textContent = 'Belum Ada Riwayat Quiz';
            if (modalBelumDesc) modalBelumDesc.textContent = 'Kamu sudah membaca materi ini! Yuk kerjakan quiz untuk menguji pemahamanmu. 💪';

            if (btnQuizLocked) btnQuizLocked.classList.add('hidden');
            if (btnKerjakanQuiz) {
                btnKerjakanQuiz.classList.remove('hidden');
                btnKerjakanQuiz.href = data.url_quiz || '#';
                if (btnKerjakanQuizText) btnKerjakanQuizText.textContent = 'Mulai Quiz';
            }

            if (btnBacaMateri) {
                btnBacaMateri.className = "flex-1 px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-sm font-bold transition flex items-center justify-center gap-2 shadow-xs";
                if (btnBacaMateriText) btnBacaMateriText.textContent = 'Baca Materi';
            }
        }
    } else {
        if (modalStatusTerkunci) modalStatusTerkunci.classList.add('hidden');
        if (modalStatusSudah) modalStatusSudah.classList.add('hidden');
        if (modalStatusBelum) modalStatusBelum.classList.add('hidden');
        if (modalStatusKosong) modalStatusKosong.classList.remove('hidden');

        if (btnLihatHasil) btnLihatHasil.classList.add('hidden');
        if (btnKerjakanQuiz) btnKerjakanQuiz.classList.add('hidden');
        if (btnQuizLocked) btnQuizLocked.classList.add('hidden');

        if (btnBacaMateri) {
            btnBacaMateri.className = "flex-1 px-4 py-2.5 rounded-xl bg-gradient-to-r from-[#018ABE] to-[#02457A] hover:from-[#02457A] hover:to-[#001B48] text-white text-sm font-bold transition flex items-center justify-center gap-2 shadow-md shadow-blue-500/20";
            if (btnBacaMateriText) btnBacaMateriText.textContent = 'Mulai Baca Materi';
        }
    }

    const modal = document.getElementById('quizDetailModal');
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
}

function closeQuizDetailModal() {
    const modal = document.getElementById('quizDetailModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}

function onBackdropClick(e) {
    if (e.target && e.target.id === 'quizDetailModal') {
        closeQuizDetailModal();
    }
}

if (!window._quizDetailModalEscRegistered) {
    window._quizDetailModalEscRegistered = true;
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeQuizDetailModal();
        }
    });
}
</script>

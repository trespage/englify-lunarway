<!-- Top Progress Loader Bar -->
<div id="englify-page-loader" class="fixed top-0 left-0 right-0 h-1 bg-transparent z-[9999] pointer-events-none transition-opacity duration-300 opacity-0">
    <div id="englify-page-loader-bar" class="h-full bg-gradient-to-r from-[#018ABE] via-[#45B69C] to-[#97CADB] rounded-r-full transition-all duration-300 ease-out shadow-xs shadow-[#018ABE]/50 w-0"></div>
</div>

<!-- Aesthetic Cat Loading Modal & Overlay -->
<div id="englify-loading-modal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-[9998] hidden items-center justify-center p-4 transition-all duration-300">
    <div class="bg-white rounded-3xl p-6 sm:p-7 max-w-xs w-full text-center shadow-2xl border border-slate-100 relative overflow-hidden transform scale-95 transition-transform duration-300" id="englify-loading-card">
        <!-- Subtle glowing blobs -->
        <div class="absolute -top-10 -left-10 w-24 h-24 bg-[#018ABE]/15 rounded-full blur-xl pointer-events-none"></div>
        <div class="absolute -bottom-10 -right-10 w-24 h-24 bg-[#45B69C]/15 rounded-full blur-xl pointer-events-none"></div>

        <!-- Cat Paw Container with Ripple -->
        <div class="relative w-20 h-20 mx-auto mb-3.5 flex items-center justify-center">
            <div class="absolute inset-0 rounded-full border-2 border-[#018ABE]/20 pulse-ring"></div>
            <div class="absolute inset-2 rounded-full border-2 border-dashed border-[#018ABE]/40 animate-spin" style="animation-duration: 9s;"></div>
            
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#018ABE] to-[#02457A] text-white flex items-center justify-center shadow-md shadow-[#018ABE]/30 cat-bob">
                <svg class="paw-icon w-6 h-6 text-sky-200" viewBox="0 0 512 512" fill="currentColor">
                    <path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C120.3 358.3 189 320 256 320s135.7 38.3 186.8 81.2c12.8 10.8 10.6 30.5-3.8 40.8-28.7 20.6-67.6 36-111 36-28.7 0-54.6-6.6-72-19.3-17.4 12.7-43.3 19.3-72 19.3-43.4 0-82.3-15.4-111-36-14.4-10.4-16.6-30.1-3.8-40.8zM440.3 165.3c24.5 14 29.1 51.7 10.2 84.1s-54.1 47.3-78.5 33.3-29.1-51.7-10.2-84.1 54.1-47.3 78.5-33.3zM318.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5 46.9 53.9 32.6 96.8-52.1 69.1-84.4 58.5z"/>
                </svg>
            </div>
        </div>

        <h4 id="englify-loading-title" class="text-sm font-extrabold text-slate-800 tracking-tight">Memuat Halaman...</h4>
        <p id="englify-loading-desc" class="text-xs text-slate-500 mt-1 leading-relaxed">Tunggu sebentar ya, kucing pintar sedang menyiapkan materimu! 🐾</p>

        <!-- Indeterminate Progress bar -->
        <div class="mt-4 w-full bg-slate-100 h-1.5 rounded-full overflow-hidden relative">
            <div class="absolute inset-y-0 w-1/3 bg-gradient-to-r from-[#018ABE] to-[#45B69C] rounded-full" style="animation: progressIndeterminate 1.5s cubic-bezier(0.4, 0, 0.2, 1) infinite;"></div>
        </div>
    </div>
</div>

<script>
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

// Auto trigger on standard page navigations
if (!window._englifyLoaderAttached) {
    window._englifyLoaderAttached = true;
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof window.finishPageLoader === 'function') {
            window.finishPageLoader();
        }

        document.querySelectorAll('a[href]:not([target="_blank"]):not([href^="#"]):not([href^="javascript:"])').forEach(a => {
            a.addEventListener('click', function(e) {
                if (e.defaultPrevented || e.metaKey || e.ctrlKey || e.shiftKey) return;
                const href = a.getAttribute('href');
                if (href && !href.startsWith('#') && !href.startsWith('mailto:') && !href.startsWith('tel:')) {
                    window.startPageLoader();
                }
            });
        });

        // 1. GLOBAL FORM ANTI-SPAM CLICK & "MEMPROSES..." BUTTON SPINNER (S3-07)
        document.addEventListener('submit', function(e) {
            const form = e.target;
            if (!form || form.tagName !== 'FORM') return;
            if (e.defaultPrevented) return;

            // Jika form HTML5 validasi gagal, jangan kunci tombol
            if (typeof form.checkValidity === 'function' && !form.checkValidity()) {
                return;
            }

            // Cegah duplikasi pengiriman (anti-spam / anti double-click)
            if (form.dataset.submitting === 'true') {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
            form.dataset.submitting = 'true';

            // Ambil semua tombol submit di dalam form
            const submitBtns = form.querySelectorAll('button[type="submit"], input[type="submit"]');
            submitBtns.forEach(btn => {
                // Simpan dimensi dan konten asli tombol agar UI tidak bergeser
                if (!btn.dataset.originalHtml && btn.innerHTML) {
                    btn.dataset.originalHtml = btn.innerHTML;
                }
                if (!btn.dataset.originalVal && btn.value) {
                    btn.dataset.originalVal = btn.value;
                }
                const currentWidth = btn.offsetWidth;
                if (currentWidth > 0) {
                    btn.style.minWidth = currentWidth + 'px';
                }

                // Ubah tampilan menjadi spinner & teks "Memproses..."
                btn.classList.add('cursor-not-allowed');
                btn.style.pointerEvents = 'none';
                btn.style.opacity = '0.85';

                if (btn.tagName.toLowerCase() === 'input') {
                    btn.value = 'Memproses...';
                } else {
                    btn.innerHTML = `
                        <span class="inline-flex items-center justify-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-current shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            <span>Memproses...</span>
                        </span>
                    `;
                }

                // Beri efek disabled setelah mikro-jeda agar native submit form tetap diproses browser
                setTimeout(() => {
                    btn.disabled = true;
                }, 20);
            });

            if (typeof window.startPageLoader === 'function') {
                window.startPageLoader();
            }
        }, true);
    });

    window.addEventListener('pageshow', function() {
        if (typeof window.finishPageLoader === 'function') {
            window.finishPageLoader();
        }
        if (typeof window.hideLoading === 'function') {
            window.hideLoading();
        }
        // Pulihkan tombol submit saat user menekan tombol Back / kembali
        document.querySelectorAll('form').forEach(form => {
            form.dataset.submitting = 'false';
            form.querySelectorAll('button[type="submit"], input[type="submit"]').forEach(btn => {
                btn.disabled = false;
                btn.style.pointerEvents = '';
                btn.style.opacity = '';
                btn.style.minWidth = '';
                btn.classList.remove('cursor-not-allowed');
                if (btn.dataset.originalHtml) {
                    btn.innerHTML = btn.dataset.originalHtml;
                }
                if (btn.dataset.originalVal) {
                    btn.value = btn.dataset.originalVal;
                }
            });
        });
    });
}
</script>

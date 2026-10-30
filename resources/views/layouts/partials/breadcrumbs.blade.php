@php
    // JIKA TIDAK ADA $breadcrumbs DARI VIEW, GENERATE OTOMATIS BERDASARKAN ROUTE NAME
    if (!isset($breadcrumbs) || !is_array($breadcrumbs) || empty($breadcrumbs)) {
        $routeName = request()->route() ? request()->route()->getName() : '';
        $breadcrumbs = [];

        // Rute Admin
        if (str_starts_with($routeName, 'admin.')) {
            $breadcrumbs[] = ['title' => 'Dashboard', 'url' => route('admin.dashboard')];

            if ($routeName === 'admin.bab') {
                $breadcrumbs[] = ['title' => 'Kelola Bab', 'url' => null];
            } elseif ($routeName === 'admin.kategori') {
                $breadcrumbs[] = ['title' => 'Kelola Divisi (Kategori)', 'url' => null];
            } elseif ($routeName === 'admin.materi') {
                $breadcrumbs[] = ['title' => 'Manajemen Materi', 'url' => null];
            } elseif ($routeName === 'admin.quiz') {
                $breadcrumbs[] = ['title' => 'Bank Soal Kuis', 'url' => null];
            } elseif ($routeName === 'admin.hasil-quiz') {
                $breadcrumbs[] = ['title' => 'Evaluasi & Hasil Kuis', 'url' => null];
            } elseif ($routeName === 'admin.hasil-quiz.detail') {
                $breadcrumbs[] = ['title' => 'Evaluasi & Hasil Kuis', 'url' => route('admin.hasil-quiz')];
                $breadcrumbs[] = ['title' => 'Detail Hasil Kuis', 'url' => null];
            } elseif ($routeName === 'admin.monitoring-siswa') {
                $breadcrumbs[] = ['title' => 'Monitoring Siswa', 'url' => null];
            } elseif ($routeName === 'admin.monitoring-siswa.detail') {
                $breadcrumbs[] = ['title' => 'Monitoring Siswa', 'url' => route('admin.monitoring-siswa')];
                $breadcrumbs[] = ['title' => 'Detail Siswa', 'url' => null];
            } elseif ($routeName === 'admin.kirim-reminder') {
                $breadcrumbs[] = ['title' => 'Kirim Pengingat (Reminder)', 'url' => null];
            } elseif ($routeName === 'admin.profil') {
                $breadcrumbs[] = ['title' => 'Profil Admin', 'url' => null];
            }
        }
        // Rute Superadmin
        elseif (str_starts_with($routeName, 'superadmin.')) {
            $breadcrumbs[] = ['title' => 'Dashboard', 'url' => route('superadmin.dashboard')];

            if ($routeName === 'superadmin.users') {
                $breadcrumbs[] = ['title' => 'Kelola Pengguna', 'url' => null];
            } elseif ($routeName === 'superadmin.siswa') {
                $breadcrumbs[] = ['title' => 'Data Siswa', 'url' => null];
            } elseif ($routeName === 'superadmin.adminDivisi') {
                $breadcrumbs[] = ['title' => 'Admin Divisi', 'url' => null];
            } elseif ($routeName === 'superadmin.divisi') {
                $breadcrumbs[] = ['title' => 'Divisi Pembelajaran', 'url' => null];
            } elseif ($routeName === 'superadmin.dataSistem') {
                $breadcrumbs[] = ['title' => 'Data Sistem', 'url' => null];
            } elseif ($routeName === 'superadmin.settings') {
                $breadcrumbs[] = ['title' => 'Pengaturan', 'url' => null];
            } elseif ($routeName === 'superadmin.profile') {
                $breadcrumbs[] = ['title' => 'Profil Super Admin', 'url' => null];
            }
        }
        // Rute Siswa
        elseif (str_starts_with($routeName, 'siswa.')) {
            $breadcrumbs[] = ['title' => 'Beranda', 'url' => route('siswa.dashboard')];

            if ($routeName === 'siswa.materi') {
                $breadcrumbs[] = ['title' => 'Modul Belajar', 'url' => null];
            } elseif ($routeName === 'siswa.materi.baca') {
                $breadcrumbs[] = ['title' => 'Modul Belajar', 'url' => route('siswa.materi')];
                $breadcrumbs[] = ['title' => isset($materi) ? ($materi->judul ?? 'Baca Materi') : 'Baca Materi', 'url' => null];
            } elseif ($routeName === 'siswa.peta-quiz') {
                $breadcrumbs[] = ['title' => 'Peta Kuis Interaktif', 'url' => null];
            } elseif ($routeName === 'siswa.quiz') {
                $breadcrumbs[] = ['title' => 'Daftar Kuis', 'url' => null];
            } elseif ($routeName === 'siswa.quiz.kerjakan') {
                $breadcrumbs[] = ['title' => 'Daftar Kuis', 'url' => route('siswa.quiz')];
                $breadcrumbs[] = ['title' => 'Pengerjaan Kuis', 'url' => null];
            } elseif ($routeName === 'siswa.quiz.hasil') {
                $breadcrumbs[] = ['title' => 'Daftar Kuis', 'url' => route('siswa.quiz')];
                $breadcrumbs[] = ['title' => 'Hasil Evaluasi Kuis', 'url' => null];
            } elseif ($routeName === 'siswa.progres') {
                $breadcrumbs[] = ['title' => 'Progres Belajar', 'url' => null];
            } elseif ($routeName === 'siswa.reminder') {
                $breadcrumbs[] = ['title' => 'Kotak Pengingat Belajar', 'url' => null];
            }
        }
        // Rute Publik (Login, Change Password, dll)
        elseif ($routeName === 'login') {
            $breadcrumbs[] = ['title' => 'Beranda Publik', 'url' => url('/')];
            $breadcrumbs[] = ['title' => 'Masuk Akun', 'url' => null];
        } elseif ($routeName === 'change.password') {
            $breadcrumbs[] = ['title' => 'Beranda', 'url' => url('/')];
            $breadcrumbs[] = ['title' => 'Perbarui Kata Sandi', 'url' => null];
        }
    }
@endphp

@if(isset($breadcrumbs) && count($breadcrumbs) > 0)
<nav aria-label="Breadcrumb" class="mb-4 sm:mb-5 select-none print:hidden">
    <ol class="inline-flex items-center flex-wrap gap-1.5 sm:gap-2 px-3 sm:px-4 py-2 bg-white/75 backdrop-blur-md rounded-2xl border border-blue-200/60 shadow-xs text-xs">
        @foreach($breadcrumbs as $index => $crumb)
            @php
                $isLast = ($index === count($breadcrumbs) - 1);
                $isFirst = ($index === 0);
            @endphp

            <li class="inline-flex items-center gap-1.5 sm:gap-2">
                @if(!$isFirst)
                    <!-- Separator Chevron -->
                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                    </svg>
                @endif

                @if($isFirst)
                    <!-- Home / Root icon -->
                    @if(!$isLast && !empty($crumb['url']))
                        <a href="{{ $crumb['url'] }}" class="inline-flex items-center gap-1.5 text-slate-600 hover:text-[#018ABE] font-semibold transition group">
                            <span class="w-6 h-6 rounded-lg bg-blue-50 text-[#018ABE] group-hover:bg-[#018ABE] group-hover:text-white flex items-center justify-center transition shadow-2xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                            </span>
                            <span class="truncate max-w-[120px] sm:max-w-none">{{ $crumb['title'] }}</span>
                        </a>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-slate-800 font-bold">
                            <span class="w-6 h-6 rounded-lg bg-[#018ABE] text-white flex items-center justify-center shadow-2xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                            </span>
                            <span>{{ $crumb['title'] }}</span>
                        </span>
                    @endif
                @elseif($isLast)
                    <!-- Active Current Page -->
                    <span class="inline-flex items-center gap-1 font-bold text-[#018ABE] bg-sky-50/80 px-2.5 py-1 rounded-xl border border-sky-100" aria-current="page">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#018ABE]"></span>
                        <span class="truncate max-w-[180px] sm:max-w-xs md:max-w-md">{{ $crumb['title'] }}</span>
                    </span>
                @else
                    <!-- Middle Linked Breadcrumb -->
                    <a href="{{ $crumb['url'] }}" class="text-slate-600 hover:text-[#018ABE] font-medium transition hover:underline truncate max-w-[140px] sm:max-w-none">
                        {{ $crumb['title'] }}
                    </a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
@endif

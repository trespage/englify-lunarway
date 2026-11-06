@extends('layouts.admin')

@section('title', 'Monitoring Per Siswa')

@section('content')
<div class="space-y-6">

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Monitoring Per Siswa</h1>
                <p class="text-slate-500 text-sm mt-0.5">Pantau progress dan aktivitas setiap siswa di divisi Anda.</p>
            </div>
        </div>
        <div class="flex items-center gap-2 text-sm bg-white px-4 py-2.5 rounded-xl border border-slate-200 shadow-sm">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span class="font-semibold text-slate-700">{{ $siswaAktif ?? 0 }} Siswa Aktif</span>
        </div>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="w-11 h-11 rounded-xl bg-indigo-50 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500">Total Siswa</p>
            <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalSiswa ?? 0 }}</p>
            <p class="text-xs text-slate-400 mt-1">di divisi Anda</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500">Siswa Aktif</p>
            <p class="text-3xl font-extrabold text-emerald-600 mt-1">{{ $siswaAktif ?? 0 }}</p>
            <p class="text-xs text-slate-400 mt-1">sedang belajar</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="w-11 h-11 rounded-xl bg-rose-50 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500">Siswa Nonaktif</p>
            <p class="text-3xl font-extrabold text-rose-600 mt-1">{{ $siswaNonaktif ?? 0 }}</p>
            <p class="text-xs text-slate-400 mt-1">tidak aktif</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500">Rata-rata Progress</p>
            <p class="text-3xl font-extrabold text-blue-600 mt-1">{{ $averageProgress }}%</p>
            <p class="text-xs text-slate-400 mt-1">dari semua siswa</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500">Total Poin</p>
            <p class="text-3xl font-extrabold text-amber-600 mt-1">{{ number_format($totalPoinTerkumpul ?? 0) }}</p>
            <p class="text-xs text-slate-400 mt-1">semua siswa</p>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200">
        <form method="GET" action="{{ route('admin.monitoring-siswa') }}" class="flex flex-col lg:flex-row gap-3">
            <div class="relative flex-1">
                <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="searchInput" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email siswa..."
                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
            </div>
            <select id="statusFilter" name="status" class="w-full lg:w-auto px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 cursor-pointer">
                <option value="">Semua Status</option>
                <option value="aktif" @selected(request('status') == 'aktif')>Aktif</option>
                <option value="nonaktif" @selected(request('status') == 'nonaktif')>Nonaktif</option>
            </select>
            <button type="submit" class="w-full lg:w-auto px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition">
                Terapkan
            </button>
            @if(request()->hasAny(['q', 'status']))
                <a href="{{ route('admin.monitoring-siswa') }}" class="w-full lg:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold rounded-xl transition text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- MOBILE CARD VIEW -->
    <div class="md:hidden space-y-3">
        @forelse($students as $student)
        <a href="{{ route('admin.monitoring-siswa.detail', $student['id']) }}" class="block bg-white rounded-2xl p-4 shadow-sm border border-slate-200 active:bg-slate-50 transition hover:shadow-md">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold text-lg shrink-0">
                        {{ substr($student['nama'], 0, 1) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-bold text-slate-800 text-sm truncate">{{ $student['nama'] }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ $student['email'] }}</p>
                    </div>
                </div>
                @if($student['status'] === 'aktif')
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 shrink-0 ml-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700 shrink-0 ml-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Nonaktif
                    </span>
                @endif
            </div>

            <div class="mb-3">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-semibold text-slate-600">Progress</span>
                    <span class="text-xs font-bold text-indigo-600">{{ $student['progress'] }}%</span>
                </div>
                <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full transition-all" style="width: {{ $student['progress'] }}%"></div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1 text-xs text-slate-600 font-semibold">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        <span>{{ $student['quiz'] }} Quiz</span>
                    </div>
                    <div class="inline-flex items-center gap-1 text-[11px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200/70">
                        <svg class="w-3 h-3 text-amber-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span>{{ number_format($student['poin'] ?? 0) }} Poin</span>
                    </div>
                </div>
                <span class="text-[10px] text-slate-400">Aktif {{ $student['lastActive'] }}</span>
            </div>
        </a>
        @empty
        <div class="bg-white rounded-2xl p-8 text-center border border-slate-200">
            <p class="text-sm font-semibold text-slate-500">Belum ada data siswa</p>
        </div>
        @endforelse
    </div>

    <!-- DESKTOP TABLE VIEW -->
    <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Progress</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Quiz</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Total Poin</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Terakhir Aktif</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($students as $index => $student)
                    <tr class="hover:bg-slate-50 transition group">
                        <td class="px-6 py-4 text-sm font-semibold text-slate-600">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.monitoring-siswa.detail', $student['id']) }}" class="flex items-center gap-3 hover:underline">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold text-sm shrink-0">
                                    {{ substr($student['nama'], 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800 text-sm">{{ $student['nama'] }}</p>
                                    <p class="text-[11px] text-slate-400">{{ $student['email'] }}</p>
                                </div>
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            @if($student['status'] === 'aktif')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full" style="width: {{ $student['progress'] }}%"></div>
                                </div>
                                <span class="text-xs font-bold text-indigo-600 w-10 text-right">{{ $student['progress'] }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $student['quiz'] }} quiz</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/80">
                                <svg class="w-3.5 h-3.5 text-amber-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span>{{ number_format($student['poin'] ?? 0) }} Poin</span>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500">{{ $student['lastActive'] }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.monitoring-siswa.detail', $student['id']) }}" class="p-2 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 transition" title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-10 text-center">
                            <p class="text-sm font-semibold text-slate-500">Belum ada data siswa</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-slate-500 text-center sm:text-left">
                Menampilkan semua {{ count($students) }} data siswa
            </p>
            <span class="text-xs font-medium text-slate-400">
                Diurutkan berdasarkan nama (A-Z)
            </span>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Filter dijalankan lewat form GET, tidak perlu handler JS tambahan.
</script>
@endpush

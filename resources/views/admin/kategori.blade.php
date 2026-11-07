@extends('layouts.admin')

@section('title', 'Kelola Kategori')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                Kelola Kategori
            </h1>
            <p class="text-slate-500 mt-1 ml-1">Kategori bidang materi kurikulum (Speaking, Writing, Reading, Listening, dll).</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.bab') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                Kelola Bab
            </a>
            <button onclick="openModal('add')" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/30 transition-all active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Kategori
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

    <!-- Daftar Kategori -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Jumlah Bab</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Jumlah Materi</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($kategoris as $kategori)
                    @php
                        $colorBadge = $kategori->color['badge'] ?? 'bg-slate-50 text-slate-600 border-slate-200';
                    @endphp
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold border {{ $colorBadge }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current opacity-75"></span>
                                {{ $kategori->nama_kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ \Illuminate\Support\Str::limit($kategori->deskripsi ?? '-', 80) }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200/60">
                                {{ $kategori->babs_count ?? $kategori->babs()->count() }} Bab
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                {{ $kategori->materi_count ?? $kategori->materi()->count() }} Materi
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick='editKategori(@js($kategori))' class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition" title="Edit Kategori">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button onclick="deleteKategori({{ $kategori->id_kategori }})" class="p-2 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition" title="Hapus Kategori">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <p class="text-slate-500 font-medium">Belum ada kategori</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit -->
<div id="kategoriModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 id="modalTitle" class="text-xl font-bold text-slate-800">Tambah Kategori</h3>
            <button onclick="closeModal()" class="p-2 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="kategoriForm" action="{{ route('admin.kategori.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="_method" id="kategoriMethod" value="PUT" disabled>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Kategori</label>
                <input type="text" id="inputNama" name="nama_kategori" value="{{ old('nama_kategori') }}" required maxlength="100" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" placeholder="Contoh: Speaking">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
                <textarea id="inputDeskripsi" name="deskripsi" rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" placeholder="Deskripsi singkat kategori...">{{ old('deskripsi') }}</textarea>
            </div>
            <div class="pt-2 flex gap-3">
                <button type="button" onclick="closeModal()" class="flex-1 px-4 py-2.5 border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-600/30">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus -->
<div id="deleteModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-sm p-6 text-center">
        <h3 class="text-xl font-bold text-slate-800 mb-2">Hapus Kategori?</h3>
        <p class="text-slate-500 text-sm mb-6">Bab dan materi di dalam kategori ini ikut terhapus. Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex gap-3">
            <button onclick="closeDeleteModal()" class="flex-1 px-4 py-3 border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50">Batal</button>
            <form id="deleteForm" action="{{ route('admin.kategori.destroy', ['id' => '__ID__']) }}" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full px-4 py-3 bg-rose-600 text-white font-semibold rounded-xl hover:bg-rose-700">Hapus</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openModal(type = 'add', kategori = null) {
    const modal = document.getElementById('kategoriModal');
    const title = document.getElementById('modalTitle');
    const form = document.getElementById('kategoriForm');

    if (type === 'edit' && kategori) {
        title.textContent = 'Edit Kategori';
        form.action = @js(route('admin.kategori.update', ['id' => '__ID__'])).replace('__ID__', encodeURIComponent(kategori.id_kategori));
        document.getElementById('kategoriMethod').disabled = false;
        document.getElementById('inputNama').value = kategori.nama_kategori;
        document.getElementById('inputDeskripsi').value = kategori.deskripsi ?? '';
    } else {
        title.textContent = 'Tambah Kategori';
        form.reset();
        form.action = @js(route('admin.kategori.store'));
        document.getElementById('kategoriMethod').disabled = true;
    }
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    document.getElementById('kategoriModal').classList.add('hidden');
    document.getElementById('kategoriModal').classList.remove('flex');
    document.getElementById('kategoriForm').reset();
}

function editKategori(kategori) {
    openModal('edit', kategori);
}

function deleteKategori(id) {
    const form = document.getElementById('deleteForm');
    form.action = @js(route('admin.kategori.destroy', ['id' => '__ID__'])).replace('__ID__', encodeURIComponent(id));
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
}

@if($errors->any())
document.addEventListener('DOMContentLoaded', function() {
    openModal('add');
});
@endif
</script>
@endpush

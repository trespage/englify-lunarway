@extends('layouts.superadmin')

@section('title', 'Akun Admin Divisi')

@section('content')
<div class="space-y-4 sm:space-y-6">
    @if($errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-800 text-sm px-4 py-3 rounded-2xl shadow-xs">
        <p class="font-bold mb-1">Gagal menyimpan akun:</p>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-center sm:text-left">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 flex items-center justify-center sm:justify-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-sky-100 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                Akun Admin Divisi
            </h1>
            <p class="text-slate-500 mt-1 text-sm">Buat dan kelola akun administrator per divisi materi Englify.</p>
        </div>
        <button onclick="openModal('add')" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-xl shadow-lg shadow-sky-600/25 transition-all active:scale-95 w-full sm:w-auto">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Admin Divisi
        </button>
    </div>

    <!-- Stats Card -->
    <div class="bg-gradient-to-r from-sky-100/70 via-blue-50/50 to-white rounded-2xl p-5 sm:p-6 border border-sky-200/70 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 sm:w-32 sm:h-32 opacity-10">
            <svg viewBox="0 0 200 200" class="w-full h-full text-sky-600" fill="currentColor">
                <circle cx="100" cy="60" r="40"/><circle cx="60" cy="140" r="35"/><circle cx="140" cy="140" r="35"/>
            </svg>
        </div>
        <div class="relative flex flex-col sm:flex-row items-center gap-4">
            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-white shadow-sm border border-slate-200/60 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7 sm:w-8 sm:h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <div class="text-center sm:text-left flex-1">
                <p class="text-sm font-semibold text-slate-600">Total Admin Divisi</p>
                <div class="flex items-center justify-center sm:justify-start gap-2 mt-1">
                    <span class="text-2xl sm:text-3xl font-bold text-slate-800">{{ $totalAdmins ?? 0 }}</span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full">{{ $adminsGrowth ?? '+ 0%' }}</span>
                </div>
            </div>
            <div class="hidden sm:block">
                <img src="{{ asset('images/cat-welcome.png') }}" alt="Cat Mascot" class="w-20 h-auto opacity-80">
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200/70">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="searchInput" value="{{ $q ?? '' }}" placeholder="Cari nama atau email..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
            </div>
            <select id="statusFilter" class="w-full sm:w-auto px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 cursor-pointer">
                <option value="">Semua Status</option>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>
        </div>
    </div>

    <!-- MOBILE CARD VIEW (md:hidden) -->
    <div class="md:hidden space-y-3">
        @forelse($admins ?? [] as $admin)
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200/70 active:bg-slate-50 transition"
             data-search="{{ mb_strtolower(trim(($admin->nama ?? '') . ' ' . ($admin->email ?? ''))) }}" data-status="{{ $admin->status ?? 'aktif' }}">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-sky-400 to-sky-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
                        {{ substr($admin->nama, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 text-sm">{{ $admin->nama }}</p>
                        <p class="text-xs text-slate-500">{{ $admin->email }}</p>
                    </div>
                </div>
                @if($admin->status === 'aktif')
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif</span>
                @else
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Nonaktif</span>
                @endif
            </div>
            <div class="space-y-2 text-sm text-slate-600 mb-4 bg-slate-50/70 p-3 rounded-xl border border-slate-100">
                <div class="flex justify-between items-center">
                    <span class="text-slate-400 text-xs font-semibold uppercase tracking-wide">Role</span>
                    <span class="font-medium text-right text-xs flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5h1.5a1.5 1.5 0 000-3H9V6"/></svg>
                        {{ $admin->kategori ? 'Divisi ' . $admin->kategori->nama_kategori : 'Admin Divisi (Semua)' }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-400 text-xs font-semibold uppercase tracking-wide">Dibuat</span>
                    <span class="font-medium text-right text-xs">{{ \Carbon\Carbon::parse($admin->created_at)->format('d M Y') }}</span>
                </div>
            </div>
            <div class="flex gap-2 pt-2 border-t border-slate-100">
                <button onclick="editAdmin(@js($admin->id_user), @js($admin->nama), @js($admin->email), @js($admin->status ?? 'aktif'), @js($admin->id_kategori))" class="flex-1 py-2.5 bg-sky-50 text-sky-600 rounded-xl text-xs font-bold flex items-center justify-center gap-2 active:bg-sky-100 transition">Edit</button>
                <button onclick="deleteAdmin(@js($admin->id_user))" class="flex-1 py-2.5 bg-rose-50 text-rose-600 rounded-xl text-xs font-bold flex items-center justify-center gap-2 active:bg-rose-100 transition">Hapus</button>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-200/70 text-center">
            <p class="text-slate-500 font-medium text-sm">{{ ($q ?? '') !== '' ? 'Tidak ada admin divisi yang cocok dengan "' . $q . '"' : 'Belum ada admin divisi' }}</p>
        </div>
        @endforelse
    </div>

    <!-- DESKTOP TABLE VIEW (hidden md:block) -->
    <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-slate-200/70 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50/60 border-b border-slate-200/60">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Dibuat</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($admins ?? [] as $admin)
                    <tr class="hover:bg-sky-50/40 transition group"
                        data-search="{{ mb_strtolower(trim(($admin->nama ?? '') . ' ' . ($admin->email ?? ''))) }}" data-status="{{ $admin->status ?? 'aktif' }}">
                        <td class="px-6 py-4 text-sm font-semibold text-slate-600">{{ ($admins->firstItem() ?? 1) + $loop->index }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-sky-400 to-sky-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
                                    {{ substr($admin->nama, 0, 1) }}
                                </div>
                                <span class="font-semibold text-slate-700">{{ $admin->nama }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $admin->email }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5h1.5a1.5 1.5 0 000-3H9V6"/></svg>
                                {{ $admin->kategori ? 'Divisi ' . $admin->kategori->nama_kategori : 'Admin Divisi (Semua)' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($admin->status === 'aktif')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif</span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ \Carbon\Carbon::parse($admin->created_at)->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="editAdmin(@js($admin->id_user), @js($admin->nama), @js($admin->email), @js($admin->status ?? 'aktif'), @js($admin->id_kategori))" class="p-2 rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-100 transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button onclick="deleteAdmin(@js($admin->id_user))" class="p-2 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-6 py-12 text-center"><p class="text-slate-500 font-medium">{{ ($q ?? '') !== '' ? 'Tidak ada admin divisi yang cocok dengan "' . $q . '"' : 'Belum ada admin divisi' }}</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($admins) && $admins->hasPages())
        <div class="px-6 py-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-slate-500 text-center sm:text-left">Menampilkan {{ $admins->firstItem() }} - {{ $admins->lastItem() }} dari {{ $admins->total() }} data</p>
            <div class="flex items-center gap-2">{{ $admins->links() }}</div>
        </div>
        @endif
    </div>

    <!-- Pesan saat pencarian/filter live tidak menemukan data -->
    <div id="listFilterEmpty" class="hidden bg-white rounded-2xl p-6 shadow-sm border border-slate-200/70 text-center text-sm font-medium text-slate-500">
        Tidak ada data yang cocok dengan pencarian / filter.
    </div>
</div>

<!-- Modal Tambah/Edit Admin -->
<div id="adminModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-3 sm:p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[85vh] sm:max-h-[90vh] overflow-y-auto border border-slate-100">
        <div class="p-5 sm:p-6 border-b border-slate-200/60 flex items-center justify-between sticky top-0 bg-white z-10 rounded-t-3xl">
            <h3 id="modalTitle" class="text-lg sm:text-xl font-bold text-slate-800">Tambah Akun Admin Divisi</h3>
            <button onclick="closeModal()" class="p-2 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="adminForm" action="{{ route('superadmin.adminDivisi.store') }}" method="POST" class="p-5 sm:p-6 space-y-4">
            @csrf
            <input type="hidden" name="_method" id="adminMethod" value="PUT" disabled>
            <input type="hidden" id="adminId" name="id">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                <input type="text" id="inputNama" name="nama" value="{{ old('nama') }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition" placeholder="Masukkan nama lengkap">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                <input type="email" id="inputEmail" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition" placeholder="nama@email.com">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                <div class="relative">
                    <input type="password" id="inputPassword" name="password" minlength="6" class="w-full px-4 py-2.5 pr-11 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition" placeholder="••••••••">
                </div>
                <p class="text-xs text-slate-400 mt-1" id="passwordHint">Wajib diisi (min. 6 karakter) saat tambah akun. Kosongkan hanya saat edit jika tidak ingin mengubah password.</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Divisi (Kategori)</label>
                <select id="inputIdKategori" name="id_kategori" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                    <option value="">Semua Divisi (Umum)</option>
                    @foreach($kategoris ?? [] as $kat)
                        <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-400 mt-1">Pilih kategori jika admin bertanggung jawab pada satu divisi saja.</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                <select id="inputStatus" name="status" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                    <option value="aktif" {{ old('status', 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="pt-4 flex gap-3 sticky bottom-0 bg-white pb-1">
                <button type="button" onclick="closeModal()" class="flex-1 px-4 py-3 border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition active:bg-slate-100">Batal</button>
                <button type="submit" class="flex-1 px-4 py-3 bg-sky-600 text-white font-semibold rounded-xl hover:bg-sky-700 shadow-lg shadow-sky-600/30 transition active:bg-sky-800">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-sm sm:max-w-md p-6 text-center mx-4">
        <div class="w-16 h-16 rounded-full bg-rose-100 flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <h3 class="text-xl font-bold text-slate-800 mb-2">Hapus Akun?</h3>
        <p class="text-slate-500 text-sm mb-6">Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex gap-3">
            <button onclick="closeDeleteModal()" class="flex-1 px-4 py-3 border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition active:bg-slate-100">Batal</button>
            <form id="deleteForm" action="{{ route('superadmin.adminDivisi.destroy', ['id' => '__ID__']) }}" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full px-4 py-3 bg-rose-600 text-white font-semibold rounded-xl hover:bg-rose-700 shadow-lg shadow-rose-600/30 transition active:bg-rose-800">Hapus</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openModal(type = 'add', admin = null) {
    const modal = document.getElementById('adminModal');
    const title = document.getElementById('modalTitle');
    const form = document.getElementById('adminForm');

    if (type === 'edit' && admin) {
        title.textContent = 'Edit Akun Admin Divisi';
        form.action = @js(route('superadmin.adminDivisi.update', ['id' => '__ID__'])).replace('__ID__', encodeURIComponent(admin.id_user));
        document.getElementById('adminMethod').disabled = false;
        document.getElementById('adminId').value = admin.id_user;
        document.getElementById('inputNama').value = admin.nama;
        document.getElementById('inputEmail').value = admin.email;
        document.getElementById('inputStatus').value = admin.status ?? 'aktif';
        document.getElementById('inputIdKategori').value = admin.id_kategori ?? '';
        document.getElementById('inputPassword').value = '';
        document.getElementById('inputPassword').required = false;
    } else {
        title.textContent = 'Tambah Akun Admin Divisi';
        form.reset();
        form.action = @js(route('superadmin.adminDivisi.store'));
        document.getElementById('adminMethod').disabled = true;
        document.getElementById('adminId').value = '';
        document.getElementById('inputIdKategori').value = '';
        document.getElementById('inputPassword').required = true;
    }
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    document.getElementById('adminModal').classList.add('hidden');
    document.getElementById('adminModal').classList.remove('flex');
    document.getElementById('adminForm').reset();
}

function editAdmin(id, nama, email, status = 'aktif', id_kategori = null) {
    openModal('edit', { id_user: id, nama: nama, email: email, status: status, id_kategori: id_kategori });
}

function deleteAdmin(id) {
    const form = document.getElementById('deleteForm');
    form.action = @js(route('superadmin.adminDivisi.destroy', ['id' => '__ID__'])).replace('__ID__', encodeURIComponent(id));
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
}

// Search and Filter (live, client-side — dipakai juga oleh pencarian global di header)
function applyListFilters() {
    const input = document.getElementById('searchInput');
    const statusSelect = document.getElementById('statusFilter');
    const q = (input && input.value || '').trim().toLowerCase();
    const status = statusSelect ? statusSelect.value : '';
    let visible = 0;

    document.querySelectorAll('[data-search]').forEach(function (el) {
        const matchQuery = !q || (el.dataset.search || '').indexOf(q) !== -1;
        const matchStatus = !status || (el.dataset.status || '') === status;
        const show = matchQuery && matchStatus;
        el.classList.toggle('hidden', !show);
        if (show) visible++;
    });

    const empty = document.getElementById('listFilterEmpty');
    const total = document.querySelectorAll('[data-search]').length;
    // Hanya tampilkan kalau memang ada baris yang tersaring habis (bukan data kosong dari server)
    if (empty) empty.classList.toggle('hidden', !(visible === 0 && total > 0));
}

document.getElementById('searchInput').addEventListener('input', applyListFilters);
document.getElementById('statusFilter').addEventListener('change', applyListFilters);

@if($errors->any())
document.addEventListener('DOMContentLoaded', function() {
    openModal('add');
});
@endif
</script>
@endpush

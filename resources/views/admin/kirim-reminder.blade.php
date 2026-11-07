@extends('layouts.admin')

@section('title', 'Kirim Reminder')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- HEADER -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.monitoring-siswa') }}" class="p-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 transition">
            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex-1">
            <h1 class="text-2xl font-extrabold text-slate-800">Kirim Reminder</h1>
            <p class="text-slate-500 text-sm mt-0.5">Berikan pengingat atau instruksi kepada siswa mengenai progress belajar mereka.</p>
        </div>
        <div class="hidden sm:flex items-center gap-2 px-4 py-2 bg-indigo-50 border border-indigo-200 rounded-xl">
            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <span class="text-xs font-bold text-indigo-700">Read-Only untuk Siswa</span>
        </div>
    </div>

    <!-- FORM CARD -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

        @if(session('success'))
        <div class="mb-5 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold rounded-xl flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('admin.kirim-reminder.store') }}" class="space-y-5">
            @csrf

            <!-- Pilih Siswa -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Pilih Siswa <span class="text-rose-500">*</span>
                </label>
                <select name="id_user" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
                        <option value="">-- Pilih Siswa --</option>
                        <option value="all" @selected(old('id_user') === 'all')>📢 Semua Siswa (Kirim Massal / Broadcast)</option>
                        @foreach($siswa as $s)
                            <option value="{{ $s->id_user }}" @selected((string) old('id_user', request('id_user')) === (string) $s->id_user)>{{ $s->nama }} ({{ $s->email }})</option>
                        @endforeach
                </select>
                @error('id_user')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Isi Pesan -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Isi Reminder <span class="text-rose-500">*</span>
                </label>
                <textarea name="pesan" rows="6" required maxlength="1000"
                          placeholder="Contoh: Halo, nilai quiz Reading kamu masih di bawah 60. Tolong pelajari kembali Bab 3 dan kerjakan ulang quiz-nya ya!"
                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 resize-none transition"></textarea>
                <div class="flex items-center justify-between mt-1">
                    <p class="text-xs text-slate-400">Siswa hanya bisa membaca reminder ini dan tidak dapat membalas.</p>
                    <p class="text-xs text-slate-400"><span id="charCount">0</span>/1000</p>
                </div>
                @error('pesan')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div class="pt-2 flex gap-3">
                <button type="reset" class="px-6 py-3 border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition">
                    Reset
                </button>
                <button type="submit" class="flex-1 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition flex items-center justify-center gap-2 shadow-lg shadow-indigo-600/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Kirim Reminder
                </button>
            </div>
        </form>
    </div>

    <!-- INFO BOX -->
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 flex items-start gap-3">
        <svg class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <p class="text-xs font-bold text-blue-800 mb-1">Tips Penggunaan Reminder:</p>
            <ul class="text-xs text-blue-700 space-y-1 list-disc list-inside">
                <li>Gunakan untuk memberi feedback progress belajar siswa</li>
                <li>Berikan instruksi spesifik yang harus dilakukan siswa</li>
                <li>Siswa akan mendapat notifikasi saat reminder baru masuk</li>
                <li>Siswa tidak dapat membalas reminder ini</li>
            </ul>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
// Character counter
const textarea = document.querySelector('textarea[name="pesan"]');
const charCount = document.getElementById('charCount');

textarea.addEventListener('input', function() {
    charCount.textContent = this.value.length;
});
</script>
@endpush

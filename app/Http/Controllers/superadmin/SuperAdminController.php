<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Support\SystemNotifications;

class SuperAdminController extends Controller
{
    /**
     * Redirect kembali ke halaman asal (dashboard / kelola akun).
     * Jadi kalau edit/hapus dari dashboard ya tetap di dashboard,
     * kalau dari halaman kelola ya tetap di sana.
     * Data tetap sinkron karena sumbernya satu tabel users.
     */
    private function redirectStay(string $fallbackRoute, string $message)
    {
        $previous = url()->previous();
        $fallback = route($fallbackRoute);

        if ($previous && $previous !== $fallback) {
            // Hanya izinkan redirect internal area superadmin (cegah open redirect)
            $prevPath = parse_url($previous, PHP_URL_PATH) ?? '';
            if (str_contains($prevPath, '/superadmin')) {
                // Kalau dari dashboard, tambahkan anchor biar langsung scroll ke tabel kelola akun
                if (str_contains($prevPath, '/superadmin/dashboard') && !str_contains($previous, '#')) {
                    $previous .= '#tabel-kelola-akun';
                }
                return redirect()->to($previous)->with('success', $message);
            }
        }

        return redirect()->route($fallbackRoute)->with('success', $message);
    }

    public function index()
    {
        // Ambil data siswa dan admin terbaru (misal 5 data terakhir) untuk ditampilkan di tabel dashboard
        $students = User::where('id_role', 3)->latest()->take(5)->get();
        $admins = User::where('id_role', 2)->latest()->take(5)->get();

        // Statistik dashboard (dipakai bersama oleh halaman & API real-time)
        $stats = $this->dashboardStats();

        return view('superadmin.dashboard', $stats + compact('students', 'admins'));
    }

    // API: Statistik dashboard real-time (JSON) — dipolling oleh frontend
    public function apiDashboardStats()
    {
        return response()->json([
            'status'  => 'success',
            'message' => 'Statistik dashboard berhasil dimuat',
            'data'    => $this->dashboardStats(),
        ]);
    }

    /**
     * Hitung semua statistik dashboard dari database (real, sesuai waktu server).
     * Dipakai oleh index() (render awal) dan apiDashboardStats() (refresh real-time).
     */
    private function dashboardStats(): array
    {
        $totalSiswa = User::where('id_role', 3)->count();
        $totalAdmin = User::where('id_role', 2)->count();
        $totalDivisi = Kategori::count();

        $now = now();
        $startThisMonth = $now->copy()->startOfMonth();
        $startLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endLastMonth = $startThisMonth->copy()->subSecond();

        // Pertumbuhan bulan ini vs bulan lalu (untuk badge card)
        $siswaThisMonth = User::where('id_role', 3)->where('created_at', '>=', $startThisMonth)->count();
        $siswaLastMonth = User::where('id_role', 3)->whereBetween('created_at', [$startLastMonth, $endLastMonth])->count();
        $adminThisMonth = User::where('id_role', 2)->where('created_at', '>=', $startThisMonth)->count();
        $adminLastMonth = User::where('id_role', 2)->whereBetween('created_at', [$startLastMonth, $endLastMonth])->count();
        $divisiThisMonth = Kategori::where('created_at', '>=', $startThisMonth)->count();
        $divisiLastMonth = Kategori::whereBetween('created_at', [$startLastMonth, $endLastMonth])->count();
        // Cakupan akun yang dikelola (siswa + admin, tanpa superadmin)
        $managedThisMonth = User::whereIn('id_role', [2, 3])->where('created_at', '>=', $startThisMonth)->count();
        $managedLastMonth = User::whereIn('id_role', [2, 3])->whereBetween('created_at', [$startLastMonth, $endLastMonth])->count();

        $siswaGrowth = $this->monthGrowth($siswaThisMonth, $siswaLastMonth);
        $adminGrowth = $this->monthGrowth($adminThisMonth, $adminLastMonth);
        $divisiGrowth = $this->monthGrowth($divisiThisMonth, $divisiLastMonth);
        $divisiTrend = $this->trendBadge($divisiThisMonth, $divisiLastMonth);

        // Ringkasan: akun baru 7 hari terakhir vs 7 hari sebelumnya
        $weekAgo = $now->copy()->subDays(7);
        $twoWeeksAgo = $now->copy()->subDays(14);
        $newSiswaCount = User::where('id_role', 3)->where('created_at', '>=', $weekAgo)->count();
        $prevSiswaCount = User::where('id_role', 3)->whereBetween('created_at', [$twoWeeksAgo, $weekAgo])->count();
        $newAdminCount = User::where('id_role', 2)->where('created_at', '>=', $weekAgo)->count();
        $prevAdminCount = User::where('id_role', 2)->whereBetween('created_at', [$twoWeeksAgo, $weekAgo])->count();
        $newSiswaGrowth = $this->trendBadge($newSiswaCount, $prevSiswaCount);
        $newAdminGrowth = $this->trendBadge($newAdminCount, $prevAdminCount);

        $activeAccounts = User::whereIn('id_role', [2, 3])->where('status', 'aktif')->count();
        $activeGrowth = $this->trendBadge($managedThisMonth, $managedLastMonth);

        $totalAkun = User::whereIn('id_role', [2, 3])->count();
        $totalAkunGrowth = $this->trendBadge($managedThisMonth, $managedLastMonth);

        // Grafik pertumbuhan siswa 7 hari terakhir (kumulatif, label tanggal nyata)
        $windowStart = $now->copy()->subDays(6)->startOfDay();
        $perDay = User::where('id_role', 3)->where('created_at', '>=', $windowStart)
            ->selectRaw('DATE(created_at) as d, COUNT(*) as c')
            ->groupBy('d')
            ->pluck('c', 'd');
        $base = User::where('id_role', 3)->where('created_at', '<', $windowStart)->count();
        $chartLabels = [];
        $chartData = [];

        // Grafik admin divisi (kumulatif) + jumlah akun baru per hari
        $perDayAdmin = User::where('id_role', 2)->where('created_at', '>=', $windowStart)
            ->selectRaw('DATE(created_at) as d, COUNT(*) as c')
            ->groupBy('d')
            ->pluck('c', 'd');
        $baseAdmin = User::where('id_role', 2)->where('created_at', '<', $windowStart)->count();

        $chartAdminData = [];
        $chartSiswaHarian = [];
        $chartAdminHarian = [];
        $running = $base;
        $runningAdmin = $baseAdmin;
        for ($i = 6; $i >= 0; $i--) {
            $day = $now->copy()->subDays($i);
            $key = $day->format('Y-m-d');
            $running += (int) ($perDay[$key] ?? 0);
            $runningAdmin += (int) ($perDayAdmin[$key] ?? 0);
            $chartLabels[] = $day->format('j M');
            $chartData[] = $running;
            $chartAdminData[] = $runningAdmin;
            $chartSiswaHarian[] = (int) ($perDay[$key] ?? 0);
            $chartAdminHarian[] = (int) ($perDayAdmin[$key] ?? 0);
        }
        $peak = !empty($chartData) ? max($chartData) : 0;
        $chartMax = $peak <= 0 ? 10 : (int) (ceil(($peak * 1.2) / 10) * 10);
        $chartStep = max(1, (int) round($chartMax / 5));

        // Aktivitas terbaru: 5 akun siswa/admin yang paling baru dibuat
        $recentActivities = User::whereIn('id_role', [2, 3])->latest()->take(5)->get()->map(function ($u) {
            $isAdmin = (int) $u->id_role === 2;
            return (object) [
                'title' => 'Akun baru: ' . $u->nama,
                'desc' => $u->email . ' • ' . ($u->created_at ? $u->created_at->format('d M Y H:i') : '-'),
                'time' => $u->created_at ? $u->created_at->diffForHumans() : '-',
                'role' => $isAdmin ? 'Admin Divisi' : 'Siswa',
                'badge_class' => $isAdmin
                    ? 'bg-violet-50 text-violet-600 border-violet-200'
                    : 'bg-blue-50 text-blue-600 border-blue-200',
            ];
        })->values();

        $systemStatus = 'Normal';
        $generatedAt = $now->format('d M Y H:i:s');

        return compact(
            'totalSiswa', 'totalAdmin', 'totalDivisi',
            'siswaGrowth', 'adminGrowth', 'divisiGrowth', 'divisiTrend',
            'newSiswaCount', 'newAdminCount', 'newSiswaGrowth', 'newAdminGrowth',
            'activeAccounts', 'activeGrowth', 'totalAkun', 'totalAkunGrowth',
            'chartLabels', 'chartData', 'chartMax', 'chartStep',
            'chartAdminData', 'chartSiswaHarian', 'chartAdminHarian',
            'recentActivities', 'systemStatus', 'generatedAt'
        );
    }

    /**
     * Persentase perubahan bulan ini vs bulan lalu, format "+ 12%" / "- 3%".
     */
    private function monthGrowth(int $current, int $previous): string
    {
        if ($previous <= 0) {
            return $current > 0 ? '+ 100%' : '+ 0%';
        }
        $p = (int) round(($current - $previous) / $previous * 100);
        return ($p < 0 ? '- ' : '+ ') . abs($p) . '%';
    }

    /**
     * Badge tren untuk ringkasan, format "▲ 20%" / "▼ 5%".
     */
    private function trendBadge(int $current, int $previous): string
    {
        if ($previous <= 0) {
            return $current > 0 ? '▲ 100%' : '▲ 0%';
        }
        $p = (int) round(($current - $previous) / $previous * 100);
        return ($p < 0 ? '▼ ' : '▲ ') . abs($p) . '%';
    }

    public function users()
    {
        return redirect('/superadmin/admin-divisi');
    }

    // API: Daftar semua user (JSON)
    public function apiUsers(Request $request)
    {
        $query = User::with(['role', 'kategori'])->latest();

        if ($request->filled('q')) {
            $q = '%' . $request->q . '%';
            $query->where(function ($sub) use ($q) {
                $sub->where('nama', 'like', $q)
                    ->orWhere('email', 'like', $q);
            });
        }

        if ($request->filled('role')) {
            $roleVal = $request->role;
            if (is_numeric($roleVal)) {
                $query->where('id_role', (int) $roleVal);
            } else {
                $roleId = match (strtolower($roleVal)) {
                    'superadmin', 'super_admin' => 1,
                    'admin', 'admin_divisi'     => 2,
                    'siswa', 'student'          => 3,
                    default                     => null,
                };
                if ($roleId) {
                    $query->where('id_role', $roleId);
                }
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil dimuat',
            'data'    => $users,
        ]);
    }

    // API: Detail satu user berdasarkan ID (JSON)
    public function apiShowUser($id)
    {
        $user = User::with(['role', 'kategori'])->find($id);

        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Pengguna tidak ditemukan',
                'data'    => null,
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Detail pengguna berhasil dimuat',
            'data'    => $user,
        ]);
    }

    public function storeUser(Request $request)
    {
        // Modal "Tambah Akun" di dashboard punya pilihan role siswa / admin
        if ($request->input('role') === 'admin') {
            return $this->storeAdminDivisi($request);
        }

        return $this->storeSiswa($request);
    }

    public function updateUser(Request $request, $id)
    {
        // Modal "Edit Akun" di dashboard: arahkan sesuai role asli user
        $user = User::findOrFail($id);

        if ((int) $user->id_role === 1) {
            return back()->with('error', 'Profil Super Admin hanya dapat diedit melalui menu Profil!');
        }

        if ((int) $user->id_role === 2) {
            return $this->updateAdminDivisi($request, $id);
        }

        return $this->updateSiswa($request, $id);
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        if ((int) $user->id_role === 1) {
            return back()->with('error', 'Akun Super Admin tidak dapat dihapus!');
        }

        if ((int) $user->id_role === 2) {
            return $this->destroyAdminDivisi($id);
        }

        return $this->destroySiswa($id);
    }

    // =========================================================
    // PENCARIAN GLOBAL (header) — live, dipakai dropdown pencarian
    // =========================================================
    public function apiSearch(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        if (mb_strlen($q) < 2) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Masukkan minimal 2 karakter',
                'data'    => ['q' => $q, 'items' => []],
            ]);
        }

        $like = '%' . $q . '%';
        $items = [];

        User::whereIn('id_role', [2, 3])
            ->where(fn ($query) => $query->where('nama', 'like', $like)->orWhere('email', 'like', $like))
            ->latest()
            ->take(8)
            ->get()
            ->each(function (User $user) use (&$items) {
                $siswa = (int) $user->id_role === 3;
                $items[] = [
                    'type'     => $siswa ? 'siswa' : 'admin',
                    'group'    => $siswa ? 'Akun Siswa' : 'Admin Divisi',
                    'title'    => $user->nama,
                    'subtitle' => $user->email,
                    'meta'     => (($user->status ?: 'aktif') === 'aktif' ? 'Aktif' : 'Nonaktif')
                        . ' · terdaftar ' . $user->created_at->format('d M Y'),
                    'url'      => $siswa
                        ? route('superadmin.siswa', ['q' => $user->nama])
                        : route('superadmin.adminDivisi', ['q' => $user->nama]),
                ];
            });

        usort($items, fn ($a, $b) => [$a['group'], $a['title']] <=> [$b['group'], $b['title']]);

        return response()->json([
            'status'  => 'success',
            'message' => $items ? 'Hasil ditemukan' : 'Tidak ada hasil',
            'data'    => ['q' => $q, 'items' => $items],
        ]);
    }

    // =========================================================
    // KELOLA AKUN SISWA (Role ID = 3)
    // =========================================================
    public function siswa(Request $request)
    {
        $idRoleSiswa = 3;
        $q = trim((string) $request->query('q', ''));

        $studentsQuery = User::where('id_role', $idRoleSiswa);
        if ($q !== '') {
            $like = '%' . $q . '%';
            $studentsQuery->where(fn ($query) => $query->where('nama', 'like', $like)->orWhere('email', 'like', $like));
        }

        $students = $studentsQuery->latest()->paginate(10)->withQueryString();
        $totalStudents = User::where('id_role', $idRoleSiswa)->count();

        $startThisMonth = now()->startOfMonth();
        $siswaThisMonth = User::where('id_role', $idRoleSiswa)->where('created_at', '>=', $startThisMonth)->count();
        $siswaLastMonth = User::where('id_role', $idRoleSiswa)
            ->whereBetween('created_at', [now()->subMonth()->startOfMonth(), $startThisMonth->copy()->subSecond()])
            ->count();
        $studentsGrowth = $this->monthGrowth($siswaThisMonth, $siswaLastMonth);

        return view('superadmin.siswa', compact('students', 'totalStudents', 'q', 'studentsGrowth'));
    }

    public function storeSiswa(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'nullable|string|min:6',
            'status' => 'nullable|in:aktif,nonaktif',
        ]);

        $idRoleSiswa = 3;

        // Membuat username unik otomatis dari depan email (dengan proteksi tabrakan)
        $baseUsername = Str::slug(explode('@', $request->email)[0]) ?: 'siswa';
        $username = $baseUsername . '-' . rand(100, 999);
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . '-' . rand(1000, 9999);
        }

        User::create([
            'nama' => $request->nama,
            'username' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->input('password') ?: 'password123'),
            'id_role' => $idRoleSiswa,
            'status' => $request->input('status', 'aktif'),
            // Siswa wajib ganti password pada login pertama
            'must_change_password' => true,
        ]);

        return $this->redirectStay('superadmin.siswa', 'Akun siswa berhasil ditambahkan! 🐾');
    }

    public function updateSiswa(Request $request, $id)
    {
        $student = User::where('id_role', 3)->findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $student->id_user . ',id_user',
            'password' => 'nullable|string|min:6',
            'status' => 'nullable|in:aktif,nonaktif',
        ]);

        $student->nama = $request->nama;
        $student->email = $request->email;
        if ($request->filled('status')) {
            $student->status = $request->status;
        }

        if ($request->filled('password')) {
            $student->password = Hash::make($request->password);
            // Password direset oleh superadmin -> siswa wajib menggantinya saat login
            $student->must_change_password = true;
        }
        $student->save();

        return $this->redirectStay('superadmin.siswa', 'Akun siswa berhasil diperbarui! 🐾');
    }

    public function destroySiswa($id)
    {
        User::where('id_role', 3)->findOrFail($id)->delete();
        return $this->redirectStay('superadmin.siswa', 'Akun siswa berhasil dihapus! 🐾');
    }

    // =========================================================
    // KELOLA ADMIN DIVISI (Role ID = 2)
    // =========================================================
    public function adminDivisi(Request $request)
    {
        $idRoleAdmin = 2;
        $q = trim((string) $request->query('q', ''));

        $adminsQuery = User::where('id_role', $idRoleAdmin);
        if ($q !== '') {
            $like = '%' . $q . '%';
            $adminsQuery->where(fn ($query) => $query->where('nama', 'like', $like)->orWhere('email', 'like', $like));
        }

        $admins = $adminsQuery->latest()->paginate(10)->withQueryString();
        $totalAdmins = User::where('id_role', $idRoleAdmin)->count();

        $startThisMonth = now()->startOfMonth();
        $adminThisMonth = User::where('id_role', $idRoleAdmin)->where('created_at', '>=', $startThisMonth)->count();
        $adminLastMonth = User::where('id_role', $idRoleAdmin)
            ->whereBetween('created_at', [now()->subMonth()->startOfMonth(), $startThisMonth->copy()->subSecond()])
            ->count();
        $adminsGrowth = $this->monthGrowth($adminThisMonth, $adminLastMonth);

        return view('superadmin.admin-divisi', compact('admins', 'totalAdmins', 'q', 'adminsGrowth'));
    }

    public function storeAdminDivisi(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'nullable|string|min:6',
            'status' => 'nullable|in:aktif,nonaktif',
            'id_kategori' => 'nullable|exists:kategori,id_kategori',
        ]);

        $idRoleAdmin = 2;

        // Membuat username unik otomatis dari depan email (dengan proteksi tabrakan)
        $baseUsername = Str::slug(explode('@', $request->email)[0]) ?: 'admin';
        $username = $baseUsername . '-' . rand(100, 999);
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . '-' . rand(1000, 9999);
        }

        User::create([
            'nama' => $request->nama,
            'username' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->input('password') ?: 'password123'),
            'id_role' => $idRoleAdmin,
            'id_kategori' => $request->input('id_kategori'),
            'status' => $request->input('status', 'aktif'),
            // Admin divisi TIDAK wajib ganti password pada login pertama
            'must_change_password' => false,
        ]);

        return $this->redirectStay('superadmin.adminDivisi', 'Akun admin divisi berhasil ditambahkan! 🐾');
    }

    public function updateAdminDivisi(Request $request, $id)
    {
        $admin = User::where('id_role', 2)->findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id_user . ',id_user',
            'password' => 'nullable|string|min:6',
            'status' => 'nullable|in:aktif,nonaktif',
            'id_kategori' => 'nullable|exists:kategori,id_kategori',
        ]);

        $admin->nama = $request->nama;
        $admin->email = $request->email;

        if ($request->filled('status')) {
            $admin->status = $request->status;
        }

        if ($request->filled('id_kategori')) {
            $admin->id_kategori = $request->id_kategori;
        }

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
            // Admin divisi tidak pernah dipaksa ganti password
            $admin->must_change_password = false;
        }
        $admin->save();

        return $this->redirectStay('superadmin.adminDivisi', 'Akun admin divisi berhasil diperbarui! 🐾');
    }

    public function destroyAdminDivisi($id)
    {
        User::where('id_role', 2)->findOrFail($id)->delete();
        return $this->redirectStay('superadmin.adminDivisi', 'Akun admin divisi berhasil dihapus! 🐾');
    }

    // =========================================================
    // HALAMAN LAINNYA (Placeholder View)
    // =========================================================
    public function divisi() { return redirect()->route('superadmin.adminDivisi'); }

    public function settings()
    {
        $stats = $this->dashboardStats();

        // Jumlah materi per divisi (kategori) + admin yangangani
        $materiPerKategori = DB::table('materi')
            ->select('id_kategori', DB::raw('count(*) as jml'))
            ->groupBy('id_kategori')
            ->pluck('jml', 'id_kategori');

        $divisi = Kategori::orderBy('id_kategori')->get()->map(function ($kategori) use ($materiPerKategori) {
            $jumlahAdmin = User::where('id_role', 2)
                ->where('id_kategori', $kategori->id_kategori)
                ->count();

            return [
                'nama'    => $kategori->nama_kategori,
                'admin'   => $jumlahAdmin,
                'materi'  => (int) ($materiPerKategori[$kategori->id_kategori] ?? 0),
            ];
        })->values();

        // Aktivitas sistem = seluruh event yang tercatat di database
        $totalAktivitas = DB::table('hasil_quiz')->count()
            + DB::table('progress_materi')->count()
            + DB::table('pesan_admin')->count()
            + DB::table('users')->count();

        // Status database & API
        try {
            DB::select('select 1');
            $statusDatabase = 'Normal';
            $warnaDatabase  = ['bg-emerald-50', 'text-emerald-700', 'bg-emerald-500'];
        } catch (\Throwable $e) {
            $statusDatabase = 'Gangguan';
            $warnaDatabase  = ['bg-rose-50', 'text-rose-700', 'bg-rose-500'];
        }

        $statusApi = Route::has('api.dashboard.stats') || Route::has('superadmin.dashboard.stats') ? 'Aktif' : 'Nonaktif';

        return view('superadmin.settings', $stats + compact(
            'divisi',
            'totalAktivitas',
            'statusDatabase',
            'warnaDatabase',
            'statusApi'
        ));
    }

    public function profile() { return view('superadmin.profile'); }

    // =========================================================
    // HALAMAN DATA SISTEM (status, info, penyimpanan, aktivitas)
    // =========================================================
    public function dataSistem()
    {
        return view('superadmin.data-sistem', $this->systemOverview());
    }

    /**
     * Data untuk halaman Data Sistem: status database, info sistem,
     * penggunaan penyimpanan, statistik akun, aktivitas & pembaruan terakhir.
     */
    private function systemOverview(): array
    {
        // --- Status database ---
        $dbStatus = 'Online';
        $dbVersion = null;
        try {
            $dbVersion = DB::getPdo()->getAttribute(\PDO::ATTR_SERVER_VERSION);
        } catch (\Throwable $e) {
            $dbStatus = 'Offline';
        }

        // --- Info sistem ---
        $connection = config('database.connections.' . config('database.default'), []);
        $serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? 'PHP Built-in Server';

        $systemInfo = [
            'env'          => app()->environment(),
            'app_name'     => config('app.name'),
            'app_version'  => config('app.version', '1.0.0'),
            'framework'    => 'Laravel ' . app()->version(),
            'database'     => strtoupper(config('database.default', 'mysql'))
                . ($dbVersion ? ' ' . $dbVersion : (isset($connection['driver']) ? ' (' . $connection['driver'] . ')' : '')),
            'server'       => $serverSoftware,
            'php_version'  => PHP_VERSION,
        ];

        // --- Penggunaan penyimpanan (disk tempat aplikasi berjalan) ---
        $storageInfo = [
            'total_gb' => 0,
            'used_gb'  => 0,
            'free_gb'  => 0,
            'percent'  => 0,
        ];
        $total = @disk_total_space(base_path());
        $free  = @disk_free_space(base_path());
        if ($total && $free !== false && $total > 0) {
            $used = max(0, $total - $free);
            $storageInfo = [
                'total_gb' => round($total / 1073741824, 1),
                'used_gb'  => round($used / 1073741824, 1),
                'free_gb'  => round($free / 1073741824, 1),
                'percent'  => min(100, (int) round(($used / $total) * 100)),
            ];
        }

        // --- Statistik akun ---
        $countAccounts = function (int $role, ?string $status) {
            return User::where('id_role', $role)
                ->when($status !== null, fn ($q) => $q->where('status', $status))
                ->count();
        };

        $siswaTotal  = $countAccounts(3, null);
        $siswaAktif  = $countAccounts(3, 'aktif');
        $adminTotal  = $countAccounts(2, null);
        $adminAktif  = $countAccounts(2, 'aktif');

        $accountStats = [
            'siswa_total'     => $siswaTotal,
            'siswa_aktif'     => $siswaAktif,
            'siswa_nonaktif'  => max(0, $siswaTotal - $siswaAktif),
            'admin_total'     => $adminTotal,
            'admin_aktif'     => $adminAktif,
            'admin_nonaktif'  => max(0, $adminTotal - $adminAktif),
        ];

        // --- Pembaruan terakhir (created_at / updated_at per jenis akun) ---
        $lastUpdate = [
            'siswa' => User::where('id_role', 3)->latest('updated_at')->value('updated_at'),
            'admin' => User::where('id_role', 2)->latest('updated_at')->value('updated_at'),
        ];

        // --- Aktivitas sistem terbaru (akun siswa & admin divisi) ---
        $recentActivities = User::whereIn('id_role', [2, 3])
            ->latest('updated_at')
            ->take(8)
            ->get()
            ->map(function (User $u) {
                $created   = $u->created_at;
                $updated   = $u->updated_at;
                $isNew     = $created && $updated && (int) $created->diffInSeconds($updated) < 1;
                $isAdmin   = (int) $u->id_role === 2;
                $waktu     = ($isNew ? $created : $updated) ?? $created;

                return [
                    'id_role' => (int) $u->id_role,
                    'is_new'  => (bool) $isNew,
                    'action'  => $isNew ? 'Akun baru: ' . $u->nama : 'Pembaruan akun: ' . $u->nama,
                    'nama'    => $u->nama,
                    'role'    => $isAdmin ? 'Admin Divisi' : 'Siswa',
                    'time'    => $waktu ? $waktu->toDateTimeString() : now()->toDateTimeString(),
                ];
            });

        return compact(
            'dbStatus',
            'systemInfo',
            'storageInfo',
            'accountStats',
            'lastUpdate',
            'recentActivities'
        );
    }

    // API: notifikasi sistem (real-time) — dari data nyata, dipolling oleh header layout
    public function apiNotifications()
    {
        $items = SystemNotifications::latest(10);

        return response()->json([
            'status'  => 'success',
            'message' => 'Notifikasi termuat',
            'data'    => [
                'items'         => $items,
                'unread'        => SystemNotifications::unreadCount($items),
                'generated_at'  => now()->toDateTimeString(),
            ],
        ]);
    }

    // =========================================================
    // PROFIL SUPER ADMIN (real-time)
    // =========================================================

    // Data profil terbaru langsung dari database (JSON), dipolling oleh halaman profil
    public function apiProfile()
    {
        $user = User::find(auth()->id());

        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Akun tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Data profil termuat',
            'data'    => $this->profilePayload($user),
        ]);
    }

    // Simpan perubahan profil (nama & email) ke database
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nama'  => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id_user . ',id_user',
        ]);

        $user->update([
            'nama'  => $request->nama,
            'email' => $request->email,
        ]);

        $data = $this->profilePayload($user->fresh());

        if ($request->wantsJson()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Profil berhasil diperbarui.',
                'data'    => $data,
            ]);
        }

        return $this->redirectStay('superadmin.profile', 'Profil berhasil diperbarui! 🐾');
    }

    // Payload standar profil yang dikirim ke halaman (render awal & polling JSON)
    private function profilePayload(User $user): array
    {
        $formatDate = fn ($value, string $fallback = '-') => $value
            ? \Carbon\Carbon::parse($value)->translatedFormat('d F Y')
            : $fallback;

        return [
            'nama'        => $user->nama,
            'email'       => $user->email,
            'role'        => $user->role?->nama_role ?? 'Super Admin',
            'status'      => $user->status ?: 'aktif',
            'registered'  => $formatDate($user->created_at),
            'joined'      => $formatDate($user->created_at),
            'lastLogin'   => $formatDate($user->last_login_at, '-'),
            'ip'          => request()->ip(),
        ];
    }
}

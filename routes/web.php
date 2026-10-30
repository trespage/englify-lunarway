<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Superadmin\SuperAdminController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BabController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\MateriController;
use App\Http\Controllers\Siswa\SiswaController;
use App\Http\Controllers\Admin\MonitoringController;

use App\Http\Controllers\ReviewController;

// =================================================================
// 1. LANDING PAGE & REVIEW
// =================================================================
Route::get('/', function () {
    $totalSiswa  = 100;
    $totalMateri = 40;
    $totalDivisi = 4;
    $reviews     = \App\Models\Review::where('is_approved', true)->latest()->get();

    return view('landing', compact('totalSiswa', 'totalMateri', 'totalDivisi', 'reviews'));
})->name('landing');

Route::post('/review', [ReviewController::class, 'store'])->name('review.store');


// =================================================================
// 2. AUTHENTICATION
// =================================================================
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('change.password');
    Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('update.password');
});


// =================================================================
// 3. SUPER ADMIN
// =================================================================
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [SuperAdminController::class, 'apiDashboardStats'])->name('dashboard.stats');
    Route::get('/notifications', [SuperAdminController::class, 'apiNotifications'])->name('notifications');
    Route::get('/search', [SuperAdminController::class, 'apiSearch'])->name('search');

    Route::get('/users', [SuperAdminController::class, 'users'])->name('users');
    Route::post('/users', [SuperAdminController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{id}', [SuperAdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [SuperAdminController::class, 'destroyUser'])->name('users.destroy');

    Route::get('/siswa', [SuperAdminController::class, 'siswa'])->name('siswa');
    Route::post('/siswa', [SuperAdminController::class, 'storeSiswa'])->name('siswa.store');
    Route::put('/siswa/{id}', [SuperAdminController::class, 'updateSiswa'])->name('siswa.update');
    Route::delete('/siswa/{id}', [SuperAdminController::class, 'destroySiswa'])->name('siswa.destroy');

    Route::get('/admin-divisi', [SuperAdminController::class, 'adminDivisi'])->name('adminDivisi');
    Route::post('/admin-divisi', [SuperAdminController::class, 'storeAdminDivisi'])->name('adminDivisi.store');
    Route::put('/admin-divisi/{id}', [SuperAdminController::class, 'updateAdminDivisi'])->name('adminDivisi.update');
    Route::delete('/admin-divisi/{id}', [SuperAdminController::class, 'destroyAdminDivisi'])->name('adminDivisi.destroy');

    Route::get('/divisi', [SuperAdminController::class, 'divisi'])->name('divisi');
    Route::get('/data-sistem', [SuperAdminController::class, 'dataSistem'])->name('dataSistem');
    Route::get('/settings', [SuperAdminController::class, 'settings'])->name('settings');
    Route::get('/profile', [SuperAdminController::class, 'profile'])->name('profile');
    Route::get('/profile/data', [SuperAdminController::class, 'apiProfile'])->name('profile.data');
    Route::put('/profile', [SuperAdminController::class, 'updateProfile'])->name('profile.update');
});


// =================================================================
// 4. ADMIN DIVISI
// =================================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/notifications', [AdminController::class, 'apiNotifications'])->name('notifications');

    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    Route::get('/bab', [BabController::class, 'index'])->name('bab');
    Route::post('/bab', [BabController::class, 'store'])->name('bab.store');
    Route::put('/bab/{id}', [BabController::class, 'update'])->name('bab.update');
    Route::delete('/bab/{id}', [BabController::class, 'destroy'])->name('bab.destroy');

    Route::get('/materi', [MateriController::class, 'index'])->name('materi');
    Route::post('/materi', [MateriController::class, 'store'])->name('materi.store');
    Route::put('/materi/{id}', [MateriController::class, 'update'])->name('materi.update');
    Route::delete('/materi/{id}', [MateriController::class, 'destroy'])->name('materi.destroy');
    Route::get('/api/babs-by-kategori/{kategoriId}', [BabController::class, 'apiByKategori'])->name('api.babs');

    Route::get('/quiz', [AdminController::class, 'quiz'])->name('quiz');
    Route::post('/quiz', [AdminController::class, 'storeQuiz'])->name('quiz.store');
    Route::put('/quiz/{id}', [AdminController::class, 'updateQuiz'])->name('quiz.update');
    Route::delete('/quiz/{id}', [AdminController::class, 'destroyQuiz'])->name('quiz.destroy');

    Route::get('/hasil-quiz', [AdminController::class, 'hasilQuiz'])->name('hasil-quiz');
    Route::get('/hasil-quiz/{id}', [AdminController::class, 'detailHasilQuiz'])->name('hasil-quiz.detail');

    Route::get('/monitoring-siswa', [MonitoringController::class, 'index'])->name('monitoring-siswa');
    Route::get('/monitoring-siswa/{id}', [MonitoringController::class, 'detail'])->name('monitoring-siswa.detail');

    Route::get('/profil', [AdminController::class, 'profil'])->name('profil');
    Route::put('/profil', [AdminController::class, 'updateProfil'])->name('profil.update');

    // ==========================================
    // KIRIM REMINDER (BARU)
    // ==========================================
    Route::get('/kirim-reminder', [AdminController::class, 'formKirimReminder'])->name('kirim-reminder');
    Route::post('/kirim-reminder', [AdminController::class, 'kirimReminder'])->name('kirim-reminder.store');
});


// =================================================================
// 5. SISWA
// =================================================================
Route::middleware(['auth', 'force.password.change', 'role:siswa', 'lock.learning'])->prefix('siswa')->name('siswa.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [SiswaController::class, 'index'])->name('dashboard');

    // Materi
    Route::get('/materi', [SiswaController::class, 'materi'])->name('materi');
    Route::get('/materi/{id}', [SiswaController::class, 'baca'])->name('materi.baca');

    // Peta Quiz
    Route::get('/peta-quiz', [SiswaController::class, 'petaQuiz'])->name('peta-quiz');

    // Quiz
    Route::get('/quiz', [SiswaController::class, 'quizList'])->name('quiz');
    Route::get('/quiz/{id}', [SiswaController::class, 'kerjakanQuiz'])->name('quiz.kerjakan');
    Route::post('/quiz/{id}/submit', [SiswaController::class, 'submitQuiz'])->name('quiz.submit');
    Route::get('/quiz/{id}/hasil', [SiswaController::class, 'hasilQuiz'])->name('quiz.hasil');

    // Progress Belajar
    Route::get('/progres', [SiswaController::class, 'progres'])->name('progres');

    // REMINDER (BARU)
    Route::get('/reminder', [SiswaController::class, 'reminder'])->name('reminder');
    Route::post('/reminder/{id}/read', [SiswaController::class, 'markAsRead'])->name('reminder.read');
    Route::delete('/reminder/{id}', [SiswaController::class, 'destroyReminder'])->name('reminder.destroy');
    Route::delete('/reminder-clear-all', [SiswaController::class, 'clearAllReminders'])->name('reminder.clearAll');

    // Profil
    Route::get('/profil', [SiswaController::class, 'profil'])->name('profil');
    Route::put('/profil', [SiswaController::class, 'updateProfil'])->name('profil.update');
    Route::post('/profil/password', [SiswaController::class, 'updatePassword'])->name('profil.password');

    // API
    Route::get('/api/progress', [SiswaController::class, 'apiProgress'])->name('api.progress');
});

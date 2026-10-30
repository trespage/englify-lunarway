<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\KategoriController;
use App\Http\Controllers\admin\BabController;
use App\Http\Controllers\admin\MateriController;
use App\Http\Controllers\admin\QuizController;
use App\Http\Controllers\admin\MonitoringController;
use App\Http\Controllers\siswa\SiswaController;
use App\Http\Controllers\superadmin\SuperAdminController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| API Routes — Sistem Englify
|--------------------------------------------------------------------------
| Semua endpoint memakai prefix /api otomatis dari bootstrap/app.php
| Contoh: GET /api/kategori, GET /api/materi, dst.
| Format response terstandar:
| {
|     "status": "success" | "error",
|     "message": "Deskripsi pesan",
|     "data": [...] | {...} | null
| }
|--------------------------------------------------------------------------
*/

// =================================================================
// 1. DATA MASTER & KURIKULUM (Publik / Integrasi Eksternal)
// =================================================================
Route::get('/kategori', [KategoriController::class, 'apiIndex'])->name('api.kategori');
Route::get('/kategori/{id}', [KategoriController::class, 'apiShow'])->name('api.kategori.detail');

Route::get('/bab', [BabController::class, 'apiIndex'])->name('api.bab');
Route::get('/bab/{id}', [BabController::class, 'apiShow'])->name('api.bab.detail');

Route::get('/materi', [MateriController::class, 'apiIndex'])->name('api.materi');
Route::get('/materi/{id}', [MateriController::class, 'apiShow'])->name('api.materi.detail');

Route::get('/quiz', [QuizController::class, 'apiIndex'])->name('api.quiz');
Route::get('/quiz/{id}', [QuizController::class, 'apiShow'])->name('api.quiz.detail');

Route::get('/reviews', [ReviewController::class, 'apiIndex'])->name('api.reviews');

// =================================================================
// 2. DATA MONITORING & PENGGUNA
// =================================================================
Route::get('/monitoring', [MonitoringController::class, 'apiIndex'])->name('api.monitoring');
Route::get('/monitoring/{id}', [MonitoringController::class, 'apiShow'])->name('api.monitoring.detail');

Route::get('/users', [SuperAdminController::class, 'apiUsers'])->name('api.users');
Route::get('/users/{id}', [SuperAdminController::class, 'apiShowUser'])->name('api.users.detail');

// =================================================================
// 3. PROGRESS SISWA (Memerlukan Sesi Login Siswa)
// =================================================================
Route::get('/siswa/progress', [SiswaController::class, 'apiProgress'])
    ->middleware(['web', 'auth'])
    ->name('api.siswa.progress');


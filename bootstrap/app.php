<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'force.password.change' => \App\Http\Middleware\ForcePasswordChange::class,
            'role'                  => \App\Http\Middleware\EnsureUserHasRole::class,
            'lock.learning'         => \App\Http\Middleware\LockActiveMateriAndQuiz::class,
        ]);

        $middleware->redirectUsersTo(function () {
            $user = \Illuminate\Support\Facades\Auth::user();
            if (!$user) {
                return route('login');
            }

            if (!empty($user->status) && strtolower(trim((string) $user->status)) === 'nonaktif') {
                \Illuminate\Support\Facades\Auth::logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();
                return route('login');
            }

            return match ((int) $user->id_role) {
                1 => route('superadmin.dashboard'),
                2 => route('admin.dashboard'),
                default => route('siswa.dashboard'),
            };
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // 1. Sistem Logging Berkas Terpusat (ke storage/logs/laravel.log)
        $exceptions->reportable(function (\Throwable $e) {
            $context = [
                'url'        => request()->fullUrl(),
                'method'     => request()->method(),
                'ip'         => request()->ip(),
                'user_agent' => request()->userAgent(),
                'file'       => $e->getFile(),
                'line'       => $e->getLine(),
            ];

            if ($e instanceof \PDOException || $e instanceof \Illuminate\Database\QueryException) {
                \Illuminate\Support\Facades\Log::channel('single')->critical('[DATABASE EXCEPTION] ' . $e->getMessage(), $context);
            }
        });

        // 2. Custom Error: PDOException / DB Connection Exception
        $exceptions->render(function (\PDOException $e, \Illuminate\Http\Request $request) {
            \Illuminate\Support\Facades\Log::channel('single')->critical('[DB CONNECTION FAILURE] ' . $e->getMessage(), [
                'url' => $request->fullUrl(),
                'ip'  => $request->ip(),
            ]);

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Terjadi kendala koneksi server. Silakan hubungi admin.',
                    'code'    => 500,
                ], 500);
            }

            return response()->view('errors.database', [
                'exception' => $e,
            ], 500);
        });

        // 3. Custom Error: QueryException (Koneksi Terputus atau Query Fatal)
        $exceptions->render(function (\Illuminate\Database\QueryException $e, \Illuminate\Http\Request $request) {
            $isConnectionFault = str_contains($e->getMessage(), 'Connection refused')
                || str_contains($e->getMessage(), 'SQLSTATE[HY000]')
                || str_contains($e->getMessage(), 'server has gone away')
                || str_contains($e->getMessage(), 'Access denied')
                || str_contains($e->getMessage(), 'Connection timed out');

            if ($isConnectionFault) {
                \Illuminate\Support\Facades\Log::channel('single')->critical('[DB CONNECTION REFUSED] ' . $e->getMessage(), [
                    'url' => $request->fullUrl(),
                    'ip'  => $request->ip(),
                ]);

                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Terjadi kendala koneksi server. Silakan hubungi admin.',
                        'code'    => 500,
                    ], 500);
                }

                return response()->view('errors.database', [
                    'exception' => $e,
                ], 500);
            }

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Terjadi kesalahan pada kueri basis data.',
                    'code'    => 500,
                ], 500);
            }

            return response()->view('errors.500', [
                'exception' => $e,
            ], 500);
        });

        // 4. Custom Error: 404 (Halaman / Endpoint Tidak Ditemukan)
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, \Illuminate\Http\Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Halaman atau endpoint tidak ditemukan (404).',
                    'code'    => 404,
                ], 404);
            }

            return response()->view('errors.404', [
                'exception' => $e,
            ], 404);
        });

        // 5. Custom Error: 403 (Akses Ditolak / Forbidden)
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e, \Illuminate\Http\Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini (403).',
                    'code'    => 403,
                ], 403);
            }

            return response()->view('errors.403', [
                'exception' => $e,
            ], 403);
        });

        $exceptions->render(function (\Illuminate\Auth\Access\AuthorizationException $e, \Illuminate\Http\Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Tindakan ini tidak diizinkan oleh sistem (403).',
                    'code'    => 403,
                ], 403);
            }

            return response()->view('errors.403', [
                'exception' => $e,
            ], 403);
        });

        // 6. Custom Error: 500 (HttpException status 500)
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, \Illuminate\Http\Request $request) {
            if ($e->getStatusCode() === 500) {
                \Illuminate\Support\Facades\Log::channel('single')->error('[HTTP 500 INTERNAL SERVER ERROR] ' . $e->getMessage(), [
                    'url' => $request->fullUrl(),
                    'ip'  => $request->ip(),
                ]);

                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Terjadi kesalahan pada server internal (500).',
                        'code'    => 500,
                    ], 500);
                }

                return response()->view('errors.500', [
                    'exception' => $e,
                ], 500);
            }
        });

        // 7. Custom Error: PostTooLargeException (Unggahan Terlalu Besar Melebihi post_max_size Server)
        $exceptions->render(function (\Illuminate\Http\Exceptions\PostTooLargeException $e, \Illuminate\Http\Request $request) {
            \Illuminate\Support\Facades\Log::channel('single')->warning('[UPLOAD TOO LARGE] Berkas unggahan melebihi kapasitas server.', [
                'url' => $request->fullUrl(),
                'ip'  => $request->ip(),
            ]);

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Ukuran berkas unggahan terlalu besar dan melebihi kapasitas server (413).',
                    'code'    => 413,
                ], 413);
            }

            return back()->withErrors(['error' => 'Ukuran berkas terlalu besar! Melebihi batas maksimal server. Silakan unggah berkas dengan ukuran lebih kecil.'])->withInput();
        });
    })->create();

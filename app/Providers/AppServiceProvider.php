<?php

namespace App\Providers;

use App\Support\SystemNotifications;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registrasi Kebijakan Otorisasi (Policies) secara eksplisit
        Gate::policy(\App\Models\HasilQuiz::class, \App\Policies\HasilQuizPolicy::class);
        Gate::policy(\App\Models\PesanAdmin::class, \App\Policies\PesanAdminPolicy::class);

        // Dukungan HTTPS di Lingkungan Hosting / Reverse Proxy (Cloudflare, cPanel, Nginx)
        if (config('app.env') === 'production' || request()->server('HTTP_X_FORWARDED_PROTO') === 'https') {
            URL::forceScheme('https');
        }

        // Notifikasi pada layout admin di isi dari data nyata (bukan dummy)
        View::composer('layouts.admin', function ($view) {
            $view->with('notifikasiTerbaru', SystemNotifications::latest(6));
        });

        View::composer('layouts.siswa', function ($view) {
            $user = auth()->user();
            $notif = $user ? SystemNotifications::forSiswa($user, 8) : [];
            $unreadCount = count(array_filter($notif, fn($n) => empty($n['is_read'])));
            $view->with([
                'notifikasiTerbaru' => $notif,
                'notifUnreadCount'  => $unreadCount,
            ]);
        });
    }
}

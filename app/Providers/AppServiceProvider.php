<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use App\Models\ActivityLogs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(\Illuminate\Http\Request $request): void
    {
        Event::listen(Login::class, function ($event) {
            ActivityLogs::create([
                'user_id'  => $event->user->id,
                'activity' => " Berhasil login.",
                'timestamp' => now(),
            ]);
        });

        Event::listen(Logout::class, function ($event) {
            ActivityLogs::create([
                'user_id'  => $event->user->id,
                'activity' => " Berhasil logout.",
                'timestamp' => now(),
            ]);
        });


        // https
        // if (config('app.env') === 'production') {
        //     URL::forceScheme('https');
        // }

        // http
        if (config('app.env') === 'production' && request()->isSecure()) {
            URL::forceScheme('https');
        }
        
        
    }
}

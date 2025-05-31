<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;

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
        Inertia::share([
            'csrf_token' => csrf_token(),
            'auth' => [
                'user' => fn () => Auth::check() ? Auth::user() : null,
            ],
            'flash' => fn () => [
                'success' => Session::get('success'),
                'error' => Session::get('error'),
            ],
            'errors' => fn () => Session::get('errors') ? Session::get('errors')->getBag('default')->getMessages() : (object) [],
        ]);
    }
}

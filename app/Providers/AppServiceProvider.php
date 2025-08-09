<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;


class AppServiceProvider extends ServiceProvider
{


    public const HOME = '/dashboard';

    /**
     * Récupère la route "home" selon le rôle utilisateur.
     */
    public static function home(): string
    {
        $user = Auth::user();

        if (!$user) {
            return self::HOME;
        }

        return match ($user->role) {
            'admin' => '/admin',
            'secretaire' => '/secretaire',
            default => self::HOME,
        };
    }

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
        //
    }
}

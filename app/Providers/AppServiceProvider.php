<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;



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
        // Activer le style Bootstrap pour la pagination
        Paginator::useBootstrap();

        // Ou pour Tailwind (par défaut sur Laravel 8+)
        // Paginator::useTailwind();

    }
}

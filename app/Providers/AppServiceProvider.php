<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

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
        // Active le style Bootstrap pour la pagination
        Paginator::useBootstrap();

        /**
         * Correction pour CSS/JS/IMG sur ngrok :
         * Forcer l'utilisation du schéma HTTPS quand le domaine est en *.ngrok-free.app
         */
        if (str_ends_with(request()->getHost(), '.ngrok-free.app')) {
            URL::forceScheme('https');
        }
    }
}

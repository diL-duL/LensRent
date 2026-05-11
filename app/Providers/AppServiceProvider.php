<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('manage-rental', function (User $user, \App\Models\Rental $rental) {
            // Admin bisa kelola semuanya, atau khusus customer harus milik sendiri
            if ($user->role === 'admin') {
                return true;
            }
            return $user->id === $rental->user_id;
        });
    }
}

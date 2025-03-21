<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('tax-accountant', function (User $user) {
            return $user->is_tax_accountant; // `is_tax_accountant` が true の場合のみ許可
        });
    }

    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // ... existing policies
        \App\Models\Booking::class => \App\Policies\BookingPolicy::class,
    ];
}

<?php

namespace App\Providers;
use App\Models\User;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    // public function boot(): void
    // {
    //     //
    // }

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is-admin', function (User $user) {
            return $user->role_id === 1; // Assuming 1 is the role_id for admin
        });
    }
}

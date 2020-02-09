<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes(function ($router) {
            $router->forAccessTokens();
        });

        Gate::define('admin', function ($user) {
            return $user->isAdmin();
        });
        Gate::define('club', function ($user) {
            return $user->isClub();
        });
        Gate::define('manage-member', function ($user) {
            return true;
        });

        $this->publishes([
            __DIR__ . '/../../vendor/almasaeed2010/adminlte/plugins' => public_path('vendor/adminlte'),
        ], 'public');
    }
}

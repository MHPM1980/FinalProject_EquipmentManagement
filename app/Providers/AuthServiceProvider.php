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
         'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin',function($user){
            return $user->role_id === 1;
        });

        Gate::define('isGestor',function($user){
            return $user->role_id === 2;
        });

        Gate::define('isFormador',function($user){
            return $user->role_id === 3;
        });

        Gate::define('isFormando',function($user){
            return $user->role_id === 4;
        });

        Passport::routes();
    }
}

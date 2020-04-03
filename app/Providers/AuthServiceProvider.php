<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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

         \Gate::define('permitidoadmin', function ($user) {

            if ($user->hasAnyRoles(['admin'])){
                return true;
            }
            return false;
        });

        \Gate::define('permitidouser', function ($user) {

            if ($user->hasAnyRoles(['user'])){
                return true;
            }
            return false;
        });

        \Gate::define('permitidoprof', function ($user) {

            if ($user->hasAnyRoles(['professor'])){
                return true;
            }
            return false;
        });
        
    }
}

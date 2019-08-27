<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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

		Passport::routes();
        Passport::routes(function ($router) {
            $router->forAccessTokens();
            $router->forTransientTokens();
        });
        /*
        Passport::tokensExpireIn(Carbon::now()->addMonth(12));
        Passport::refreshTokensExpireIn(Carbon::now()->addMinutes(1));
        */

        //
    }
}

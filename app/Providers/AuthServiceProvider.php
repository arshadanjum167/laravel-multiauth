<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Extensions\TokenToUserProvider;
use App\Extensions\AccessTokenGuard;

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
    //public function boot()
    //{
    //    $this->registerPolicies();
    //
    //    //
    //}
    public function boot()
    {
        $this->registerPolicies();
        // Passport::routes();
        
        // Passport::tokensExpireIn(now()->addDays(15));

        // Passport::refreshTokensExpireIn(now()->addDays(30));
		
        Auth::extend('access_token', function ($app, $name, array $config) {
            // automatically build the DI, put it as reference
		
            $userProvider = app(TokenToUserProvider::class);
			
            $request = app('request');
			return new AccessTokenGuard($userProvider, $request, $config);
		    
        });
        
    }
}

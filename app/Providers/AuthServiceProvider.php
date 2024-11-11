<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Repositories\User\IUserRepository;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

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
    public function boot(): void
    {
        // $this->registerPolicies();

        Auth::provider('ApiUsers', function ($app, array $config) {
            return new ApiUserProvider($app->make(IUserRepository::class));
        });
    }
}

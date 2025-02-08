<?php

namespace App\Providers;

use App\Models\Bike;
use App\Policies\BikePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    protected $policies = [
        Bike::class => BikePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

    }
}

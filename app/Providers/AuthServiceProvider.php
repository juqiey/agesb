<?php

namespace App\Providers;

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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        //Access for IT Team
        Gate::before(function ($user, $ability) {
            if ($user->role === 'admin') {
                return true;
            }
        });

        //Access for procurement only
        Gate::define('procurement', function ($user){
           return $user->department === 'PROCUREMENT';
        });

        //Access for operation department
        Gate::define('operation', function ($user){
           return in_array($user->department, ['OPERATION','TECHNICAL']);
        });

        //Confirmation
        Gate::define('confirm-action', function ($user){
           return in_array($user->department, ['OPERATION','TECHNICAL']) && in_array($user->position, [
                'TECHNICAL SUPERINTENDENT',
                   'MARINE SUPERINTENDENT',
                   'SENIOR EXECUTIVE CUM HSE'
               ]);
        });

        //CEO approval
        Gate::define('ceo-approve', function ($user){
           return $user->position === 'CHIEF EXECUTIVE OFFICER';
        });

    }
}

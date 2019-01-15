<?php

namespace App\Providers;

use App\Record;
use App\Policies\RecordPolicy;
use App\Program;
use App\Policies\ProgramPolicy;
use App\Role;
use App\Policies\RolePolicy;

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
        'App\Model' => 'App\Policies\ModelPolicy',
        Record::class => RecordPolicy::class,
        Program::class => ProgramPolicy::class,
        Role::class => RolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            if ($user->hasRole('Super User')) {
                return true;
            }
        });
    }
}

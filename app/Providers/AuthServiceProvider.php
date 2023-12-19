<?php

namespace App\Providers;

use App\Models\AdminUser;
use App\Models\CarUser;
use App\Models\Company;
use App\Models\CompanyOffice;
use App\Models\User;
use App\Policies\AdminUserPolicy;
use App\Policies\CarUserPolicy;
use App\Policies\CompanyOfficePolicy;
use App\Policies\CompanyPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        AdminUser::class => AdminUserPolicy::class,
        Company::class => CompanyPolicy::class,
        CompanyOffice::class => CompanyOfficePolicy::class,
        CarUser::class => CarUserPolicy::class,
//         'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }

        //
    }
}

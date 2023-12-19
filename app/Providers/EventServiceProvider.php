<?php

namespace App\Providers;

use App\Events\Authenticated;
use App\Events\CarCompanyUserCreatedEvent;
use App\Events\CompanyCreated;
use App\Events\CompanyUpdated;
use App\Events\CompanyUserCreatedEvent;
use App\Events\UserCreatedEvent;
use App\Events\UserCreatedEmail;
use App\Events\UserUpdated;
use App\Events\UserUpdatedEvent;
use App\Jobs\SendDailyLeaseMail;
use App\Listeners\CarCompanyUserCreatedListener;
use App\Listeners\CheckUserVerified;
use App\Listeners\CompanyCreatedMailer;
use App\Listeners\CompanyUpdatedMailer;
use App\Listeners\CompanyUserCreatedListener;
use App\Listeners\UserCreatedListener;
use App\Listeners\UserCreatedMailerEmail;
use App\Listeners\UserUpdatedListener;
use App\Listeners\UserUpdatedMailer;
use App\Models\AdminUser;
use App\Models\Car;
use App\Models\CarCompanyUser;
use App\Models\CarUser;
use App\Models\Company;
use App\Models\CompanyOffice;
use App\Models\CompanyUser;
use App\Observers\AdminUserObserver;
use App\Observers\CarCompanyUserObserver;
use App\Observers\CarObserver;
use App\Observers\CarUserObserver;
use App\Observers\CompanyOfficeObserver;
use App\Observers\CompanyUserObserver;
use App\Observers\CompanyObserver;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserCreatedEvent::class => [
            UserCreatedListener::class,
        ],
        Authenticated::class => [
            CheckUserVerified::class,
        ],
        UserUpdatedEvent::class => [
            UserUpdatedListener::class,
        ],
        CompanyUserCreatedEvent::class => [
            CompanyUserCreatedListener::class,
        ],


    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        AdminUser::observe(AdminUserObserver::class);
        Company::observe(CompanyObserver::class);
        CompanyUser::observe(CompanyUserObserver::class);
        CompanyOffice::observe(CompanyOfficeObserver::class);
        Car::observe(CarObserver::class);
        CarUser::observe(CarUserObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}

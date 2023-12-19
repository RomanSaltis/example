<?php

namespace App\Providers;

use App\Channels\LogChannel;
use App\Channels\SlackChannel;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
     /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Notification::extend('log', function ($app) {
            return new LogChannel();
        });
        Notification::extend('slack', function ($app) {
            return new SlackChannel();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}

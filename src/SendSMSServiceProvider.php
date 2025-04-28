<?php

namespace Amsiam\SendSMS;

use Illuminate\Support\ServiceProvider;

class SendSMSServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('sendsms', function ($app) {
            return new SendSMS();
        });
    }

    /**
     * Bootstrap the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/sendsms.php',
            'sms'
        );
        $this->publishes([
            __DIR__ . '/../config/sendsms.php' => config_path('sendsms.php'),
        ], 'config');

        // Load
    }
}

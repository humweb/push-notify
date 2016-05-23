<?php

namespace Humweb\PushNotify;

use Illuminate\Support\ServiceProvider;

class PushServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('push.auth', function ($app) {
            return new Auth($app);
        });
    }


    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/pusher.php' => config_path('pusher.php'),
        ]);
        $this->publishes([
            __DIR__.'/assets/js'  => public_path('js'),
            __DIR__.'/assets/css' => public_path('css'),
        ], 'public');
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'push.auth',
        ];
    }
}

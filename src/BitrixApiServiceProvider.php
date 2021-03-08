<?php

namespace PcWeb\BitrixApi;

use PcWeb\BitrixApi\BitrixSettings;
use PcWeb\BitrixApi\Response\BitrixResponseFactory;
use Illuminate\Support\ServiceProvider;

class BitrixApiServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'pcweb');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'pcweb');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/bitrix.php', 'bitrix');

        // Register the service the package provides.
        $this->app->singleton(BitrixApi::class, function ($app) {
            return new BitrixApi(new BitrixSettings(
                config('bitrix.webhookUrl'),
                config('bitrix.logDir'),
                config('bitrix.logEnabled'),
                config('bitrix.dumpLog'),
                config('bitrix.ignoreSsl'),
            ), $app->make(BitrixResponseFactory::class));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['bitrix'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/bitrix.php' => config_path('bitrix.php'),
        ], 'config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/pcweb'),
        ], 'bitrix.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/pcweb'),
        ], 'bitrixapi.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/pcweb'),
        ], 'bitrixapi.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}

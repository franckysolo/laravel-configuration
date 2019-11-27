<?php
   // Indy\src\ConfigurationServiceProvider.php
namespace Indy\LaravelConfiguration;

use Illuminate\Support\ServiceProvider;

/**
 * @author franckysolo
 * @version 1.0.0
 */
class ConfigurationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
        $this->registerResources();
        $this->registerMigrations();
        $this->registerPublishing();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/configuration.php', 'configuration');
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        $this->app['router']->namespace('Indy\\LaravelConfiguration\\Http\\Controllers')
             ->middleware(config('configuration.middlewares'))
             ->prefix(config('configuration.prefix'))
             ->group(function () {
                 $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
             });
    }

    /**
     * Register the package resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadJsonTranslationsFrom(__DIR__ . '/../resources/lang');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'configurations');
    }

    /**
     * Register the package migrations.
     *
     * @return void
     */
    protected function registerMigrations()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../databases/migrations');
        }
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../databases/migrations' => $this->app->databasePath('migrations'),
            ], 'configurations-migrations');

            $this->publishes([
                __DIR__ . '../resources/lang' => resource_path('lang/vendor/configurations'),
            ], 'configurations-translations');

            $this->publishes([
                __DIR__ . '/../resources/views' => $this->app->resourcePath('views/vendor/configurations'),
            ], 'configurations-views');
        }
    }
}

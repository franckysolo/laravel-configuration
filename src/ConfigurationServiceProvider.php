<?php
   // Indy\src\ConfigurationServiceProvider.php
namespace Indy\LaravelConfiguration;

use Illuminate\Support\ServiceProvider;
use Indy\LaravelConfiguration\Http\Middleware\Settings;
use Indy\LaravelConfiguration\Console\InstallConfigurationCommand as InstallPackage;

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
        $this->registerMiddleWare();
        $this->registerRoutes();
        $this->registerResources();
        $this->registerMigrations();
        $this->registerPublishing();
        $this->registerCommand();
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
        $this->loadJsonTranslationsFrom(__DIR__ . '/../resources/lang', 'configurations');

        if ($this->app->environment('testing')) {
            $dirname = __DIR__ . '/../tests/views';
        } else {
            $dirname = __DIR__ . '/../resources/views';
        }

        $this->loadViewsFrom($dirname, 'configurations');
    }

    /**
     * Register the package migrations.
     *
     * @return void
     */
    protected function registerMigrations()
    {
        if ($this->app->runningInConsole() && !$this->app->environment('testing')) {
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
               __DIR__ . '/../config/configuration.php' => config_path('configuration.php')
            ], 'configurations-settings');

            if ($this->app->environment('testing')) {
                $filename = 'migrations/0000_00_00_000000_create_configurations_table.php';
            } else {
                $filename = 'migrations/' . date('Y_m_d_His', time()) . '_create_configurations_table.php';
            }

            $this->publishes([
              __DIR__ . '/../databases/migrations/create_configurations_table.php.stub' => database_path($filename),
            ], 'configurations-migrations');

            $this->publishes([
                __DIR__ . '/../resources/lang' => $this->app->resourcePath('lang/vendor/configurations'),
            ], 'configurations-translations');

            if ($this->app->environment('testing')) {
                $dirname = __DIR__ . '/../tests/views';
            } else {
                $dirname = __DIR__ . '/../resources/views';
            }

            $this->publishes([
                $dirname => $this->app->resourcePath('views/vendor/configurations'),
            ], 'configurations-views');
        }
    }

    /**
     * Register the package middleware.
     *
     * @return void
     */
    protected function registerMiddleWare()
    {
        $router = $this->app['router'];
        $router->aliasMiddleware('settings', Settings::class);
    }

    /**
     * Register the package command.
     *
     * @return void
     */
    protected function registerCommand()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([InstallPackage::class]);
        }
    }
}

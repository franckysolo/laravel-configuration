<?php

namespace Indy\LaravelConfiguration\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Assert;

abstract class TestCase extends BaseTestCase
{
    /**
     * If testing db avaliable
     *
     * @var boolean
     */
    protected $dbTestEnable;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        //
        $this->app['config']->set('configuration.enable_toast', false);

        if ($this->dbTestEnable) {
            $this->loadMigrationsFrom(__DIR__ . '/migrations');
        }

        TestResponse::macro('assertMiddlewarePassed', function () {
            Assert::assertEquals('__passed__', $this->content());
        });
    }

    /**
     * provide Data configuration
     *
     * @return array
     */
    protected function provideData(): array
    {
        return [
          'name' => 'param_01',
          'value' => 120,
          'type' => 'int',
          'description' => 'Test param int'
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
          'driver'   => 'sqlite',
          'database' => ':memory:',
          'prefix'   => '',
        ]);
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array|null
     */
    protected function getPackageProviders($app): array
    {
        return ['Indy\LaravelConfiguration\ConfigurationServiceProvider'];
    }

    /**
     * Get application timezone.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return string|null
     */
    protected function getApplicationTimezone($app): string
    {
        return 'Europe/Paris';
    }

    /**
     * Call the given middleware.
     *
     * @param  string|string[]  $middleware
     * @param  string  $method
     * @param  array  $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function callMiddleware($middleware, $method = 'GET', array $data = [])
    {
        return $this->call(
            $method,
            $this->makeMiddlewareRoute($method, $middleware),
            $data
        );
    }

    /**
     * Call the given middleware using a JSON request.
     *
     * @param  string|string[]  $middleware
     * @param  string  $method
     * @param  array  $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function callMiddlewareJson($middleware, $method = 'GET', array $data = [])
    {
        return $this->json(
            $method,
            $this->makeMiddlewareRoute($method, $middleware),
            $data
        );
    }

    /**
     * Make a dummy route with the given middleware applied.
     *
     * @param  string  $method
     * @param  string|string[]  $middleware
     * @return string
     */
    protected function makeMiddlewareRoute($method, $middleware): string
    {
        $method = strtolower($method);

        return $this->app->make('router')->{$method}('/__middleware__', [
            'middleware' => $middleware,
            function () {
                return '__passed__';
            }
        ])->uri();
    }
}

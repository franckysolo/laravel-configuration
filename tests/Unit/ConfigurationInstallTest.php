<?php
namespace Indy\LaravelConfiguration\Tests\Unit;

use Indy\LaravelConfiguration\Configuration;
use Indy\LaravelConfiguration\Tests\TestCase;

use Illuminate\Support\Facades\File;

class ConfigurationInstallTest extends TestCase
{
    /**
     * @test
     */
    public function it_must_publish_config_file()
    {
        if (File::exists(config_path('configuration.php'))) {
            unlink(config_path('configuration.php'));
        }

        $this->assertFalse(File::exists(config_path('configuration.php')));

        $this->artisan('configuration:install');

        $this->assertTrue(File::exists(config_path('configuration.php')));
    }

    /**
     * @test
     */
    public function it_must_publish_migration_file()
    {
        $filename = database_path('migrations/0000_00_00_000000_create_configurations_table.php');

        if (File::exists($filename)) {
            unlink($filename);
        }

        $this->assertFalse(File::exists($filename));

        $this->artisan('configuration:install');

        $this->assertTrue(File::exists($filename));
    }

    /**
     * @test
     */
    public function it_must_publish_views()
    {
        $filename = resource_path('views/vendor/configurations');

        if (File::exists($filename)) {
            File::deleteDirectory($filename);
        }

        $this->assertFalse(File::exists($filename));

        $this->artisan('configuration:install');

        $this->assertTrue(File::exists($filename));
    }

    /**
     * @test
     */
    public function it_must_publish_translations()
    {
        $filename = resource_path('lang/vendor/configurations');

        if (File::exists($filename)) {
            File::deleteDirectory($filename);
        }

        $this->assertFalse(File::exists($filename));

        $this->artisan('configuration:install');

        $this->assertTrue(File::exists($filename));
    }

    /**
     * @test
     */
    public function it_must_register_middleware()
    {
        $router = app('router');
        $middleware = $router->getMiddleware();
        $this->assertArrayHasKey('settings', $middleware);
    }
}

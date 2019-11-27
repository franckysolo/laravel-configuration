<?php
namespace Indy\LaravelConfiguration\Tests\Feature;

use Indy\LaravelConfiguration\Configuration;
use Indy\LaravelConfiguration\Tests\TestCase;
use Indy\LaravelConfiguration\Http\Middleware\Settings;

use Illuminate\Support\Facades\Route;

class ConfigurationHttpTest extends TestCase
{
    public function __construct()
    {
        parent::__construct();

        $this->dbTestEnable = true;
    }
    /**
     * @test
     * @route configurations.index
     */
    public function can_access_configuration_index_page()
    {
        $route = route('configurations.index');

        $response = $this->get($route);

        $response->assertStatus(200)
                 ->assertViewIs('configurations::index')
                 ;
    }

    /**
     * @test
     * @route configurations.create
     */
    public function can_access_configuration_create_page()
    {
        $route = route('configurations.create');

        $response = $this->get($route);

        $response->assertStatus(200)
                 ->assertViewIs('configurations::create')
                 ;
    }

    /**
     * @test
     * @route configurations.create
     */
    public function can_access_create_page_and_store_post()
    {
        $data = $this->provideData();

        $route = route('configurations.store', $data);

        $response = $this->post($route);

        $response->assertSessionHasNoErrors()
                 ->assertStatus(302);

        $this->assertDatabaseHas('configurations', $data);
    }

    /**
     * @test
     * @route configurations.edit
     */
    public function can_access_configuration_edit_page()
    {
        $setting = Configuration::create($this->provideData());

        $route = route('configurations.edit', $setting);

        $response = $this->get($route);

        $response->assertStatus(200)
                 ->assertViewIs('configurations::create')
                ;
    }

    /**
     * @test
     * @route configurations.show
     */
    public function cant_access_configuration_show_page()
    {
        $setting = Configuration::create($this->provideData());

        $route = route('configurations.show', $setting);

        $response = $this->get($route);

        $response->assertStatus(403);
    }

    /**
     * @test
     * @route configurations.update
     */
    public function can_access_configuration_update_page()
    {
        //  $this->withoutExceptionHandling();

        $setting = Configuration::create($this->provideData());

        $route = route('configurations.update', $setting);

        $data = $setting->toArray();
        $data['value'] = '200';

        $response = $this->put($route, $data);

        $response->assertSessionHasNoErrors()
                 ->assertStatus(302);

        $actual = Configuration::find($setting->id);
        $this->assertDatabaseHas('configurations', $actual->toArray());
    }

    /**
     * @test
     * @route configurations.destroy
     */
    public function can_access_delete_action()
    {
        $setting = Configuration::create($this->provideData());

        $this->assertCount(1, Configuration::all());

        $route = route('configurations.destroy', $setting);

        $response = $this->delete($route);

        $response->assertStatus(302);

        $this->assertCount(0, Configuration::all());
    }

    /**
     * @test
     */
    public function setting_middleware_should_be_enable()
    {
        $this->withMiddleware('settings');

        Route::group(['middleware' => 'settings'], function () {
            Route::get('__test__', function () {
                return config('param_01');
            });
        });

        $setting = Configuration::create($this->provideData());

        $response = $this->get('__test__');

        $response->assertStatus(200);

        $this->assertEquals(120, $response->getContent());
    }
}

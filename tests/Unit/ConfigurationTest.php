<?php
namespace Indy\LaravelConfiguration\Tests\Unit;

use Indy\LaravelConfiguration\Configuration;
use Indy\LaravelConfiguration\Tests\TestCase;

use Illuminate\Support\Facades\File;

class ConfigurationTest extends TestCase
{
    public function __construct()
    {
        parent::__construct();

        $this->dbTestEnable = true;
    }

    /**
     * @test
     */
    public function it_must_create_a_configuration_model_instance()
    {
        $class = new Configuration();

        $this->assertInstanceOf(Configuration::class, $class);
    }

    /**
     * @test
     */
    public function configuration_model_have_types()
    {
        $types = Configuration::getTypes();

        $this->assertArrayHasKey('string', $types);

        $this->assertArrayHasKey('int', $types);

        $this->assertArrayHasKey('float', $types);

        $this->assertArrayHasKey('serialized', $types);

        $this->assertArrayHasKey('json', $types);
    }

    /**
     * @test
     */
    public function configuration_model_can_get_type()
    {
        $type = Configuration::getType('string');

        $this->assertEquals('String', $type);
    }

    /**
     * @test
     */
    public function configuration_return_empty_string_when_key_type_not_found()
    {
        $type = Configuration::getType('xxxx');

        $this->assertEquals('', $type);
    }

    /**
     * @test
     */
    public function configuration_seetings_must_return_an_array()
    {
        $settings = Configuration::settings();

        $this->assertTrue(is_array($settings));
    }

    /**
     * @test
     */
    public function can_create_configuration_entry()
    {
        $settings = new Configuration($this->provideData());

        $settings->save();

        $this->assertInstanceOf(Configuration::class, $settings);

        $this->assertDatabaseHas('configurations', $settings->toArray());
    }


    /**
     * @test
     */
    public function can_update_configuration_entry()
    {
        $settings = Configuration::create($this->provideData());

        $this->assertEquals(120, $settings->value);

        $settings->update(['value' => 200]);

        $this->assertEquals(200, $settings->value);
    }

    /**
     * @test
     */
    public function can_delete_configuration_entry()
    {
        $settings = Configuration::create($this->provideData());

        $this->assertCount(1, Configuration::all());

        Configuration::destroy($settings->id);

        $this->assertCount(0, Configuration::all());
    }
}

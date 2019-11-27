<?php
namespace Tests;

use Indy\LaravelConfiguration\Configuration;

class ConfigurationTest extends TestCase
{
    /**
     * @test
     */
    public function it_must_create_a_configuration_model_instance()
    {
        $class = new Configuration();
        $this->assertInstanceOf(Configuration::class, $class);
    }
}

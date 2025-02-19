<?php

namespace WalkerChiu\Shipment;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use WalkerChiu\Shipment\Models\Entities\Shipment;
use WalkerChiu\Shipment\Models\Entities\ShipmentLang;

class ShipmentTest extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ .'/../migrations');
        $this->withFactories(__DIR__ .'/../../src/database/factories');
    }

    /**
     * To load your package service provider, override the getPackageProviders.
     *
     * @param \Illuminate\Foundation\Application  $app
     * @return Array
     */
    protected function getPackageProviders($app)
    {
        return [\WalkerChiu\Core\CoreServiceProvider::class,
                \WalkerChiu\Shipment\ShipmentServiceProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
    }

    /**
     * A basic functional test on Shipment.
     *
     * For WalkerChiu\Shipment\Models\Entities\Shipment
     * 
     * @return void
     */
    public function testShipment()
    {
        // Config
        Config::set('wk-core.onoff.core-lang_core', 0);
        Config::set('wk-shipment.onoff.core-lang_core', 0);
        Config::set('wk-core.lang_log', 1);
        Config::set('wk-shipment.lang_log', 1);
        Config::set('wk-core.soft_delete', 1);
        Config::set('wk-shipment.soft_delete', 1);

        // Give
        $db_morph_1 = factory(Shipment::class)->create();
        $db_morph_2 = factory(Shipment::class)->create();
        $db_morph_3 = factory(Shipment::class)->create(['is_enabled' => 1]);

        // Get records after creation
            // When
            $records = Shipment::all();
            // Then
            $this->assertCount(3, $records);

        // Delete someone
            // When
            $db_morph_2->delete();
            $records = Shipment::all();
            // Then
            $this->assertCount(2, $records);

        // Resotre someone
            // When
            Shipment::withTrashed()
                   ->find($db_morph_2->id)
                   ->restore();
            $record_2 = Shipment::find($db_morph_2->id);
            $records = Shipment::all();
            // Then
            $this->assertNotNull($record_2);
            $this->assertCount(3, $records);

        // Return Lang class
            // When
            $class = $record_2->lang();
            // Then
            $this->assertEquals($class, ShipmentLang::class);

        // Scope query on enabled records
            // When
            $records = Shipment::ofEnabled()
                              ->get();
            // Then
            $this->assertCount(1, $records);

        // Scope query on disabled records
            // When
            $records = Shipment::ofDisabled()
                              ->get();
            // Then
            $this->assertCount(2, $records);
    }
}

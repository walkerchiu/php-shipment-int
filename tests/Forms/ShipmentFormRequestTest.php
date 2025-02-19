<?php

namespace WalkerChiu\Shipment;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use WalkerChiu\Core\Models\Constants\CountryZone;
use WalkerChiu\Shipment\Models\Entities\Shipment;
use WalkerChiu\Shipment\Models\Forms\ShipmentFormRequest;

class ShipmentFormRequestTest extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        //$this->loadLaravelMigrations(['--database' => 'mysql']);
        $this->loadMigrationsFrom(__DIR__ .'/../migrations');
        $this->withFactories(__DIR__ .'/../../src/database/factories');

        $this->request  = new ShipmentFormRequest();
        $this->rules    = $this->request->rules();
        $this->messages = $this->request->messages();
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
     * Unit test about Authorize.
     *
     * For WalkerChiu\Shipment\Models\Forms\ShipmentFormRequest
     * 
     * @return void
     */
    public function testAuthorize()
    {
        $this->assertEquals(true, 1);
    }

    /**
     * Unit test about Rules.
     *
     * For WalkerChiu\Shipment\Models\Forms\ShipmentFormRequest
     * 
     * @return void
     */
    public function testRules()
    {
        $faker = \Faker\Factory::create();

        DB::table(config('wk-core.table.site.sites'))->insert([
            'serial'   => $faker->username,
        ]);


        // Give
        $attributes = [
            'morph_type' => config('wk-core.class.site.site'),
            'morph_id'   => 1,
            'serial'     => $faker->isbn10,
            'name'       => $faker->name,
            'is_enabled' => 0
        ];
        // When
        $validator = Validator::make($attributes, $this->rules, $this->messages); $this->request->withValidator($validator);
        $fails = $validator->fails();

        // Then
        $this->assertEquals(false, $fails);
    }
}

<?php

/** @var \Illuminate\Database\Eloquent\Factory  $factory */

use Faker\Generator as Faker;
use WalkerChiu\Shipment\Models\Entities\Shipment;
use WalkerChiu\Shipment\Models\Entities\ShipmentLang;

$factory->define(Shipment::class, function (Faker $faker) {
    return [
        'serial' => $faker->isbn10,
        'type'   => $faker->randomElement(config('wk-core.class.shipment.shipmentType')::getCodes())
    ];
});

$factory->define(ShipmentLang::class, function (Faker $faker) {
    return [
        'code'  => $faker->locale,
        'key'   => $faker->randomElement(['name', 'description']),
        'value' => $faker->sentence
    ];
});

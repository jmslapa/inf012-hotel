<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Common\Models\Address;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'zip' => $faker->randomNumber(8),
        'number' => $faker->buildingNumber(),
        'address' => $faker->address(),
        'complement' => 'N/A',
        'district' => 'N/A',
        'city' => 'Salvador',
        'state' => 'BA',
    ];
});

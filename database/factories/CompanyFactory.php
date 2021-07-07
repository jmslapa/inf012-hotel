<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Company\Models\Company;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company(),
        'category' => 'EIRELI',
        'email' => $faker->email(),
    ];
});

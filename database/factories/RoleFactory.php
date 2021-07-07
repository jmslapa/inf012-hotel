<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\HumanResource\Models\Role;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => $faker->word()
    ];
});

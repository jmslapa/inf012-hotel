<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\HumanResource\Models\Employee;

$factory->define(Employee::class, function (Faker $faker) {
    $gender = collect(['M', 'S'])->random();
    return [
        'name' => $faker->name($gender === 'M' ? 'male' : 'female'),
        'cpf' => $faker->cpf(false),
        'gender' => $gender
    ];
});

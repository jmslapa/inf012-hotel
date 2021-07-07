<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Auth\Models\Permission;

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'target' => $target = $faker->word(),
        'name' => $target . ' permission',
        'policy_method' => collect(['viewAny', 'view', 'create', 'update', 'delete'])->random()
    ];
});

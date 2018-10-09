<?php

use App\Models\Role;
use Faker\Generator;

$factory->define(Role::class, function (Generator $faker) {
    return [
        'label' => $faker->word,
        'level' => $faker->numberBetween(1, 5),
        'name' => $faker->word,
        'protected' => false,
    ];
});

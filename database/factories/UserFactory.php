<?php

use App\Models\User;
use Faker\Generator;

$factory->define(User::class, function (Generator $faker) {
    static $password;

    return [
        'email' => $faker->unique()->safeEmail,
        'is_active' => true,
        'marketing' => 1,
        'name' => $faker->name,
        'password' => $password ?: $password = bcrypt('secret'),
        'phone' => $faker->phoneNumber,
        'remember_token' => str_random(10),
    ];
});

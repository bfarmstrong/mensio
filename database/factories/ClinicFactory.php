<?php

use App\Models\Clinic;
use Faker\Generator as Faker;

$factory->define(Clinic::class, function (Faker $faker) {
    return [
        'address_line_1' => $faker->streetAddress,
        'address_line_2' => $faker->secondaryAddress,
        'city' => $faker->city,
        'country' => 'CAN',
        'postal_code' => $faker->postcode,
        'province' => 'ON',
        'name' => $faker->company,
        'subdomain' => $faker->domainWord,
    ];
});

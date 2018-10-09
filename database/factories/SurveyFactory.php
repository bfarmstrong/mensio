<?php

use App\Models\Survey;
use Faker\Generator;

$factory->define(Survey::class, function (Generator $faker) {
    return [
        'description' => $faker->sentence,
        'name' => $faker->word,
    ];
});

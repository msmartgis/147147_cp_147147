<?php

use Faker\Generator as Faker;

$factory->define(App\Intervention::class, function (Faker $faker) {
    return [
        'nom' => $faker->sentence($nbWords = 1, $variableNbWords = true),
    ];
});

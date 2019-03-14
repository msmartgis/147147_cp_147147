<?php

use Faker\Generator as Faker;

$factory->define(App\Moa::class, function (Faker $faker) {
    return [
        'nom_fr' => $faker->sentence($nbWords = 4, $variableNbWords = true),
        'nom_ar' => $faker->sentence($nbWords = 4, $variableNbWords = true)

    ];
});

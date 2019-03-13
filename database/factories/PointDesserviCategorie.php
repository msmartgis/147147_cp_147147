<?php

use Faker\Generator as Faker;

$factory->define(App\PointDesserviCategorie::class, function (Faker $faker) {
    return [
        'nom_fr' => $faker->sentence($nbWords= 1,$variableNbWords = true),
        'nom_ar' => $faker->sentence($nbWords= 1,$variableNbWords = true),

    ];
});

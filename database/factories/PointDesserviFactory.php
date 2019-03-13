<?php

use Faker\Generator as Faker;

$factory->define(App\PointDesservi::class, function (Faker $faker) {
    return [
        'categorie_point_id' => App\PointDesserviCategorie::all()->random()->id,
        'nom_ar' => $faker->sentence($nbWords = 4, $variableNbWords = true),
        'nom_fr' => $faker->sentence($nbWords = 4, $variableNbWords = true),
        'created_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
        'updated_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s')


    ];
});

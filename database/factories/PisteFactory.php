<?php

use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'longueur' => rand(2,20),
        'demande_id' => App\Demande::all()->random()->id,
        'convention_id' => App\Convention::all()->random()->id,
        'projet_id' => App\Projet::all()->random()->id,
        'created_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
        'updated_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s')
    ];
});

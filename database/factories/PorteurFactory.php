<?php

use Faker\Generator as Faker;

$factory->define(App\Porteur::class, function (Faker $faker) {
    //random element for decsion
    $type_porteur = array('association','commmune','cp');
    shuffle($type_porteur);
    return [
        'type' => $type_porteur[1],
        'nom_porteur_fr' => $faker->sentence($nbWords = 4, $variableNbWords = true),
        'nom_porteur_ar' => $faker->sentence($nbWords = 4, $variableNbWords = true),

        'demande_id' => App\Demande::all()->random()->id,
        'convention_id' => App\Convention::all()->random()->id,
        'projet_id' => App\Projet::all()->random()->id,
        'created_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
        'updated_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s')
    ];
});

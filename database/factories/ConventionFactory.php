<?php

use Faker\Generator as Faker;

$factory->define(App\Convention::class, function (Faker $faker) {
    static $num_ordre = 1;
    //random element for decsion
    $decision_array = array('a_traiter','accord_definitif','en_cours');
    shuffle($decision_array);

    $objet_ar_array = array(' الخير جمعية',' تهيئة مشروع',' دواري ربط','  السحل دوار','أقليم تيزنيت','جماعة','المجلس الاقليمي','طريق','انجاز');
    shuffle($objet_ar_array);

    return [
        'session_id' => rand(1,12),
        'demande_id' => rand(10000,20000),
        'num_ordre' => $num_ordre++,
        'date_reception' => $faker->dateTimeThisYear()->format('Y-m-d'),
        'objet_fr'  => $faker->sentence($nbWords = 30, $variableNbWords = true),
        'objet_ar'  => $faker->randomElement($objet_ar_array),
        'montant_global' => rand(50000,1000000),
        'observation'  => $faker->sentence($nbWords = 70, $variableNbWords = true),
        'decision'  => $decision_array[1],
        'is_affecter' => rand(0,1),
        'created_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
        'updated_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s')
        ];

});

<?php

use Faker\Generator as Faker;

$factory->define(App\Convention::class, function (Faker $faker) {
    static $num_ordre = 1;

    $objet_ar_array = array(' الخير جمعية',' تهيئة مشروع',' دواري ربط','  السحل دوار','أقليم تيزنيت','جماعة','المجلس الاقليمي','طريق','انجاز');
    shuffle($objet_ar_array);

    return [
        'session_id' => rand(1,12),
        'demande_id' => App\Demande::all()->random()->id,
        'num_ordre' => $num_ordre++,
        'date_reception' => $faker->dateTimeThisYear()->format('Y-m-d'),
        'objet_fr'  => $faker->sentence($nbWords = 30, $variableNbWords = true),
        'objet_ar'  => $faker->randomElement($objet_ar_array),
        'montant_global' => rand(50000,1000000),
        'observation'  => $faker->sentence($nbWords = 70, $variableNbWords = true),
        'is_affecter' => rand(0,1),
        'avancement_id' => App\Avancement::all()->random()->id,
        'created_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
        'updated_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s')
        ];

});

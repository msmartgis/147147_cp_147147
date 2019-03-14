<?php

use Faker\Generator as Faker;

$factory->define(App\Avancement::class, function (Faker $faker) {
    static $pourcent_increase = 0;
    return [
        'pourcentage' => $pourcent_increase += 10,
    ];
});

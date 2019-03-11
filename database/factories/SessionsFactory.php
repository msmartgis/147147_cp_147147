<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Session::class, function (Faker $faker) {
    return [
        'nom' => $faker->sentence($nbWords = 1, $variableNbWords = true),
        'date' =>  Carbon::parse(now())->format('Y.m.d')
    ];
});

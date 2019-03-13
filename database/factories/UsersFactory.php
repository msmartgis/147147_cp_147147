<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'username' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make('147147'),
        'remember_token' => str_random(10),
        'first_name' => $faker->name,
        'last_name' => $faker->name,
        'role' => 'admin'

    ];
});

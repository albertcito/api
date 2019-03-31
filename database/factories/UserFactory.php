<?php

use Faker\Generator as Faker;
use App\Model\User;

$factory->define(App\Model\User::class, function (Faker $faker) {
    static $password = null;
    return [
        'email' => uniqid() . '@miaum.cl',
        'password' => $password ?: $password = bcrypt('123456'),
        'name' => $faker->name,
        'status' => "Active",
        'remember_token' => str_random(10),
        'validEmail' => rand(0, 1),
    ];
});

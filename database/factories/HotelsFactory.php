<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Hotels;
use Faker\Generator as Faker;

$factory->define(Hotels::class, function (Faker $faker) {
    return [
        'h_name' => 'Hotel '. $faker->unique()->firstName,
        'h_admin' => $faker->numberBetween(1, 5),
        'h_description' => $faker->unique()->realText(),
        'h_stars' => $faker->numberBetween(1, 5),
        'h_country' => $faker->country,
        'h_city' => $faker->city,
        'h_address' => $faker->address,
        'h_price' => $faker->numberBetween(1, 10) * 1000,
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
//        'b_h_id' => 'Hotel'. $faker->unique()->firstName,
//        'b_u_id' => $faker->numberBetween(1, 5),
//        'b_start_date' => $faker->unique()->realText(),
//        'b_end_date' => $faker->numberBetween(1, 5),
    ];
});

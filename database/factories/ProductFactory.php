<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'user_id' => auth()->user()->id ?? null,
        'name' => $faker->name,
        'description' => $faker->sentence(),
        'expiry_date' => $faker->dateTimeBetween('-7 days', '7 days')->format('Y-m-d'),
    ];
});

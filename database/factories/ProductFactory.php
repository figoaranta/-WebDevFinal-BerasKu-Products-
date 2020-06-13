<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'riceGradeType' => $faker->riceGradeType,
        'riceType' => $faker->riceType,
        'riceShapeType' => $faker->riceShapeType,
        'riceColorType' => $faker->riceColorType,
        'riceTextureType' => $faker->riceTextureType,
        'quantity' => $faker->quantity,
        'riceUnitType' => $faker->riceUnitType,
        'price' => $faker->price,
    ];
});

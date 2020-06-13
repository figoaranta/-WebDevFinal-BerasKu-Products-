<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\productImage;
use Faker\Generator as Faker;

$factory->define(productImage::class, function (Faker $faker) {
    return [
        'productId'=>$faker->productId,
        'productImage'=>$faker->productImage
    ];
});

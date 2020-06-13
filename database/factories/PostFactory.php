<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'userId' => $faker->userId,
        'productId' => $faker->productId,
        'postTitle' => $faker->postTitle,
        'postDescription' => $faker->postDescription
    ];
});

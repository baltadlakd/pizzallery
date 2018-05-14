<?php

use Faker\Generator as Faker;

$factory->define(pizzallery\Pizza::class, function (Faker $faker) {
    return [
      'user_id'=> $faker->biasedNumberBetween(1,100),
      'title'=> $faker->userName,
      'description'=> $faker->realText(200),
      'price'=>$faker->randomFloat(2,1,200),
      'bought'=>$faker->biasedNumberBetween(1,1000),
        //
    ];
});

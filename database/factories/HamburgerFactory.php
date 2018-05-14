<?php

use Faker\Generator as Faker;

$factory->define(pizzallery\Hamburger::class, function (Faker $faker) {
    return [
      'title'=> $faker->userName,
      'description'=> $faker->realText(200),
      'price'=>$faker->randomFloat(2,1,200),
    ];
});

<?php

use Illuminate\Database\Seeder;
use pizzallery\Pizza;

class PizzasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Pizza::class,100)->create();
    }
}

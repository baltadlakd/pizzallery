<?php

use Illuminate\Database\Seeder;
use pizzallery\Hamburger;
class HamburgersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Hamburger::class,100)->create();
    }
}

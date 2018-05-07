<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarjetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarjetas', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id')->unsigned()->references('id')->on('users');
          $table->string('name');
          $table->string('address');
          $table->string('number');
          $table->integer('month');
          $table->integer('year');
          $table->integer('ccv');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarjetas');
    }
}

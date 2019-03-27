<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDishServingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dish_serving', function (Blueprint $table) {
            $table->unsignedInteger('dish_id');
            $table->unsignedInteger('serving_id');
            $table->unsignedMediumInteger('price');
            $table->foreign('dish_id')->references('id')->on('dishes');
            $table->foreign('serving_id')->references('id')->on('servings');
            $table->primary(['dish_id', 'serving_id']);
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
        Schema::dropIfExists('dish_serving');
    }
}
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->integer('subcategory_id')->unsigned()->nullable();
            $table->foreign('subcategory_id')->references('id')->on('categories')->onDelete('set null');
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->longText('description')->nullable();
            $table->tinyInteger('price_level')->unsigned()->nullable();
            $table->tinyInteger('difficulty_level')->unsigned()->nullable();
            $table->integer('portions')->unsigned()->nullable();
            $table->longText('info')->nullable();
            $table->string('source')->nullable();
            // Cookidoo
            $table->bigInteger('cookidoo_id')->unsigned()->nullable();
            $table->integer('cookidoo_fav_count')->unsigned()->nullable();
            // Times
            $table->integer('time_total')->unsigned()->nullable();
            $table->integer('time_active')->unsigned()->nullable();
            $table->integer('time_waiting')->unsigned()->nullable();
            // Nutrition
            $table->float('kilojoules', 10, 3)->unsigned()->nullable();
            $table->integer('kilocalories')->unsigned()->nullable();
            $table->float('protein', 10, 3)->unsigned()->nullable();
            $table->float('carbohydrates', 10, 3)->unsigned()->nullable();
            $table->float('fat', 10, 3)->unsigned()->nullable();
            $table->float('cholesterol', 10, 3)->unsigned()->nullable();
            $table->float('dietaryFibre', 10, 3)->unsigned()->nullable();
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
        Schema::dropIfExists('recipes');
    }
}

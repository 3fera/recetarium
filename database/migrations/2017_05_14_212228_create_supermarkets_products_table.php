<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupermarketsProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supermarkets_products', function (Blueprint $table) {
            $table->increments('id');
            $table->float('price', 10, 2);
            $table->float('price_quantity', 10, 2)->nullable();
            $table->integer('supermarket_id')->unsigned();
            $table->foreign('supermarket_id')->references('id')->on('supermarkets')->onDelete('cascade');
            $table->integer('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supermarkets_products');
    }
}

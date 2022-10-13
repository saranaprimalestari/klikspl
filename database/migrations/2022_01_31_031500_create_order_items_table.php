<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('order_id')->references('id')->on('orders');
            $table->foreignId('order_id');
            // $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('user_id');
            // $table->foreignId('product_id')->references('id')->on('products');
            $table->foreignId('product_id');
            $table->foreignId('product_variant_id');
            $table->foreignId('order_product_id');
            $table->integer('quantity');
            $table->bigInteger('price');
            $table->bigInteger('total_price_item');
            $table->boolean('is_review')->default(false);
            $table->string('order_item_status')->nullable();
            $table->string('retur')->nullable();
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
        Schema::dropIfExists('order_items');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('user_id');
            // $table->foreignId('product_id')->references('id')->on('products');
            $table->foreignId('product_id');
            $table->foreignId('product_variant_id');
            $table->foreignId('sender_address_id');
            $table->integer('quantity');
            $table->boolean('is_checkout_view')->default(false);
            $table->boolean('is_checkout_payment')->default(false);
            $table->bigInteger('subtotal')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
}

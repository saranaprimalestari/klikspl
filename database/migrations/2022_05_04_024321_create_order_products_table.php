<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('specification');
            $table->text('description');
            $table->string('excerpt');
            $table->string('slug');
            $table->string('product_code');
            $table->string('product_category');
            $table->string('product_merk');
            $table->string('variant_name')->nullable();
            $table->string('variant_value')->nullable();
            $table->string('variant_code')->nullable();
            $table->integer('stock');
            $table->bigInteger('weight');
            $table->bigInteger('price');
            $table->string('promo_name')->nullable();
            $table->string('promo_discount')->nullable();
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
        Schema::dropIfExists('order_products');
    }
}

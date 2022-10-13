<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('product_merks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('image');
            $table->timestamps();
        });

        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('promo_type_id');
            $table->dateTime('start_period', $precision = 0);
            $table->dateTime('end_period', $precision = 0);
            $table->text('description');
            $table->bigInteger('min_transaction');
            $table->bigInteger('discount');
            $table->string('is_active');
            $table->string('image');
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('specification');
            $table->text('description');
            $table->string('excerpt');
            $table->string('slug')->unique();
            $table->string('product_code')->unique();
            // $table->foreignId('product_category_id')->references('id')->on('product_categories');
            $table->foreignId('product_category_id');
            // $table->foreignId('product_merk_id')->references('id')->on('product_merks');
            $table->foreignId('product_merk_id');
            $table->integer('stock');
            $table->integer('sold');
            $table->integer('view');
            $table->bigInteger('weight');
            $table->bigInteger('long');
            $table->bigInteger('width');
            $table->bigInteger('height');
            $table->bigInteger('price');
            // $table->foreignId('promo_id')->references('id')->on('promos');
            $table->boolean('is_active')->default(true);
            $table->boolean('stock_notification')->default(true);
            $table->foreignId('promo_id');
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
        Schema::dropIfExists('product_merks');
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('products');
        Schema::dropIfExists('promos');
    }
}

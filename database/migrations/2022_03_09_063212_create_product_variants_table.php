<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->string('variant_name');
            $table->string('variant_slug')->unique();
            $table->string('variant_value');
            $table->string('variant_code')->unique();
            $table->integer('sold');
            $table->integer('stock');
            $table->bigInteger('weight');
            $table->bigInteger('long');
            $table->bigInteger('width');
            $table->bigInteger('height');
            $table->bigInteger('price');
            $table->foreignId('promo_id');
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
        Schema::dropIfExists('product_variants');
    }
}

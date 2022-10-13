<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Move to product comments migration
        // Schema::create('orders', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('invoice_no')->unique();
        //     $table->string('resi')->unique();
        //     $table->foreignId('user_id')->references('id')->on('users');
        //     $table->string('courier');
        //     $table->string('courier_package_type');
        //     $table->string('estimation');
        //     $table->decimal('total_price');
        //     $table->foreignId('product_id')->references('id')->on('products');
        //     $table->string('order_status');
        //     $table->string('retur');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    // public function down()
    // {
    //     Schema::dropIfExists('orders');
    // }
}

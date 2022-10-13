<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDeliveryStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_delivery_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->string('delivery_status');
            $table->string('delivery_status_detail');
            $table->dateTime('delivery_date');
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
        Schema::dropIfExists('order_delivery_statuses');
    }
}

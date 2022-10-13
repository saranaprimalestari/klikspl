<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSenderAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sender_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->string('district');
            $table->foreignId('city_ids');
            $table->foreignId('province_ids');
            $table->bigInteger('postal_code');
            $table->string('telp_no');
            $table->integer('is_active');
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
        Schema::dropIfExists('sender_addresses');
    }
}

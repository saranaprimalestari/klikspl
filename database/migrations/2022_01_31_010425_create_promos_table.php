<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // move to product migrations
        // Schema::create('promos', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->text('description');
        //     $table->string('excerpt');
        //     $table->string('slug')->unique();
        //     $table->integer('discount_percent');
        //     $table->string('active');
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
    //     Schema::dropIfExists('promos');
    // }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('user_admins', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('username')->unique();
        //     $table->string('firstname');
        //     $table->string('lastname');
        //     // $table->foreignId('admin_type')->references('id')->on('admin_types');
        //     $table->foreignId('admin_type');
        //     $table->string('telp_no');
        //     $table->string('email')->unique();
        //     $table->timestamp('email_verified_at')->nullable();
        //     $table->string('password');
        //     $table->rememberToken();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_admins');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNullableOnAdmins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('firstname')->nullable()->change();
            $table->string('lastname')->nullable()->change();
            $table->string('admin_type')->nullable()->change();
            $table->string('company_id')->nullable()->change();
            $table->string('telp_no')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('firstname')->nullable(false)->change();
            $table->string('lastname')->nullable(false)->change();
            $table->string('admin_type')->nullable(false)->change();
            $table->string('company_id')->nullable(false)->change();
            $table->string('telp_no')->nullable(false)->change();
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeProductCommentUserAdminIdCanBeNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_comments', function (Blueprint $table) {
            $table->foreignId('user_id')->unsigned()->nullable()->change();
            $table->foreignId('admin_id')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_comments', function (Blueprint $table) {
            $table->foreignId('user_id')->unsigned()->nullable(false)->change();
            $table->foreignId('admin_id')->unsigned()->nullable(false)->change();
            
        });
    }
}

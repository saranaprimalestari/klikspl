<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeProductCommentCommentImageCanBeNull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_comments', function (Blueprint $table) {
            $table->string('comment_image')->nullable()->change();
            $table->text('comment')->nullable()->change();
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
            $table->string('comment_image')->nullable(false)->change();
            $table->text('comment')->nullable(false)->change();

        });
    }
}

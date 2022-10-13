<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductVariantIdToProductCommentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_comments', function (Blueprint $table) {
            $table->foreignId('product_variant_id')->default(0)->nullable()->after('product_id');
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
            $table->dropColumn('product_variant_id');
        });
    }
}

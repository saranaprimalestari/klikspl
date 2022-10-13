<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminAndCompanyIdToPromoBanner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promo_banners', function (Blueprint $table) {
            $table->foreignId('admin_id')->after('is_active');
            $table->foreignId('company_id')->after('admin_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promo_banners', function (Blueprint $table) {
            $table->dropColumn('admin_id');
            $table->dropColumn('company_id');
        });
    }
}

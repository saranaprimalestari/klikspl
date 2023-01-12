<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundOrderPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_order_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->foreignId('user_id');
            $table->foreignId('company_id');
            $table->foreignId('admin_id')->nullable();
            $table->string('name');
            $table->string('bank_name');
            $table->string('type')->nullable();
            $table->string('account_number');
            $table->string('email')->nullable();
            $table->string('telp_no')->nullable();
            $table->string('proof_of_payment')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('refund_order_payments');
    }
}

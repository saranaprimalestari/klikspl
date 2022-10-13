<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique()->nullable();
            $table->string('resi')->unique()->nullable();
            // $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('user_id');
            $table->foreignId('sender_address_id');
            $table->foreignId('order_address_id');
            $table->string('courier');
            $table->string('courier_package_type');
            $table->string('estimation_day');
            $table->dateTime('estimation_date');
            $table->bigInteger('courier_price');
            $table->bigInteger('total_price');
            // $table->foreignId('product_id')->references('id')->on('products');
            // $table->foreignId('product_id');
            $table->string('order_status')->nullable();
            $table->string('proof_of_payment')->nullable();
            $table->string('retur')->nullable();
            $table->string('unique_code');
            $table->foreignId('payment_method_id');
            $table->dateTime('payment_due_date');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('product_comments', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('user_id')->nullable();
            // $table->foreignId('product_id')->references('id')->on('products');
            $table->foreignId('product_id');
            $table->text('comment');
            $table->string('star');
            $table->date('comment_date');
            // $table->foreignId('order_id')->references('id')->on('orders');
            $table->foreignId('order_id');
            $table->date('deadline_to_comment');
            $table->integer('reply_comment_id')->nullable();
            $table->string('comment_image');
            // $table->foreignId('useradmin_id')->references('id')->on('user_admins');
            $table->foreignId('admin_id')->nullable();
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
        Schema::dropIfExists('product_comments');
        Schema::dropIfExists('orders');
    }
}

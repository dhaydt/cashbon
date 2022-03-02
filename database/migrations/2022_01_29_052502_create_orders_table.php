<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
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
            $table->string('customer_id', 15)->nullable();
            $table->string('customer_type', 10)->nullable();
            $table->string('payment_status', 15)->default('unpaid');
            $table->string('order_status', 50)->default('pending');
            $table->date('delivery_date')->nullable();
            $table->string('payment_method', 100)->nullable();
            $table->string('transaction_ref', 30)->nullable();
            $table->double('order_amount')->default(0);
            $table->text('shipping_address')->nullable();
            $table->double('discount_amount')->default(0);
            $table->string('discount_type', 30)->nullable();
            $table->string('coupon_code', 191)->nullable();
            $table->bigInteger('shipping_method_id')->nullable();
            $table->double('shipping_cost')->default(0);
            $table->string('order_group_id', 255)->default('def-order-group');
            $table->string('verification_code', 255)->default(0);
            $table->double('discount')->default(1);
            $table->text('shipping_address_data')->nullable();
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
        Schema::dropIfExists('orders');
    }
}

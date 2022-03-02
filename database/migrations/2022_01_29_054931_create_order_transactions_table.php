<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->nullable();
            $table->bigInteger('customer_id')->nullable();
            $table->bigInteger('seller_is')->nullable();
            $table->bigInteger('seller_id')->nullable();
            $table->decimal('order_amount')->default(0);
            $table->decimal('admin_commission')->default(0);
            $table->string('received_by', 191)->nullable();
            $table->string('delivered_by', 191)->nullable();
            $table->string('payment_method', 191)->nullable();
            $table->string('transaction_id', 191)->nullable();
            $table->string('status', 191)->nullable();
            $table->decimal('delivery_charge')->default(0);
            $table->decimal('tax')->default(0);
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
        Schema::dropIfExists('order_transactions');
    }
}

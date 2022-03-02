<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->text('product_details')->nullable();
            $table->integer('qty')->nullable();
            $table->double('price')->default(0);
            $table->double('tax')->default(0);
            $table->double('discount')->default(0);
            $table->string('delivery_status', 15)->default('pending');
            $table->string('payment_status', 50)->default('unpaid');
            $table->bigInteger('shipping_method_id')->nullable();
            $table->string('variant', 255)->nullable();
            $table->string('variation', 255)->nullable();
            $table->string('discount_type', 30)->nullable();
            $table->tinyInteger('is_stock_decreased')->default(1);
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
        Schema::dropIfExists('order_details');
    }
}

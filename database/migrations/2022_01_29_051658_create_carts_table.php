<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->nullable();
            $table->string('cart_group_id', 191)->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->string('color', 250)->nullable();
            $table->text('choices')->nullable();
            $table->text('variations')->nullable();
            $table->text('variant')->nullable();
            $table->integer('quantity')->nullable();
            $table->double('price')->default(1);
            $table->double('tax')->default(1);
            $table->double('discount')->default(1);
            $table->string('slug')->nullable();
            $table->string('name', 255)->nullable();
            $table->string('thumbnail', 255)->nullable();
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
        Schema::dropIfExists('carts');
    }
}

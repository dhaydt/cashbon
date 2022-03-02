<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80)->nullable();
            $table->string('slug', 120)->nullable();
            $table->string('label', 100)->nullable();
            $table->string('category_ids', 80)->nullable();
            $table->bigInteger('brand_id')->default(0);
            $table->string('country', 80)->nullable();
            $table->string('province', 80)->nullable();
            $table->string('city', 80)->nullable();
            $table->string('district', 100)->nullable();
            $table->integer('city_id')->default(0);
            $table->integer('district_id')->default(0);
            $table->decimal('weight', 10.0)->default('1.0');
            $table->string('unit', 191)->nullable();
            $table->integer('min_qty')->default(1);
            $table->tinyInteger('refundable')->default(1);
            $table->string('thumbnail', 255)->nullable();
            $table->string('featured', 255)->nullable();
            $table->string('flash_deal', 255)->nullable();
            $table->string('colors', 255)->nullable();
            $table->tinyInteger('variant_product')->default(0);
            $table->string('attributes', 255)->nullable();
            $table->text('choice_options')->nullable();
            $table->text('variation')->nullable();
            $table->tinyInteger('published')->default(0);
            $table->double('unit_price')->default('0');
            $table->double('purchase_price')->default('0');
            $table->string('tax', 255)->default('0.00');
            $table->string('tax_type', 80)->nullable();
            $table->string('discount', 255)->default('0.0');
            $table->string('discount_type', 255)->nullable();
            $table->integer('current_stock')->default(0);
            $table->text('details')->nullable();
            $table->tinyInteger('free_shipping')->default(0);
            $table->string('attachment', 191)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('featured_status')->default(1);
            $table->string('meta_title', 191)->nullable();
            $table->string('meta_description', 191)->nullable();
            $table->string('meta_image', 191)->nullable();
            $table->tinyInteger('request_status')->default(0);
            $table->string('denied_note', 191)->nullable();
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
        Schema::dropIfExists('products');
    }
}

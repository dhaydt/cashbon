<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('phone', 50)->unique();
            $table->string('status', 20)->default('pending');
            $table->string('country', 50)->nullable();
            $table->string('province', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('district', 50)->nullable();
            $table->string('street', 100)->nullable();
            $table->string('city_id', 10)->nullable();
            $table->string('district_id', 10)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('password', 80);
            $table->tinyInteger('is_active')->default(0);
            $table->string('bank_name', 191)->nullable();
            $table->string('branch', 191)->nullable();
            $table->string('account_no', 191)->nullable();
            $table->string('holder_name', 191)->nullable();
            $table->text('auth_token')->nullable();
            $table->double('sales_commission_percentage')->nullable();
            $table->string('gst')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('sellers');
    }
}

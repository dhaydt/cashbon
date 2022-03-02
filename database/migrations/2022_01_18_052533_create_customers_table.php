<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('phone', 50)->unique();
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
            $table->string('login_medium', 191);
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('is_phone_verified')->default(0);
            $table->tinyInteger('is_email_verified')->default(0);
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
        Schema::dropIfExists('customers');
    }
}

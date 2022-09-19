<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */


    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('name');
            $table->string('user_country');
            $table->string('user_city');
            $table->string('user_state')->nullable();
            $table->mediumText('user_address')->nullable();
            $table->string('user_contact');
            $table->string('email')->unique();
            $table->mediumText('user_picture')->nullable();
            $table->enum('user_gender', ['M','F'])->nullable();
            $table->date('user_dob')->nullable();
            $table->string('user_timezone')->nullable();
            $table->string('user_currency')->nullable();
            $table->string('user_language')->nullable();
            $table->string('user_organization')->nullable();
            $table->string('user_last_login_ip')->nullable();
            $table->string('user_last_login')->nullable();
            $table->boolean('user_status')->default(1);
            $table->boolean('user_verified')->default(0);
            $table->longText('user_misc')->nullable();
            $table->string('password');
            $table->string('salt_password');
            $table->index(['name', 'user_country','user_city']);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};

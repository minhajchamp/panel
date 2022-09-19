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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->integer('subscription_id');
            $table->string('client_name');
            $table->string('client_country');
            $table->string('client_city');
            $table->string('client_state')->nullable();
            $table->mediumText('client_address')->nullable();
            $table->string('client_contact');
            $table->string('client_email');
            $table->mediumText('client_picture')->nullable();
            $table->enum('client_gender', ['M','F'])->nullable();
            $table->date('client_dob')->nullable();
            $table->string('client_timezone')->nullable();
            $table->string('client_currency')->nullable();
            $table->string('client_language')->nullable();
            $table->string('client_organization')->nullable();
            $table->string('client_last_login_ip')->nullable();
            $table->string('client_last_login')->nullable();
            $table->boolean('client_status')->default(1);
            $table->boolean('client_verified')->default(0);
            $table->longText('client_misc')->nullable();
            $table->string('client_password');
            $table->string('salt_password');
            $table->timestamps();
            $table->index(['client_name', 'client_country','client_city']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
};

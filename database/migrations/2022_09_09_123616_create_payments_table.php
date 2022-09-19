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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('method_name');
            $table->string('method_type')->nullable();
            $table->string('method_picture')->nullable();
            $table->string('method_details')->nullable();
            $table->boolean('method_status')->default(1);
            $table->timestamps();
        });
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('method_id');
            $table->double('amount');
            $table->string('currency')->nullable();
            $table->mediumText('card_details');
            $table->timestamps();
        });
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_id')->unique()->nullable();
            $table->string('invoice_token')->unique()->nullable();
            $table->boolean('invoice_sent_cl')->default(0);
            $table->boolean('invoice_sent_emp')->default(0);
            $table->boolean('invoice_is_seen')->default(0);
            $table->enum('invoice_status', ['paid','unpaid']);
            $table->date('invoice_sent_at')->nullable();
            $table->mediumText('invoice_details');
            $table->timestamps();
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('method_id')->references('id')->on('payment_methods');
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::table('invoice', function (Blueprint $table) {
            $table->foreign('payment_id')->references('id')->on('payments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};

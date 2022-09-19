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
        Schema::create('smtp_settings', function (Blueprint $table) {
            $table->id();
            $table->string('smtp_name');
            $table->string('smtp_username');
            $table->string('smtp_password');
            $table->string('smtp_port');
            $table->string('smtp_driver');
            $table->string('smtp_host');
            $table->string('smtp_encryption')->default("tls");
            $table->string('smtp_from_address');
            $table->boolean('smtp_status')->default(1);
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
        //
    }
};

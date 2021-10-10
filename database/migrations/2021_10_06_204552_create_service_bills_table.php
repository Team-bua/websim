<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_bills', function (Blueprint $table) {
            $table->id();
            $table->integer('service_id');
            $table->integer('user_id');
            $table->string('order_code');
            $table->string('phone_number')->nullable();
            $table->string('code_otp')->nullable();
            $table->integer('expired_time')->nullable();
            $table->string('content')->nullable();
            $table->integer('price')->default(0);
            $table->integer('status')->default(0);
            $table->integer('code_status')->default(0);
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
        Schema::dropIfExists('service_bills');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name');
            $table->string('street')->nullable();
            $table->string('status');
            $table->string('city')->nullable();
            $table->string('zip')->nullable();
            $table->string('country');
            $table->string('promocode')->nullable();
            $table->string('paymentMethod');
            $table->string('priceId');
            $table->integer('package_id');
            $table->string('packageType');
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
        Schema::dropIfExists('orders');
    }
}

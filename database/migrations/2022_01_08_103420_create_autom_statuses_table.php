<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutomStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autom_statuses', function (Blueprint $table) {
            $table->id();
            $table->integer('autom_id');
            $table->integer('user_id');
            $table->string('token');
            $table->string('uploaded_file')->nullable();
            $table->string('exported_file')->nullable();
            $table->string('status');
            $table->string('back_log');
            $table->string('instance');
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
        Schema::dropIfExists('autom_statuses');
    }
}

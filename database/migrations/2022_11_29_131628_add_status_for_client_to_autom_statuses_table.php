<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusForClientToAutomStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('autom_statuses', function (Blueprint $table) {
            $table->text("statusForUser")->nullable();
            $table->json("taskData")->nullable();
            $table->text("currentTask")->nullable();
            $table->boolean("notifyMe")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('autom_statuses', function (Blueprint $table) {
            $table->dropColumn("statusForUser");
            $table->dropColumn("taskData");
            $table->dropColumn("currentTask");
            $table->dropColumn("notifyMe");
        });
    }
}

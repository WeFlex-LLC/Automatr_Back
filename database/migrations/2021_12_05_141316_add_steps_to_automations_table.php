<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStepsToAutomationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('automations', function (Blueprint $table) {
            $table->string('step1Header')->nullable();
            $table->string('step2Header')->nullable();
            $table->string('step3Header')->nullable();
            $table->string('step4Header')->nullable();
            $table->text('step1Text')->nullable();
            $table->text('step2Text')->nullable();
            $table->text('step3Text')->nullable();
            $table->text('step4Text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('automations', function (Blueprint $table) {
            $table->dropColumn('step1Header')->nullable();
            $table->dropColumn('step2Header')->nullable();
            $table->dropColumn('step3Header')->nullable();
            $table->dropColumn('step4Header')->nullable();
            $table->dropColumn('step1Text')->nullable();
            $table->dropColumn('step2Text')->nullable();
            $table->dropColumn('step3Text')->nullable();
            $table->dropColumn('step4Text')->nullable();
        });
    }
}

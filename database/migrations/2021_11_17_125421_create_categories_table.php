<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('url');
            $table->string('icon');
            $table->timestamps();
        });
        Schema::create('type', function (Blueprint $table) {
            $table->increments('type_id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('automations', function (Blueprint $table) {
            $table->increments('auto_id');
            $table->unsignedInteger('category_id');
            $table->string('name');
            $table->longText('h1');
            $table->text('text1');
            $table->longText('h2');
            $table->text('text2');
            $table->longText('h3');
            $table->text('text3');
            $table->text('tutorial');
            $table->text('updates');
            $table->unsignedInteger('type_id');
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('type_id')->references('type_id')->on('type')->onDelete('set null')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id')->unsigned();
            $table->integer('record_id')->unsigned();
            $table->integer('program_id')->unsigned();
            $table->integer('created_by')->unsigned();
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('records');
            $table->foreign('record_id')->references('id')->on('records');
            $table->foreign('program_id')->references('id')->on('programs');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
            $table->dropForeign(['record_id']);
            $table->dropForeign(['program_id']);
            $table->dropForeign(['created_by']);
        });

        Schema::dropIfExists('cases');
    }
}

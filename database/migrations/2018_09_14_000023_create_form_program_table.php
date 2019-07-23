<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormProgramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_program', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('form_id')->unsigned();
            $table->bigInteger('program_id')->unsigned();
            $table->timestamps();

            $table->foreign('form_id')->references('id')->on('forms');
            $table->foreign('program_id')->references('id')->on('programs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form_program', function (Blueprint $table) {
            $table->dropForeign(['form_id']);
            $table->dropForeign(['program_id']);
        });

        Schema::dropIfExists('form_program');
    }
}

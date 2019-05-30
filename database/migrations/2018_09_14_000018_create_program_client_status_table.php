<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramClientStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_client_status', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('program_client_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->integer('previous_status_id')->unsigned()->nullable();
            $table->unsignedBigInteger('previous_status_duration')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('program_client_id')->references('id')->on('program_record');
            $table->foreign('status_id')->references('id')->on('client_statuses');
            $table->foreign('previous_status_id')->references('id')->on('client_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_client_status', function (Blueprint $table) {
            $table->dropForeign(['program_client_id']);
        });

        Schema::dropIfExists('program_client_status');
    }
}

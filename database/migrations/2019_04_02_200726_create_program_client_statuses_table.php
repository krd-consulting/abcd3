<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramClientStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_client_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('program_client_id')->unsigned();
            $table->string('status');
            $table->string('previous_status')->nullable();
            $table->unsignedBigInteger('previous_status_duration')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned();

            $table->foreign('program_client_id')->references('id')->on('program_record');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_client_statuses', function (Blueprint $table) {
            $table->dropForeign(['program_client_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });

        Schema::dropIfExists('program_client_statuses');
    }
}

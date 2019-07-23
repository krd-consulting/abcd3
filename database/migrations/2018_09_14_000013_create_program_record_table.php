<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_record', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('record_id')->unsigned();
            $table->bigInteger('program_id')->unsigned();
            $table->timestamp('enrolled_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('record_id')->references('id')->on('records');
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
        Schema::table('program_record', function (Blueprint $table) {
            $table->dropForeign(['record_id']);
            $table->dropForeign(['program_id']);
        });

        Schema::dropIfExists('program_record');
    }
}

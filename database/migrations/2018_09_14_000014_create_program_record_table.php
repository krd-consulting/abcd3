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
            $table->integer('record_id')->unsigned();
            $table->integer('program_id')->unsigned();
            $table->text('notes')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('status_updated_at')->nullable();
            $table->timestamps();

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

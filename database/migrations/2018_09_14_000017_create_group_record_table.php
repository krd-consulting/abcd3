<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_record', function (Blueprint $table) {
            $table->bigInteger('group_id')->unsigned();
            $table->bigInteger('record_id')->unsigned();
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('record_id')->references('id')->on('records');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_record', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropForeign(['record_id']);
        });

        Schema::dropIfExists('group_record');
    }
}

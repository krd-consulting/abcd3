<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyConstraintsToFileTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('file_types', function (Blueprint $table) {
            $table->foreign('field_1_id')->references('id')->on('fields');
            $table->foreign('field_2_id')->references('id')->on('fields');
            $table->foreign('field_3_id')->references('id')->on('fields');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('file_types', function (Blueprint $table) {
            $table->dropForeign(['field_1_id']);
            $table->dropForeign(['field_2_id']);
            $table->dropForeign(['field_3_id']);
        });
    }
}

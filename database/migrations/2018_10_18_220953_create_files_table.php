<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('file_type_id')->unsigned();
            $table->string('field_1_value', 100);
            $table->string('field_2_value', 100);
            $table->string('field_3_value', 100);
            $table->timestamps();

            $table->foreign('file_type_id')->references('id')->on('file_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropForeign(['file_type_id']);
        });

        Schema::dropIfExists('files');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_types', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 32);
            $table->text('description')->nullable();
            $table->string('slug', 40)->nullable();

            $table->integer('field_1_id')->unsigned();

            $table->integer('field_2_id')->unsigned();

            $table->integer('field_3_id')->unsigned();

            $table->timestamps();

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

        Schema::dropIfExists('file_types');
    }
}

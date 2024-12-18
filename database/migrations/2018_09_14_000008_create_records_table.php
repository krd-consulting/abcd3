<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('record_type_id')->unsigned();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('field_1_value', 100);
            $table->string('field_2_value', 100)->nullable();
            $table->string('field_3_value', 100)->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('record_type_id')->references('id')->on('record_types');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('records', function (Blueprint $table) {
            $table->dropForeign(['record_type_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('records');
    }
}

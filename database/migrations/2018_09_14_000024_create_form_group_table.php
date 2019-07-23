<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_group', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('form_id')->unsigned();
            $table->bigInteger('group_id')->unsigned();
            $table->timestamps();

            $table->foreign('form_id')->references('id')->on('forms');
            $table->foreign('group_id')->references('id')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form_group', function (Blueprint $table) {
            $table->dropForeign(['form_id']);
            $table->dropForeign(['group_id']);
        });

        Schema::dropIfExists('form_group');
    }
}

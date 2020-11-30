<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelHasFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_has_forms', function (Blueprint $table) {
            $table->bigInteger('form_id')->unsigned();
            $table->bigInteger('model_id');
            $table->string('model_type');
            $table->boolean('required');
            $table->timestamps();

            $table->foreign('form_id')->references('id')->on('forms');
            $table->primary(['form_id', 'model_id', 'model_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_has_forms');
    }
}

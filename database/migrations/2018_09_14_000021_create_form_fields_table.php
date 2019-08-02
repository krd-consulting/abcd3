<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('form_id')->unsigned();
            $table->string('column_name');
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->string('type', 20);
            $table->bigInteger('reference_target_type_id')->unsigned()->nullable();
            $table->integer('reference_target_id')->unsigned()->nullable();
            $table->schemalessAttributes('options');
            $table->schemalessAttributes('settings');
            $table->schemalessAttributes('validation_rules');
            $table->unique(['form_id', 'column_name']);
            $table->foreign('reference_target_type_id')->references('id')->on('form_target_types');
            $table->foreign('form_id')->references('id')->on('forms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropForeign(['target_type_id']);

        Schema::dropIfExists('form_fields');
    }
}

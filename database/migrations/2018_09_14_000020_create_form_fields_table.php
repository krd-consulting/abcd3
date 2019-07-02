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
            $table->string('name', 30);
            $table->text('label')->nullable();
            $table->text('description')->nullable();
            $table->string('type', 10);
            $table->integer('target_type_id')->unsigned();
            $table->integer('target_id')->unsigned()->nullable();
            $table->json('options');
            $table->json('settings');
            $table->json('validation_rules');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_fields');
    }
}

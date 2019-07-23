<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->text('description')->nullable();
            $table->string('table_name', 50);
            $table->string('type', 10)->default('static');
            $table->bigInteger('target_type_id')->unsigned();
            $table->integer('target_id')->unsigned()->nullable();
            $table->integer('scope_id')->unsigned();
            //$table->integer('scheduler_id')->unsigned()->nullable();
            $table->schemalessAttributes('extra_data')->nullable();
            $table->schemalessAttributes('field_layout');
            $table->timestamp('disabled_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('target_type_id')->references('id')->on('form_target_types');
            $table->foreign('scope_id')->references('id')->on('scopes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form_team', function (Blueprint $table) {
            $table->dropForeign(['target_type_id']);
            $table->dropForeign(['scope_id']);
        });

        Schema::dropIfExists('forms');
    }
}

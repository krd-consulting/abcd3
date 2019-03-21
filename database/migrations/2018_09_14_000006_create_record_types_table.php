<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_types', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 32);
            $table->text('description')->nullable();
            $table->string('slug', 40)->nullable();
            $table->boolean('userable')->default(false);
            $table->integer('identity_id')->unsigned();

            $table->timestamps();

            $table->foreign('identity_id')->references('id')->on('record_identities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('record_types', function (Blueprint $table) {
            $table->dropForeign(['identity_id']);
        });

        Schema::dropIfExists('record_types');
    }
}

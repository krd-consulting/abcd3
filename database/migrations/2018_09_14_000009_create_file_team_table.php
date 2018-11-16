<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_team', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('file_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('file_id')
            ->references('id')
            ->on('files')
            ->onDelete('cascade');

            $table->foreign('team_id')
            ->references('id')
            ->on('teams')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('file_team', function (Blueprint $table) {
            $table->dropForeign(['file_id']);
            $table->dropForeign(['team_id']);
        });

        Schema::dropIfExists('file_team');
    }
}

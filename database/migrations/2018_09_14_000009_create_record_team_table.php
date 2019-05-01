<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_team', function (Blueprint $table) {
            $table->integer('record_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('record_id')
            ->references('id')
            ->on('records')
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
        Schema::table('record_team', function (Blueprint $table) {
            $table->dropForeign(['record_id']);
            $table->dropForeign(['team_id']);
        });

        Schema::dropIfExists('record_team');
    }
}

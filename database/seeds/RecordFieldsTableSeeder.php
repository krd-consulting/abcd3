<?php

use Illuminate\Database\Seeder;

class RecordFieldsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('record_fields')->insert(config('app.record_fields'));
    }
}

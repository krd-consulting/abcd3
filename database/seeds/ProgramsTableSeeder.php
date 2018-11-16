<?php

use Illuminate\Database\Seeder;

class ProgramsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('programs')->insert([
            [
                'name' => 'Program in Team One',
                'team_id' => 1
            ],

            [
                'name' => 'Program in Team Two',
                'team_id' => 2
            ]
        ]);
    }
}

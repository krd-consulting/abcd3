<?php

use Illuminate\Database\Seeder;

class ScopesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('scopes')->insert([
            [
                'name' => 'universal',
                'value' => 5
            ],
            [
                'name' => 'team',
                'value' => 4
            ],
            [
                'name' => 'program',
                'value' => 3
            ],
            [
                'name' => 'case load',
                'value' => 2
            ],
            [
                'name' => 'self',
                'self' => 1
            ]
        ]);
    }
}

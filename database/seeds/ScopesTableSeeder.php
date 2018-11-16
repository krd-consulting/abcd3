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
            ['name' => 'universal'],
            ['name' => 'team'],
            ['name' => 'program'],
            ['name' => 'self']
        ]);
    }
}

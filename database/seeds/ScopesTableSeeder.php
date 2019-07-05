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
        DB::table('scopes')->insert(config('auth.scopes'));
    }
}

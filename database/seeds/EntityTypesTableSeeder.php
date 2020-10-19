<?php

use Illuminate\Database\Seeder;

class EntityTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('entity_types')->insert(config('app.entity_types'));
    }
}

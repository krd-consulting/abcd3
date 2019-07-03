<?php

use Illuminate\Database\Seeder;

class FormTargetTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('form_target_types')->insert(config('app.form_target_types'));
    }
}

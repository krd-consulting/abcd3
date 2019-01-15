<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'name' => 'write records',
                'guard_name' => 'web'
            ],
            [
                'name' => 'write programs',
                'guard_name' => 'web'
            ],
            [
                'name' => 'write roles',
                'guard_name' => 'web'
            ]
        ]);
    }
}

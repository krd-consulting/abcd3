<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'Super User',
                'guard_name' => 'web',
                'scope_id' => 1
            ],
            [
                'name' => 'Team Manager',
                'guard_name' => 'web',
                'scope_id' => 2
            ],
            [
                'name' => 'Program Manager',
                'guard_name' => 'web',
                'scope_id' => 3
            ],
            [
                'name' => 'Guidance Counselor',
                'guard_name' => 'web',
                'scope_id' => 4
            ]
        ]);
    }
}

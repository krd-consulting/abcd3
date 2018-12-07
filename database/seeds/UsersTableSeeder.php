<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Super User',
                'email' => 'admin@hellokrd.net',
                'password' => bcrypt('secret'),
                'remember_token' => str_random(10)
            ],
            [
                'id' => 2,
                'name' => 'Rupert Amodia',
                'email' => 'rupert@hellokrd.net',
                'password' => bcrypt('secret'),
                'remember_token' => str_random(10)
            ],
            [
                'id' => 3,
                'name' => 'Gui Gramari',
                'email' => 'gui@hellokrd.net',
                'password' => bcrypt('secret'),
                'remember_token' => str_random(10)
            ],
            [
                'id' => 4,
                'name' => 'Scott McCrae',
                'email' => 'scott@hellokrd.net',
                'password' => bcrypt('secret'),
                'remember_token' => str_random(10)
            ]
        ]);
    }
}

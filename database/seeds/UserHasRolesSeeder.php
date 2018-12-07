<?php

use Illuminate\Database\Seeder;

class UserHasRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('model_has_roles')->insert([
            [
                'role_id' => 1, // Super User
                'model_type' => 'App\User',
                'model_id' => 1 // Super User
            ],
            [
                'role_id' => 2, // Team Manager
                'model_type' => 'App\User',
                'model_id' => 2 // Rupert Amodia
            ],
            [
                'role_id' => 3, // Program Manager
                'model_type' => 'App\User',
                'model_id' => 3 // Gui Gramari
            ],
            [
                'role_id' => 4, // Case Load
                'model_type' => 'App\User',
                'model_id' => 4 // Scott McCrae
            ],
        ]);
    }
}

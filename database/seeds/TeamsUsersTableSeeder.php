<?php

use Illuminate\Database\Seeder;

use App\Team as Team;
use App\User as User;

class TeamsUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teams_users')->insert([
            [
                'team_id' => 1,
                'user_id' => 1
            ],
            [
                'team_id' => 2,
                'user_id' => 2
            ]
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

use App\Program;
use App\Role;
use App\Team;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roman = new User;
        $roman->name = 'Roman Katsnelson';
        $roman->email = 'roman@hellokrd.net';
        $roman->password = bcrypt('secret');
        $roman->remember_token = str_random(10);
        $roman->save();
        $roman->assignRole('Super User');

        $rupert = new User;
        $rupert->name = 'Rupert Amodia';
        $rupert->email = 'rupert@hellokrd.net';
        $rupert->password = bcrypt('secret');
        $rupert->remember_token = str_random(10);
        $rupert->save();
        //$rupert->teams()->attach(Team::inRandomOrder()->first());
        $rupert->assignRole('Team Manager');

        $ben = new User;
        $ben->name = 'Benjamin Wozak';
        $ben->email = 'ben@hellokrd.net';
        $ben->password = bcrypt('secret');
        $ben->remember_token = str_random(10);
        $ben->save();
        $ben->assignRole('Program Manager');

        $alanya = new User;
        $alanya->name = 'Alanya Dallah';
        $alanya->email = 'alanya@hellokrd.net';
        $alanya->password = bcrypt('secret');
        $alanya->remember_token = str_random(10);
        $alanya->save();
        $alanya->assignRole('Guidance Counselor');
    }
}

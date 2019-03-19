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

        $gui = new User;
        $gui->name = 'Guilherme Gramari';
        $gui->email = 'gui@hellokrd.net';
        $gui->password = bcrypt('secret');
        $gui->remember_token = str_random(10);
        $gui->save();
        //$gui->programs()->attach(Program::inRandomOrder()->first());
        $gui->assignRole('Program Manager');

        $scott = new User;
        $scott->name = 'Scott McCrae';
        $scott->email = 'scott@hellokrd.net';
        $scott->password = bcrypt('secret');
        $scott->remember_token = str_random(10);
        $scott->save();
        $scott->assignRole('Guidance Counselor');
    }
}

<?php

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use App\Role;
use App\Scope;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $superUser = new Role;
        $superUser->name = 'Super User';
        $superUser->guard_name = 'web';
        $superUser->assignScope(Scope::where('name', 'universal')->first());
        $superUser->save();
        $superUser->givePermissionTo(Permission::all());

        $teamManager = new Role;
        $teamManager->name = 'Team Manager';
        $teamManager->guard_name = 'web';
        $teamManager->assignScope(Scope::where('name', 'team')->first());
        $teamManager->save();

        $programManager = new Role;
        $programManager->name = 'Program Manager';
        $programManager->guard_name = 'web';
        $programManager->assignScope(Scope::where('name', 'program')->first());
        $programManager->save();

        $guidanceCounselor = new Role;
        $guidanceCounselor->name = 'Guidance Counselor';
        $guidanceCounselor->guard_name = 'web';
        $guidanceCounselor->assignScope(Scope::where('name', 'case load')->first());
        $guidanceCounselor->save();
    }
}

<?php

use App\Collection;
use Illuminate\Database\Seeder;

class CollectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $program = new Collection;
        $program->name = 'Program';
        $program->slug = 'programs';
        $program->model_type = 'App\Program';
        $program->save();

        $team = new Collection;
        $team->name = 'Team';
        $team->slug = 'teams';
        $team->model_type = 'App\Team';
        $team->save();

        $group = new Collection;
        $group->name = 'Group';
        $group->slug = 'groups';
        $group->model_type = 'App\Group';
        $group->save();
    }
}

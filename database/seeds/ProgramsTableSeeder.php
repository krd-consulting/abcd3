<?php

use Illuminate\Database\Seeder;

use App\Program;
use App\Team;

class ProgramsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $programOne = new Program;
        $programOne->name = 'Program in T1';
        $programOne->created_by = 1;
        $programOne->updated_by = 1;
        $programOne->assignToTeam(
                Team::where('name', 'Team One')->first()
            );
        $programOne->save();

        $programTwo = new Program;
        $programTwo->name = 'Program in T2';
        $programTwo->created_by = 1;
        $programTwo->updated_by = 1;
        $programTwo->assignToTeam(
                Team::where('name', 'Team Two')->first()
            );
        $programTwo->save();
    }
}

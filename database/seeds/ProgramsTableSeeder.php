<?php

use Illuminate\Database\Seeder;

use App\ClientStatus;
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
        $programOne->default_client_status_id =
                    ClientStatus::where('name', config('app.program_client_statuses.waitlist.name'))
                        ->first()
                        ->id;
        $programOne->assignToTeam(
                Team::where('name', 'Team One')->first()
            );
        $programOne->active = true;
        $programOne->save();

        $programTwo = new Program;
        $programTwo->name = 'Program in T2';
        $programTwo->default_client_status_id =
                    ClientStatus::where('name', config('app.program_client_statuses.active.name'))
                        ->first()
                        ->id;
        $programTwo->assignToTeam(
                Team::where('name', 'Team Two')->first()
            );
        $programTwo->active = true;
        $programTwo->save();
    }
}

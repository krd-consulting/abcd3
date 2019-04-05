<?php

namespace App\Traits;

use App\Record;
use App\Program;

trait AddsRecordToProgramTeams
{
    /*
     * Temporary implementation for automatically adding a record to a program's teams
     * where the record doesn't belong to.
     *
     * Ideal implementation would be to trigger Eloquent Model Events.
     *
     */
    private function addRecordToProgramTeam(Record $record, Program $program)
    {
        $programTeam = $program->team->id;
        $recordTeams = $record->teams->pluck('id');

        if($recordTeams->contains($programTeam))
            return;

        $record->teams()->save($program->team);
    }
}

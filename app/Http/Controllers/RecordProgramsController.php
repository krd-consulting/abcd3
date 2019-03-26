<?php

namespace App\Http\Controllers;

use App\Program;
use App\Record;
use App\RecordType;

use Illuminate\Http\Request;

class RecordProgramsController extends Controller
{
    public function index(RecordType $recordType, Record $record)
    {
        return $record->programs()->with('team')->get();
    }

    public function store(RecordType $recordType, Record $record, Program $program)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $program);

        $record->programs()->attach($program, [
            'notes' => '',
            'status' => 'active',
            'status_updated_at' => now()
        ]);

        $this->addRecordToProgramTeam($record, $program);

        return $program;
    }

    public function destroy(RecordType $recordType, Record $record, Program $program)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $program);

        $record->programs()->detach($program);

        return $program;
    }

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

<?php

namespace App\Http\Controllers;

use App\Team;
use App\Record;
use App\ProgramRecord;
use App\RecordType;

use App\Http\Resources\Teams;

use Illuminate\Http\Request;

class RecordTeamsController extends Controller
{
    public function index(RecordType $recordType, Record $record)
    {
        $teams = $record->teams();

        $teams = $teams->availableFor(auth()->user());

        // Search
        $search = request('search');
        $teams = $teams->search($search);

        // Sort per request.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $teams = $teams->sort($sortBy, $ascending);

        // Paginate per request.
        $perPage = request('perPage');
        $teams = $teams->paginate($perPage);

        return new Teams($teams);
    }

    public function store(RecordType $recordType, Record $record, Team $team)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $team);

        $record->teams()->attach($team);

        return $team;
    }

    public function destroy(RecordType $recordType, Record $record, Team $team)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $team);

        abort_if(
            $record->isActiveInProgramsIn($team),
            422,
            "Can't remove record from team. It is still active in (a) program/s."
        );

        $programs = $record->programs()->inTeams([$team->id])->pluck('programs.id');

        $groups = $record->groups()->where('program_id', $programs)->pluck('id');
        $record->groups()->detach($groups);

        $programRecords = (new ProgramRecord)->findUsingPrograms(
            $record, 
            $programs
        );

        $programRecords->delete();

        $team->records()->detach($record);

        return $record;
    }
}

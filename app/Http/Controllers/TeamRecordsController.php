<?php

namespace App\Http\Controllers;

use App\Team;
use App\Record;
use App\ProgramRecord;
use App\RecordType;

use App\Http\Resources\Records;

use Illuminate\Http\Request;

class TeamRecordsController extends Controller
{
    public function index(Team $team, RecordType $recordType)
    {
        $records = $team->records()->only($recordType);

        $records = $records->availableFor(auth()->user());

        // Search
        $search = request('search');
        $records = $records->search($search);

        // Sort per request.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $records = $records->sort($sortBy, $ascending);

        // Paginate per request.
        $perPage = request('perPage');
        $records = $records->paginate($perPage);

        return (new Records($records))->as($recordType);
    }

    public function store(Team $team, RecordType $recordType, Record $record)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $team);

        $team->records()->attach($record);

        return $record;
    }

    public function destroy(Team $team, RecordType $recordType, Record $record)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $team);

        abort_if(
            $record->isActiveInProgramsIn($team),
            422,
            "Can't remove record from team. It is still active in (a) program/s."
        );

        $caseloadPrograms = $record
                ->cases_managers()
                ->join('programs', 'cases.program_id', 'programs.id')
                ->where('programs.team_id', $team->id)
                ->with('pivot.program');

        abort_if(
            $caseloadPrograms
                ->exists(),
            422,
            "Can't remove record from team. It belongs to a caseload in programs: " 
            . $caseloadPrograms->get()->implode('pivot.program.name', ', ')
        );

        $programs = $record->programs()->inTeams([$team->id])->pluck('programs.id');

        $groups = $record->groups()->where('program_id', $programs)->pluck('id');
        $record->groups()->detach($groups);

        $programRecords = (new ProgramRecord)->ofPrograms(
            $programs,
            $record
        );

        $programRecords->delete();

        $team->records()->detach($record);

        return $record;
    }
}

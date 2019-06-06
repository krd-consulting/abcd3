<?php

namespace App\Http\Controllers;

use App\Team;
use App\Record;
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
            $record->isActiveInProgram($team),
            422,
            "Can't remove record from team. It is still active in (a) program/s."
        );

        $team->records()->detach($record);

        return $record;
    }
}

<?php

namespace App\Http\Controllers;

use App\Team;
use App\Record;
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

        $team->records()->detach($record);

        return $record;
    }
}

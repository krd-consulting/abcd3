<?php

namespace App\Http\Controllers;

use App\Team;
use App\Record;
use App\RecordType;

use App\Http\Resources\Teams;

use Illuminate\Http\Request;

class TeamsAvailableForRecord extends Controller
{

    public function __invoke(RecordType $recordType, Record $record)
    {
        $selectedTeams = $record->teams()->pluck('teams.id');
        $teams = (new Team);

        $teams = $teams->availableFor(auth()->user())->whereNotIn('teams.id', $selectedTeams);

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

        return (new Teams($teams));
    }
}

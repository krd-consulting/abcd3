<?php

namespace App\Http\Controllers;

use App\Team;
use App\Record;
use App\RecordType;

use App\Http\Resources\Records;

use Illuminate\Http\Request;

class RecordsAvailableForTeam extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Team $team, RecordType $recordType)
    {
        $selectedRecords = $team->records()->pluck('records.id');
        $records = $recordType->records();

        $records = $records->availableFor(auth()->user())->whereNotIn('records.id', $selectedRecords);

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
}

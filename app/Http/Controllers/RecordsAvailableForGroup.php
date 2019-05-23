<?php

namespace App\Http\Controllers;

use App\Group;
use App\RecordType;

use App\Http\Resources\Records;

use Illuminate\Http\Request;

class RecordsAvailableForGroup extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Group $group, RecordType $recordType)
    {
        $selectedRecords = $group->records()->pluck('records.id');
        $records = $recordType->records()->whereNotIn('records.id', $selectedRecords);

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
}

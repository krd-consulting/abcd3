<?php

namespace App\Http\Controllers;

use App\Program;
use App\Record;
use App\RecordType;

use App\Http\Resources\Records;

use Illuminate\Http\Request;

class RecordsAvailableForProgram extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Program $program, RecordType $recordType)
    {
        $selectedRecords = $program->records()->pluck('records.id');
        $records = $recordType->records()->whereNotIn('records.id', $selectedRecords);

        // Search
        $search = request('search');
        $records = $records->search($search);

        // Sort per request.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $records = $records->sort($sortBy, $ascending);

        $records = $records->availableFor(auth()->user());

        // Paginate per request.
        $perPage = request('perPage');
        $records = $records->paginate($perPage);

        return (new Records($records))->as($recordType);
    }
}

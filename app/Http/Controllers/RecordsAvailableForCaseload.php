<?php

namespace App\Http\Controllers;

use App\Record;
use App\RecordType;
use App\Program;

use App\Http\Resources\Records;

use Illuminate\Http\Request;

class RecordsAvailableForCaseload extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Program $program, RecordType $recordType, Record $record)
    {
        $ownRecords = [];

        if(!empty($record->user))
            $ownRecords = $record->user->records()->pluck('records.id');

        $caseload = $record
            ->cases()
            ->where('program_id', $program->id)
            ->pluck('records.id');

        $except = $caseload->merge($ownRecords);

        $records = new Record();
        $records = $records
            ->whereNotIn('id', $except)
            ->whereHas('record_type', function($query) {
                $query->whereHas('identity', function($query) {
                    $query->whereIn('name', ['Client', 'Volunteer']);
                });
            });

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

        return (new Records($records));
    }
}

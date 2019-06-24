<?php

namespace App\Http\Controllers;

use App\Record;
use App\RecordType;
use App\Program;

use App\Http\Resources\Records;

use Illuminate\Http\Request;

class CaseController extends Controller
{
    public function index(Program $program, RecordType $recordType, Record $record)
    {
    	$cases = $record->cases()->where('program_id', $program->id);

    	// Search
        $search = request('search');
        $cases = $cases->search($search);

        // Sort per request.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $cases = $cases->sort($sortBy, $ascending);

        $cases = $cases->availableFor(auth()->user());

    	// Paginate per request.
        $perPage = request('perPage');
        $cases = $cases->paginate($perPage);

    	return (new Records($cases));
    }

    public function store(Program $program, RecordType $recordType, Record $record, Record $case)
    {
    	$record->assignCase($case, $program);

    	return $case;
    }

    public function destroy(Program $program, RecordType $recordType, Record $record, Record $case)
    {
    	$record->cases()->wherePivot('program_id', $program->id)->detach($case);

    	return $case;
    }
}

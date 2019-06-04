<?php

namespace App\Http\Controllers;

use App\Program;
use App\ProgramRecord;
use App\Record;
use App\RecordType;

use App\Http\Resources\Programs;

use App\Http\Requests\StoreProgramRecord;

use Illuminate\Http\Request;

class RecordProgramsController extends Controller
{
    public function index(RecordType $recordType, Record $record)
    {
        $programs = $record->programs()
            ->with(['client_statuses' => function($query) use ($record) {
                $query->where('record_id', $record->id);
            }, 'client_statuses.status']);

        $programs = $programs->availableFor(auth()->user());

        // Search
        $search = request('search');
        $programs = $programs->search($search);

        // Sort per request.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $programs = $programs->sort($sortBy, $ascending);

        // Paginate per request.
        $perPage = request('perPage');
        $programs = $programs->paginate($perPage);

        return new Programs($programs);
    }

    public function store(RecordType $recordType, Record $record, Program $program, StoreProgramRecord $request)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $program);

        $class = $this->getClass($recordType);

        $programRecord = new $class();
        
        $programRecord->createUsingBelongsTo($program, $record, $request);

        return $program;
    }

    public function destroy(RecordType $recordType, Record $record, Program $program)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $program);

        $class = $this->getClass($recordType);

        $programRecord = new $class();

        $programRecord = $programRecord->findUsingBelongsTo($program, $record)->first();

        $programRecord->delete();

        return $program;
    }

    private function getClass(RecordType $recordType) 
    {
        $class = $recordType->identity->name == 'Client' ? 'App\ProgramClient' : 'App\ProgramRecord';

        return $class;
    }
}

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

        // Search
        $search = request('search');
        $programs = $programs->search($search);

        // Sort per request.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $programs = $programs->sort($sortBy, $ascending);

        $programs = $programs->availableFor(auth()->user());

        // Paginate per request.
        $perPage = request('perPage');
        $programs = $programs->paginate($perPage);

        return new Programs($programs);
    }

    public function store(RecordType $recordType, Record $record, Program $program, StoreProgramRecord $request)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $program);

        $programRecord = new ProgramRecord();
        $programRecord->createUsingBelongsTo($program, $record, $request);

        return $program;
    }

    public function destroy(RecordType $recordType, Record $record, Program $program)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $program);

        ProgramRecord::where('program_id', $program->id)->where('record_id', $record->id)->first()->delete();

        return $program;
    }
}

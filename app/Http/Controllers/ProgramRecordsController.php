<?php

namespace App\Http\Controllers;

use App\Program;
use App\ProgramClient;
use App\ProgramRecord;
use App\Record;
use App\RecordType;
use App\ClientStatus;

use App\Http\Resources\Records;

use App\Http\Requests\StoreProgramRecord;
use App\Http\Requests\UpdateProgramRecord;

use Illuminate\Http\Request;

class ProgramRecordsController extends Controller
{

    public function index(Program $program, RecordType $recordType)
    {
        $records = $program->records()
            ->with(['client_statuses' => function($query) use ($program) {
                $query->where('program_id', $program->id);
            }, 'client_statuses.status'])->only($recordType);

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

    public function edit(Program $program, RecordType $recordType, Record $record)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $program);

        return [
            'data' => (new ProgramClient)
                        ->findUsingBelongsTo($program, $record)
                        ->with(['statuses' => function($query) {
                            return $query->latest()->first();
                        }, 'statuses.status'])->first()
        ];
    }

    public function store(Program $program, RecordType $recordType, Record $record, StoreProgramRecord $request)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $program);

        $programRecord = new ProgramClient();
        $programRecord->createUsingBelongsTo($program, $record, true, $request);

        return $record;
    }

    public function update(Program $program, RecordType $recordType, Record $record, UpdateProgramRecord $request)
    {
        $programRecord = new ProgramClient();
        $programRecord = $programRecord->findUsingBelongsTo($program, $record)->first();

        // Find latest status which is needed to compare to request data
        $clientStatus = $programRecord->statuses()->latest()->first();
        $clientStatus->updateUsingRequest($request);

        // Update enrollment date
        $programRecord->enrolled_at = $request->enrolled_at;
        $programRecord->save();

        // Return response
        return $programRecord;
    }

    public function destroy(Program $program, RecordType $recordType, Record $record)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $program);

        ProgramRecord::where('program_id', $program->id)->where('record_id', $record->id)->first()->delete();

        return $record;
    }
}

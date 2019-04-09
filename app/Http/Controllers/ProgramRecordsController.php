<?php

namespace App\Http\Controllers;

use App\Program;
use App\ProgramRecord;
use App\Record;
use App\RecordType;
use App\ClientStatus;

use App\Http\Resources\Records;

use App\Http\Requests\UpdateProgramRecord;

use Illuminate\Http\Request;

class ProgramRecordsController extends Controller
{

    public function index(Program $program, RecordType $recordType)
    {
        $records = $program->records()
            ->with('program_records', 'program_statuses', 'program_statuses.status')
            ->only($recordType);

        $records = $records->availableFor(auth()->user())->paginate(10);

        return (new Records($records))->as($recordType);
    }

    public function edit(Program $program, RecordType $recordType, Record $record)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $program);

        return ClientStatus::all();
    }

    public function store(Program $program, RecordType $recordType, Record $record)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $program);

        $user = auth()->user();

        $programRecord = new ProgramRecord();
        $programRecord->createUsingBelongsTo($program, $record, $user);

        return $record;
    }

    public function update(Program $program, RecordType $recordType, Record $record, UpdateProgramRecord $request)
    {
        $programRecord = new ProgramRecord();
        $programRecord = $programRecord->findUsingBelongsTo($program, $record)->first();

        // find latest status which is needed to compare to request data
        $clientStatus = $programRecord->statuses()->latest()->first();

        $clientStatus->updateUsingRequest($request, auth()->user());

        // update enrollment date
        $programRecord->enrolled_at = $request->enrolled_at;
        $programRecord->save();

        // return response
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

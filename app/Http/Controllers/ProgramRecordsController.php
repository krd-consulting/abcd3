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
        $records = $program
            ->setRecordIdentity($recordType->identity)
            ->records()
            ->withLatestProgramStatuses($recordType, $program)
            ->only($recordType);

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

        $programRecord = $this->getModel($recordType);

        $data = (new $programRecord)->of($program, $record)->first();

        return [
            'data' => $data                        
        ];
    }

    public function store(Program $program, RecordType $recordType, Record $record, StoreProgramRecord $request)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $program);

        $programRecord = $this->getModel($recordType);

        $programRecord = new $programRecord();
        $programRecord->createFrom($program, $record, true, $request);

        return $record;
    }

    public function update(
        Program $program, 
        RecordType $recordType, 
        Record $record, 
        UpdateProgramRecord $request
    )
    {
        $programRecord = $this->getModel($recordType);

        $programRecord = new $programRecord();
        $programRecord = $programRecord->of($program, $record)->first();

        $programRecord->updateUsingRequest($request)->save();

        // Return response
        return $programRecord;
    }

    public function destroy(Program $program, RecordType $recordType, Record $record)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $program);

        $model = $this->getModel($recordType);

        $programRecord = new $model();

        $programRecord = $programRecord->of($program, $record)->first();

        $programRecord->delete();

        return $record;
    }

    private function getModel(RecordType $recordType) 
    {
        return "App\Program" . $recordType->identity->model;
    }
}

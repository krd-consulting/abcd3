<?php

namespace App\Http\Controllers;

use App\Program;
use App\ProgramRecord;
use App\Record;
use App\RecordType;

use App\ProgramClientStatus;

use App\Http\Resources\Programs;

use App\Http\Requests\StoreProgramRecord;

use Illuminate\Http\Request;

class RecordProgramsController extends Controller
{
    public function index(RecordType $recordType, Record $record)
    {
        $model = 'App\\' . $recordType->identity->model;
        $record = (new $model())->find($record->id);

        $programs = $record->programs()->withLatestRecordStatuses($record);

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

        $class = $this->getModel($recordType);

        $programRecord = new $class();
        
        $programRecord->createFrom($program, $record, true, $request);

        return $program;
    }

    public function destroy(RecordType $recordType, Record $record, Program $program)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $program);

        $class = $this->getModel($recordType);

        $programRecord = new $class();

        $programRecord = $programRecord->of($program, $record)->first();

        $programRecord->delete();

        return $program;
    }

    private function getModel(RecordType $recordType) 
    {
        return "App\Program" . $recordType->identity->model;
    }
}

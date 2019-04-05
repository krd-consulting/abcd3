<?php

namespace App\Http\Controllers;

use App\Program;
use App\ProgramRecord;
use App\Record;
use App\RecordType;

use App\Http\Resources\Programs;
use App\Traits\AddsRecordToProgramTeams;

use Illuminate\Http\Request;

class RecordProgramsController extends Controller
{
    public function index(RecordType $recordType, Record $record)
    {
        return new Programs($record->programs);
    }

    public function store(RecordType $recordType, Record $record, Program $program)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $program);

        $user = auth()->user();

        $programRecord = new ProgramRecord();
        $programRecord->program_id = $program->id;
        $programRecord->record_id = $record->id;
        $programRecord->created_by = $user->id;
        $programRecord->save();

        return $program;
    }

    public function destroy(RecordType $recordType, Record $record, Program $program)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $program);

        $record->programs()->detach($program);

        return $program;
    }
}

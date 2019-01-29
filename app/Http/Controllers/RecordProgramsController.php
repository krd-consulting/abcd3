<?php

namespace App\Http\Controllers;

use App\Program;
use App\Record;
use App\RecordType;

use Illuminate\Http\Request;

class RecordProgramsController extends Controller
{
    public function index(RecordType $recordType, Record $record)
    {
        return $record->programs()->with('team')->get();
    }

    public function store(RecordType $recordType, Record $record, Program $program)
    {
        $record->programs()->attach($program);

        return $program;
    }

    public function destroy(RecordType $recordType, Record $record, Program $program)
    {
        $record->programs()->detach($program);

        return $program;
    }
}

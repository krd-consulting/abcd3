<?php

namespace App\Http\Controllers;

use App\Program;
use App\RecordType;

use App\Http\Resources\Records;

use Illuminate\Http\Request;

class ProgramRecordsController extends Controller
{
    public function index(Program $program, RecordType $recordType)
    {
        return (new Records($program->records()->only($recordType)->get()))->as($recordType);
    }
}

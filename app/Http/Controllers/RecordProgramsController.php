<?php

namespace App\Http\Controllers;

use App\Record;
use App\RecordType;

use Illuminate\Http\Request;

class RecordProgramsController extends Controller
{
    public function index(RecordType $recordType, Record $record)
    {
        return $record->programs()->with('team')->get();
    }
}
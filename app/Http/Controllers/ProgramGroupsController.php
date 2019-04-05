<?php

namespace App\Http\Controllers;

use App\Program;

use App\Http\Resources\Groups;

use Illuminate\Http\Request;

class ProgramGroupsController extends Controller
{
    public function index(Program $program)
    {
        return new Groups($program->groups);
    }
}

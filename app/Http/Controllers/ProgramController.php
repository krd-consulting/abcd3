<?php

namespace App\Http\Controllers;

use App\Program;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Returns all programs (sorted and paginated per request) available to the user..
     *
     * @return Collection
     */
    public function index()
    {
        return auth()->user()->availablePrograms;
    }

    /**
     * Show the profile of the selected program.
     *
     * @param  Program  $program
     * @return File
     */
    public function show(Program $program)
    {
        $this->authorize('read', $program);

        return $program->load('files');
    }
}

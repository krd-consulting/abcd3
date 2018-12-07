<?php

namespace App\Http\Controllers;

use App\Program;

use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show a list of programs with associated teams available to the user.
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
     * @param  int  $id
     * @return Collection
     */
    public function show($id)
    {
        return Program::with('files')->where('id', $id)->first();
    }
}

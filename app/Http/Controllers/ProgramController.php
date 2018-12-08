<?php

namespace App\Http\Controllers;

use App\Program;

use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['scope:program'], ['only' => 'show']);

        // Next: permissions middleware for `functionality` - creating, updating, and deleting programs.
        // Should prevent users from sending requests that create, update, and delete programs.
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
     * @param  int  $id
     * @return Collection
     */
    public function show($id)
    {
        return Program::with('files')->where('id', $id)->first();
    }
}

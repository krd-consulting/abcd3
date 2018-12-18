<?php

namespace App\Http\Controllers;

use App\Program;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProgramController extends Controller
{
    public function __construct()
    {

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
     * @return Program
     */
    public function show(Program $program)
    {
        $this->authorize('read', $program);

        return $program->load('files');
    }

    public function create()
    {
        $this->authorize('create', File::class);

        return auth()->user()->availableTeams;
    }

    public function store()
    {
        $this->authorize('create', File::class);

        // Store program when user is authorized.
    }

    public function edit(Program $program)
    {
        $this->authorize('write', $program);

        // Return program when user is authorized.
    }

    public function update(Program $program)
    {
        $this->authorize('write', $program);

        // Update program when user is authorized.
    }

    public function destroy(Program $program)
    {
        $this->authorize('write', $program);

        // Delete program when user is authorized.
    }
}

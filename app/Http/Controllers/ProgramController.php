<?php

namespace App\Http\Controllers;

use App\Program;
use App\Http\Resources\Program as ProgramResource;
use App\Http\Resources\Programs;
use App\Http\Requests\StoreProgram;
use App\Http\Requests\UpdateProgram;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProgramController extends Controller
{
    /**
     * Returns all programs (sorted and paginated per request) available to the user..
     *
     * @return Collection
     */
    public function index()
    {
        $programs = (new Program)->availableFor(auth()->user())->with('team')->get();

        return (new Programs($programs));
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

        return (new ProgramResource($program));
    }

    public function create()
    {
        $this->authorize('create', Program::class);

        return auth()->user()->availableTeams;
    }

    public function store(StoreProgram $request)
    {
        $this->authorize('create', Program::class);

        // Store program when user is authorized.
        $program = new Program();
        $program->name = $request->input('name');
        $program->description = $request->input('description');
        $program->team_id = $request->input('team_id');
        $program->save();

        return new ProgramResource($program);
    }

    public function edit(Program $program)
    {
        $this->authorize('write', $program);

        // Return available teams when user is authorized.
        return (new ProgramResource($program->load('team')));
    }

    public function update(Program $program, UpdateProgram $request)
    {
        $this->authorize('write', $program);

        // Update program when user is authorized.
        $program->name = $request->input('name');
        $program->description = $request->input('description');
        $program->save();

        return $program;
    }

    public function destroy(Program $program)
    {
        $this->authorize('write', $program);

        // Delete program when user is authorized.
        $program->delete();
    }
}

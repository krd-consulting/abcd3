<?php

namespace App\Http\Controllers;

use App\Program;
use App\Http\Resources\Program as ProgramResource;
use App\Http\Requests\StoreProgram;
use App\Http\Requests\UpdateProgram;

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
        return (new Program)->availableFor(auth()->user())->with('team')->get();
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
        $program->created_by = auth()->user()->id;
        $program->updated_by = auth()->user()->id;
        $program->save();

        return new ProgramResource($program);
    }

    public function edit(Program $program)
    {
        $this->authorize('write', $program);

        // Return available teams when user is authorized.
        return auth()->user()->availableTeams;
    }

    public function update(UpdateProgram $request)
    {
        // Update program when user is authorized.
        $program = new Program();
        $program->exists = true;
        $program->id = $request->input('id');
        $program->name = $request->input('name');
        $program->description = $request->input('description');
        $program->updated_by = auth()->user()->id;
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

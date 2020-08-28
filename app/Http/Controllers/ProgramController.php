<?php

namespace App\Http\Controllers;

use App\Program;
use App\ClientStatus;
use App\Http\Resources\Program as ProgramResource;
use App\Http\Resources\Programs;
use App\Http\Requests\StoreProgram;
use App\Http\Requests\UpdateProgram;

class ProgramController extends Controller
{
    /**
     * Returns all programs (sorted and paginated per request) available to the user..
     *
     * @return Collection
     */
    public function index()
    {
        $programs = new Program();

        // Sort per request.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $programs = $programs->sort($sortBy, $ascending);

        $programs = $programs->availableFor(auth()->user())->with('team');

        $programs->search(request('search'));

        $perPage = request('perPage');
        $programs = $programs->paginate($perPage);

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

        $teams = auth()->user()->availableTeams;
        $statuses = ClientStatus::all();
        $volunteer_types = config('app.program_volunteer_types');

        return compact('teams', 'statuses', 'volunteer_types');
    }

    public function store(StoreProgram $request)
    {
        $this->authorize('create', Program::class);

        // Store program when user is authorized.
        $program = new Program();
        $program->name = $request->input('name');
        $program->description = $request->input('description');
        $program->team_id = $request->input('team_id');
        $program->default_client_status_id = $request->input('default_client_status_id');
        $program->case_client_status_id = $request->input('case_client_status_id');
        $program->group_client_status_id = $request->input('group_client_status_id');
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
        $program->name = $request->input('name') ?? $program->name;
        $program->description = $request->input('description') ?? $program->description;
        $program->default_client_status_id = $request->input('default_client_status_id') ?? $program->default_client_status_id;
        $program->case_client_status_id = $request->input('case_client_status_id') ?? $program->case_client_status_id;
        $program->group_client_status_id = $request->input('group_client_status_id') ?? $program->group_client_status_id;
        $program->active = $request->input('active') ?? $program->active;
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

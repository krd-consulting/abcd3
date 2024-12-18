<?php

namespace App\Http\Controllers;

use App\Team;

use App\Http\Requests\StoreTeam;
use App\Http\Requests\UpdateTeam;

use App\Http\Resources\Team as TeamResource;
use App\Http\Resources\Teams;

use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
    	$teams = new Team;

        // Search
        $search = request('search');
        $teams = $teams->search($search);

        // Sort per request.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $teams = $teams->sort($sortBy, $ascending);

        $teams = $teams->availableFor(auth()->user());

        // Paginate per request.
        $perPage = request('perPage');
        $teams = $teams->paginate($perPage);

    	return (new Teams($teams));
    }

    public function show(Team $team)
    {
    	$this->authorize('read', $team);

    	return (new TeamResource($team));
    }

    public function edit(Team $team)
    {
        $this->authorize('write', $team);

        return (new TeamResource($team));
    }

    public function store(StoreTeam $request)
    {
        $this->authorize('create', Team::class);

        $team = new Team();
        $team->name = $request->name;
        $team->description = $request->input('description', null);
        $team->active = $request->input('active', true);
        $team->save();

        return (new TeamResource($team));
    }

    public function update(Team $team, UpdateTeam $request)
    {
        $this->authorize('write', $team);

        $team->name = $request->input('name', $team->name);
        $team->description = $request->input('description', $team->description);
        $team->active = $request->input('active', $team->active);
        $team->save();

        return (new TeamResource($team));
    }

    public function destroy(Team $team)
    {
        $this->authorize('write', $team);

        $team->delete();
    }
}

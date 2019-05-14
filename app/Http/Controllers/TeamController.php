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
    	$teams = (new Team)->availableFor(auth()->user())->get();

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
        $team->description = $request->description;
        $team->save();

        return (new TeamResource($team));
    }

    public function update(Team $team, UpdateTeam $request)
    {
        $this->authorize('write', $team);

        $team->name = $request->name;
        $team->description = $request->description;
        $team->save();

        return (new TeamResource($team));
    }

    public function destroy(Team $team)
    {
        $this->authorize('write', $team);

        $team->delete();
    }
}

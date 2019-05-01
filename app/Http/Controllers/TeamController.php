<?php

namespace App\Http\Controllers;

use App\Team;

use App\Http\Resources\Team as TeamResource;
use App\Http\Resources\Teams;

use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index() 
    {
    	$teams = (new Team)->availableFor(auth()->user())->get()

    	return $teams;
    }

    public function show(Team $team)
    {
    	$this->authorize('read', $team);

    	return new TeamResource($team);
    }
}

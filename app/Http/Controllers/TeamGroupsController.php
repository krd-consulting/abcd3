<?php

namespace App\Http\Controllers;

use App\Team;

use App\Http\Resources\Groups;

use Illuminate\Http\Request;

class TeamGroupsController extends Controller
{
    public function index(Team $team)
    {
        $groups = $team->groups()->with('program');

        $groups = $groups->availableFor(auth()->user());

        // Search
        $search = request('search');
        $groups = $groups->search($search);

        // Sort per request.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $groups = $groups->sort($sortBy, $ascending);

        // Paginate per request.
        $perPage = request('perPage');
        $groups = $groups->paginate($perPage);

        return new Groups($groups);
    }
}

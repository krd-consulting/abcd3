<?php

namespace App\Http\Controllers;

use App\Team;

use App\Http\Resources\Programs;

use Illuminate\Http\Request;

class TeamProgramsController extends Controller
{
    public function index(Team $team)
    {
        $programs = $team->programs();

        $programs = $programs->availableFor(auth()->user());

        // Search
        $search = request('search');
        $programs = $programs->search($search);

        // Sort per request.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $programs = $programs->sort($sortBy, $ascending);

        // Paginate per request.
        $perPage = request('perPage');
        $programs = $programs->paginate($perPage);

        return new Programs($programs);
    }
}

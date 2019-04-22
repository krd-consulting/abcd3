<?php

namespace App\Http\Controllers;

use App\Group;
use App\Record;
use App\RecordType;

use App\Http\Resources\Groups;

use Illuminate\Http\Request;

class GroupsAvailableForRecord extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RecordType $recordType, Record $record)
    {
        $selectedGroups = $record->groups()->pluck('groups.id');
        $groups = Group::whereNotIn('groups.id', $selectedGroups);

        // Search
        $search = request('search');
        $groups = $groups->search($search);

        // Sort per request.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $groups = $groups->sort($sortBy, $ascending);

        $groups = $groups->availableFor(auth()->user());

        // Paginate per request.
        $perPage = request('perPage');
        $groups = $groups->paginate($perPage);

        return (new Groups($groups));
    }
}

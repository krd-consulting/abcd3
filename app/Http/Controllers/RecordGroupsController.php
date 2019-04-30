<?php

namespace App\Http\Controllers;

use App\Group;
use App\Record;
use App\RecordType;

use App\Http\Resources\Groups;

use Illuminate\Http\Request;

class RecordGroupsController extends Controller
{
    public function index(RecordType $recordType, Record $record)
    {
        $groups = $record->groups()->with('program');

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

        return new Groups($groups);
    }

    public function store(RecordType $recordType, Record $record, Group $group)
    {
    	$this->authorize('write', $record);
        $this->authorize('write', $group);

        $record->assignGroup($group);

        return $group;
    }

    public function destroy(RecordType $recordType, Record $record, Group $group)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $group);

        $record->groups()->detach($group);

        return $group;
    }
}

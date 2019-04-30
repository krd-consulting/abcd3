<?php

namespace App\Http\Controllers;

use App\Group;
use App\Record;
use App\RecordType;

use App\Http\Resources\Records;

use Illuminate\Http\Request;

class GroupRecordsController extends Controller
{
    public function index(Group $group, RecordType $recordType)
    {
        $records = $group->records()->only($recordType);

        // Search
        $search = request('search');
        $records = $records->search($search);

        // Sort per request.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $records = $records->sort($sortBy, $ascending);

        $records = $records->availableFor(auth()->user());

        // Paginate per request.
        $perPage = request('perPage');
        $records = $records->paginate($perPage);

        return (new Records($records))->as($recordType);
    }

    public function store(Group $group, RecordType $recordType, Record $record)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $group);

        $group->addRecord($record);

        return $record;
    }

    public function destroy(Group $group, RecordType $recordType, Record $record)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $group);

        $group->records()->detach($record);

        return $record;
    }
}

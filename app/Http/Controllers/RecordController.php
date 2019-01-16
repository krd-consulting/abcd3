<?php

namespace App\Http\Controllers;

use App\Record;
use App\RecordType;
use App\User;
use App\Http\Resources\Record as RecordResource;
use App\Http\Resources\Records;

use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Returns a list $recordType records (sorted and paginated per request) available to the user
     * with data about the records' record type and field names.
     *
     * @param  RecordType $recordType
     * @return ResourceCollection
     */
    public function index(RecordType $recordType)
    {
        $records = $recordType->records()->availableFor(auth()->user());

        // Search
        $search = request('search');
        $records->search($search);

        // Sort per request.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $records->sort($sortBy, $ascending);

        // Paginate per request.
        $perPage = request('perPage');
        $records = $records->paginate($perPage);

        $records->load('record_type');

        return (new Records($records));
    }

    /**
     * Show the prorecord of the selected user.
     *
     * @param  Record  $record
     * @return Record
     */
    public function show(RecordType $recordType, Record $record)
    {
        $this->authorize('read', $record);

        $record = $record->load('record_type');

        return (new RecordResource($record));
    }

    public function create()
    {
        $this->authorize('create', Record::class);

        return auth()->user()->availableTeams;
    }

    public function store()
    {
        $this->authorize('create', Record::class);

        // Store record when user is authorized.
    }

    public function edit(Record $record)
    {
        $this->authorize('write', $record);

        // Return record when user is authorized.
    }

    public function update(Record $record)
    {
        $this->authorize('write', $record);

        // Update record when user is authorized.
    }

    public function destroy(Record $record)
    {
        $this->authorize('write', $record);

        // Delete record when user is authorized.
    }
}

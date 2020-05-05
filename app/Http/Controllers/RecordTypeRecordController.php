<?php

namespace App\Http\Controllers;

use App\RecordType;
use App\Http\Resources\Records;

class RecordTypeRecordController extends Controller
{
    /**
     * Returns a list $recordType records (sorted and paginated per request) available to the user
     * with data about the records' record type and field names.
     *
     * @param  RecordType $recordType
     * @return ResourceCollection
     */
    public function index(RecordType $recordType)
    {
        $records = $recordType->records();

        $active = request('active') ?? true;
        $records->active($active);

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
}

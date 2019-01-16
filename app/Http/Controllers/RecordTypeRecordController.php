<?php

namespace App\Http\Controllers;

use App\Record;
use App\RecordType;
use App\User;
use App\Http\Resources\Records;

use Illuminate\Http\Request;

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

        return (new Records($records))->as($recordType);
    }
}

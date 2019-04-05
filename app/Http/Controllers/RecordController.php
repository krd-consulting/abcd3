<?php

namespace App\Http\Controllers;

use App\Record;
use App\RecordType;
use App\User;
use App\Http\Requests\StoreRecord;
use App\Http\Requests\UpdateRecord;
use App\Http\Resources\Record as RecordResource;
use App\Http\Resources\Records;

use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function __construct()
    {

    }

    /**
     *
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

    public function store(StoreRecord $request)
    {
        $this->authorize('create', Record::class);

        // Store record when user is authorized.
        $record = new Record();
        $record->field_1_value = $request->input('field_1_value');
        $record->field_2_value = $request->input('field_2_value');
        $record->field_3_value = $request->input('field_3_value');
        $record->record_type_id = $request->input('record_type_id');
        $record->created_by = auth()->user()->id;
        $record->updated_by = auth()->user()->id;
        $record->save();
        $record->assignTeam(
            $request->input('team_id')
        );

        return new RecordResource($record);
    }

    public function edit(Record $record)
    {
        $this->authorize('write', $record);

        // Return available teams when user is authorized.
        return auth()->user()->availableTeams;
    }

    public function update(UpdateRecord $request)
    {
        // Update record when user is authorized.
        $record = new Record();
        $record->exists = true;
        $record->id = $request->input('id');
        $record->field_1_value = $request->input('field_1_value');
        $record->field_2_value = $request->input('field_2_value');
        $record->field_3_value = $request->input('field_3_value');
        $record->updated_by = auth()->user()->id;
        $record->save();

        return $record;
    }

    public function destroy(Record $record)
    {
        $this->authorize('write', $record);

        // Delete record when user is authorized.
        $record->delete();
    }
}

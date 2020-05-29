<?php

namespace App\Http\Controllers;

use App\Record;
use App\RecordType;
use App\User;
use App\Http\Requests\StoreRecord;
use App\Http\Requests\UpdateRecord;
use App\Http\Resources\Record as RecordResource;
use App\Http\Resources\Teams as Teams;
use App\Http\Resources\Records;

use Illuminate\Http\Request;

class RecordController extends Controller
{
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

    public function create(RecordType $recordType)
    {
        $this->authorize('create', Record::class);

        return (new Teams(auth()->user()->availableTeams));
    }

    public function store(RecordType $recordType, StoreRecord $request)
    {
        $this->authorize('create', Record::class);

        // Store record when user is authorized.
        $record = new Record();

        $record = $record->firstOrCreate(
            [
                'field_1_value' => $request->input('field_1_value'),
                'field_2_value' => $request->input('field_2_value', null),
                'field_3_value' => $request->input('field_3_value', null),
                'record_type_id' => $request->input('record_type_id'),
            ],
            [
                'active' => true
            ]
        );

        $record->assignTeam(
            $request->input('team_id')
        );

        return new RecordResource($record);
    }

    public function edit(RecordType $recordType, Record $record)
    {
        $this->authorize('write', $record);

        // Return record data when user is authorized.
        $record = $record->load('record_type');
        return (new RecordResource($record));
    }

    public function update(RecordType $recordType, Record $record, UpdateRecord $request)
    {
        $this->authorize('write', $record);

        // Update record when user is authorized.
        $record->field_1_value = $request->input('field_1_value') ?? $record->field_1_value;
        $record->field_2_value = $request->input('field_2_value') ?? $record->field_2_value;
        $record->field_3_value = $request->input('field_3_value') ?? $record->field_3_value;
        $record->active = $request->input('active') ?? $record->active;
        $record->save();

        return $record;
    }

    public function destroy(RecordType $recordType, Record $record)
    {
        $this->authorize('write', $record);

        // Delete record when user is authorized.
        $record->delete();
    }
}

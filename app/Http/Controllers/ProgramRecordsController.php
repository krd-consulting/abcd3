<?php

namespace App\Http\Controllers;

use App\Program;
use App\ProgramClient;
use App\ProgramRecord;
use App\Record;
use App\RecordType;
use App\ClientStatus;

use App\Http\Resources\ProgramRecord\ProgramRecords as Records;

use App\Http\Requests\StoreProgramRecord;
use App\Http\Requests\UpdateProgramRecord;

use Illuminate\Http\Request;

class ProgramRecordsController extends Controller
{

    public function index(Program $program, RecordType $recordType)
    {
        $records = $program
            ->records($recordType->identity)
            ->withLatestProgramStatuses($recordType->identity, $program)
            ->only($recordType);
            // join statuses latest status
            // ->leftJoin('program_client_status', 'program_record.id', '=', 'program_client_status.program_record_id');

        // return $records->get();

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

        return $this->transform($records, $recordType);
    }

    private function transform($records, RecordType $recordType)
    {
        $map = [
            'Client' => 'App\Http\Resources\ProgramRecord\ProgramClients',
            'Staff' => 'App\Http\Resources\ProgramRecord\ProgramStaves',
            'Volunteer' => 'App\Http\Resources\ProgramRecord\ProgramVolunteers',
            'Other' => 'App\Http\Resources\ProgramRecord\ProgramOthers',
        ];

        $class = $map[$recordType->identity->name];

        return (new $class($records))->as($recordType);
    }

    private function pivots(RecordType $recordType)
    {
        $enrolledAt = [
            'name' => 'Enrolled At',
            'key' => 'enrolled_at',
            'slug' => 'enrolled_at'
        ];

        $map = [
          'Client' => [
              $enrolledAt,
              [
                  'name' => 'Status',
                  'slug' => 'latest_status',
                  'key' => 'latest_status'
              ],
              [
                  'name' => 'Notes',
                  'slug' => 'latest_status_notes',
                  'key' => 'latest_status_notes'
              ]
          ],
          'Staff' => [
              $enrolledAt,
          ],
          'Volunteer' => [
              $enrolledAt,
          ],
          'Other' => [
              $enrolledAt,
          ]
        ];

        return $map[$recordType->identity->name];
    }

    public function edit(Program $program, RecordType $recordType, Record $record)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $program);

        $programRecord = $this->getModel($recordType);

        $data = (new $programRecord)->of($program, $record)->first();

        return [
            'data' => $data
        ];
    }

    public function store(Program $program, RecordType $recordType, Record $record, StoreProgramRecord $request)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $program);

        $programRecord = $this->getModel($recordType);

        $programRecord = new $programRecord();
        $programRecord->createFrom($program, $record, true, $request);

        return $record;
    }

    public function update(
        Program $program,
        RecordType $recordType,
        Record $record,
        UpdateProgramRecord $request
    )
    {
        $programRecord = $this->getModel($recordType);

        $programRecord = new $programRecord();
        $programRecord = $programRecord->of($program, $record)->first();

        $programRecord->updateUsingRequest($request)->save();

        // Return response
        return $programRecord;
    }

    public function destroy(Program $program, RecordType $recordType, Record $record)
    {
        $this->authorize('write', $record);
        $this->authorize('write', $program);

        $model = $this->getModel($recordType);

        $programRecord = new $model();

        $programRecord = $programRecord->of($program, $record)->first();

        $programRecord->delete();

        return $record;
    }

    private function getModel(RecordType $recordType)
    {
        return "App\Program" . $recordType->identity->model;
    }
}

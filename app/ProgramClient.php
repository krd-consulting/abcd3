<?php

namespace App;

use App\ProgramRecord;
use App\ProgramClientStatus as Status;

use Illuminate\Database\Eloquent\Model;

class ProgramClient extends ProgramRecord
{
    protected $table = 'program_record';

    public function createProgramRecord(Program $program, Record $record, User $user)
    {
        $programRecord = parent::createProgramRecord($program, $record, $user);

        if($record->record_type->identity->name == 'Client') {
            $status = new Status([
                'program_client_id' => $programRecord->id,
                'status' => 'waitlist',
                'previous_status' => '',
                'previous_status_duration' => 1312312,
                'notes' => '',
                'created_by' => $user->id,
                'updated_by' => $user->id
            ]);

            $this->statuses()->save($status);
        }

        return $programRecord;
    }

    public function statuses()
    {
        return $this->hasMany('App\ProgramClientStatus', 'program_client_id');
    }
}

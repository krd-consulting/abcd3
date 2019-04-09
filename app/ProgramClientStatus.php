<?php

namespace App;

use App\ProgramRecord;
use App\User;

use App\Http\Requests\UpdateProgramRecord;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class ProgramClientStatus extends Model
{
    protected $table = 'program_client_status';

    protected $guarded = [];

    public function programRecord()
    {
        return $this->belongsTo('App\ProgramRecord', 'program_client_id');
    }

    public function status()
    {
        return $this->belongsTo('App\ClientStatus', 'status_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('F j, Y');
    }

    public function updateUsingRequest(UpdateProgramRecord $request, User $user)
    {
        $currentStatusId = $this->status_id;

        $this->status_id = $request->status['id'];
        $this->notes = $request->status['notes'];

        $this->exists = !$this->isDirty('status_id');

        if(!$this->exists) {
            $this->id = NULL;
            $this->previous_status_id = $currentStatusId;
            $this->previous_status_duration = 0;
            $this->created_by = $user->id;
        }
        $this->updated_by = $user->id;
        $this->save();
    }

    public function createForProgramRecord(
        ProgramRecord $programRecord,
        $status = 1,
        $previous_status = NULL,
        $previous_status_duration = 0,
        $notes = ''
    )
    {
        if($programRecord->record->record_type->identity->name != 'Client')
            return;

        $this->program_client_id = $programRecord->id;
        $this->status_id = $status;
        $this->previous_status_id = $previous_status;
        $this->previous_status_duration = $previous_status_duration;
        $this->notes = $notes;
        $this->created_by = $programRecord->created_by;
        $this->updated_by = $programRecord->created_by;
        $this->save();
    }
}

<?php

namespace App;

use App\ProgramRecord;

use App\Http\Requests\UpdateProgramRecord;

use App\Model;

use Carbon\Carbon;

class ProgramClientStatus extends Model
{
    protected $table = 'program_client_status';

    public $with = ['status'];

    protected $guarded = [];

    public function programRecord()
    {
        return $this->belongsTo('App\ProgramRecord', 'program_record_id');
    }

    public function status()
    {
        return $this->belongsTo('App\ClientStatus', 'status_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('F j, Y');
    }

    public function updateUsingRequest(UpdateProgramRecord $request)
    {
        $this->updateUsing($request->status['id'], $request->notes, true);
    }

    public function updateUsing($status, $notes = '', $save = false)
    {
        $currentStatusId = $this->status_id;

        $this->status_id = $status;
        $this->notes = $notes;

        $this->exists = !$this->isDirty('status_id');

        if(!$this->exists) {
            $this->id = NULL;
            $this->previous_status_id = $currentStatusId;
            $this->previous_status_duration = $this->calculatePreviousStatusDuration();
        }
        
        $save == true ? $this->save() : NULL;
    }

    protected function calculatePreviousStatusDuration()
    {
        $end = Carbon::parse($this->{$this->getUpdatedAtColumn()});

        return $end->diffInSeconds(Carbon::now());
    }

    public function createForProgramRecord(
        ProgramRecord $programRecord,
        $status = NULL,
        $previous_status = NULL,
        $previous_status_duration = 0,
        $notes = ''
    )
    {
        if($programRecord->record->record_type->identity->name != 'Client')
            return;

        $this->program_record_id = $programRecord->id;
        $this->status_id = isset($status) ? $status : $programRecord->program->default_client_status_id;
        $this->previous_status_id = $previous_status;
        $this->previous_status_duration = $previous_status_duration;
        $this->notes = $notes;
        $this->save();
    }
}

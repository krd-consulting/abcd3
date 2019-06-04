<?php

namespace App;

use App\Program;
use App\Record;

use App\Http\Requests\StoreProgramRecord;

use App\ProgramRecord;

class ProgramClient extends ProgramRecord
{
    protected $table = 'program_record';

    public function statuses()
    {
        return $this->hasMany('App\ProgramClientStatus', 'program_client_id');
    }

    public function createUsingBelongsTo(Program $program, Record $record, $save = true, StoreProgramRecord $request = null)
    {
        $programRecord = parent::createUsingBelongsTo($program, $record, false);

        $programRecord->enrolled_at = $request->enrolled_at;

        $save ? $programRecord->save() : NULL;

        return $programRecord;
    }

    public function delete()
    {
        abort_if(
            $this->isActive,
            422,
            "Can't remove record from program. The record is still active."
        );

        return parent::delete();
    }

    public function getLatestStatusAttribute()
    {
        return $this->statuses()->latest()->first();
    }

    public function scopeWithLatestStatus($query)
    {
        return $query->with(['statuses' => function($query) {
                            return $query->latest()->first();
                        }, 'statuses.status'])->first();
    }

    public function getIsActiveAttribute()
    {
        return $this->latestStatus->status->name == config('app.program_client_statuses.active.name');
    }
}

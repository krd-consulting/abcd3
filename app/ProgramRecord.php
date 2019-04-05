<?php

namespace App;

use App\Program;
use App\Record;
use App\User;

use App\Events\ProgramRecordCreated;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProgramRecord extends Pivot
{
    protected $dispatchesEvents = [
        'saved' => ProgramRecordCreated::class
    ];

    public function createProgramRecord(Program $program, Record $record, User $user)
    {
        $this->program_id = $program->id;
        $this->record_id = $record->id;
        $this->created_by = $user->id;
        $this->save();

        return $this;
    }

    public function program()
    {
        return $this->belongsTo('App\Program');
    }

    public function statuses()
    {
        return $this->hasMany('App\ProgramClientStatus', 'program_client_id');
    }

    public function record()
    {
        return $this->belongsTo('App\Record');
    }

    public function getEnrolledAtAttribute($value)
    {
        return Carbon::parse($value)->format('F j, Y');
    }
}

<?php

namespace App;

use App\Program;
use App\Record;
use App\User;

use App\Events\ProgramRecordSaved;
use App\Events\ProgramRecordDeleted;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramRecord extends Pivot
{
    use SoftDeletes;

    protected $dispatchesEvents = [
        'created' => ProgramRecordSaved::class,
        'deleted' => ProgramRecordDeleted::class,
        'restored' => ProgramRecordSaved::class
    ];

    public function createUsingBelongsTo(Program $program, Record $record, User $user)
    {
        $existingRow = $this->findTrashedUsingBelongsTo($program, $record);

        if($existingRow->exists()) {
            $existingRow->first()->restore();
            return $existingRow;
        }

        $this->program_id = $program->id;
        $this->record_id = $record->id;
        $this->created_by = $user->id;
        $this->save();

        return $this;
    }

    public function findTrashedUsingBelongsTo(Program $program, Record $record)
    {
        return $this
            ->where('program_id', $program->id)
            ->where('record_id', $record->id)
            ->onlyTrashed();
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

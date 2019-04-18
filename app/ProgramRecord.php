<?php

namespace App;

use App\Program;
use App\Record;
use App\User;

use App\Events\ProgramRecordSaved;
use App\Events\ProgramRecordDeleted;

use Carbon\Carbon;

use App\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramRecord extends Pivot
{
    use SoftDeletes;

    public $incrementing = true;

    protected $dispatchesEvents = [
        'created' => ProgramRecordSaved::class,
        'deleted' => ProgramRecordDeleted::class,
        'restored' => ProgramRecordSaved::class
    ];

    public function createUsingBelongsTo(Program $program, Record $record)
    {
        $existingRow = $this->findTrashedUsingBelongsTo($program, $record);

        if($existingRow->exists()) {
            $existingRow->first()->restore();
            return $existingRow;
        }

        $this->program_id = $program->id;
        $this->record_id = $record->id;
        $this->save();

        return $this;
    }

    public function findTrashedUsingBelongsTo(Program $program, Record $record)
    {
        return $this->findUsingBelongsTo($program, $record)->onlyTrashed();
    }

    public function findUsingBelongsTo(Program $program, Record $record)
    {
        return $this->where('program_id', $program->id)->where('record_id', $record->id);
    }

    public function program()
    {
        return $this->belongsTo('App\Program');
    }

    public function record()
    {
        return $this->belongsTo('App\Record');
    }

    public function getEnrolledAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
}

<?php

namespace App;

use App\Program;
use App\Record;
use App\User;

use App\Http\Requests\StoreProgramRecord;

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

    public function createUsingBelongsTo(Program $program, Record $record, $save = true)
    {
        $programRecord = $this->findTrashedUsingBelongsTo($program, $record);

        if($programRecord->exists()) {
            $programRecord = $programRecord->first();
            $programRecord->restore();
        }else {
            $this->program_id = $program->id;
            $this->record_id = $record->id;
            $programRecord = $this;
        }

        $save ? $programRecord->save() : NULL;

        return $programRecord;
    }

    public function findTrashedUsingBelongsTo(Program $program, Record $record)
    {
        return $this->findUsingBelongsTo($program, $record)->onlyTrashed();
    }

    public function findUsingBelongsTo(Program $program, Record $record)
    {
        return $this->where('program_id', $program->id)->where('record_id', $record->id);
    }

    public function findUsingPrograms(Record $record, $programs)
    {
        return $this->where('record_id', $record->id)->whereIn('program_id', $programs);
    }

    public function findUsingRecords(Program $program, $records)
    {
        return $this->where('program_id', $program->id)->whereIn('record_id', $records);
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
        if($value == NULL)
            return NULL;
        
        return Carbon::parse($value)->format('Y-m-d');
    }
}

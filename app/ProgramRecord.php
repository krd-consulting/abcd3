<?php

namespace App;

use App\Program;
use App\Record;

use App\Http\Requests\StoreProgramRecord;
use App\Http\Requests\UpdateProgramRecord;

use App\Observers\ProgramRecordObserver;

use Carbon\Carbon;

use App\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramRecord extends Pivot
{
    use SoftDeletes;

    public $incrementing = true;

    protected static function boot()
    {
        parent::boot();

        static::observe(ProgramRecordObserver::class);
    }

    public function createFrom(Program $program, Record $record, $save = true, StoreProgramRecord $request = NULL)
    {
        $programRecord = $this->of($program, $record);

        if($programRecord->of($program, $record)->exists()) {
            $programRecord = $programRecord->first();
        }else if($this->ofTrashed($program, $record)->exists()) {
            $programRecord = $this->ofTrashed($program, $record)->first();
            $programRecord->restore();
        }else {
            $this->program_id = $program->id;
            $this->record_id = $record->id;
            $programRecord = $this;
        }

        if(isset($request)) {
            if(!empty($request->validated()['enrolled_at'])) {
                $programRecord->enrolled_at = $request->validated()['enrolled_at'];
            }
        }

        if(empty($programRecord->enrolled_at))
            $programRecord->enrolled_at = now();

        $save ? $programRecord->save() : NULL;

        return $programRecord;
    }

    public function updateUsingRequest(UpdateProgramRecord $request)
    {   
        $this->enrolled_at = $request->enrolled_at;

        return $this;
    }

    public function getEnrolledAtAttribute($value)
    {
        if($value == NULL)
            return NULL;
        
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function setStatus($status)
    {

    }

    public function scopeOfTrashed($query, Program $program, Record $record)
    {
        return $query->of($program, $record)->onlyTrashed();
    }

    public function scopeOf($query, Program $program, Record $record)
    {
        return $query->where('program_id', $program->id)->where('record_id', $record->id);
    }

    public function scopeOfPrograms($query, $programs, Record $record)
    {
        return $query->where('record_id', $record->id)->whereIn('program_id', $programs);
    }

    public function scopeOfRecords($query, $records, Program $program)
    {
        return $query->where('program_id', $program->id)->whereIn('record_id', $records);
    }

    public function program()
    {
        return $this->belongsTo('App\Program');
    }

    public function record()
    {
        return $this->belongsTo('App\Record');
    }
}

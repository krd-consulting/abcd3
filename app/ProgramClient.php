<?php

namespace App;

use App\Program;
use App\Record;
use App\ProgramRecord;
use App\ProgramClientStatus;

use App\Http\Requests\StoreProgramRecord;
use App\Http\Requests\UpdateProgramRecord;

use App\Observers\ProgramClientObserver;

use \Tightenco\Parental\HasParent;

class ProgramClient extends ProgramRecord
{
    use HasParent;
        
    public $incrementing = true;

    protected $table = 'program_record';

    protected $appends = ['latest_status'];

    // protected $dispatchesEvents = [
    //     'created' => ProgramRecordSaved::class,
    //     'deleted' => ProgramRecordDeleted::class,
    //     'restored' => ProgramRecordSaved::class
    // ];

    protected static function boot()
    {
        parent::boot();

        static::observe(ProgramClientObserver::class);
    }

    public function statuses()
    {
        return $this->hasMany('App\ProgramClientStatus');
    }

    public function record()
    {
        return $this->belongsTo('App\Client');
    }

    public function client()
    {
        return $this->record();
    }

    public function createFrom(
        Program $program, Record $record, $save = true, StoreProgramRecord $request = NULL
    )
    {
        $programRecord = parent::createFrom($program, $record, false, $request);

        $save ? $programRecord->save() : NULL;

        return $programRecord;
    }

    public function updateUsingRequest(UpdateProgramRecord $request)
    {   
        parent::updateUsingRequest($request);

        $this->statuses()->latest()->first()->updateUsingRequest($request);

        return $this;
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

    public function setStatus($status)
    {
        $clientStatus = new ProgramClientStatus();
        $clientStatus->createForProgramRecord($this, $status);
        $clientStatus->save();
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

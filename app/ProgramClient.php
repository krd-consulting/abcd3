<?php

namespace App;

use App\Program;
use App\Record;

use App\Http\Requests\StoreProgramRecord;

use App\ProgramRecord as Model;

class ProgramClient extends Model
{
    protected $table = 'program_record';

    public function statuses()
    {
        return $this->hasMany('App\ProgramClientStatus', 'program_client_id');
    }

    public function createUsingBelongsTo(Program $program, Record $record, $save = true, StoreProgramRecord $request = null)
    {
    	if($record->record_type->identity->name != 'Client') {
    		return parent::createUsingBelongsTo($program, $record, true);
    	}

        $programRecord = parent::createUsingBelongsTo($program, $record, $save);

        $programRecord->enrolled_at = $request->enrolled_at;

        $programRecord->save();

        return $programRecord;
    }
}

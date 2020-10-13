<?php

namespace App;

use App\Record;

use Parental\HasParent;

class Client extends Record
{
    use HasParent;

    protected static function boot()
    {
    	parent::boot();

    	static::addGlobalScope(function ($query) {
    		$query->whereHas('record_type', function ($query) {
    			$query->whereHas('identity', function ($query) {
    				$query->where('name', 'Client');
    			});
    		});
    	});
    }

    public function program_statuses()
    {
        return $this->hasManyThrough(
            'App\ProgramClientStatus',
            'App\ProgramClient',
            'record_id',
            'program_record_id'
        );
    }

    public function scopeWithLatestProgramStatuses($query, RecordType $recordType, Program $program)
    {
        if($recordType->identity->model == 'Record')
            return $query;

        $recordStatusTable = 'program_' . strtolower($recordType->identity->model) . '_status';

        $model = 'App\\Program' . $recordType->identity->model . 'Status';

        $latestStatuses = $model::selectRaw(
            "program_record_id, MAX(created_at) as max_created_at"
        )->groupBy('program_record_id');

        return $query->with([
            'program_statuses' => function ($query) use ($program, $latestStatuses, $recordStatusTable) {
                $query
                    ->joinSub($latestStatuses, 'latest_statuses', function ($join) use ($recordStatusTable) {
                        $join
                            ->on($recordStatusTable.'.program_record_id', '=', 'latest_statuses.program_record_id')
                            ->on($recordStatusTable.'.created_at', '=', 'latest_statuses.max_created_at');
                    })->where('program_id', $program->id);
            }
        ]);
    }
}

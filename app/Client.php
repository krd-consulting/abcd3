<?php

namespace App;

use App\Record;

use \Tightenco\Parental\HasParent;

class Client extends Record
{
    use HasParent;

	protected $table = 'records';

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
}

<?php

namespace App;

use App\Model;

class FieldTargetType extends Model
{
    protected $table = 'form_target_types';

    protected $singularNameMap = [
      'Records' => 'Record',
      'Programs' => 'Program',
      'Teams' => 'Team',
      'Groups' => 'Group',
      'Form Fields' => 'FormField',
    ];

    protected $appends = ['singular_name'];

    protected static function boot()
    {
    	parent::boot();

    	static::addGlobalScope(function ($query) {
    		$query
    			->where('name', '!=', config('app.form_target_types.form.name'));
    	});
    }

    public function getSingularNameAttribute()
    {
      return $this->singularNameMap[$this->name];
    }
}

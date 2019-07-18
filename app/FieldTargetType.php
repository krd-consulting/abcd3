<?php

namespace App;

use App\Model;

class FieldTargetType extends Model
{
	protected $table = 'form_target_types';

    protected static function boot()
    {
    	parent::boot();

    	static::addGlobalScope(function ($query) {
    		$query
    			->where('name', '!=', config('app.form_target_types.form.name'));
    	});
    }
}

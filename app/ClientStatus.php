<?php

namespace App;

use App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class ClientStatus extends Model
{
	use SoftDeletes;

    protected $guarded = [];
	
    public function program_clients()
    {
        return $this->hasMany('App\ProgramClientStatus', 'status_id');
    }

    public function programs()
    {
    	return $this->hasMany('App\Program', 'default_client_status_id');
    }

    public function setEnabledAttribute($enabled)
    {
        $this->attributes['disabled_at'] = !$enabled ? now() : NULL;
    }

    public function scopeDisabled($query, $disabled)
    {
        return $disabled == true ? $query->whereNotNull('disabled_at') : $query->whereNull('disabled_at');
    }
}

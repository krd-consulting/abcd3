<?php

namespace App;

use App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class ClientStatus extends Model
{
	use SoftDeletes;
	
    public function program_clients()
    {
        return $this->hasMany('App\ProgramClientStatus', 'status_id');
    }

    public function programs()
    {
    	return $this->hasMany('App\Program', 'default_client_status_id');
    }
}

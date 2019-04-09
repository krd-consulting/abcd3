<?php

namespace App;

use App\Model;

class ClientStatus extends Model
{
    public function program_clients()
    {
        return $this->hasMany('App\ProgramClientStatus', 'status_id');
    }
}

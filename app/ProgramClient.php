<?php

namespace App;

use App\ProgramRecord as Model;

class ProgramClient extends Model
{
    protected $table = 'program_record';

    public function statuses()
    {
        return $this->hasMany('App\ProgramClientStatus', 'program_client_id');
    }
}

<?php

namespace App;

use App\Model;

class Scope extends Model
{
    public function roles()
    {
        return $this->hasMany('App\Role');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scope extends Model
{
    public function users() {
        return $this->hasMany('App\User');
    }
}

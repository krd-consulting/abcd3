<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function records()
    {
        return $this->belongsToMany('App\Record');
    }

    public function programs()
    {
        return $this->hasMany('App\Program');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}

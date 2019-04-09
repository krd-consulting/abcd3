<?php

namespace App;

use App\Pivot;

class TeamRecord extends Pivot
{
    public $incrementing = true;

    protected $table = 'record_team';

    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function record()
    {
        return $this->belongsTo('App\Record');
    }
}

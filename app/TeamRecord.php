<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TeamRecord extends Pivot
{
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

<?php

namespace App;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProgramRecord extends Pivot
{
    public function program()
    {
        return $this->belongsTo('App\Program');
    }

    public function record()
    {
        return $this->belongsTo('App\Record');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('F j, Y');
    }

    public function getStatusUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('F j, Y');
    }
}

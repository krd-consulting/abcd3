<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CaseRecord extends Pivot
{
    protected $table = 'cases';

    public function owner()
    {
        return $this->belongsTo('App\Record', 'owner_id');
    }

    public function record()
    {
        return $this->belongsTo('App\Record');
    }

}

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

    public function program()
    {
        return $this->belongsTo('App\Program');
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

}

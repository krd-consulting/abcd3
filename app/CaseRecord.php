<?php

namespace App;

use App\Pivot;

class CaseRecord extends Pivot
{
    public $incrementing = true;

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

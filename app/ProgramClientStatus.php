<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class ProgramClientStatus extends Model
{
    protected $table = 'program_client_statuses';

    protected $guarded = [];

    public function programRecord()
    {
        return $this->belongsTo('App\ProgramRecord', 'program_client_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('F j, Y');
    }
}

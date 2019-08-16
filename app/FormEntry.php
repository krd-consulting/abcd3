<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Models\Search;
use App\Traits\Models\Sort;

use Carbon\Carbon;

class FormEntry extends Model
{
    use Search;
    use Sort;

    public $searchColumns = [];

    public $guarded = [];

    public function setCompletedAtAttribute($value)
	{
	    $this->attributes['completed_at'] = Carbon::parse($value)->toDateTimeString();
	}
}

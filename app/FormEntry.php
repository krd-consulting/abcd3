<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Models\Search;
use App\Traits\Models\Sort;

use Carbon\Carbon;

use Wildside\Userstamps\Userstamps;

class FormEntry extends Model
{
    use Search;
    use Sort;
    use Userstamps;

    public $searchColumns = [];

    public $guarded = [];

    public function setCompletedAtAttribute($value)
	{
	    $this->attributes['completed_at'] = Carbon::parse($value)->toDateTimeString();
	}
}

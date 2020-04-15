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

    protected $guarded = [];

    protected $casts = [
    	//'field_1' => 'array'
    ];

    public function setCompletedAtAttribute($value)
	{
	    $this->attributes['completed_at'] = Carbon::parse($value)->toDateTimeString();
	}

	public function castFieldsToArray($fields)
	{
		$casts = [];

		foreach($fields as $field) {
			$casts[$field] = 'array';
		}

		$this->casts = $casts;
	}

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Models\Search;
use App\Traits\Models\Sort;

use Carbon\Carbon;

use Barryvdh\Debugbar\Facade as Debugbar;

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

    /**
     * Returns the Form that this entry belongs to.
     * @return Form the form that this entry belongs to
     */
    public function form() {
        if(empty($this->getTable())) {
            return null;
        }

        return Form::where('table_name', $this->getTable())->first();
    }

    public function target()
    {
        $targetModel = $this->form()->target_type->model;

        if($targetModel == 'App\RecordType') {
            $targetModel = 'App\Record';
        }

		return $this->belongsTo($targetModel);
    }

}

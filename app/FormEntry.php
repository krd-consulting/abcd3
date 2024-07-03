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

    private $targetModel;

    public function getTargetModelRelationship() {
        return $this->belongsTo($this->targetModel, 'target_id', 'id');
    }

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
        // Have to do this because for some reason,
        // $this->form()->target_type always returns the first item in
        // the form target types table.
        $targetType = FormTargetType::find($this->form()->target_type_id);

        $targetModel = $targetType->model;

        $targetModel = (new $targetModel)->getFormReferenceClass();

		    return $this->belongsTo($targetModel);
    }

    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function scopeAvailableFor($query, $user) {
        $formTargetTypeModel = $this->form()->target_type->model;
        $this->targetModel = (new $formTargetTypeModel())->getFormReferenceClass();

        $query->joinRelation('getTargetModelRelationship as target_model', function ($targetModelObject) use ($user) {
            $targetModelObject->availableFor($user);
        });

        $table = $this->getTable();
        $query->select("$table.*");

        return $query;
    }

}

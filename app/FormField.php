<?php

namespace App;

use App\Traits\Models\Search;
use App\Traits\Models\Sort;

use Illuminate\Database\Eloquent\Model;

use Spatie\SchemalessAttributes\SchemalessAttributes;

class FormField extends Model
{
    use Search;
    use Sort;

    protected $guarded = [];

    protected $appends = ['target', 'name'];

    public $timestamps = false;

    protected $searchColumns = [
        'title'
    ];

	public $casts = [
        'validation_rules' => 'array',
        'options' => 'array',
        'settings' => 'array',
    ];

    protected $columnTypes = [
        'text' => 'string',
        'textbox' => 'text',
        'number' => 'decimal',
        'dropdown' => 'string',
        'radio' => 'string',
        'checkbox' => 'json',
        'date' => 'timestamp',
        'datetime' => 'timestamp',
        'time' => 'time',
        'file' => 'json'
    ];

    protected $fieldTypes = [
        'TextField' => 'text',
        'TextBox' => 'textbox',
        'NumberField' => 'number',
        'DropdownField' => 'dropdown',
        'RadioField' => 'radio',
        'CheckBoxField' => 'checkbox',
        'DateField' => 'date',
        'DateTimeField' => 'datetime',
        'TimeField' => 'time',
        'FileField' => 'file'
    ];

    public function form()
    {
        return $this->belongsTo('App\Form');
    }

    public function target_type()
    {
    	return $this->belongsTo('App\FieldTargetType', 'reference_target_type_id');
    }

    public function target()
    {
    	return $this->belongsTo($this->target_type->model, 'reference_target_id');
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = $this->fieldTypes[$value];
    }

    public function setChoicesAttribute($value)
    {
    	$this->options['choices'] = $value;
    }

    public function getOptionsAttribute(): SchemalessAttributes
    {
        return SchemalessAttributes::createForModel($this, 'options');
    }

    public function getValidationRulesAttribute(): SchemalessAttributes
    {
        return SchemalessAttributes::createForModel($this, 'validation_rules');
    }

    public function getSettingsAttribute(): SchemalessAttributes
    {
        return SchemalessAttributes::createForModel($this, 'settings');
    }

    public function getColumnTypeAttribute()
    {
        // this allows a multi value field to store a php array (after being encoded as json)
        if(!$this->settings['single']) {
            return 'text';
        }
        
        if(
            $this->type == 'TextField' &&
            !empty($this->target_type) &&
            $this->target_type->name != config('app.form_target_types.form_field.name')
        ) {
            dump($this->target_type->name);

            return 'bigInteger';
        }


        return $this->columnTypes[$this->type];
    }

    public function getTargetAttribute()
    {
      if(empty($this->reference_target_id))
        return null;

      return $this->reference_target_type;
    }

    public function getNameAttribute()
    {
        return $this->form->name . " :: $this->title";
    }

    public function scopeFilter($query, $terms)
    {
        foreach($terms as $column=>$term) {
            $query->where($column, $term);
        }

        return $query;
    }

    public function attachFormFieldReference($formEntryQueryBuilder, $formTable, $fieldColumn, $targetId) {
        return $formEntryQueryBuilder;
    }

    public function getFormFieldReferenceValues($targetId) {
        $targetField = $this->find($targetId);
        $formTable = $targetField->form->table_name;
        $entries = new FormEntry();
        $entries->setTable($formTable);
        $entries = $entries
            ->addSelect("$formTable.$targetField->column_name as label")
            ->addSelect("$formTable.$targetField->column_name as value");

        return $entries;
    }
}

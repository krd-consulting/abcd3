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

    public $timestamps = false;

    protected $searchColumns = [
        'title'
    ];

	public $casts = [
        'options' => 'array',
        'settings' => 'array',
    ];

    protected $columnTypes = [
        'text' => 'string',
        'textbox' => 'text',
        'number' => 'decimal',
        'dropdown' => 'string',
        'radio' => 'string',
        'checkbox' => 'string',
        'date' => 'date',
        'time' => 'time',
        'file' => 'bigInteger'
    ];

    protected $fieldTypes = [
        'TextField' => 'text',
        'TextBox' => 'textbox',
        'NumberField' => 'number',
        'DropdownField' => 'dropdown',
        'RadioField' => 'radio',
        'CheckBoxField' => 'checkbox',
        'DateField' => 'date',
        'DateTimeField', 'datetime',
        'TimeField' => 'time',
        'FileField' => 'file'
    ];

    public function form()
    {
        return $this->belongsTo('App\Form');
    }

    public function target_type()
    {
    	return $this->belongsTo('App\FieldTargetType');
    }

    public function target()
    {
    	return $this->belongsTo($this->target_type->model);
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = $this->fieldTypes[$value];
    }

    public function setChoicesAttribute($value)
    {
    	$this->options['choices'] = $value;
    }

    public function setValidationRulesAttribute($value)
    {
        $this->validation_rules = $value;
    }

    public function setSettingsAttribute($value)
    {
        $this->settings = $value;
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

    public function scopeFilter($query, $terms)
    {   
        foreach($terms as $column=>$term) {
            $query->where($column, $term);
        }

        return $query;
    }
}

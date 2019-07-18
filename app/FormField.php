<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\SchemalessAttributes\SchemalessAttributes;

class FormField extends Model
{
	protected $guarded = [];

	public $casts = [
        'options' => 'array',
        'settings' => 'array',
    ];

    protected $columnTypes = [
        'TextField' => 'string',
        'TextBox' => 'text',
        'NumberField' => 'decimal',
        'DropdownField' => 'string',
        'RadioField' => 'string',
        'CheckBoxField' => 'string',
        'DateField' => 'string',
        'TimeField' => 'string',
        'MatrixField' => 'string',
        'FileField' => 'string'
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

    public function setQuestionsAttribute($value)
    {
    	$this->options['questions'] = $value;
    }

    public function setChoicesAttribute($value)
    {
    	$this->options['choices'] = $value;
    }

    public function getOptionsAttribute(): SchemalessAttributes
    {
        return SchemalessAttributes::createForModel($this, 'options');
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
}

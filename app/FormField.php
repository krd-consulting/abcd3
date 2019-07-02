<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    public function target_type()
    {
    	return $this->belongsTo('App\FormTargetType');
    }

    public function target()
    {
    	return $this->belongsTo($this->target_type->model);
    }
}

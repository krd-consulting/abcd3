<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileType extends Model
{
    public function field1() {
        return $this->hasOne('App\Field', 'id', 'field_1_id');
    }

    public function field2() {
        return $this->hasOne('App\Field', 'id', 'field_2_id');
    }

    public function field3() {
        return $this->hasOne('App\Field', 'id', 'field_3_id');
    }

    public function files()
    {
        return $this->hasMany('App\File')
        ->addSelect('field_1_value as ' . $this->field1->name )
        ->addSelect('field_2_value as ' . $this->field2->name )
        ->addSelect('field_3_value as ' . $this->field3->name );
    }
}

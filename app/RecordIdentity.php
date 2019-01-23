<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecordIdentity extends Model
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

    public function types() {
        return $this->hasMany('App\RecordTypes');
    }
}

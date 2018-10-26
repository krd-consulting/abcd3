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
        return $this->hasMany('App\File');
    }
}

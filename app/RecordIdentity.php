<?php

namespace App;

use App\Model;

class RecordIdentity extends Model
{
    protected $modelMap = [
        'Client' => 'Client',
        'Staff' => 'Record',
        'Volunteer' => 'Record',
        'Other' => 'Record'
    ];

    public function field1() {
        return $this->hasOne('App\RecordField', 'id', 'field_1_id');
    }

    public function field2() {
        return $this->hasOne('App\RecordField', 'id', 'field_2_id');
    }

    public function field3() {
        return $this->hasOne('App\RecordField', 'id', 'field_3_id');
    }

    public function types() {
        return $this->hasMany('App\RecordType', 'identity_id');
    }

    public function getModelAttribute() {
        return $this->modelMap[$this->name];
    }
}

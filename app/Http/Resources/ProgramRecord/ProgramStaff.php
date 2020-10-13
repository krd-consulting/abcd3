<?php

namespace App\Http\Resources\ProgramRecord;

use App\Http\Resources\Record;
use App\Traits\Resources\CountRelated;

class ProgramStaff extends Record
{
    use CountRelated;

    public function fields()
    {
        $fields = parent::fields();

        $fields['cases'] = [
            'name' => 'Cases',
            'value' => $this->countRelated('cases'),
            'slug' => 'cases',
            'key' => 'cases'
        ];

        $fields['groups'] = [
            'name' => 'Groups',
            'value' => $this->countRelated('groups'),
            'slug' => 'groups',
            'key' => 'groups'
        ];

        return $fields;
    }
}

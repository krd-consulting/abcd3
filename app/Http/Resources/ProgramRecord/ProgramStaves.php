<?php

namespace App\Http\Resources\ProgramRecord;

use App\Http\Resources\Records;

class ProgramStaves extends Records
{
    public $collects = 'App\Http\Resources\ProgramRecord\ProgramStaff';

    public function __construct($resource)
    {
        $resource->load('cases', 'groups');

        parent::__construct($resource);
    }

    public function fields()
    {
        $fields = parent::fields();

        return array_merge($fields,
            [
                'cases' => [
                    'name' => 'Cases',
                    'slug' => 'cases',
                    'key' => 'cases'
                ],
                'groups' => [
                    'name' => 'Groups',
                    'slug' => 'groups',
                    'key' => 'groups'
                ],
                'enrolled_at' => [
                    'name' => 'Enrolled At',
                    'key' => 'enrolled_at',
                    'slug' => 'enrolled_at'
                ],
            ]
        );
    }
}

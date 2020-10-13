<?php

namespace App\Http\Resources\ProgramRecord;

use App\Http\Resources\Records;

class ProgramClients extends Records
{

    public $collects = 'App\Http\Resources\ProgramRecord\ProgramClient';

    public function fields()
    {
        $fields = parent::fields();

        return array_merge($fields,
            [
                'latest_status' => [
                    'name' => 'Status',
                    'slug' => 'latest_status',
                    'key' => 'latest_status'
                ],
                'latest_status_notes' => [
                    'name' => 'Notes',
                    'slug' => 'latest_status_notes',
                    'key' => 'latest_status_notes'
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

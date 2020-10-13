<?php

namespace App\Http\Resources\ProgramRecord;

use App\Http\Resources\Records;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProgramVolunteers extends Records
{
    public function fields()
    {
        $fields = parent::fields();

        return array_merge($fields,
            [
                'enrolled_at' => [
                    'name' => 'Enrolled At',
                    'key' => 'enrolled_at',
                    'slug' => 'enrolled_at'
                ],
            ]
        );
    }
}

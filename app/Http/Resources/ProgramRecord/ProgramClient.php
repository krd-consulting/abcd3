<?php

namespace App\Http\Resources\ProgramRecord;

use App\Http\Resources\Record;

class ProgramClient extends Record
{

    public function fields()
    {
        $fields = parent::fields();

        $fields['latest_status'] = [
            'name' => 'Status',
            'value' => $this->pivot->latest_status->status->name,
            'slug' => 'latest_status',
            'key' => 'latest_status'
        ];

        $fields['latest_status_notes'] = [
            'name' => 'Notes',
            'value' => $this->pivot->latest_status->notes,
            'slug' => 'latest_status_notes',
            'key' => 'latest_status_notes'
        ];

        return $fields;
    }
}

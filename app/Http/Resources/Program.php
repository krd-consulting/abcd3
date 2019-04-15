<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Program extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'team' => $this->team,
            'team_id' => $this->team->id,
            'program_status' => $this->client_statuses->last(),
            'enrolled_at' => $this->when(
                !empty($this->program_records),
                $this->program_records->firstWhere(
                    'id',
                    $this->client_statuses->last()['program_client_id']
                )['enrolled_at']
            ),
            'available_record_types' => $this->available_record_types,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

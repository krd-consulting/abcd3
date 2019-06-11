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
            'default_client_status_id' => $this->default_client_status_id,
            'program_status' => $this->whenPivotLoaded('program_record', function() {
                return $this->client_statuses()->latest()->first()->load('status');
            }),
            'enrolled_at' => $this->whenPivotLoaded('program_record', function() {
                return $this->pivot->enrolled_at;
            }),
            'available_record_types' => $this->available_record_types,
            'path' => $this->path,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

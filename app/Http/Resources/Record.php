<?php

namespace App\Http\Resources;

use App\Http\Resources\RecordType;
use App\Http\Resources\Groups;
use App\Traits\Resources\CountRelated;

use Illuminate\Http\Resources\Json\JsonResource;

class Record extends JsonResource
{

    use CountRelated;

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
            'active' => $this->active,

            'display_value' => $this->fields()['full_name']['value'],
            // We're using this API resource for transforming form entries
            // about Records so this field is added adhoc:
            'name' => $this->fields()['full_name']['value'],

            'field_values' => $this->record_field_values(),
            'fields' => $this->fields(),
            'profile_fields' => $this->profile_fields(),
            // TODO: Remove n+1 query
            'type' => new RecordType($this->record_type),

            'pivot' => $this->pivot,

            'relationships' => [
                'cases_count' => $this->countRelated('cases'),
                'groups_count' => $this->countRelated('groups'),
            ],

            'links' => $this->links(),

            'permissions' => $this->permissions()
        ];
    }

    public function record_field_values()
    {
        $values = array();

        for($index = 1; $index <= 3; $index++) {
            $column = 'field' . $index;
            $recordColumn = 'field_' . $index . '_value';

            if($this->record_type->identity->$column != null) {
                $values[$this->record_type->identity->$column->slug] = $this->$recordColumn;
            }
        }

        return $values;
    }

    public function fields()
    {
        $fields = [];

        $fields['full_name']['name'] = 'Full Name';
        $fields['full_name']['slug'] = 'full_name';

        if($this->record_type->identity->name == config('app.record_identities.other.name')) {
            $fields['name']['value'] = $this->field_1_value;
            $fields['name']['name'] = 'Name';
            $fields['name']['slug'] = 'name';
            $fields['name']['key'] = 'field_1_value';

            $fields['full_name']['value'] = $this->field_1_value;
            $fields['full_name']['key'] = 'field_1_value';
        } else {
            $fields['full_name']['value'] = "$this->field_1_value $this->field_2_value";
            $fields['full_name']['key'] = 'field_1_value';

            $fields[$this->record_type->identity->field3->slug]['value'] = $this->field_3_value;
            $fields[$this->record_type->identity->field3->slug]['name'] = $this->record_type->identity->field3->name;
            $fields[$this->record_type->identity->field3->slug]['slug'] = $this->record_type->identity->field3->slug;
            $fields[$this->record_type->identity->field3->slug]['key'] = 'field_3_value';
        }

        // Dynamically include pivot data in this fields column.
        if(isset($this->pivot->enrolled_at)) {
          $fields['enrolled_at'] = [
            'name' => 'Enrolled At',
            'value' => $this->pivot->enrolled_at,
            'slug' => 'enrolled_at',
            'key' => 'enrolled_at'
          ];
        }


        return $fields;
    }

    public function profile_fields()
    {
        $fields[0] = $this->fields()['full_name'] ?? $this->fields()['name'];

        if($this->record_type->identity->name == config('app.record_identities.other.name')) {
            return $fields;
        }

        $fields[1] = $this->fields()[$this->record_type->identity->field3->slug];

        return $fields;
    }

    public function permissions()
    {
        $canWrite = auth()->user()->can('write', $this->resource);

        return [
            'can_write' => $canWrite,
            'can_edit' => $canWrite,
            'can_delete' => $canWrite,
        ];
    }

    public function links()
    {
        return [
            'to' => $this->path
        ];
    }
}

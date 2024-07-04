<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormEntry extends JsonResource
{
    private $resourceMap = [
        'App\Record' => 'App\Http\Resources\Record',
        'App\Program' => 'App\Http\Resources\FormEntry\Program',
        'App\Group' => 'App\Http\Resources\FormEntry\Group'
    ];

    private $formFields = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response = parent::toArray($request);

        $response['links'] = [
          'to' => ''
        ];
        
        $target = $this->getTarget()->toArray($request);

        $response['fields'] = $this->fields($target);

        if($this->formFields) {
            $response = $this->formatFormFieldValues($response);
        }

        return $response;
    }

    public function fields($target)
    {
        $fields = [
          'target' => [
            'value' => $target['name'],
            'slug' => 'target',
            'name' => 'Target',
            'key' => 'target'
          ],
          'team' => [
            'value' => $this->team->name,
            'slug' => 'team',
            'name' => 'Team',
            'key' => 'team_id'
          ]
        ];

        return $fields;
    }

    private function getTarget()
    {
        return $this->when($this->relationLoaded('target'), function () {
            $class = $this->resourceMap[
                get_class($this->target)
            ];

            return (new $class($this->target));
        });
    }

    private function formatFormFieldValues($item) {
        foreach($this->formFields as $field) {
            $key = $field['slug'];

            $item['form_fields'][$key] = [
                'raw_value' => $item[$key],
                'value' => $item[$key]
            ];

            // Fields that refer to to other Form fields dont generate 
            // reference values at the query level.
            // But, they still have a target type.
            if(!$field['target_type'] || !isset($item[$key.'_reference_value'])) continue;

            if(isset($item[$key.'_reference_path'])) {
                $item['form_fields'][$key]['path'] = $item[$key.'_reference_path'];
                unset($item[$key.'_reference_path']);
            }

            // replace 'value' with referenced value if there is any
            $item['form_fields'][$key]['value'] = $item[$key.'_reference_value'];
            unset($item[$key.'_reference_value']);
            $item['form_fields'][$key]['secondary_value'] = $item[$key.'_reference_secondary_value'];
            unset($item[$key.'_reference_secondary_value']);
        }

        return $item;
    }

    public function setFormFields($formFields) {
        $this->formFields = $formFields;
    }
}

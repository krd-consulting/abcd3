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

        $target = $this->getTarget();

        if(!empty($target)) {
            $response['target'] = $target;
        }

        $response['links'] = [
          'to' => ''
        ];        

        if($this->formFields) {
            $response = $this->formatFormFieldValues($response);
        }

        return $response;
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

            $item[$key] = [
                'raw_value' => $item[$key],
                'value' => $item[$key]
            ];

            // Fields that refer to to other Form fields dont generate 
            // reference values at the query level.
            // But, they still have a target type.
            if(!$field['target_type'] || !isset($field[$key.'_reference_value'])) continue;

            // replace 'value' with referenced value if there is any
            $item[$key]['value'] = $item[$key.'_reference_value'];
            unset($item[$key.'_reference_value']);
            $item[$key]['secondary_value'] = $item[$key.'_reference_secondary_value'];
            unset($item[$key.'_reference_secondary_value']);
        }

        return $item;
    }

    public function setFormFields($formFields) {
        $this->formFields = $formFields;
    }
}

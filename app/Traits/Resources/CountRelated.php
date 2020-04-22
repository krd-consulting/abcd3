<?php

namespace App\Traits\Resources;

trait CountRelated {

    private function countRelated($related)
    {
        $related = $this->whenLoaded($related);

        if(is_countable($related)) {
            $related = count($related);
        }

        return $related;
    }
}

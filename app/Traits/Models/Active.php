<?php

namespace App\Traits\Models;

trait Active {

    public function scopeActive($query, $active = true)
    {
        if(is_string($active)) {
            $active = filter_var($active, FILTER_VALIDATE_BOOLEAN);
        }

        return $query->where('active', $active);
    }

    public function getActiveAttribute($value) : bool
    {
        return $value;
    }

}

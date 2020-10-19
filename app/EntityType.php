<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntityType extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }
}

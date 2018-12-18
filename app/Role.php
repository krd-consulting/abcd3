<?php

namespace App;

use Spatie\Permission\Models\Role as Model;

class Role extends Model
{
    public function scope()
    {
        return $this->belongsTo('App\Scope');
    }

    public function assignScope($scope)
    {
        $this->scope()->associate($scope);

        return $this->load('scope');
    }

    public function availableFor($query, $user)
    {

    }
}

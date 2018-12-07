<?php

namespace App;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    public function scope() {
        return $this->belongsTo('App\Scope');
    }
}

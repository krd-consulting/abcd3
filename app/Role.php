<?php

namespace App;

use Spatie\Permission\Models\Role as Model;

class Role extends Model
{
    public function scope()
    {
        return $this->belongsTo('App\Scope');
    }

    public function assignScope($scopeId)
    {
        $this->scope()->associate($scopeId);

        return $this->load('scope');
    }

    public function giveOrRevokePermissionTo($permission, $give)
    {
        if(!isset($give))
            return $this;

        if($give == false) {
            $this->revokePermissionTo($permission);
        }else {
            $this->givePermissionTo($permission);
        }

        return $this;
    }
}

<?php

namespace App;

use App\Scope;

use Spatie\Permission\Models\Role as Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as HasAuditable;

class Role extends Model implements Auditable
{
    use HasAuditable;

    public function scope()
    {
        return $this->belongsTo('App\Scope');
    }

    public function assignScope($scope)
    {
        if(is_string($scope))
            $scope = Scope::where('name', $scope)->first()->id;

        $this->scope()->associate($scope);

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

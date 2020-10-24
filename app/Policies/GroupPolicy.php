<?php

namespace App\Policies;

use App\User;
use App\Group;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if($user->scope == 'universal' && $ability == 'read')
            return true;

        if($user->hasRole('Super User') && ( $ability == 'create' || $ability == 'write'))
            return true;
    }

    public function read(User $user, Group $group)
    {
        if(!$user->hasScopeOfAtleast('case load'))
            return false;

        if(!$user->hasGroup($group->id))
            return false;

        return true;
    }

    public function create(User $user)
    {
        if(!$user->hasPermissionTo('write groups'))
            return false;

        return true;
    }

    public function write(User $user, Group $group)
    {
        if(!$user->hasPermissionTo('write groups'))
            return false;

        if(!$user->hasScopeOfAtleast('case load'))
            return false;

        if(!$user->hasGroup($group))
            return false;

        return true;
    }
}

<?php

namespace App\Policies;

use App\User;
use App\Record;

use Illuminate\Auth\Access\HandlesAuthorization;

class RecordPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if($user->scope == 'universal' && $ability == 'read')
            return true;

        if($user->hasRole('Super User') && ( $ability == 'create' || $ability == 'write'))
            return true;
    }

    public function read(User $user, Record $record)
    {
        if(!$user->hasScopeOfAtleast('case load'))
            return false;

        if(!$user->hasRecord($record))
            return false;

        return true;
    }

    public function create(User $user)
    {
        if(!$user->hasPermissionTo('write records'))
            return false;

        return true;
    }

    public function write(User $user, Record $record)
    {
        if(!$user->hasPermissionTo('write records'))
            return false;

        if(!$user->hasScopeOfAtleast('case load'))
            return false;

        if(!$user->hasRecord($record))
            return false;

        return true;
    }
}

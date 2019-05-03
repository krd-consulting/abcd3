<?php

namespace App\Policies;

use App\User;
use App\Team;

use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if($user->scope == 'universal' && $ability == 'read')
            return true;

        if($user->hasRole('Super User') && ( $ability == 'create' || $ability == 'write'))
            return true;
    }

    public function read(User $user, Team $team)
    {
        if(!$user->hasScopeOfAtleast('team'))
            return false;

        if(!$user->hasTeam($team->id))
            return false;

        return true;
    }

    public function create(User $user)
    {
        if(!$user->can('write teams'))
            return false;

        return true;
    }

    public function write(User $user, Team $team)
    {
        if(!$user->can('write teams'))
            return false;

        if(!$user->hasScopeOfAtleast('teams'))
            return false;

        if(!$user->hasTeam($team))
            return false;

        return true;
    }
}

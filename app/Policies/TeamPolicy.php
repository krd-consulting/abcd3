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
        if(!$user->hasScopeOfAtleast(config('auth.scopes.team.value')))
            return false;

        if(!$user->hasTeam($team->id))
            return false;

        return true;
    }

    public function create(User $user)
    {
        if(!$user->can(config('auth.permissions.write-teams.name')))
            return false;

        return true;
    }

    public function write(User $user, Team $team)
    {
        if(!$user->can(config('auth.permissions.write-teams.name')))
            return false;

        if(!$user->hasScopeOfAtleast(config('auth.scopes.team.value')))
            return false;

        if($user->hasScopeOfAtleast(config('auth.scopes.universal.value')))
            return true;

        if(!$user->hasTeam($team))
             return false;

        return true;
    }
}

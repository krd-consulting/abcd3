<?php

namespace App\Policies;

use App\User;
use App\Program;

use Illuminate\Auth\Access\HandlesAuthorization;

class ProgramPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if($user->scope == 'universal' && $ability == 'read')
            return true;

        if($user->hasRole('Super User') && ( $ability == 'create' || $ability == 'write'))
            return true;
    }

    public function read(User $user, Program $program)
    {
        if(!$user->hasScopeOfAtleast('program'))
            return false;

        if(!$user->hasProgram($program->id))
            return false;

        return true;
    }

    public function create(User $user)
    {
        if(!$user->can('write programs'))
            return false;

        return true;
    }

    public function write(User $user, Program $program)
    {
        if(!$user->can('write programs'))
            return false;

        if(!$user->hasScopeOfAtleast('case load'))
            return false;

        if(!$user->hasProgram($program))
            return false;

        return true;
    }
}

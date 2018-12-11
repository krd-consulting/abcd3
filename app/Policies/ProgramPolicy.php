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
    }

    public function read(User $user, Program $program)
    {
        if(!$user->hasScopeOfAtleast('program'))
            return false;

        if(!$user->hasProgram($program->id))
            return false;

        return true;
    }

    public function write(User $user, Program $program)
    {

    }
}

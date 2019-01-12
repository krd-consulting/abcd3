<?php

namespace App\Policies;

use App\User;
use App\File;

use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if($user->scope == 'universal' && $ability == 'read')
            return true;

        if($user->hasRole('Super User') && ( $ability == 'create' || $ability == 'write'))
            return true;
    }

    public function read(User $user, File $file)
    {
        if(!$user->hasScopeOfAtleast('case load'))
            return false;

        if(!$user->hasFile($file))
            return false;

        return true;
    }

    public function create(User $user)
    {
        if(!$user->can('write files'))
            return false;

        return true;
    }

    public function write(User $user, File $file)
    {
        if(!$user->can('write files'))
            return false;

        if(!$user->hasScopeOfAtleast('case load'))
            return false;

        if(!$user->hasFile($file))
            return false;

        return true;
    }
}

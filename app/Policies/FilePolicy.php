<?php

namespace App\Policies;

use App\User;
use App\File;

use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy
{
    use HandlesAuthorization;

    public function before(User $user, 'read')
    {
        if($user->scope == 'universal')
            return true;
    }

    public function read(User $user, File $file) : bool
    {
        if(!$user->hasFile($file))
            return false;

        if(!$user->hasScopeOfAtleast('case load'))
            return false;

        return true;
    }

    public function write(User $user, File $file)
    {
        //
    }
}

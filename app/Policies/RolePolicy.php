<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function write(User $user)
    {
        if($user->can('write roles'))
            return true;

        return false;
    }
}

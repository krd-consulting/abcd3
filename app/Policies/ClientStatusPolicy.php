<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientStatusPolicy
{
    use HandlesAuthorization;

    public function write(User $user)
    {
        if($user->hasPermissionTo('write client statuses'))
            return true;

        return false;
    }
}

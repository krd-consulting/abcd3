<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        if(!$user->can('write forms'))
            return false;

        return true;
    }
}

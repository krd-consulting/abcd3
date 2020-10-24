<?php

namespace App\Policies;

use App\Form;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormPolicy
{
    use HandlesAuthorization;

    public function read(User $user, Form $form)
    {
        if(!$user->hasForm($form))
            return false;

        return true;
    }

    public function create(User $user)
    {
        if(!$user->hasPermissionTo('write forms'))
            return false;

        return true;
    }

    public function write(User $user, Form $form)
    {
        if(!$user->hasPermissionTo('write forms'))
            return false;

        if(!$user->hasForm($form))
            return false;

        return true;
    }
}

<?php

namespace App\Policies;

use App\Models\Bike;
use App\Models\User;
use Illuminate\Auth\Access\Response;


class BikePolicy
{

    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Bike $bike)
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Bike $bike)
    {
        return $user->role === 'admin';
    }
}


<?php

namespace App\Policies;

use App\Models\Bike;
use App\Models\User;
use Illuminate\Auth\Access\Response;
namespace App\Policies;


class BikePolicy
{
    /**
     * فقط کاربرانی که role آنها admin است اجازه ایجاد دوچرخه دارند.
     */
    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * فقط کاربرانی که role آنها admin است اجازه ویرایش دارند.
     */
    public function update(User $user, Bike $bike)
    {
        return $user->role === 'admin';
    }

    /**
     * فقط کاربرانی که role آنها admin است اجازه حذف دارند.
     */
    public function delete(User $user, Bike $bike)
    {
        return $user->role === 'admin';
    }
}


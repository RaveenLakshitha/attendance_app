<?php

namespace App\Repository;

use App\Models\User;

class AuthRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Summary of registerUser
     * @param mixed $userRequest
     */

    public function registerUser($userRequest){
        return User::create($userRequest);
    }
}

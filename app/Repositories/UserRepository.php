<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function deleteByEmail(string $email)
    {
        return User::where('email', $email)->delete();
    }
}

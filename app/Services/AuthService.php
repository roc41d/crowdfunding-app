<?php

namespace App\Services;

use App\Models\User;
use Exception;

class AuthService
{
    /**
     * Register a new user
     * @param array $data
     * @return User
     * @throws Exception
     */
    public function registerUser(array $data): User
    {
        try {
            return User::create($data);
        } catch (Exception $e) {
            throw new Exception('Registration Failed: ' . $e->getMessage(), 500);
        }
    }
}

<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

    /**
     * Login a user
     * @param array $data
     * @return array
     * @throws Exception
     */
    public function loginUser(array $data): array
    {
        try {
            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                $user = Auth::user();
                $token = $user->createToken('auth_token')->plainTextToken;

                return [
                    'user' => $user,
                    'token' => $token,
                ];
            } else {
                throw new Exception('Invalid Credentials', 401);
            }
        } catch (Exception $e) {
            throw new Exception('Login Failed: ' . $e->getMessage(), 500);
        }
    }
}

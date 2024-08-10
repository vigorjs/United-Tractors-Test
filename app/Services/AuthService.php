<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

interface AuthService
{
    public function register(RegisterRequest $request);
    public function login(LoginRequest $request);
    public function logout(string $token);
}

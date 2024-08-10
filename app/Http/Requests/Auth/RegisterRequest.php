<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => 'required|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'Name must be string',
            'email.string' => 'Email must be string',
            'email.required' => 'Email is required',
            'email.unique' => 'User already exists',
            'email.email' => 'Wrong email format',
            'password.required' => 'Password is required',
        ];
    }
}

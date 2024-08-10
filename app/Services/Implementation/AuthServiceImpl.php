<?php
namespace App\Services\Implementation;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthServiceImpl implements AuthService
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $tokenResult = $user->createToken("ordinary_token");
        $token = $tokenResult->plainTextToken;

        $tokenModel = $user->tokens()->where('name', 'ordinary_token')->latest()->first();
        if ($tokenModel) {
            $tokenModel->expires_at = now()->addDay();
            $tokenModel->save();
        }

        return [
            'status' => true,
            'message' => "Berhasil Register",
            'token' => $token,
            'data' => $user,
        ];
    }

    public function login(LoginRequest $request)
    {
        $user = User::where("email", $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            auth()->loginUsingId($user->id);

            $tokenResult = $request->remember_me ?
                $user->createToken("remember_token", ["remember"]) :
                $user->createToken("ordinary_token");

            $token = $tokenResult->plainTextToken;

            $tokenName = $request->remember_me ? 'remember_token' : 'ordinary_token';
            $tokenModel = $user->tokens()->where('name', $tokenName)->latest()->first();
            if ($tokenModel) {
                $expiry = $request->remember_me ? now()->addDays(30) : now()->addDay();
                $tokenModel->expires_at = $expiry;
                $tokenModel->save();
            }

            return [
                "status" => true,
                "message" => "Berhasil Login",
                "token" => $token,
                "user" => $user,
            ];
        }

        return [
            'status' => false,
            'message' => 'Password Salah',
        ];
    }

    public function logout(string $token){
        //get token di db
         $tokenInstance = PersonalAccessToken::findToken($token);

         if ($tokenInstance) {
            // get user by token
             $user = $tokenInstance->tokenable;

             // delete semua token user
             $user->tokens()->delete();

             return [
                 "status" => true,
                 "message" => 'Berhasil Logout',
             ];
         }

         return [
             "status" => false,
             "message" => 'Token tidak valid',
         ];
    }
}

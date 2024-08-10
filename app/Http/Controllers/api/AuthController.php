<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller{

    protected $authService;

    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }

    /**
     * @OA\Post(
     *     path="/register",
     *     tags={"Register"},
     *     operationId="register",
     *     summary="Register User",
     *     description="Register User and create token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil Register"),
     *             @OA\Property(property="token", type="string", example="1|abc..."),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-08-10T00:00:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-08-10T00:00:00.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function register(RegisterRequest $request)
    {
        return response()->json($this->authService->register($request));
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"Login"},
     *     operationId="login",
     *     summary="Login User",
     *     description="Login User and create token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", example="password123"),
     *             @OA\Property(property="remember_me", type="boolean", example=true)
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful Login",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil Login"),
     *             @OA\Property(property="token", type="string", example="1|abc..."),
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-08-10T00:00:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-08-10T00:00:00.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Invalid credentials")
     *         )
     *     )
     * )
     */
    public function login(LoginRequest $request)
    {
        return response()->json($this->authService->login($request));
    }

    /**
     * @OA\Get(
    *     path="/logout",
    *     tags={"Logout"},
    *     operationId="logout",
    *     summary="Logout User",
    *     description="Logout User by removing all tokens usin Bearer token used for authentication (Login dulu di swagger)",
    *     @OA\Response(
    *         response=200,
    *         description="Successful Logout",
    *         @OA\JsonContent(
    *             @OA\Property(property="status", type="boolean", example=true),
    *             @OA\Property(property="message", type="string", example="Berhasil Logout"),
    *             @OA\Property(
    *                 property="user",
    *                 type="object",
    *                 @OA\Property(property="id", type="integer", example=1),
    *                 @OA\Property(property="name", type="string", example="John Doe"),
    *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
    *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-08-10T00:00:00.000000Z"),
    *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-08-10T00:00:00.000000Z")
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=401,
    *         description="Unauthorized",
    *         @OA\JsonContent(
    *             @OA\Property(property="status", type="boolean", example=false),
    *             @OA\Property(property="message", type="string", example="Invalid token")
    *         )
    *     )
    * )
    */
    public function logout(Request $request){
        return response()->json($this->authService->logout($request->bearerToken()));
    }
}

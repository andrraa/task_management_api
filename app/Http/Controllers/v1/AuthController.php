<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\LoginRequest;
use App\Http\Requests\v1\RegisterRequest;
use App\Http\Resources\v1\UserResource;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return ErrorResponse::unauthorized();
        }

        $user = Auth::user();

        $token = $user->createToken('api-token')->plainTextToken;

        return SuccessResponse::ok(
            message: 'Login success',
            data: [
                'user'  => new UserResource($user),
                'token' => $token
            ]
        );
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => bcrypt($validated['password'])
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return SuccessResponse::created(
            message: 'User registered successfully', 
            data: [
                'user'  => new UserResource($user),
                'token' => $token
            ]
        );
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()
            ->currentAccessToken()
            ->delete();
        
        return SuccessResponse::noContent();
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RefreshTokenRequest;
use App\Services\UserService;
use Illuminate\Http\Response;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    public function login(LoginRequest $request, UserService $service, JWTAuth $auth)
    {
        $credentials = $request->all(['email', 'password']);
        $token = $auth->attempt($credentials);

        if ($token === false) {
            return response()->json([
                'message' => 'Authorization failed'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = $service->first(['email' => $request->input('email')]);

        return response()->json([
            'token' => $token,
            'ttl' => config('jwt.ttl'),
            'refresh_ttl' => config('jwt.refresh_ttl'),
            'user' => $user
        ]);
    }

    public function refreshToken(RefreshTokenRequest $request)
    {
        return response('', Response::HTTP_NO_CONTENT);
    }

    public function username()
    {
        return 'email';
    }
}

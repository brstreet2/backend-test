<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenBlacklistedException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;

class AuthService implements AuthServiceInterface
{
    public function login($request)
    {
        $credentials = $request->only('email', 'password');

        $token = auth('api')->attempt($credentials);
        if (!$token) {
            return response()->json([
                'error'        => false,
                'message'      => 'UNAUTHORIZED',
                'data'         => null,
                'status'       => 401
            ], 401);
        }

        try {
            $user    = Auth::user();
            $userDb  = User::find($user->id);
            $userDb->access_token = $token;
            $userDb->save();
            return response()->json([
                'error'        => false,
                'message'      => 'OK',
                'data'         => $userDb,
                'status'       => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error'        => true,
                'message'      => $e->getMessage(),
                'data'         => null,
                'status'       => 500
            ], 500);
        }
    }

    public function logout($request)
    {
        if (!$request->bearerToken()) {
            return response()->json([
                'error'        => false,
                'message'      => 'INVALID TOKEN',
                'data'         => null,
                'status'       => 401
            ], 401);
        }

        try {
            Auth::logout();
            return response()->json([
                'error'        => false,
                'message'      => 'OK',
                'data'         => null,
                'status'       => 200
            ], 200);
        } catch (\Exception $e) {
            if ($e instanceof TokenBlacklistedException) {
                return response()->json([
                    'error'        => false,
                    'message'      => $e->getMessage(),
                    'data'         => null,
                    'status'       => 400
                ], 400);
            } elseif ($e instanceof TokenExpiredException) {
                return response()->json([
                    'error'        => false,
                    'message'      => $e->getMessage(),
                    'data'         => null,
                    'status'       => 400
                ], 400);
            } elseif ($e instanceof TokenInvalidException) {
                return response()->json([
                    'error'        => false,
                    'message'      => $e->getMessage(),
                    'data'         => null,
                    'status'       => 400
                ], 400);
            }
        }
    }

    public function refresh($request)
    {
        if (!$request->bearerToken()) {
            return response()->json([
                'error'        => false,
                'message'      => 'INVALID TOKEN',
                'data'         => null,
                'status'       => 401
            ], 401);
        }
        try {
            $token = Auth::refresh();
            return response()->json([
                'error'        => false,
                'message'      => 'OK',
                'data'         => [
                    'token'         => $token,
                ],
                'status'       => 200
            ], 200);
        } catch (\Exception $e) {
            if ($e instanceof TokenBlacklistedException) {
                return response()->json([
                    'error'        => "true",
                    'message'      => $e->getMessage(),
                    'data'         => null,
                    'status'       => 400
                ], 400);
            } elseif ($e instanceof TokenExpiredException) {
                try {
                    $token   = Auth::refresh();
                    $payload = Auth::payload();
                    return response()->json([
                        'error'        => true,
                        'message'      => 'OK',
                        'data'         => [
                            'token'         => Auth::refresh(),

                        ],
                        'status'       => 400
                    ], 400);
                } catch (TokenExpiredException $e) {
                    return response()->json([
                        'error'        => true,
                        'message'      => $e->getMessage(),
                        'data'         => null,
                        'status'       => 400
                    ], 400);
                }
            } elseif ($e instanceof TokenInvalidException) {
                return response()->json([
                    'error'        => true,
                    'message'      => $e->getMessage(),
                    'data'         => null,
                    'status'       => 400
                ], 400);
            }
        }
    }
}

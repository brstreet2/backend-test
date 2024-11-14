<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthServiceInterface;
use Illuminate\Http\Request;

class ApiAuthController extends Controller
{
    public function login(LoginRequest $request, AuthServiceInterface $authServiceInterface)
    {
        return $authServiceInterface->login($request);
    }

    public function logout(Request $request, AuthServiceInterface $authServiceInterface)
    {
        return $authServiceInterface->logout($request);
    }

    public function refresh(Request $request, AuthServiceInterface $authServiceInterface)
    {
        return $authServiceInterface->refresh($request);
    }
}

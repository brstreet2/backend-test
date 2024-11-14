<?php

namespace App\Services\Auth;

interface AuthServiceInterface
{
    public function login($request);

    public function logout($request);

    public function refresh($request);
}

<?php

namespace App\Services;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\AdminResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    /**
     * Authenticate user.
     *
     * @param LoginRequest $request
     * 
     * @return mixed
     */
    public function login(LoginRequest $request): mixed
    {
        $credentials = $request->safe()->toArray();

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();

            return new AdminResource(Auth::user());
        }

        return response()->json([], 401);
    }

    /**
     * Logout.
     *
     * @param Request $request
     * 
     * @return Response
     */
    public function logout(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        return response()->noContent();
    }
}

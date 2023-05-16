<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\LoginService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    public function __construct(protected LoginService $loginService)
    {
        
    }

    /**
     * Authenticate user.
     *
     * @param LoginRequest $request
     * 
     * @return mixed
     */
    public function login(LoginRequest $request): mixed
    {
        return $this->loginService->login($request);
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
        return $this->loginService->logout($request);
    }
}

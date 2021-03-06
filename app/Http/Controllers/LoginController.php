<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        if (Auth::check()) {
            return response()->json([
                'error' => 'You are already logged in',
            ], 401);
        }
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json(['status' => 204]);
        }

        return response()->json(['error' => 'Invalid credentials']);
    }
}

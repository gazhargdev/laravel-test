<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Get user input and pass to variable
        $credentials = $request->only('email', 'password');

        // Attempt to generate token and respond on failure
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'User unauthorised'
            ], 401);
        }

        // Authorise user and respond with success
        $user = Auth::user();

        return response()->json([
            'status' => 'success',
            'message' => 'User authorised',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function register(Request $request)
    {
        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Login user and respond with success
        $token = Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User created',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout()
    {
        // Logout user
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);

    }
}

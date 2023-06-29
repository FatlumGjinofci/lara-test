<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        $validatedData['password'] = Hash::make($request->password);

        $user = User::create($validatedData);
        $accessToken = $user->createToken('authToken');

        return response()->json([
            'status' => true,
            'message' => 'Registered successfully',
            'user' => $user,
            'accessToken' => $accessToken->plainTextToken,
        ], 201);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials'
            ], 422);
        }

        $accessToken = auth()->user()->createToken('authToken');

        return response()->json([
            'status' => true,
            'message' => 'Login successfully',
            'user' => auth()->user(),
            'accessToken' => $accessToken->plainTextToken,
        ]);
    }
}

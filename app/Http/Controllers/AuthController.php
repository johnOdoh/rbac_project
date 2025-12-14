<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 400,
                'data' => $validator->errors(),
                'message' => 'Validation failed'
            ], 400);
        };
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->accessToken;

            return response()->json([
                'success' => true,
                'code' => 200,
                'data' => [
                    'user' => new UserResource($user),
                    'token' => $token
                ],
                'message' => 'Login Successful'
            ]);
        }
        return response()->json([
            'success' => false,
            'code' => 400,
            'data' => [],
            'message' => 'Invalid credentials'
        ], 400);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 400,
                'data' => $validator->errors(),
                'message' => 'Validation failed'
            ], 400);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken('MyApp')->accessToken;
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => [
                'user' => new UserResource($user),
                'token' => $token
            ],
            'message' => 'User created successfully'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => [],
            'message' => 'Logout successful'
        ]);
    }
}

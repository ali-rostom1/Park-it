<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try{
            $user = User::create($request->validated());
            $user->assignRole('user');
            return response()->json([
                'message' => 'User registered successfully'
            ],201);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Failed to register User',
                'error' => $e->getMessage(),
            ],500);
        }
    }
    public function login(LoginRequest $request)
    {
        try{
            $validated = $request->validated();
            $user = User::where('email',$validated['email'])->first();
            if(!$user || !Hash::check($validated['password'],$user->password)){
                return response()->json([
                    'message' => 'Invalid credentials'
                ],401);
            }
            $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
            return response()->json([
                'access_token' => $token
            ],201);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Inputs dont match the rules'
            ]);
        }
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logged out'
        ]);
    }
}

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


// MODEL IS HERE MODEL IS HERE MODEL IS HERE MODEL IS HERE
// MODEL IS HERE MODEL IS HERE MODEL IS HERE MODEL IS HERE
// MODEL IS HERE MODEL IS HERE MODEL IS HERE MODEL IS HERE
use App\Models\User;
// MODEL IS HERE MODEL IS HERE MODEL IS HERE MODEL IS HERE
// MODEL IS HERE MODEL IS HERE MODEL IS HERE MODEL IS HERE
// MODEL IS HERE MODEL IS HERE MODEL IS HERE MODEL IS HERE


class ApiController extends Controller
{
    //
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'User'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully'
        ]);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])){
            $user = Auth::user();
            $token = $user->createToken('myToken')->accessToken;

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'token' => $token
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials'
            ]);
        }
    }
    //Get
    public function logout(){
        $user = Auth::user();

        auth()->user()->token()->revoke();

        return response()->json([
            'status' => true,
            'message' => 'User logged out'
        ]);
    }
    public function profile(){
        $user = Auth::user();

        return response()->json([
            'status' => true,
            'message' => 'User profile',
            'data' => $user
        ]);
    }

    
}
<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => [
                'required',
                Password::min(8) // Minimum 8 characters
                    ->letters() // Must contain at least one letter
                    ->mixedCase() // Must contain at least one uppercase and one lowercase letter
                    ->numbers() // Must contain at least one number
                    ->symbols() // Must contain at least one symbol
                    ->max(16)
            ],
        ]);

        dd($validator);
        $validator->validate();
    }
}

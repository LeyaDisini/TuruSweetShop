<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',                    // Huruf kapital
                'regex:/[!@#$%^&*(),.?":{}|<>]/'    // Special char
            ],
        ]);

        $user = User::create([
            'id' => Str::uuid(),
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // 'money' => 0, udh dibuat default di settingan migration
        ]);

        return response()->json([
            'user' => $user->makeVisible('password'), //makeVisible buat munculin hashed pass di JSON (debugging aja)
            'message' => 'User registered successfully!',
        ], 201,[], JSON_PRETTY_PRINT);
    }

    


    
}

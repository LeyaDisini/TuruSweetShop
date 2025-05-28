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
        ],[
                'password.min' =>'Panjang password minimal 8 karakter.',
                'password.regex' => 'Password harus mengandung minimal 1 huruf kapital dan 1 karakter spesial.',
                'email.unique' =>'Email sudah terdaftar dalam database, silahkan login',
                'email.max' =>'Panjang email maksimal 255 karakter.',
                'name.max' => 'Panjang nama maksimal 255 karakter.'
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

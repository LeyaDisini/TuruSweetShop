<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request){
        $validated = $request->validate([
            'email' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'remember_me' => 'nullable|in:true,false,1,0' // biar bisa test form-data di postman
        ]);

        $user = User::where('email', $validated['email'])->first();

        if(!$user || !Hash::check($validated['password'], $user->password)){
            return response()->json([
                'message'=> 'Invalid User'
            ], 404);
        }

        $remember = filter_var($validated['remember_me'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $user->remember_me = $remember;
        $user->save();

        if ($user->is_admin) {
            // $token = $user->createToken('admin-token')->plainTextToken;
            $token = $user->createToken('admin-token', ['*'], $remember ? now()->addMonths(1) : now()->addMinutes(60))->plainTextToken; //['*'] artinya bisa di create, edit, delete
            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_admin' => $user->is_admin,
                    'remember_me' => $user->remember_me
                ],
                // 'redirect' => ... (isi FE disini)
            ]);
        }
        
        else {
            // $token = $user->createToken('user-token')->plainTextToken;
            $token = $user->createToken('user-token', ['*'], $remember ? now()->addMonths(1) : now()->addMinutes(60))->plainTextToken; //['*'] artinya bisa di create, edit, delete
            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_admin' => $user->is_admin,
                    'remember_me' => $user->remember_me
                ],
                // 'redirect' => ... (isi FE disini)
            ]);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        $user->remember_me = false;
        $user->save();

        return response()->json(['message' => 'Logout successful'], 200);
    }
}

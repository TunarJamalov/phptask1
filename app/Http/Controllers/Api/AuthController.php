<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email və ya şifrə yalnışdır!'
            ], 401);
        }

        $token = $user->createToken('Secop_API_Token')->plainTextToken;

        return response()->json([
            'message' => 'Uğurla giriş etdiniz!',
            'user' => $user->name,
            'token' => $token
        ]);
    }
}

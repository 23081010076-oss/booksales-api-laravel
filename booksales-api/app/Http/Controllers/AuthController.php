<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * LOGIN
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Ambil user dulu
        $user = User::where('email', $request->email)->first();

        if (!$user || !Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Tambahkan claim 'role' ke token JWT
        $token = auth('api')->claims(['role' => $user->role])->attempt($credentials);

        return $this->respondWithToken($token);
    }

    /**
     * REGISTER
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'role' => 'required|in:admin,user' // hanya boleh admin atau user
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user'    => $user
        ], 201);
    }

    /**
     * LOGOUT
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * GET PROFILE LOGIN
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * FORMAT TOKEN RESPONSE
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60,
            'user'         => auth('api')->user() // untuk langsung tahu role user juga
        ]);
    }
}

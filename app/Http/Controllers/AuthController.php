<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
Use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        Auth::login($user);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->accessToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
            ], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user) {
            $user->token()->revoke();
            $user->tokens->each(function ($token, $key) {
                $token->delete();
            });
        }

        Auth::logout(); // Clear session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }

}

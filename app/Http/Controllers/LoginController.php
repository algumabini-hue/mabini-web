<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function authenticate(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // Find user by email
        $user = User::where('email', $validated['email'])->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        // Check if password matches (password is hashed)
        if (! Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        // Log the user in to establish a Laravel session
        Auth::login($user);

        // Authentication successful
        return response()->json([
            'success' => true,
            'message' => 'Login successful!',
            'user' => $user,
        ], 200);
    }
}

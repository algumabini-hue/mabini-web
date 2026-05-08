<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    public function signup()
    {
        return view('admin.signup');
    }

    public function store(SignupRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // Create user with hashed password
        $user = User::create([
            'name' => $validated['name'] ?? $validated['email'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Log the user in to establish a Laravel session
        Auth::login($user);

        return response()->json([
            'success' => true,
            'message' => 'Account created successfully!',
            'user' => $user,
        ], 201);
    }
}

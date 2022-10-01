<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    /**
     * Login with email and password.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $attempted = Auth::attempt(
            $request->only(['email', 'password']),
            $request->boolean('remember', false)
        );

        if (!$attempted) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = User::where('email', $request->input('email'))->first();

        return response()->json([
            'token' => $user->createToken('API TOKEN')->plainTextToken,
        ]);
    }
}

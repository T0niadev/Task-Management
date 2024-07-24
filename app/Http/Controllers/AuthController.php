<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{


    public function register(Request $request)
    {
        try {
            // Validate the request
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|confirmed',
            ]);

            // Create the user
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            // Generate the token and return response
            return response()->json([
                'token' => $user->createToken('Taskapp')->plainTextToken,
                'message' => 'User registered successfully.'
            ], 201);

        } catch (ValidationException $e) {
            // Handle validation exceptions
            return response()->json([
                'message' => 'Validation error.',
                'errors' => $e->errors()
            ], 422);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'A user with this email already exists.',
                'errors' => $e->getMessage()
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred.',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            try {
                // Validate the request data
                $request->validate([
                    'email' => 'required|string|email',
                    'password' => 'required|string',
                ]);

                // Attempt to authenticate the user
                if (!Auth::attempt($request->only('email', 'password'))) {
                    // Throw an exception if authentication fails
                    throw ValidationException::withMessages([
                        'email' => ['The provided credentials are incorrect.'],
                    ]);
                }

                // Retrieve the authenticated user
                $user = Auth::user();

                // Return a successful response with a token
                return response()->json([
                    'token' => $user->createToken('Taskapp')->plainTextToken
                ]);
            } catch (ValidationException $e) {
                // Catch validation exceptions and return a custom error response
                return response()->json([
                    'message' => 'Validation error',
                    'errors' => $e->errors()
                ], 422);
            } catch (\Exception $e) {
                // Catch any other exceptions and return a generic error response
                return response()->json([
                    'message' => 'An error occurred',
                    'error' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'message' => 'Please login using POST.',
        ], 405);
    }

}

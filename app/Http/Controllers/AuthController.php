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

            // This validates the request
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|confirmed',
            ]);


            // This creates the user
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);


            // This generates the token and return response
            return response()->json([
                'token' => $user->createToken('Taskapp')->plainTextToken,
                'message' => 'User registered successfully.'
            ], 201);



        } catch (ValidationException $e) {

            // This handles validation exceptions
            return response()->json([
                'message' => 'Validation error.',
                'errors' => $e->errors()
            ], 422);


        } catch (QueryException $e) {

           // This handles query exception
            return response()->json([
                'message' => 'A user with this email already exists.',
                'errors' => $e->getMessage()
            ], 400);


        } catch (\Exception $e) {

            // This catches any other exceptions and return a generic error response
            return response()->json([
                'message' => 'An unexpected error occurred.',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {

        //This action happens when the login route is accessed via POST
        if ($request->isMethod('post')) {
            try {

                // This validates the request data
                $request->validate([
                    'email' => 'required|string|email',
                    'password' => 'required|string',
                ]);


                //This attempt to authenticate the user
                if (!Auth::attempt($request->only('email', 'password'))) {
                    // Throw an exception if authentication fails
                    throw ValidationException::withMessages([
                        'email' => ['The provided credentials are incorrect.'],
                    ]);
                }


                // This retrieves the authenticated user
                $user = Auth::user();


                // This returns a successful response with a token
                return response()->json([
                    'token' => $user->createToken('Taskapp')->plainTextToken
                ]);


            } catch (ValidationException $e) {

                // This catches validation exceptions and return a custom error response with 422 error code
                return response()->json([
                    'message' => 'Validation error',
                    'errors' => $e->errors()
                ], 422);


            } catch (\Exception $e) {

                // This catches any other exceptions and return a generic error response
                return response()->json([
                    'message' => 'An error occurred',
                    'error' => $e->getMessage()
                ], 500);
            }
        }


        //This action happens when the login route is accessed via any other method
        return response()->json(['message' => 'Not authenticated.  Please sign in'], 401);
    }

    public function logout(Request $request)
    {
        
        if (Auth::guard('sanctum')->check()) {

            // This revokes all tokens of the authenticated user
            Auth::user()->tokens()->delete(); 
            return response()->json(['message' => 'Logged out successfully.'], 200);
        }

        // This returns 401 if user is not authenticated
        return response()->json(['message' => 'Not authenticated.'], 401);
    }

}

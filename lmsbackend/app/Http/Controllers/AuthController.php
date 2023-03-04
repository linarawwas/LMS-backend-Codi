<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $userRole = auth()->user()->role; // Get the role of the current user

        if ($userRole == 1) {
            $fields = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|unique:users,email',
                'password' => 'required|string|confirmed',
                'firstname' => 'required|max:255',
                'lastname' => 'required|max:255',
                'role' => 'required|in:1,2,3',
            ]);
        } elseif ($userRole == 2) {
            $fields = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|unique:users,email',
                'password' => 'required|string|confirmed',
                'firstname' => 'required|max:255',
                'lastname' => 'required|max:255',
                'role' => 'required|in:3',
            ]);
        } else {
            // If the user's role is not 1 or 2, they can't register a new user
            return response(['message' => 'You are not authorized to perform this action.'], 403);
        }

        $user = User::create([
            'username' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'firstname' => $fields['firstname'],
            'lastname' => $fields['lastname'],
            'role' => $fields['role'],
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
        ];
        return response($response, 201);
    }



    public function login(Request $request)
    {

        $fields = $request->validate([

            'email' => 'required|string',
            'password' => 'required|string',

        ]);

        // Check Email
        $user = User::where('email', $fields['email'])->first();

        // Check Password
        if (!$user || !Hash::check($fields['password'], $user->password)) {

            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;


        $response = [

            'user' => $user,
            'token' => $token,

        ];
        return response($response, 201);

    }


    public function logout(Request $request)
    {

        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged out',
        ];
    }
}
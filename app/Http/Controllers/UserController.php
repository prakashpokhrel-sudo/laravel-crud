<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function register(Request $request)
    {
        //validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // create user data + save
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile= $request->mobile;
        $user->password = bcrypt($request->password);
        $user->save();

        // send response
        return response()->json([
            "status" => 1,
            "message" => "User registered successfully"
        ], 200);
    }
     public function login(Request $request)
    {
         // validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // verify user + token
        if (!$token = auth()->attempt(["email" => $request->email, "password" => $request->password])) {
            return response()->json([
                "status" => 0,
                "message" => "Invalid credentials"
            ]);
        }

        // send response
        return response()->json([
            "status" => 1,
            "message" => "Logged in successfully",
            "access_token" => $token
        ]);
        
    }
    public function profile()
    {
        $user_data = auth()->user();
        return response()->json([
            "status" => 1,
            "message" => "User profile data",
            "data" => $user_data
        ]);
    }



}

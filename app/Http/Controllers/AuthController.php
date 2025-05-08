<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);


        if ($validator->fails()) {
           $errorMessage = $validator->errors()->first();
           $response = [
                "status" => false,
                "message" => $errorMessage,
           ];

           return response()->json([$response, 401]);

        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            "status" => true,
            "message" => "user registerd successfully."
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            $response = [
                 "status" => false,
                 "message" => $errorMessage,
            ];
 
            return response()->json([$response, 401]);
        }

        $user = User::where("email", $request->email)->first();

        if(!empty($user)){
            if(Hash::check($request->password, $user->password)){
                $tokenInfo = $user->CreateToken("caoirocoders-ednalan");
                $token = $tokenInfo->plainTextToken;

                return response()->json([
                    "status" => true,
                    "message" => "Login successful.",
                    "token" => $token,

                ]);
            }
        } else {
            return response()->json([
                "status" => false,
                "message" => "Invalid credencials."
            ]);
        }
    }

    public function profile(Request $request)
    {
        $userData = $request->user();

        return response()->json([
            "status" => true,
            "message" => "User Information",
            "data" => $userData
        ]);
    }

    // Logout (GET, Auth Token)
    public function logout()
    {
        // To get all tokens of logged in user and delete that
        request()->user()->tokens()->delete();
 
        return response()->json([
            "status" => true,
            "message" => "User logged out"
        ]);
    }

    // Refresh Token (GET, Auth Token)
    public function refreshToken()
    {
        $tokenInfo = request()->user()->createToken("newtokencairocdoers-ednalan");
 
        $newToken = $tokenInfo->plainTextToken; // Token value
 
        return response()->json([
            "status" => true,
            "message" => "Refresh token",
            "acccess_token" => $newToken
        ]);
    }
}

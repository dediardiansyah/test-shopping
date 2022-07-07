<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'username' => 'required',
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'encrypted_password' => 'required',
                    'phone' => 'required',
                    'address' => 'required',
                    'city' => 'required',
                    'country' => 'required',
                    'postcode' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'message' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->encrypted_password),
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
                'postcode' => $request->postcode
            ]);

            return response()->json([
                'user' => [
                    'email' => $user->email,
                    'token' => $user->createToken("API TOKEN")->plainTextToken,
                    'username' => $user->username,
                ]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function signin(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'message' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'user' => [
                    'email' => $user->email,
                    'token' => $user->createToken("API TOKEN")->plainTextToken,
                    'username' => $user->username,
                ]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }
}

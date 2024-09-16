<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
          //  $token = $user->createToken('authtoken')->plainTextToken;
            return response()->json([
                'status' => true,
               // 'token' => $token,
                'message' => 'Login successful',
               
                'data' => $user
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Wrong username or password'
            ]);
        }
    }

    public function register(Request $request)
    {
        $user=User::where('email',$request->email)->first();
        
        if(is_null($user))
        {
           $user=new User();
           $user->id = $request->get('id');
           $user->name = $request->get('name');
           $user->email = $request->get('email');
           $user->password = bcrypt($request->password);
           $user->save();

           $token = $user->createToken('authtoken')->plainTextToken;
           return response()->json(
               [
                   "status" =>true,
                   "message" => "User created successfully",
                   "access_token" => $user
               ]);
        }
        else {
            return response()->json([
                "status" => false,
                "message" => "User already exists"
            ], 409);  
        }
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user=User::create($request->all());
        return response()->json($user, 201);
    }
    public function login(Request $request){
        $credentials=$request->only('email','password');
        if(!auth()->attempt($credentials)){
            return response()->json(['message'=>'Invalid credentials'],422);
        }
        $user=Auth::user();
        $authToken=$user->createToken('auth_token')->plainTextToken;
        return response()->json(['access_token'=>$authToken],422);
    }
}
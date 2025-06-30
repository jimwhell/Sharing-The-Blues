<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


    public function register(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed'            
        ]);

        $user = new User();

        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        return response()->json('User registered', 201);
    }


    
    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string|min:8'
        ]);


        $matchedUser = User::where('email', $request->email)->firstOrFail();
       
        if (!Hash::check($request->password, $matchedUser->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

         $token = JWTAuth::fromUser($matchedUser);
        
        return $this->respondwithToken($token);
    }

    public function logout() {

    }

    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh());
    }
    
    protected function respondwithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ]);
    }
    
    
}

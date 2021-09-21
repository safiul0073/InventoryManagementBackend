<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    
    public function login (Request $request) {


                    // dd($request->all());
                    $credentials = $request->only('email', 'password');

                    if ($token = $this->guard()->attempt($credentials)) {
                        return $this->respondWithToken($token);
                    }
            
                    return response()->json(['error' => 'Unauthorized'], 401);


    }

    // log out section 
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me()
    {
        return response()->json($this->guard()->user());
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }


    public function guard()
    {
        return Auth::guard();
    }
    // user Registration section.... 
    public function register (Request $request) {


                    User::create($request->all());
                    return response()->json(['message' => "success"]);
             
        
    }



}

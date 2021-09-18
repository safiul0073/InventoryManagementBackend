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




                    $credentials = ['email' => $request->email, 'password' => $request->password];

                    if ( Auth::attempt( $credentials )) {
                        $token = $request->user()->createToken('acc-token')->plainTextToken;
                        return response()->json(['token' => $token]);
                    }else {
                        return response()->json(['error' => "Credentials not match"], 401);
                    }


    }

    // log out section 
    public function logout () {
        if (Auth::check()) {
            auth()->user()->tokens()->delete();
            return response()->json(null, 200);
         }
    }


    // user Registration section.... 
    public function register (Request $request) {


                    User::create($request->all());
                    return response()->json(['message' => "success"]);
             
        
    }



}

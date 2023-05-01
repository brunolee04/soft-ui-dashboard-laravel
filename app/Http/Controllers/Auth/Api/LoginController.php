<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller{
    
    
    public function login(Request $request){
        
        //TO-DO: to valid request
        $credentials  = $request->only('email','password');

        if(!auth()->attempt($credentials)) abort(401,'Invalid credentials');

        $token = auth()->user()->createToken('auth_token');

        var_dump($token);

        return response()->json([
            'data'=>[
                'token' => $token->plainTextToken,
                'auth_type' => 'Bearer ',
                'user' => auth()->user()
            ]
        ]);
    }
}

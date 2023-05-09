<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller{
    
    
    public function login(Request $request){
        
        //TO-DO: to valid request
        $credentials  = $request->only('email','password');
       
        if(!auth('customer')->attempt($credentials)) abort(401,'Invalid credentials');

        $token = auth('customer')->user()->createToken('auth_token');

        $user_id = auth('customer')->user()->customer_id;
        $user_name = auth('customer')->user()->customer_firstname;
        $user_mail = auth('customer')->user()->email;

   

        return response()->json([
            'data'=>[
                'token' => $token->plainTextToken,
                'auth_type' => 'Bearer ',
                'user' => [
                    'id' => $user_id,
                    'name' => $user_name,
                    'mail' => $user_mail
                ]
            ]
        ]);
    }
}

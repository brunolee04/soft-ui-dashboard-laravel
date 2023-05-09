<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller{
    
    
    public function login(Request $request){
        
        //TO-DO: to valid request
        $credentials  = $request->only('email','password');

        if($response = !auth('customer')->attempt($credentials)){
            var_dump($response);
        } //abort(401,'Invalid credentials');

        $token = auth()->user()->createToken('auth_token');

        $user_id = auth()->user()->id;
        $user_name = auth()->user()->name;
        $user_mail = auth()->user()->email;

   

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

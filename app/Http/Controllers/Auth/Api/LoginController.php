<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller{
    
    
    public function login(Request $request){
        
        
        $credentials  = $request->only('email','password');
       
        if(!auth('customer')->attempt($credentials)) abort(401,'Invalid credentials');

        $token = auth('customer')->user()->createToken('auth_token');

        $user_id = auth('customer')->user()->customer_id;
        $user_name = auth('customer')->user()->customer_firstname;
        $user_lastname = auth('customer')->user()->customer_lastname;
        $user_mail = auth('customer')->user()->email;
        $user_profile_id = auth('customer')->user()->customer_user_id;
        $user_avatar = auth('customer')->user()->customer_image_url;
        $user_bio = auth('customer')->user()->customer_bio;

   

        return response()->json([
            'data'=>[
                'token' => $token->plainTextToken,
                'auth_type' => 'Bearer ',
                'user' => [
                    'id' => $user_id,
                    'name' => $user_name,
                    'lastname' => $user_lastname,
                    'mail' => $user_mail,
                    'profile_id' => $user_profile_id,
                    'avatar' => $user_avatar,
                    'bio' => $user_bio,
                ]
            ]
        ]);
    }
}

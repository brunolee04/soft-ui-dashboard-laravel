<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class RegisterController extends Controller{
    
    
    public function register(Request $request,User $user){
        
        //TO-DO: to valid request
        $userData  = $request->only('name','email','password');
      
        if(!$user = $user->create($userData))
            abort(500,'Error to create new user');

        return response()->json([
            'data'=>[
                'user' => $user
            ]
        ]);
    }

}

<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class RegisterController extends Controller{
    
    // public function register(Request $request,Customer $customer){
        
    //     //TO-DO: to valid request
    //     $customerData  = $request->only('customer_firstname','customer_lastname','customer_date_birth','customer_mail','customer_pass','customer_status');
    //     $customerData['customer_date_birth']  = Carbon::createFromFormat('d/m/Y',$customerData['customer_date_birth'])->format('Y-m-d');

    //     $customerData['customer_pass'] = bcrypt($customerData['customer_pass']);
      
    //     if(!$customer = $customer->create($customerData))
    //         abort(500,'Error to create new customer');

    //     return response()->json([
    //         'data'=>[
    //             'customer' => $customer
    //         ]
    //     ]);
    // }

    public function register(Request $request,User $user){
        
        //TO-DO: to valid request
        $userData  = $request->only('name','email','password');
        $userData['password'] = bcrypt($userData['password']);
      
        if(!$user = $user->create($userData))
            abort(500,'Error to create new user');

        return response()->json([
            'data'=>[
                'user' => $user
            ]
        ]);
    }

}

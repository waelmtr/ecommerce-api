<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{
    public function register(Request $request){
      $fields = $request->validate([
          'name'=>'required|string' ,
          'email'=>'required|email|unique:users,email',
          'password'=>'required|string|confirmed',
          'phone'=>'required|string' ,
          'facebook_url'=>'required|string'
      ]);
      $user = User::create([
          'name'=>$fields['name'] ,
          'email'=>$fields['email'],
          'password'=>bcrypt($fields['password']),
          'phone'=>$fields['phone'] ,
          'facebook_url'=>$fields['facebook_url']
      ]);

      $token = $user->createToken('myToken')->plainTextToken;

      $user_id = $user->id;

      return response()->json("Account created successfuly and your token is: $token 
      and your Id is $user_id , keep them please
      ", 201);
    }
     public function login(Request $request){
        $fields = $request->validate([
            'email'=>'required|email',
            'password'=>'required|string'
        ]);
         
        $user = User::where('email' , $fields['email'])->first();
           
        if(!$user || !Hash::check($fields['password'], $user->password)){
         return response('error sure from your email and password');
        }
      $token = $user->createToken('myToken')->plainTextToken;
      
        return response("login success and your new token is : $token",201);
    }
      
     public function logout(){
         auth()->user()->tokens()->delete();
         return response("logout success");
     }

    public function profile(){
     $id = Auth::id();
     echo User::find($id)->products;
    return User::find($id);
    }
}

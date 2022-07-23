<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $validate=$request->validate([
            'name'=>'required|string',
            'email'=>'required|string|unique:Users,email',
            'password'=> 'required|string|confirmed'

        ]);
        $user=User::create([
            'name'=>$validate['name'],
            'email'=>$validate['email'],
            'password'=>bcrypt($validate['password']),
        ]);
        $token=$user->createToken('myAppToken')->plainTextToken;
        $response=[
            'user'=>$user,
            'token'=>$token
        ];
        if($response){
            $st=1;
            $message='Data received successfully';
         }else{
            $st=0;
            $message='Data not found';
         }
         $array=[
            'status'=>$st,
            'message'=>$message,
            'data'=>$response

         ];
        return response()->json($array);
         
    }
    public function login(Request $request){
        $validate=$request->validate([
            
            'email'=>'required',
            'password'=> 'required'

        ]);
        // check email
        // $user=User::where('email',$request->email)->first();
        $user=User::where('email',$validate['email'])->first();
        // check password
        if(!$user || !Hash::check( $validate['password'],$user->password)){
            return response()->json([
                'message'=>'Bad Cred',
            ], 401);
        }
        
        $token = $user->createToken('myAppToken')->plainTextToken;
        $response=[
            'user'=>$user,
            'token'=>$token
        ];
        if($response){
            $st=1;
            $message='Data received successfully';
         }else{
            $st=0;
            $message='Data not found';
         }
         $array=[
            'status'=>$st,
            'message'=>$message,
            'data'=>$response

         ];
         return response()->json($array);
         
    }
    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return [
            'message'=>'logged out '
        ];
    }
    
}

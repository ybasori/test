<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\User;


class AuthController extends Controller
{
    //
    public function register(){
        return view("pages/register");
    }
    public function registering(Request $request){
        $rules=[
            'phone' => 'digits_between:0,15'
            ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            $errors=$validator->getMessageBag()->toArray();

            return response()->json($errors, 400);
        }
        else{
            if($request->input('email')!=""){
                if (!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {
                    return response()->json([
                        'email'=>[
                            'Invalid E-mail'
                        ]
                    ], 400);
                }
            }
            try{
                $user= new User;
                $user->name=$request->input('name');
                $user->email=$request->input('email');
                $user->password=bcrypt($request->input('password'));
                $user->gender=$request->input('gender');
                $user->phone=$request->input('phone');
                $user->nationality=$request->input('nationality');
                $user->save();
                return response()->json([
                    'success'=>true
                ], 200);
                
            }
            catch(\Illuminate\Database\QueryException $e){
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    return response("<div class='alert alert-danger'>Duplicate Entry</div>", 403 );
                }
                else if($errorCode == 1048 ){
                    return response("<div class='alert alert-danger'>Some fields are required</div>", 422);
                }
                else if($errorCode == 1064 ){
                    return response("<div class='alert alert-danger'>Some fields are required</div>", 422);
                }
            }
        }

    }
}

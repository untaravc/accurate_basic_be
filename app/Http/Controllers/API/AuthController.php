<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request ){
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required',
        ]);

        $this->response['status'] = false;
        if($validator->fails()){
            $this->response['text'] = $validator->errors()->first();
            $this->response['result'] = $validator->errors();
            return $this->response;
        }

        $user = User::whereEmail($request->email)->first();

        if(!$user){
            $this->response['text'] = 'Email atau password salah.';
            return $this->response;
        }

        if(!Hash::check($request->password, $user->password)){
            $this->response['text'] = 'Email atau password salah.';
            return $this->response;
        }

        $token = $user->createToken('panel');

        $this->response['status'] = true;
        $this->response['result'] = $user;
        $this->response['token'] = $token->plainTextToken;
        return $this->response;
    }

    public function auth(Request $request){
        $this->response['result'] = $request->user();
        return $this->response;
    }

    public function logout(Request $request){
        $token = $request->user()->currentAccessToken();
        if($token){
            $token->delete();
        }

        return $this->response;
    }
}

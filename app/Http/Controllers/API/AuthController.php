<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Repositories\UsersRepository;
use App\Http\Requests\RegisterRequest;


class AuthController extends Controller
{
    public $Users;

    public function __construct(UsersRepository $users_Repository)
    {
        $this->Users = $users_Repository;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $users=$this->Users->create($request->all());
            $token = $users->createToken('auth_token')->plainTextToken;

            return
            response()
            ->json(['status'=>'success','message'=>"hi", 'access_token' => $token, 'token_type' => 'Bearer']);

        } catch (\Throwable $error) {
            return response()
            ->json(['status'=>'failed','message'=>$error->getMessage()]);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            if (!Auth::attempt($request))
            {
                return
                response()
                ->json([ 'status'=>'failed','message' => 'Unauthorized'], 401);
            }

            $User=$this->Users->find($request->email);
            $token = $User->createToken('auth_token')->plainTextToken;

            return
            response()
            ->json(['message' => 'Hi '.$User->name.', welcome to home','access_token' => $token, 'token_type' => 'Bearer', ]);

        } catch (\Throwable $error) {
            return response()
            ->json(['status'=>'failed','message'=>$error->getMessage()]);
        }
    }

    // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'status'=>'success','message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }
}

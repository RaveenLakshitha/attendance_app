<?php

namespace App\Services;

use App\Http\Requests\AuthRegister;
use App\Repository\AuthRepository;
use Auth;
use Hash;

class AuthService
{
    protected $authRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * Summary of authRegister
     * @param mixed $request
     * @return $response
     */
    public function authRegister($request)
    {
        $request = $request->all();
        $request['password'] = Hash::make(($request['password']));

        # Register user
        return $this->authRepository->registerUser($request);
    }
    /**
     * Summary of userLogin
     * @param mixed $request
     * @return $response
     */
    public function userLogin($request)
    {
        if(!(Auth::attempt(['email'=> $request['email'], 'password' => $request['password']]))){
            return false;
        }

        $authUser = Auth::user();
        $token = $authUser->createToken('token')->accessToken;

        $user = [
            'email' => $authUser->email,
            'token' => $token,
        ];
        return $user;
    }

    /**
     * Summary of userProfile
     */
    
     public function userProfile(){
        return Auth::user();
    }

    public function userLogout(){
        $authUser = Auth::user();
        if($authUser){
            $authUser->token()->revoke();
            return true;
        }
        return false;
    }
}

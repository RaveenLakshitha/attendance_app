<?php

namespace App\Http\Controllers\Auth;

use App\Helper\ApiResponse;
use App\Http\Controllers\APIController;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLogin;
use App\Http\Requests\AuthRegister;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\Request;
use Log;

class AuthController extends APIController
{
    protected $authService;
    
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    /**
     * Function: register
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    
     public function register(AuthRegister $request)
     {
         try{
            $response =  $this->authService->authRegister($request);

            if($response){
                return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $response, statusCode:self::SUCCESS);
            }
            return ApiResponse::success(status: self::ERROR_STATUS, message: self::FAILED_MESSAGE, statusCode:self::ERROR);

         }catch(Exception $e){
            Log::error('Exception occurred while registering user' . $e->getMessage());
            return ApiResponse::success(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode:self::ERROR);
         }
     }
     
    /**
     * Summary of login
     * @param \App\Http\Requests\AuthLogin $request
     * @return illuminate\Http\JsonResponse
     */
    public function login(AuthLogin $request){
        try{
            $loginResponse = $this->authService->userLogin($request);

            if(! $loginResponse){
                return ApiResponse::error(status:self::ERROR_STATUS, message:self::INVALID_CREDENTIALS, statusCode:SELF::ERROR);
            }
            return ApiResponse::success(status:self::SUCCESS_STATUS, message:self::SUCCESS_MESSAGE, data: $loginResponse, statusCode:SELF::SUCCESS);
        }catch(Exception $e){
            Log::error('Exception occurred while login user' . $e->getMessage());
            dump($e->getMessage());
            return ApiResponse::success(status:self::ERROR_STATUS, message:self::EXCEPTION_MESSAGE, statusCode:SELF::ERROR);
        }
    }

    /**
     * Summary of userProfile
     */

    public function userProfile(){
        try{
            $authUser = $this->authService->userProfile();

            if(!$authUser){
                return ApiResponse::error(status:self::ERROR_STATUS, message:self::USER_NOT_FOUND, statusCode:SELF::ERROR);
            }
            return ApiResponse::success(status:self::SUCCESS_STATUS, message:self::SUCCESS_MESSAGE, data: $authUser, statusCode:SELF::SUCCESS);
        }catch(Exception $e){
            Log::error('Exception occurred while fetching user' . $e->getMessage());
            return ApiResponse::success(status:self::ERROR_STATUS, message:self::EXCEPTION_MESSAGE, statusCode:SELF::ERROR);
        }
    }

    /**
     * Summary of logout
     * @return illuminate\Http\JsonResponse
     */

    public function logout(){
        try{
            $authUser =  $this->authService->userLogout();
            
            if(!$authUser){
                return ApiResponse::error(status:self::ERROR_STATUS, message:self::USER_NOT_FOUND, statusCode:SELF::ERROR);
            }
            return ApiResponse::success(status:self::SUCCESS_STATUS, message:self::USER_LOGGED_OUT, data: $authUser, statusCode:SELF::SUCCESS);
        }catch(Exception $e){
            Log::error('Exception occurred while logout the user' . $e->getMessage());
            return ApiResponse::success(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode:self::ERROR);
        }
    }
}

<?php

namespace App\Services;

use App\Http\Requests\AuthRegister;
use App\Models\User;
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
        $existingUser = User::where('device_id', $request->device_id)->first();

        if ($existingUser) {
            return response()->json(['message' => 'This device is already in use. Registration not allowed.'], 403);
        }

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
        // Find user by email
        $authUser = User::where('email', $request->email)->first();

        if (!$authUser) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Check if the provided device ID is already assigned to another user
        $existingUserWithDevice = User::where('device_id', $request->device_id)->where('id', '!=', $authUser->id)->first();
        if ($existingUserWithDevice) {
            return response()->json(['message' => 'This device is already registered to another user.'], 403);
        }

        // Verify credentials
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['message' => 'Invalid email or password.'], 403);
        }

        // If the user already has a registered device and it's different, deny login
        if ($authUser->device_id && $authUser->device_id !== $request->device_id) {
            return response()->json(['message' => 'Login denied. This account is linked to another device.'], 403);
        }

        // If no device is linked, assign this device ID
        if (!$authUser->device_id) {
            $authUser->update(['device_id' => $request->device_id]);
        }

        // Generate access token
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

    /**
     * Function: getAuthUser
     */
    public function getAuthUser() {
        return Auth::user();
    }
}

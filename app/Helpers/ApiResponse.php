<?php

namespace App\Helpers;

class ApiResponse
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Summary of success
     * @param mixed $status
     * @param mixed $message
     * @param mixed $data
     * @param mixed $statusCode
     * @return mixed|\Illuminate\Http\JsonResponse
     */

    public static function success($status = 'success', $message = null, $data = [], $statusCode = 200){
        return response()->json(
            [
                'status' => $status,
                'message' => $message,
                'data' => $data,
            ], $statusCode
        );
    }

    /**
     * Summary of error
     * @param mixed $status
     * @param mixed $message
     * @param mixed $data
     * @param mixed $statusCode
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    
     public static function error($status = 'error', $message = null, $statusCode = 500){
        return response()->json(
            [
                'status' => $status,
                'message' => $message,
            ], $statusCode
        );
    }
}

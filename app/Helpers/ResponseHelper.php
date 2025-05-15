<?php


namespace App\Helpers;

class ResponseHelper
{
    public static function success($message = 'Success', $data = [], $status = 200)
    {
        return response()->json([
            'status_code' => 1, 
            'status' => true, 
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public static function error($message = 'Error', $sdata = null, $status = 400)
    {
        return response()->json([
            'status_code' => 0,
            'status' => false,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}

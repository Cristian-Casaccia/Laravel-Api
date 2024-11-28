<?php

namespace App\Helper;

class HelperResponse
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Display success Json Response.
     * @param string $status
     * @param string $message
     * @param array $data
     * @param integer $statusCode
     * @return response
     */
    public static function success($status = 'success',$message = null, $data = [], $statusCode = 200) {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
        /**
     * Display error Json Response.
     * @param string $status
     * @param string $message
     * @param integer $statusCode
     * @return response
     */
    public static function error($status = 'error',$message = null, $statusCode = 400) {
        return response()->json([
            'status' => $status,
            'message' => $message,
        ], $statusCode);
    }
}

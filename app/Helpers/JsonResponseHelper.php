<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Response;

class JsonResponseHelper {

    public static function dataResponse($message, $data = false, $error = false, $statusCode = 200, $errorDetails = []) {
        $response = [];
        $response['message'] = $message;

        if($error) {
            $response['status'] = 'fail';
            $response['error'] = $error;
            $response['error_detail'] = $errorDetails;
        } else {
            $response['status'] = 'success';
        }

        if($data) {
            $response = $response + $data;
        }

        return Response::json($response, $statusCode);
    }

    public static function successResponse($message, $data = false, $statusCode = 200) {
        return JsonResponseHelper::dataResponse($message, $data, false, $statusCode);
    }

    public static function errorResponse($message, $error = true, $statusCode = 500, $errorDetails = []) {
        return JsonResponseHelper::dataResponse($message, false, $error, $statusCode, $errorDetails);
    }

}

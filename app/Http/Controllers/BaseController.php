<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    public function sendError($error, $errorMessages,$code=400): JsonResponse
    {
        $response = [
            'error' => true,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response,$code);
    }
    public function sendResponse($result, $message,$code=200): JsonResponse
    {
        $response = [
            'error'   => 'ok',
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }
}

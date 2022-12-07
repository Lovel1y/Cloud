<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Service;

class BaseController extends Controller
{
    public $service;

    public function __construct(Service $service){
        $this->service = $service;
    }
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleResponse($result, $message)

    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);

    }
}

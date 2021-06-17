<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Success response method.
     *
     * @param mixed $data
     * @param array $params
     * @return JsonResponse
     */
    public function sendResponse($data = NULL, $params = [])
    {
        $response = [
            'success' => true
        ];

        if(isset($data)){
            $response['data'] = $data;
        }

        if(!empty($params)){
            foreach($params as $name => $value) {
                $response[$name] = $value;
            }
        }

        return response()->json($response, 200);
    }

    /**
     * Return error response.
     *
     * @param mixed $error
     * @param int $code
     * @return JsonResponse
     */
    public function sendError($error = NULL, $code = 422)
    {
        $response = [
            'error' => true,
        ];

        if(isset($error)){
            $response['data'] = $error;
        }

        return response()->json($response, $code);
    }
}

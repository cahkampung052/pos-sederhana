<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function successResponse($response, $data, $messages = '')
    {
        return $response->setStatusCode(200)->setJSON([
            'status' => true,
            'messages' => $messages,
            'data' => $data
        ]);
    }

    public static function unAuthResponse($response, $data)
    {
        return $response->setStatusCode(403)->setJSON([
            'status' => false,
            'error' => $data
        ]);
    }

    public static function unSuccessResponse($response, $data)
    {
        return $response->setStatusCode(500)->setJSON([
            'status' => false,
            'error' => $data
        ]);
    }
}

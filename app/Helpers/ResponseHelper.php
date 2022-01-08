<?php

namespace App\Helpers;

use App\Models\UserModel;

class ResponseHelper
{
    public static function successResponse($response, $data)
    {
        return $response->setStatusCode(200)->setJSON([
            'status' => true,
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

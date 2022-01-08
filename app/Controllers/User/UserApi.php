<?php

namespace App\Controllers\User;

use App\Helpers\ResponseHelper;
use App\Helpers\UserHelper;
use CodeIgniter\RESTful\ResourceController;

class UserApi extends ResourceController
{
    public function login()
    {
        $params = $this->request->getPost();
        $email = $params['email'] ?? '';
        $password = $params['password'] ?? '';

        $login = UserHelper::login($email, $password);

        if($login['status']) {
            return ResponseHelper::successResponse($this->response, $login['data']);
        }

        return ResponseHelper::unSuccessResponse($this->response, $login['error']);
    }
}

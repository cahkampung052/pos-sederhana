<?php

namespace App\Controllers\User;

use App\Helpers\UserHelper;
use App\Helpers\ResponseHelper;
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

    public function get(){
        $params = $this->request->getGet();

        $list = UserHelper::get([], $params['length'], $params['start']);     
        return $this->response->setStatusCode(200)->setJSON([
            'draw' => $params['draw'],
            'recordsTotal' => $list['totalItems'],
            'recordsFiltered' => $list['totalItems'],
            'data' => $list['data']
        ]);
    }

    public function find($kategoriId){
        $kategori = UserHelper::find($kategoriId);

        if(!$kategori['status']) {
            return ResponseHelper::unSuccessResponse($this->response, $kategori['error']);
        }

        return ResponseHelper::successResponse($this->response, $kategori['data']);
    }

    public function save()
    {
        $params = $this->request->getPost();
        if(isset($params['id']) && $params['id'] > 0){
            $save = UserHelper::update($params);
            $message = 'Kamu telah mengubah user ini';
        } else {
            $save = UserHelper::input($params);
            $message = 'Kamu telah menambah user baru';
        }

        if(!$save['status']) {
            return ResponseHelper::unSuccessResponse($this->response, $save['error']);
        }

        return ResponseHelper::successResponse($this->response, $save['data'], $message);
    }

    public function drop()
    {
        $kategoriId = $this->request->getPost();
        $delete = UserHelper::delete($kategoriId['id']);

        if(!$delete['status']) {
            return ResponseHelper::unSuccessResponse($this->response, $delete['error']);
        }

        return ResponseHelper::successResponse($this->response, $delete['data'], 'Data user telah kamu hapus');
    }
}

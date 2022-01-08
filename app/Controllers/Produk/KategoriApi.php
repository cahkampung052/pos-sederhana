<?php

namespace App\Controllers\Produk;

use App\Helpers\ResponseHelper;
use App\Helpers\KategoriHelper;
use CodeIgniter\RESTful\ResourceController;

class KategoriApi extends ResourceController
{
    public function get(){
        $params = $this->request->getGet();

        $list = KategoriHelper::get([], $params['length'], $params['start']);     
        return $this->response->setStatusCode(200)->setJSON([
            'draw' => $params['draw'],
            'recordsTotal' => $list['totalItems'],
            'recordsFiltered' => $list['totalItems'],
            'data' => $list['data']
        ]);
    }

    public function find($kategoriId){
        $kategori = KategoriHelper::find($kategoriId);

        if(!$kategori['status']) {
            return ResponseHelper::unSuccessResponse($this->response, $kategori['error']);
        }

        return ResponseHelper::successResponse($this->response, $kategori['data']);
    }

    public function save()
    {
        $params = $this->request->getPost();
        if(isset($params['id']) && $params['id'] > 0){
            $save = KategoriHelper::update($params);
        } else {
            $save = KategoriHelper::input($params);
        }

        if(!$save['status']) {
            return ResponseHelper::unSuccessResponse($this->response, $save['error']);
        }

        return ResponseHelper::successResponse($this->response, $save['data']);
    }

    public function drop()
    {
        $kategoriId = $this->request->getPost();
        $delete = KategoriHelper::delete($kategoriId['id']);

        if(!$delete['status']) {
            return ResponseHelper::unSuccessResponse($this->response, $delete['error']);
        }

        return ResponseHelper::successResponse($this->response, $delete['data'], 'Data kategori produk telah kamu hapus');
    }
}

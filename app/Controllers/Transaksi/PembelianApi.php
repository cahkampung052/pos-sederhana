<?php

namespace App\Controllers\Transaksi;

use App\Helpers\ResponseHelper;
use App\Helpers\Pembelian;
use CodeIgniter\RESTful\ResourceController;

class PembelianApi extends ResourceController
{
    public function get(){
        $params = $this->request->getGet();

        $list = Pembelian::get([], $params['length'], $params['start']);     
        return $this->response->setStatusCode(200)->setJSON([
            'draw' => $params['draw'],
            'recordsTotal' => $list['totalItems'],
            'recordsFiltered' => $list['totalItems'],
            'data' => $list['data']
        ]);
    }

    public function find($supplierId){
        $supplier = Pembelian::find($supplierId);

        if(!$supplier['status']) {
            return ResponseHelper::unSuccessResponse($this->response, $supplier['error']);
        }

        return ResponseHelper::successResponse($this->response, $supplier['data']);
    }

    public function save()
    {
        $params = $this->request->getPost();
        if(isset($params['id']) && $params['id'] > 0){
            $save = Pembelian::update($params);
            $messages = 'Kamu telah mengubah data Supplier';
        } else {
            $save = Pembelian::input($params);
            $messages = 'Kamu telah menambah data Supplier';
        }

        if(!$save['status']) {
            return ResponseHelper::unSuccessResponse($this->response, $save['error']);
        }

        return ResponseHelper::successResponse($this->response, $save['data'], $messages);
    }

    public function drop()
    {
        $supplierId = $this->request->getPost();
        $delete = Pembelian::delete($supplierId['id']);

        if(!$delete['status']) {
            return ResponseHelper::unSuccessResponse($this->response, $delete['error']);
        }

        return ResponseHelper::successResponse($this->response, $delete['data'], 'Data Supplier telah kamu hapus');
    }
}

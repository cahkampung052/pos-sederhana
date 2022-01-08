<?php

namespace App\Controllers\Produk;

use App\Helpers\ResponseHelper;
use App\Helpers\ProdukHelper;
use CodeIgniter\RESTful\ResourceController;

class ProdukApi extends ResourceController
{
    public function get(){
        $params = $this->request->getGet();

        $list = ProdukHelper::get([], $params['length'], $params['start']);     
        return $this->response->setStatusCode(200)->setJSON([
            'draw' => $params['draw'],
            'recordsTotal' => $list['totalItems'],
            'recordsFiltered' => $list['totalItems'],
            'data' => $list['data']
        ]);
    }

    public function find($produkId){
        $produk = ProdukHelper::find($produkId);

        if(!$produk['status']) {
            return ResponseHelper::unSuccessResponse($this->response, $produk['error']);
        }

        return ResponseHelper::successResponse($this->response, $produk['data']);
    }

    public function save()
    {
        $data = $this->request->getPost();

        $params['id'] = $data['id'] ?? '';
        $params['nama'] = $data['nama'] ?? '';
        $params['m_produk_kategori_id'] = $data['kategori'] ?? '';
        $params['deskripsi'] = $data['deskripsi'] ?? '';
        $params['harga_beli'] = $data['harga_beli'] ?? '';
        $params['harga_jual'] = $data['harga_jual'] ?? '';

        if(isset($params['id']) && $params['id'] > 0){
            $save = ProdukHelper::update($params);
            $message = 'Produk telah kamu ubah';
        } else {
            $save = ProdukHelper::input($params);
            $message = 'Produk telah kamu tambahkan';
        }

        if(!$save['status']) {
            return ResponseHelper::unSuccessResponse($this->response, $save['error']);
        }

        return ResponseHelper::successResponse($this->response, $save['data'], $message);
    }

    public function drop()
    {
        $produkId = $this->request->getPost();
        $delete = ProdukHelper::delete($produkId['id']);

        if(!$delete['status']) {
            return ResponseHelper::unSuccessResponse($this->response, $delete['error']);
        }

        return ResponseHelper::successResponse($this->response, $delete['data'], 'Data produk telah kamu hapus');
    }
}

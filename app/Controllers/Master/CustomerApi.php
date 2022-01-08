<?php

namespace App\Controllers\Master;

use App\Helpers\ResponseHelper;
use App\Helpers\CustomerHelper;
use CodeIgniter\RESTful\ResourceController;

class CustomerApi extends ResourceController
{
    public function get(){
        $params = $this->request->getGet();

        $list = CustomerHelper::get([], $params['length'], $params['start']);     
        return $this->response->setStatusCode(200)->setJSON([
            'draw' => $params['draw'],
            'recordsTotal' => $list['totalItems'],
            'recordsFiltered' => $list['totalItems'],
            'data' => $list['data']
        ]);
    }

    public function find($customerId){
        $customer = CustomerHelper::find($customerId);

        if(!$customer['status']) {
            return ResponseHelper::unSuccessResponse($this->response, $customer['error']);
        }

        return ResponseHelper::successResponse($this->response, $customer['data']);
    }

    public function save()
    {
        $params = $this->request->getPost();
        if(isset($params['id']) && $params['id'] > 0){
            $save = CustomerHelper::update($params);
            $messages = 'Kamu telah mengubah data customer';
        } else {
            $save = CustomerHelper::input($params);
            $messages = 'Kamu telah menambah data customer';
        }

        if(!$save['status']) {
            return ResponseHelper::unSuccessResponse($this->response, $save['error']);
        }

        return ResponseHelper::successResponse($this->response, $save['data'], $messages);
    }

    public function drop()
    {
        $customerId = $this->request->getPost();
        $delete = CustomerHelper::delete($customerId['id']);

        if(!$delete['status']) {
            return ResponseHelper::unSuccessResponse($this->response, $delete['error']);
        }

        return ResponseHelper::successResponse($this->response, $delete['data'], 'Data customer telah kamu hapus');
    }
}

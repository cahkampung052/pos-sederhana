<?php

namespace App\Helpers;

use App\Models\CustomerModel;

class CustomerHelper
{
    public static function validateUnique($nama, $nohp, $id = 0) {
        $db      = \Config\Database::connect();
        
        if($id > 0) {
            $query = $db->query('SELECT id from m_customer where (nama = "'.$nama.'" or no_hp = "'.$nohp.'") and id != "'.$id.'"');
        } else {
            $query = $db->query('SELECT id from m_customer where (nama = "'.$nama.'" or no_hp = "'.$nohp.'")');
        }

        $isExist = $query->getRowArray();
        if(isset($isExist['id'])){
            return false;
        }

        return true;
    }

    public static function input($data) {

        $validation =  \Config\Services::validation();
        $validation->setRules([
            'nama' => 'required|alpha_numeric_space|min_length[3]|max_length[50]',
            'no_hp' => 'required|alpha_numeric_space|min_length[3]|max_length[12]',
            'alamat' => 'required|max_length[255]',
        ]);

        $isDataValid = $validation->run($data);
        if(!$isDataValid){
            return [
                'status' => false,
                'error' => array_values($validation->getErrors())
            ];
        }

        if(!self::validateUnique($data['nama'], $data['no_hp'])) {
            return [
                'status' => false,
                'error' => ['Nama Customer / no HP telah digunakan']
            ];
        }

        $customerModel = new CustomerModel();
        $data = $customerModel->insert($data);

        return [
            'status' => true,
            'data' => $customerModel->find($data)
        ];
    }

    public static function update($data) {

        $validation =  \Config\Services::validation();
        $validation->setRules([
            'nama' => 'required|alpha_numeric_space|min_length[3]|max_length[50]',
            'no_hp' => 'required|alpha_numeric_space|min_length[3]|max_length[12]',
            'alamat' => 'required|max_length[255]',
        ]);

        $isDataValid = $validation->run($data);
        if(!$isDataValid){
            return [
                'status' => false,
                'error' => array_values($validation->getErrors())
            ];
        }

        if(!self::validateUnique($data['nama'], $data['no_hp'], $data['id'])) {
            return [
                'status' => false,
                'error' => ['Nama Customer / no HP telah digunakan']
            ];
        }

        $customerModel = new CustomerModel();
        $data = $customerModel->update($data['id'], $data);

        return [
            'status' => true,
            'data' => $customerModel->find($data)
        ];
    }

    public static function delete($kategoriId) {

        $customerModel = new CustomerModel();
        $data = $customerModel->delete($kategoriId);

        if(!$data) {
            return [
                'status' => false,
                'error' => ['Terjadi kesalahan pada sistem, Tim kami akan segera memperbaikinya !']
            ];
        }

        return [
            'status' => true,
            'data' => []
        ];
    }

    public static function get($params, $limit = null, $offset = null) {
        $db      = \Config\Database::connect();

        $builder = $db->table('m_customer');
        $builder->select('*');

        if(!empty($limit)){
            $builder->limit($limit);
        }

        if(!empty($offset)){
            $builder->offset($offset);
        }

        if(isset($params['nama'])){
            $builder->like('nama', $params['nama'], 'both'); 
        }

        $return = $builder->get()->getResultArray();
        $total = $builder->countAll();

        return [
            'data' => $return,
            'totalItems' => $total
        ];
    } 

    public static function find($customerId) {
        $customer = new CustomerModel();
        $customerData = $customer->where('id', $customerId)->first();

        if(!isset($customerData['id'])){
            return [
                'status' => false,
                'error' => ['Customer tidak ditemukan']
            ];
        }

        return [
            'status' => true,
            'data' => $customerData
        ];
    }
}
<?php

namespace App\Helpers;

use App\Models\SupplierModel;

class SupplierHelper
{
    public static function validateUnique($nama, $noTelepon, $id = 0) {
        $db      = \Config\Database::connect();
        
        if($id > 0) {
            $query = $db->query('SELECT id from m_supplier where (nama = "'.$nama.'" or no_telepon = "'.$noTelepon.'") and id != "'.$id.'"');
        } else {
            $query = $db->query('SELECT id from m_supplier where (nama = "'.$nama.'" or no_telepon = "'.$noTelepon.'")');
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
            'no_telepon' => 'required|alpha_numeric_space|min_length[3]|max_length[12]',
            'alamat' => 'required|max_length[255]',
        ]);

        $isDataValid = $validation->run($data);
        if(!$isDataValid){
            return [
                'status' => false,
                'error' => array_values($validation->getErrors())
            ];
        }

        if(!self::validateUnique($data['nama'], $data['no_telepon'])) {
            return [
                'status' => false,
                'error' => ['Nama dan no telepon supplier telah digunakan']
            ];
        }

        $supplierModel = new SupplierModel();
        $data = $supplierModel->insert($data);

        return [
            'status' => true,
            'data' => $supplierModel->find($data)
        ];
    }

    public static function update($data) {

        $validation =  \Config\Services::validation();
        $validation->setRules([
            'nama' => 'required|alpha_numeric_space|min_length[3]|max_length[50]',
            'no_telepon' => 'required|alpha_numeric_space|min_length[3]|max_length[12]',
            'alamat' => 'required|max_length[255]',
        ]);

        $isDataValid = $validation->run($data);
        if(!$isDataValid){
            return [
                'status' => false,
                'error' => array_values($validation->getErrors())
            ];
        }

        if(!self::validateUnique($data['nama'], $data['no_telepon'], $data['id'])) {
            return [
                'status' => false,
                'error' => ['Nama dan no telepon telah digunakan']
            ];
        }

        $supplierModel = new SupplierModel();
        $data = $supplierModel->update($data['id'], $data);

        return [
            'status' => true,
            'data' => $supplierModel->find($data)
        ];
    }

    public static function delete($kategoriId) {

        $supplierModel = new SupplierModel();
        $data = $supplierModel->delete($kategoriId);

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

        $builder = $db->table('m_supplier');
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

    public static function find($supplierId) {
        $supplier = new SupplierModel();
        $supplierData = $supplier->where('id', $supplierId)->first();

        if(!isset($supplierData['id'])){
            return [
                'status' => false,
                'error' => ['supplier tidak ditemukan']
            ];
        }

        return [
            'status' => true,
            'data' => $supplierData
        ];
    }
}
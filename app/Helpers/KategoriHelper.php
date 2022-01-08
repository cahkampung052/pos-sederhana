<?php

namespace App\Helpers;

use App\Models\KategoriModel;

class KategoriHelper
{
    public static function validateUnique($nama, $id = 0) {
        $db      = \Config\Database::connect();
        
        if($id > 0) {
            $query = $db->query('SELECT id from m_produk_kategori where nama = "'.$nama.'" and id != "'.$id.'"');
        } else {
            $query = $db->query('SELECT id from m_produk_kategori where nama = "'.$nama.'"');
        }

        $isExist = $query->getRowArray();
        if(isset($isExist['id'])){
            return false;
        }

        return true;
    }

    public static function input($data) {

        $validation =  \Config\Services::validation();
        $validation->setRules(['nama' => 'required|alpha_numeric_space|min_length[3]|max_length[50]']);

        $isDataValid = $validation->run($data);
        if(!$isDataValid){
            return [
                'status' => false,
                'error' => array_values($validation->getErrors())
            ];
        }

        if(!self::validateUnique($data['nama'])) {
            return [
                'status' => false,
                'error' => ['Nama kategori telah digunakan']
            ];
        }

        $kategoriModel = new KategoriModel();
        $data = $kategoriModel->insert($data);

        return [
            'status' => true,
            'data' => $kategoriModel->find($data)
        ];
    }

    public static function update($data) {

        $validation =  \Config\Services::validation();
        $validation->setRules(['nama' => 'required|alpha_numeric_space|min_length[3]|max_length[50]']);

        $isDataValid = $validation->run($data);
        if(!$isDataValid){
            return [
                'status' => false,
                'error' => array_values($validation->getErrors())
            ];
        }

        if(!self::validateUnique($data['nama'], $data['id'])) {
            return [
                'status' => false,
                'error' => ['Nama kategori telah digunakan']
            ];
        }

        $kategoriModel = new KategoriModel();
        $data = $kategoriModel->update($data['id'], $data);

        return [
            'status' => true,
            'data' => $kategoriModel->find($data)
        ];
    }

    public static function delete($kategoriId) {

        $kategoriModel = new KategoriModel();
        $data = $kategoriModel->delete($kategoriId);

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

        $builder = $db->table('m_produk_kategori');
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

    public static function find($kategoriId) {
        $kategori = new KategoriModel();
        $kategoriData = $kategori->where('id', $kategoriId)->first();

        if(!isset($kategoriData['id'])){
            return [
                'status' => false,
                'error' => ['Kategori tidak ditemukan']
            ];
        }

        return [
            'status' => true,
            'data' => $kategoriData
        ];
    }
}
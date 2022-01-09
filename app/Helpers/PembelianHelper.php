<?php

namespace App\Helpers;

use App\Models\PembelianModel;

class PembelianHelper
{
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

        $PembelianModel = new PembelianModel();
        $data = $PembelianModel->insert($data);

        return [
            'status' => true,
            'data' => $PembelianModel->find($data)
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

        $PembelianModel = new PembelianModel();
        $data = $PembelianModel->update($data['id'], $data);

        return [
            'status' => true,
            'data' => $PembelianModel->find($data)
        ];
    }

    public static function delete($kategoriId) {

        $PembelianModel = new PembelianModel();
        $data = $PembelianModel->delete($kategoriId);

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

        $builder = $db->table('t_pembelian');
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
        $kategori = new PembelianModel();
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
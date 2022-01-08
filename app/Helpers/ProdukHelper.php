<?php

namespace App\Helpers;

use App\Models\ProdukModel;

class ProdukHelper
{
    public static function validateUnique($nama, $id = 0) {
        $db      = \Config\Database::connect();
        
        if($id > 0) {
            $query = $db->query('SELECT id from m_produk where nama = "'.$nama.'" and id != "'.$id.'"');
        } else {
            $query = $db->query('SELECT id from m_produk where nama = "'.$nama.'"');
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
            'm_produk_kategori_id' => 'required',
            'deskripsi' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
        ]);

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
                'error' => ['Nama Produk telah digunakan']
            ];
        }

        $produkModel = new ProdukModel();
        $data = $produkModel->insert($data);

        return [
            'status' => true,
            'data' => $produkModel->find($data)
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
                'error' => ['Nama Produk telah digunakan']
            ];
        }

        $produkModel = new ProdukModel();
        $data = $produkModel->update($data['id'], $data);

        return [
            'status' => true,
            'data' => $produkModel->find($data)
        ];
    }

    public static function delete($produkId) {

        $produkModel = new ProdukModel();
        $data = $produkModel->delete($produkId);

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

        $builder = $db->table('m_produk');
        $builder->select('m_produk.*')
                ->join('m_produk_kategori', 'm_produk_kategori.id = m_produk.m_produk_kategori_id');

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

    public static function find($produkId) {
        $kategori = new ProdukModel();
        $kategoriData = $kategori->where('id', $produkId)->first();

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
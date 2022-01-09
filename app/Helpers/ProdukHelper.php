<?php

namespace App\Helpers;

use App\Models\ProdukModel;
use CodeIgniter\Files\File;

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

    public static function uploadFile($fileTmp) {
        $file = $fileTmp['foto'];
        
        // if($file->getSize('mb') > 3) {
        //     return [
        //         'status' => false,
        //         'error' => ['Ukuran file gambar tidak boleh lebih dari 3 MB']
        //     ];
        // }

        if(!in_array($file->getClientMimeType(), ['image/png', 'image/jpeg', 'image/jpg'])){
            return [
                'status' => false,
                'error' => ['Ekstensi file gambar harus PNG / JPG']
            ];
        }

        if (!$file->hasMoved()) {
            // $filepath = WRITEPATH . 'uploads/' . $file->store();
            $file->move('../public/img/product/' . date('Ymd'), $file->getRandomName());
           
            return [
                'status' => true,
                'data' => date('Ymd').'/'.$file->getName()
            ];
        }
    }

    public static function input($data) {

        if(!empty($data['fileFoto']->getClientMimeType())){
            $upload = self::uploadFile(['foto' => $data['fileFoto']]);
            if(!$upload['status']) {
                return [
                    'status' => false,
                    'error' => $upload['error']
                ];
            }
            $data['foto'] = $upload['data'];
        }else{
            $data['foto'] = 'default.png';
        }

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

        if(!empty($data['fileFoto']->getClientMimeType())){
            $upload = self::uploadFile(['foto' => $data['fileFoto']]);
            if(!$upload['status']) {
                return [
                    'status' => false,
                    'error' => $upload['error']
                ];
            }
            $data['foto'] = $upload['data'];
        }
        
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
        $builder->select('m_produk.*, m_produk_kategori.nama as kategori')
                ->join('m_produk_kategori', 'm_produk_kategori.id = m_produk.m_produk_kategori_id')
                ->orderBy('m_produk.id', 'DESC');

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

        foreach($return as $key => $val) {
            $return[$key]['harga_jual'] = 'Rp. ' . number_format($val['harga_jual']);
            $return[$key]['harga_beli'] = 'Rp. ' . number_format($val['harga_beli']);
            $return[$key]['foto'] = base_url(). '/img/product/' . $val['foto'];
        }

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

        $kategoriData['foto'] = base_url(). '/img/product/' . $kategoriData['foto'];
        return [
            'status' => true,
            'data' => $kategoriData
        ];
    }
}
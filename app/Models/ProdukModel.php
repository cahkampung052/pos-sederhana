<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'm_produk';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id',
        'nama',
        'm_produk_kategori_id', 
        'deskripsi', 
        'harga_beli',
        'harga_jual'
    ];

    protected $validationRules = [
        'nama' => 'required|alpha_numeric_space|min_length[3]|max_length[50]',
        'm_produk_kategori_id' => 'required',
        'deskripsi' => 'required',
        'harga_beli' => 'required',
        'harga_jual' => 'required',
    ];
}
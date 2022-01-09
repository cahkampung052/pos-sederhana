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
        'harga_jual',
        'foto'
    ];
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'm_produk_kategori';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id',
        'nama',
    ];

    protected $validationRules = [
        'nama' => 'required|alpha_numeric_space|min_length[3]|max_length[50]',
    ];
}
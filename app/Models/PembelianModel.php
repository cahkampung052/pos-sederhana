<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelianModel extends Model
{
    protected $table = 't_pembelian';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id',
        'kode',
        'm_supplier_id',
        'tanggal',
        'total'
    ];
}
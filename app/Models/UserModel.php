<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'm_user';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id',
        'nama',
        'email',
        'password',
        'roles',
    ];

    protected $validationRules = [
        'nama' => 'required|alpha_numeric_space|min_length[3]|max_length[50]',
        'email' => 'required|alpha_numeric_space|min_length[3]|max_length[50]',
        'password' => 'required',
        'roles' => 'required'
    ];
}
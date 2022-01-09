<?php

namespace App\Helpers;

use App\Models\UserModel;

class UserHelper
{
    public static function validateUnique($nama, $email, $id = 0) {
        $db      = \Config\Database::connect();
        
        if($id > 0) {
            $query = $db->query('SELECT id from m_user where (nama = "'.$nama.'" or email = "'.$email.'") and id != "'.$id.'"');
        } else {
            $query = $db->query('SELECT id from m_user where (nama = "'.$nama.'" or email = "'.$email.'")');
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
            'email' => 'trim|required|valid_email|max_length[50]',
            'password' => 'required|max_length[50]|min_length[4]',
            'rePassword' => 'matches[password]',            
        ]);

        $isDataValid = $validation->run($data);
        if(!$isDataValid){
            return [
                'status' => false,
                'error' => array_values($validation->getErrors())
            ];
        }

        if(!self::validateUnique($data['nama'], $data['email'])) {
            return [
                'status' => false,
                'error' => ['Nama atau Email user telah digunakan']
            ];
        }

        $data['password'] = \password_hash($data['password'], PASSWORD_DEFAULT);

        $userModel = new UserModel();
        $data = $userModel->insert($data);

        return [
            'status' => true,
            'data' => $userModel->find($data)
        ];
    }

    public static function update($data) {

        $validation =  \Config\Services::validation();
        $validation->setRules([
            'nama' => 'required|alpha_numeric_space|min_length[3]|max_length[50]',
            'email' => 'trim|required|valid_email|max_length[50]',
            'rePassword' => 'matches[password]', 
        ]);

        $isDataValid = $validation->run($data);
        if(!$isDataValid){
            return [
                'status' => false,
                'error' => array_values($validation->getErrors())
            ];
        }

        if(!self::validateUnique($data['nama'], $data['email'], $data['id'])) {
            return [
                'status' => false,
                'error' => ['Nama atau Email telah digunakan']
            ];
        }

        if(empty($data['password'])){
            unset($data['password']);
        }else{
            $data['password'] = \password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $userModel = new UserModel();
        $data = $userModel->update($data['id'], $data);

        return [
            'status' => true,
            'data' => $userModel->find($data)
        ];
    }

    public static function delete($kategoriId) {

        $userModel = new UserModel();

        $total = self::get([]);
        if($total['totalItems'] == 1) {
            return [
                'status' => false,
                'error' => ['Kamu tidak boleh menghapus semua User, sisakan 1 user agar sistem tetap dapat digunakan']
            ];
        }

        $data = $userModel->delete($kategoriId);

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

        $builder = $db->table('m_user');
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

    public static function find($userId) {
        $user = new UserModel();
        $userData = $user->where('id', $userId)->first();

        if(!isset($userData['id'])){
            return [
                'status' => false,
                'error' => ['user tidak ditemukan']
            ];
        }

        return [
            'status' => true,
            'data' => $userData
        ];
    }
    
    public static function isLogin() {
        session();
        if(!isset($_SESSION['user']['id'])){
            return false;
        }

        return true;
    }

    public static function login($email, $password)
    {
        if(empty($email)) {
            return [
                'status' => false,
                'error' => ['Email tidak boleh kosong']
            ];

            return [
                'status' => false,
                'error' => ['Password tidak boleh kosong']
            ];
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();
        
        if(!isset($user['id'])){
            return [
                'status' => false,
                'error' => ['Email tidak ditemukan']
            ];
        }

        if(!password_verify($password, $user['password'])) {
            return [
                'status' => false,
                'error' => ['Kata sandi yang kamu masukkan salah']
            ];
        }

         // Simpan user ke session
         session();
         $_SESSION['user']['id'] = $user['id'];
         $_SESSION['user']['nama']  = $user['nama'];
         $_SESSION['user']['email'] = $user['email'];
         $_SESSION['user']['roles'] = $user['roles'];

         // Hapus password agar tidak ditampilkan di response 
         unset($user['password']);

        return [
            'status' => true,
            'data' => $user
        ];
    }
}

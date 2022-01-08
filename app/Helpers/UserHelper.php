<?php

namespace App\Helpers;

use App\Models\UserModel;

class UserHelper
{
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

<?php

namespace App\Controllers;

use App\Helpers\UserHelper;

class User extends BaseController
{
    public function index()
    {
        if(!UserHelper::isLogin()){
            return redirect()->to(base_url('/login'));
        }

        return $this->twig->render('MasterUser/Index.html', ['baseUrl' => base_url()]);
    }

    public function add()
    {
        if(!UserHelper::isLogin()){
            return redirect()->to(base_url('/login'));
        }

        return $this->twig->render('MasterUser/Form.html', [
            'baseUrl' => base_url(),
            'tittle' => 'Tambah User Baru',
            'icon' => 'fa fa-plus'
        ]);
    }

    public function edit($param = false)
    {
        if(!UserHelper::isLogin()){
            return redirect()->to(base_url('/login'));
        }

        return $this->twig->render('MasterUser/Form.html', [
            'baseUrl' => base_url(),
            'tittle' => 'Edit User',
            'icon' => 'fa fa-edit',
            'userId' => $param
        ]);
    }

    public function editProfile()
    {
        if(!UserHelper::isLogin()){
            return redirect()->to(base_url('/login'));
        }

        return $this->twig->render('MasterUser/Form.html', [
            'baseUrl' => base_url(),
            'tittle' => 'Ubah Profile',
            'icon' => 'fa fa-user',
            'userId' => $_SESSION['user']['id'],
            'hiddenBackBtn' => 1
        ]);
    }

    public function logout()
    {
        $session = session();
        $session->remove('user');
       
        if(!UserHelper::isLogin()){
            return redirect()->to(base_url('/login'));
        }
    }
}

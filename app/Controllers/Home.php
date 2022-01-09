<?php

namespace App\Controllers;

use App\Helpers\UserHelper;

class Home extends BaseController
{
    public function index()
    {
        if(!UserHelper::isLogin()){
            return redirect()->to(base_url('/login'));
        }

        return redirect()->to(base_url('/pembelian/add'));
    }

    public function login()
    {
        if(UserHelper::isLogin()){
            return redirect()->to(base_url());
        }

        return $this->twig->render('Auth/Login.html', ['baseUrl' => base_url()]);
    }
}

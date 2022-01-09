<?php

namespace App\Controllers;

use App\Helpers\UserHelper;

class Pembelian extends BaseController
{
    public function index()
    {
        if(!UserHelper::isLogin()){
            return redirect()->to(base_url('/login'));
        }

        return $this->twig->render('Pembelian/Index.html', ['baseUrl' => base_url()]);
    }

    public function add()
    {
        if(!UserHelper::isLogin()){
            return redirect()->to(base_url('/login'));
        }

        return $this->twig->render('Pembelian/Form.html', [
            'baseUrl' => base_url(),
            'tittle' => 'Tambah Pembelian Baru',
            'icon' => 'fa fa-plus'
        ]);
    }

    public function edit($param = false)
    {
        if(!UserHelper::isLogin()){
            return redirect()->to(base_url('/login'));
        }

        return $this->twig->render('Pembelian/Form.html', [
            'baseUrl' => base_url(),
            'tittle' => 'Edit Pembelian',
            'icon' => 'fa fa-edit',
            'pembelianId' => $param
        ]);
    }
}

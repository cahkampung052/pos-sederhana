<?php

namespace App\Controllers;

use App\Helpers\UserHelper;

class Produk extends BaseController
{
    public function index()
    {
        if(!UserHelper::isLogin()){
            return redirect()->to(base_url('/login'));
        }

        return $this->twig->render('MasterProduk/Index.html', ['baseUrl' => base_url()]);
    }

    public function add()
    {
        if(!UserHelper::isLogin()){
            return redirect()->to(base_url('/login'));
        }

        return $this->twig->render('MasterProduk/Form.html', [
            'baseUrl' => base_url(),
            'tittle' => 'Tambah Produk Baru',
            'icon' => 'fa fa-plus'
        ]);
    }

    public function edit($param = false)
    {
        if(!UserHelper::isLogin()){
            return redirect()->to(base_url('/login'));
        }

        return $this->twig->render('MasterProduk/Form.html', [
            'baseUrl' => base_url(),
            'tittle' => 'Edit Produk',
            'icon' => 'fa fa-edit',
            'produkId' => $param,
        ]);
    }
}

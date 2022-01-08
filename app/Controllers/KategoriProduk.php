<?php

namespace App\Controllers;

use App\Helpers\UserHelper;

class KategoriProduk extends BaseController
{
    public function index()
    {
        if(!UserHelper::isLogin()){
            return redirect()->to(base_url('/login'));
        }

        return $this->twig->render('MasterKategori/Index.html', ['baseUrl' => base_url()]);
    }

    public function add()
    {
        if(!UserHelper::isLogin()){
            return redirect()->to(base_url('/login'));
        }

        return $this->twig->render('MasterKategori/Form.html', [
            'baseUrl' => base_url(),
            'tittle' => 'Tambah Kategori Baru',
            'icon' => 'fa fa-plus'
        ]);
    }

    public function edit($param = false)
    {
        if(!UserHelper::isLogin()){
            return redirect()->to(base_url('/login'));
        }

        return $this->twig->render('MasterKategori/Form.html', [
            'baseUrl' => base_url(),
            'tittle' => 'Edit Kategori',
            'icon' => 'fa fa-edit',
            'kategoriId' => $param
        ]);
    }
}

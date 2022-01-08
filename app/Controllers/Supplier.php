<?php

namespace App\Controllers;

use App\Helpers\UserHelper;

class Supplier extends BaseController
{
    public function index()
    {
        if(!UserHelper::isLogin()){
            return redirect()->to(base_url('/login'));
        }

        return $this->twig->render('MasterSupplier/Index.html', ['baseUrl' => base_url()]);
    }

    public function add()
    {
        if(!UserHelper::isLogin()){
            return redirect()->to(base_url('/login'));
        }

        return $this->twig->render('MasterSupplier/Form.html', [
            'baseUrl' => base_url(),
            'tittle' => 'Tambah Supplier Baru',
            'icon' => 'fa fa-plus'
        ]);
    }

    public function edit($param = false)
    {
        if(!UserHelper::isLogin()){
            return redirect()->to(base_url('/login'));
        }

        return $this->twig->render('MasterSupplier/Form.html', [
            'baseUrl' => base_url(),
            'tittle' => 'Edit Supplier',
            'icon' => 'fa fa-edit',
            'supplierId' => $param
        ]);
    }
}

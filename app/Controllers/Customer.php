<?php

namespace App\Controllers;

use App\Helpers\UserHelper;

class Customer extends BaseController
{
    public function index()
    {
        if(!UserHelper::isLogin()){
            return redirect()->to(base_url('/login'));
        }

        return $this->twig->render('MasterCustomer/Index.html', ['baseUrl' => base_url()]);
    }

    public function add()
    {
        if(!UserHelper::isLogin()){
            return redirect()->to(base_url('/login'));
        }

        return $this->twig->render('MasterCustomer/Form.html', [
            'baseUrl' => base_url(),
            'tittle' => 'Tambah Customer Baru',
            'icon' => 'fa fa-plus'
        ]);
    }

    public function edit($param = false)
    {
        if(!UserHelper::isLogin()){
            return redirect()->to(base_url('/login'));
        }

        return $this->twig->render('MasterCustomer/Form.html', [
            'baseUrl' => base_url(),
            'tittle' => 'Edit Customer',
            'icon' => 'fa fa-edit',
            'customerId' => $param
        ]);
    }
}

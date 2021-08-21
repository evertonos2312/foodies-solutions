<?php

namespace App\Controllers\Admin;

class Usuarios extends AdminBaseController
{
    public $data = array();

    public function index()
    {
        $this->data['title'] = 'Início';


        return $this->display_template($this->smarty->setData($this->data)->view('Admin/Usuarios/index'));
//        return view('errors/construct_admin');
    }
}
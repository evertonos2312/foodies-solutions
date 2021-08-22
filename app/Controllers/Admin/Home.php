<?php

namespace App\Controllers\Admin;

class Home extends AdminBaseController
{
    public $data = array();

    public function index()
    {
        $this->data['title'] = 'Início';
        $this->data['active'] = 'dashboard';


        return $this->display_template($this->smarty->setData($this->data)->view('Admin/Home/index'));
//        return view('errors/construct_admin');
    }
}

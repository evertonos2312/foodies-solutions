<?php

namespace App\Controllers\Admin;

class Home extends AdminBaseController
{
    public $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->data['active'] = 'dashboard';
    }

    public function index()
    {
        $this->data['title'] = 'Início';


        return $this->render($this->data, 'Admin/Home/index');
    }
}

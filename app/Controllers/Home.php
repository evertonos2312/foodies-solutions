<?php

namespace App\Controllers;

class Home extends BaseController
{
    public $data = array();

    public function index()
    {
        $this->data['title'] = 'Início';


        return view('errors/construct');
    }
}

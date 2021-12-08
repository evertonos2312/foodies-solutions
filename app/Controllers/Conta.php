<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Conta extends BaseController
{
    private $usuario;
    public function __construct()
    {
        parent::__construct();
        $this->usuario = service('authentication')->getUserLogged();
    }

    public function index()
    {
        return redirect()->to('Conta/show');
    }

    public function show()
    {
        $this->data['usuario'] = $this->usuario;
        $this->data['title'] = 'Meus dados';
        return $this->display_template($this->smarty->setData($this->data)->view('Conta/show'));
    }

    public function editar()
    {
        $this->data['usuario'] = $this->usuario;
        $this->data['title'] = 'Editar meus dados';
        return $this->display_template($this->smarty->setData($this->data)->view('Conta/editar'));
    }
}

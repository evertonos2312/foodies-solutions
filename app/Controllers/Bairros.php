<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BairroModel;

class Bairros extends BaseController
{
    private $bairroModel;
    public function __construct()
    {
        parent::__construct();
        $this->bairroModel = new BairroModel();
    }

    public function index()
    {
        $this->data['title'] = 'Bairros que atendemos em São Paulo - SP';
        $this->data['bairros'] = $this->bairroModel->where('ativo', true)->orderBy('nome')->findAll();
        return $this->display_template($this->smarty->setData($this->data)->view('Bairros/index'));
    }
}

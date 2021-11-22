<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\ProdutoModel;

class Home extends BaseController
{
    public $data = array();
    private $categoriaModel;
    private $produtoModel;

    public function __construct()
    {
        parent::__construct();
        $this->categoriaModel = new CategoriaModel();
        $this->produtoModel = new ProdutoModel();
    }


    public function index()
    {
        $this->data['title'] = 'Pizza Planet | Seja bem vindo!';
        $this->data['categorias'] = $this->categoriaModel->buscaCategoriasHome();
        $this->data['produtos'] = $this->produtoModel->buscaProdutosHome();
        return $this->display_template($this->smarty->setData($this->data)->view('home/index'));
    }
}

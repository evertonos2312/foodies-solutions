<?php

namespace App\Controllers;

use App\Models\ProdutoEspecificacaoModel;
use App\Models\ProdutoModel;

class Produto extends BaseController
{
    private $produtoModel;
    private $especificacaoModel;
    public function __construct()
    {
        parent::__construct();
        $this->especificacaoModel = new ProdutoEspecificacaoModel();
        $this->produtoModel = new ProdutoModel();
    }

    public function detalhes(string $produto_slug = null)
    {
        if(!$produto_slug || !$produto = $this->produtoModel->where('slug', $produto_slug)->first()) {
            return redirect()->to(site_url('/'));
        }
        $this->data['title'] = 'Detalhando o produto '.$produto['nome'];
        $this->data['produto'] = $produto;
        $this->data['especificacoes'] = $this->especificacaoModel->getEspecificacoesProduto($produto['id']);
        return $this->display_template($this->smarty->setData($this->data)->view('Produto/detalhes'));
    }
}
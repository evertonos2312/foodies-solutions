<?php

namespace App\Controllers;

use App\Models\ProdutoEspecificacaoModel;
use App\Models\ProdutoExtraModel;
use App\Models\ProdutoModel;

class Produto extends BaseController
{
    private $produtoModel;
    private $especificacaoModel;
    private $produtoExtraModel;
    public function __construct()
    {
        parent::__construct();
        $this->especificacaoModel = new ProdutoEspecificacaoModel();
        $this->produtoModel = new ProdutoModel();
        $this->produtoExtraModel = new ProdutoExtraModel();
    }

    public function detalhes(string $produto_slug = null)
    {
        if(!$produto_slug || !$produto = $this->produtoModel->where('slug', $produto_slug)->where('ativo', 1)->first()) {
            return redirect()->to(site_url('/'));
        }

        $extras = $this->produtoExtraModel->buscaExtrasDoProdutoDetalhes($produto['id']);

        $this->data['extras'] = $extras;
        $this->data['title'] = 'Detalhando o produto '.$produto['nome'];
        $this->data['produto'] = $produto;
        $this->data['especificacoes'] = $this->especificacaoModel->getEspecificacoesProduto($produto['id']);
        return $this->display_template($this->smarty->setData($this->data)->view('Produto/detalhes'));
    }

    public function customizar(string $produto_slug = null)
    {
        if(!$produto_slug || !$produto = $this->produtoModel->where('slug', $produto_slug)->where('ativo', 1)->first()) {
            return redirect()->back();
        }
        if(!$this->especificacaoModel->where('produto_id', $produto['id'])->where('customizavel', 1)->first()) {
            $this->session->setFlashdata('msg', "O produto <strong>{$produto['nome']}</strong> não é customizável");
            $this->session->setFlashdata('msg_type', 'alert-warning');
            return redirect()->back();
        }
        $this->data['title'] = 'Customizando o produto '.$produto['nome'];
        $this->data['produto'] = $produto;
        $this->data['especificacoes'] = $this->especificacaoModel->getEspecificacoesProduto($produto['id']);
        $this->data['opcoes'] = $this->produtoModel->exibeOpcoesProdutosParaCustomizar($produto['categoria_id']);
        return redirect()->back();

//        return $this->display_template($this->smarty->setData($this->data)->view('Produto/customizar'));

    }
}
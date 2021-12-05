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

        return $this->display_template($this->smarty->setData($this->data)->view('Produto/customizar'));
    }

    public function procurar()
    {
        if ($this->request->isAJAX()) {
            $data = array();
            $get = $this->request->getGet();
            $primeira_metade = $get['primeira_metade'];
            $categoria_id = $get['categoria_id'];
            $data['token'] = csrf_hash();
            if (!empty($primeira_metade) && !empty($categoria_id)) {
                $produto = $this->produtoModel->where('id', $primeira_metade)->first();
                if ($produto) {
                    $produtos = $this->produtoModel->exibeProdutosSegundaMetade($primeira_metade, $categoria_id);
                    if($produtos) {
                        $data['code'] = 200;
                        $data['status'] = 'success';
                        $data['detail'] = [
                            'produtos' => $produtos,
                            'imagemPrimeiroProduto' => $produto['imagem']
                        ];
                        $data['msg_error'] = '';
                    } else {
                        $data['code'] = 404;
                        $data['status'] = 'error';
                        $data['detail'] = '';
                        $data['msg_error'] = 'Produto não encontrado.';
                    }

                } else {
                    $data['code'] = 404;
                    $data['status'] = 'error';
                    $data['detail'] = '';
                    $data['msg_error'] = 'Produto não encontrado.';
                }
                return $this->response->setJSON($data);
            }
        }
        return redirect()->back();
    }

    public function exibeTamanhos()
    {
        if ($this->request->isAJAX()) {
            $data = array();
            $get = $this->request->getGet();
            $primeiro_produto_id = $get['primeiro_produto_id'];
            $segundo_produto_id = $get['segundo_produto_id'];
            $data['token'] = csrf_hash();
            if (!empty($primeiro_produto_id) && !empty($segundo_produto_id)) {
                $produto = $this->produtoModel->where('id', $primeiro_produto_id)->first();
                if ($produto) {
                    $produtos = $this->produtoModel->exibeProdutosSegundaMetade($primeiro_produto_id, $segundo_produto_id);
                    if($produtos) {
                        $data['code'] = 200;
                        $data['status'] = 'success';
                        $data['detail'] = [
                            'produtos' => $produtos,
                            'imagemPrimeiroProduto' => $produto['imagem']
                        ];
                        $data['msg_error'] = '';
                    } else {
                        $data['code'] = 404;
                        $data['status'] = 'error';
                        $data['detail'] = '';
                        $data['msg_error'] = 'Produto não encontrado.';
                    }

                } else {
                    $data['code'] = 404;
                    $data['status'] = 'error';
                    $data['detail'] = '';
                    $data['msg_error'] = 'Produto não encontrado.';
                }
                return $this->response->setJSON($data);
            }
        }
        return redirect()->back();
    }
}
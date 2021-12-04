<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ExtraModel;
use App\Models\ProdutoEspecificacaoModel;
use App\Models\ProdutoModel;

class Carrinho extends BaseController
{

    private $validation;
    private $produtoEspecificacaoModel;
    private $extraModel;
    private $produtoModel;
    public function __construct()
    {
        parent::__construct();
        $this->validation = service('validation');
        $this->produtoEspecificacaoModel = new ProdutoEspecificacaoModel();
        $this->extraModel = new ExtraModel();
        $this->produtoModel = new ProdutoModel();
    }

    public function index()
    {
        //
    }

    public function adicionar()
    {
        if($this->request->getPost()) {
            $produtoPost = $this->request->getPost('produto');
            $this->validation->setRules([
                'produto.slug' => ['label' => 'Produto', 'rules' => 'required|string'],
                'produto.especificacao_id' => ['label' => 'Valor do Produto', 'rules' => 'required|greater_than[0]'],
                'produto.preco' => ['label' => 'Valor do Produto', 'rules' => 'required|greater_than[0]'],
                'produto.quantidade' => ['label' => 'Quantidade', 'rules' => 'required|greater_than[0]'],
            ]);
            if(!$this->validation->withRequest($this->request)->run()) {
                $this->session->setFlashdata('msg', $this->validation->getErrors());
                $this->session->setFlashdata('msg_type', 'alert-danger');
                return redirect()->back()->withInput();
            }
            $produtoEspecificacao = $this->produtoEspecificacaoModel->getEspecificacoesProdutoSlug($produtoPost['slug'], $produtoPost['especificacao_id']);
            if(is_null($produtoEspecificacao)) {
                $this->session->setFlashdata('msg', 'Não conseguimos processar a sua solicitação. Entre em contato conosco e informe <strong>ERRO-ADD-PROD-1001</strong>');
                $this->session->setFlashdata('msg_type', 'alert-warning');
                return redirect()->back();
            }

            if($produtoPost['extra_id'] && $produtoPost['extra_id'] != "") {
                $extra = $this->extraModel->where('id', $produtoPost['extra_id'])->first();
                if(is_null($extra)) {
                    $this->session->setFlashdata('msg', 'Não conseguimos processar a sua solicitação. Entre em contato conosco e informe <strong>ERRO-ADD-PROD-2002</strong>');
                    $this->session->setFlashdata('msg_type', 'alert-warning');
                    return redirect()->back();
                }

            }

            $produto = $this->produtoModel->select('id, nome, slug, ativo')->where('slug', $produtoPost['slug'])->where('ativo', 1)->first();
            if(is_null($produto)) {
                $this->session->setFlashdata('msg', 'Não conseguimos processar a sua solicitação. Entre em contato conosco e informe <strong>ERRO-ADD-PROD-3003</strong>');
                $this->session->setFlashdata('msg_type', 'alert-warning');
                return redirect()->back();
            }
            $produto['slug'] = mb_url_title($produto['slug'].'-'.$produtoEspecificacao['nome'].'-'.'-'.(isset($extra) ? 'com extra-'.$extra['nome']: ''),'-', true);
            $produto['nome'] = $produto['nome'] . ' ' . $produtoEspecificacao['nome'] . ' ' . (isset($extra) ? 'Com extra '.$extra['nome'] : '');
            $preco = $produtoEspecificacao['preco'] + (isset($extra) ? $extra['preco'] : 0);
            $produto['preco'] = number_format($preco, 2, ',', '.');
            $produto['quantidade'] = (int) $produtoPost['quantidade'];
            $produto['tamanho'] = $produtoEspecificacao['nome'];

            
            return redirect()->back();
        }
    }
}

<?php

namespace App\Controllers;

use App\Models\ExtraModel;
use App\Models\MedidaModel;
use App\Models\ProdutoEspecificacaoModel;
use App\Models\ProdutoExtraModel;
use App\Models\ProdutoModel;

class Produto extends BaseController
{
    private $produtoModel;
    private $especificacaoModel;
    private $produtoExtraModel;
    private $medidaModel;
    private $extraModel;
    public function __construct()
    {
        parent::__construct();
        $this->especificacaoModel = new ProdutoEspecificacaoModel();
        $this->produtoModel = new ProdutoModel();
        $this->produtoExtraModel = new ProdutoExtraModel();
        $this->medidaModel = new MedidaModel();
        $this->extraModel = new ExtraModel();
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
                $primeiroProduto = $this->produtoModel->where('id', $primeiro_produto_id)->first();
                if (!$primeiroProduto) {
                    $data['code'] = 404;
                    $data['status'] = 'error';
                    $data['detail'] = '';
                    $data['msg_error'] = 'Primeiro produto não encontrado.';
                    return $this->response->setJSON($data);
                }
                $especificacoesPrimeiroProduto = $this->especificacaoModel->where('produto_id', $primeiroProduto['id'])->findAll();
                if(!$especificacoesPrimeiroProduto){
                    $data['code'] = 404;
                    $data['status'] = 'error';
                    $data['detail'] = '';
                    $data['msg_error'] = 'Especificações primeiro produto não encontradas.';
                    return $this->response->setJSON($data);
                }
                $extrasPrimeiroProduto = $this->produtoExtraModel->buscaExtrasDoProdutoDetalhes($primeiroProduto['id']);

                $segundoProduto = $this->produtoModel->where('id', $segundo_produto_id)->first();
                if (!$segundoProduto) {
                    $data['code'] = 404;
                    $data['status'] = 'error';
                    $data['detail'] = '';
                    $data['msg_error'] = 'Segundo produto não encontrado.';
                    return $this->response->setJSON($data);
                }
                $especificacoesSegundoProduto = $this->especificacaoModel->where('produto_id', $segundoProduto['id'])->findAll();
                if(!$especificacoesSegundoProduto){
                    $data['code'] = 404;
                    $data['status'] = 'error';
                    $data['detail'] = '';
                    $data['msg_error'] = 'Especificações segundo produto não encontradas.';
                    return $this->response->setJSON($data);
                }

                $extrasSegundoProduto = $this->produtoExtraModel->buscaExtrasDoProdutoDetalhes($segundoProduto['id']);

                $extrasCombinados = $this->combinaExtrasProdutos($extrasPrimeiroProduto, $extrasSegundoProduto);

                if(!is_null($extrasCombinados)) {
                    $data['detail']['extras'] = $extrasCombinados;
                }
                
                $medidasEmComum = $this->recuperaMedidasEmComum($especificacoesPrimeiroProduto, $especificacoesSegundoProduto);
                $medidas = $this->medidaModel->select('id, nome')->whereIn('id', $medidasEmComum)->where('ativo', true)->findAll();

                $data['detail']['medidas'] = $medidas;
                $data['detail']['imagemSegundoProduto'] = $segundoProduto['imagem'];
                $data['code'] = 200;
                $data['status'] = 'success';
                $data['msg_error'] = '';
                return $this->response->setJSON($data);

            }
        }
        return redirect()->back();
    }

    public function exibeValor()
    {
        if ($this->request->isAJAX()) {
            $data = array();
            $get = $this->request->getGet();
            $medida_id = $get['medida_id'];
            $primeira_metade = $get['primeira_metade'];
            $segunda_metade = $get['segunda_metade'];
            $extra_id = $get['extra_id'];
            $data['token'] = csrf_hash();
            if (!empty($medida_id && !empty($primeira_metade) && !empty($segunda_metade))){
                $medida = $this->medidaModel->exibeValor($medida_id, $primeira_metade, $segunda_metade);
                if(!$medida) {
                    $data['code'] = 403;
                    $data['status'] = 'error';
                    $data['detail'] = '';
                    $data['msg_error'] = 'Forbidden';
                    return $this->response->setJSON($data);
                }
                if(!empty($extra_id)) {
                    $extra = $this->extraModel->select('preco')->find($extra_id);
                }

                if(isset($extra) &&!is_null($extra)){
                    $medida['preco'] =  number_format($medida['preco'] + $extra['preco'], 2, ',', '.');
                } else {
                    $medida['preco'] = number_format($medida['preco'], 2, ',', '.');
                }

                $data['detail']['medida'] = $medida;
                $data['code'] = 200;
                $data['status'] = 'success';
                $data['msg_error'] = '';
                return $this->response->setJSON($data);
            }
            $data['code'] = 403;
            $data['status'] = 'error';
            $data['detail'] = '';
            $data['msg_error'] = 'Forbidden';
            return $this->response->setJSON($data);
        }
        return redirect()->back();
    }

    private function combinaExtrasProdutos(array $extrasPrimeiroProduto, array $extrasSegundoProduto)
    {
        $extrasUnicos = [];
        $extrasCombinados = array_merge($extrasPrimeiroProduto, $extrasSegundoProduto);
        foreach ($extrasCombinados as $extra) {
            $extraExiste = in_array($extra['id'], array_column($extrasUnicos, 'id'));
            if($extraExiste == false) {
                $extrasUnicos[] = [
                    'id' => $extra['id'],
                    'nome' => $extra['extra'],
                    'preco' => number_format($extra['preco'], 2, ',', '.'),
                ];
            }
        }
        return $extrasUnicos;
    }

    private function recuperaMedidasEmComum(array $especificacoesPrimeiroProduto, array $especificacoesSegundoProduto)
    {
        $primeiroArrayMedidas = [];

        foreach ($especificacoesPrimeiroProduto as $especificacao){
            if($especificacao['customizavel']) {
                $primeiroArrayMedidas[] = $especificacao['medida_id'];
            }
        }

        $segundoArrayMedidas = [];

        foreach ($especificacoesSegundoProduto as $especificacao_2){
            if($especificacao['customizavel']) {
                $segundoArrayMedidas[] = $especificacao_2['medida_id'];
            }
        }

        return array_intersect($primeiroArrayMedidas, $segundoArrayMedidas);
    }
}
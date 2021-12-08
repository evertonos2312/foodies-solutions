<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BairroModel;
use App\Models\ExtraModel;
use App\Models\MedidaModel;
use App\Models\ProdutoEspecificacaoModel;
use App\Models\ProdutoModel;

class Carrinho extends BaseController
{

    private $validation;
    private $produtoEspecificacaoModel;
    private $extraModel;
    private $produtoModel;
    private $medidaModel;
    private $bairroModel;
    private $acao;
    public function __construct()
    {
        parent::__construct();
        $this->validation = service('validation');
        $this->produtoEspecificacaoModel = new ProdutoEspecificacaoModel();
        $this->extraModel = new ExtraModel();
        $this->produtoModel = new ProdutoModel();
        $this->medidaModel = new MedidaModel();
        $this->bairroModel = new BairroModel();
        $this->acao = service('router')->methodName();
    }

    public function index()
    {
        if(session()->has('carrinho') && count(session()->get('carrinho')) > 0) {
            $carrinho = session()->get('carrinho');
            $total = 0;
            foreach ($carrinho as &$produto) {
                $final1 = str_replace (',', '.', str_replace ('.', '', $produto['preco']));
                $final2 = str_replace (',', '.', str_replace ('.', '', $produto['quantidade']));
                $produto['subtotal'] = $final1 * $final2;
                $total += $produto['subtotal'];
            }

            $this->data['total'] = $total;
            $this->data['carrinho'] = $carrinho;
        }

        $this->data['title'] = 'Meu carrinho de compras';
        return $this->display_template($this->smarty->setData($this->data)->view('Carrinho/index'));
    }

    public function adicionar()
    {
        if(!$this->checkAbertura()) {
            $this->session->setFlashdata('msg', 'Estamos fechados no momento.');
            $this->session->setFlashdata('msg_type', 'alert-warning');
            return redirect()->back();
        }
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

            $produto = $this->produtoModel->select('id, nome, slug')->where('slug', $produtoPost['slug'])->where('ativo', 1)->first();
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

            if(session()->has('carrinho')) {
                $produtos = session()->get('carrinho');
                $produtosSlugs = array_column($produtos, 'slug');

                if(in_array($produto['slug'], $produtosSlugs)) {
                    $produtos = $this->atualizaProduto($this->acao, $produto['slug'], $produto['quantidade'], $produtos);
                    session()->set('carrinho', $produtos);
                } else {
                    session()->push('carrinho', [$produto]);
                }
            } else {
                $produtos[] = $produto;
                session()->set('carrinho', $produtos);
            }

            $this->session->setFlashdata('msg', 'Produto adicionado com sucesso');
            $this->session->setFlashdata('msg_type', 'alert-success');
            return redirect()->to(site_url('carrinho'));
        }
        return redirect()->back();
    }

    public function especial()
    {
        if($this->request->getPost()){
            $produtoPost = $this->request->getPost();

            $this->validation->setRules([
                'primeira_metade' => ['label' => 'Primeiro produto', 'rules' => 'required|greater_than[0]'],
                'segunda_metade' => ['label' => 'Segundo produto', 'rules' => 'required|greater_than[0]'],
                'tamanho' => ['label' => 'Tamanho do produto', 'rules' => 'required|greater_than[0]']
            ]);
            if(!$this->validation->withRequest($this->request)->run()) {
                $this->session->setFlashdata('msg', $this->validation->getErrors());
                $this->session->setFlashdata('msg_type', 'alert-danger');
                return redirect()->back()->withInput();
            }

            $primeiroProduto = $this->produtoModel->select('id, nome, slug')->where('id', $produtoPost['primeira_metade'])->first();

            if(is_null($primeiroProduto)){
                $this->session->setFlashdata('msg', 'Não conseguimos processar a sua solicitação. Entre em contato conosco e informe <strong>ERRO-ADD-CUSTOM-1001</strong>');
                $this->session->setFlashdata('msg_type', 'alert-warning');
                return redirect()->back();
            }
            $segundoProduto = $this->produtoModel->select('id, nome, slug')->where('id', $produtoPost['segunda_metade'])->first();
            if(is_null($segundoProduto)){
                $this->session->setFlashdata('msg', 'Não conseguimos processar a sua solicitação. Entre em contato conosco e informe <strong>ERRO-ADD-CUSTOM-2002</strong>');
                $this->session->setFlashdata('msg_type', 'alert-warning');
                return redirect()->back();
            }

            if($produtoPost['extra_id'] && $produtoPost['extra_id'] != "") {
                $extra = $this->extraModel->where('id', $produtoPost['extra_id'])->first();
                if(is_null($extra)) {
                    $this->session->setFlashdata('msg', 'Não conseguimos processar a sua solicitação. Entre em contato conosco e informe <strong>ERRO-ADD-CUSTOM-3003</strong>');
                    $this->session->setFlashdata('msg_type', 'alert-warning');
                    return redirect()->back();
                }
            }
            $medida = $this->medidaModel->exibeValor($produtoPost['tamanho'], $primeiroProduto['id'], $segundoProduto['id']);
            if(is_null($medida['preco'])) {
                $this->session->setFlashdata('msg', 'Não conseguimos processar a sua solicitação. Entre em contato conosco e informe <strong>ERRO-ADD-CUSTOM-4004</strong>');
                $this->session->setFlashdata('msg_type', 'alert-warning');
                return redirect()->back();
            }

            $produto['slug'] = mb_url_title($medida['nome'].'-metade-'.$primeiroProduto['slug'].'-metade-'.$segundoProduto['slug'].'-'.(isset($extra) ? 'com extra-'.$extra['nome']: ''),'-', true);
            $produto['nome'] = $medida['nome'].' metade '.$primeiroProduto['nome'].' metade '.$segundoProduto['nome'].' '.(isset($extra) ? 'com extra '.$extra['nome']: '');

            $preco = $medida['preco'] + (isset($extra) ? $extra['preco'] : 0);
            $produto['preco'] = number_format($preco, 2, ',', '.');
            $produto['quantidade'] = 1;
            $produto['tamanho'] = $medida['nome'];

            if(session()->has('carrinho')) {
                $produtos = session()->get('carrinho');
                $produtosSlugs = array_column($produtos, 'slug');

                if(in_array($produto['slug'], $produtosSlugs)) {
                    $produtos = $this->atualizaProduto($this->acao, $produto['slug'], $produto['quantidade'], $produtos);
                    session()->set('carrinho', $produtos);
                } else {
                    session()->push('carrinho', [$produto]);
                }
            } else {
                $produtos[] = $produto;
                session()->set('carrinho', $produtos);
            }

            $this->session->setFlashdata('msg', 'Produto adicionado com sucesso');
            $this->session->setFlashdata('msg_type', 'alert-success');
            return redirect()->to(site_url('carrinho'));



        }
        return redirect()->back();
    }

    public function atualizar()
    {
        if($this->request->getPost()) {
            $produtoPost = $this->request->getPost('produto');
            $this->validation->setRules([
                'produto.slug' => ['label' => 'Produto', 'rules' => 'required|string'],
                'produto.quantidade' => ['label' => 'Quantidade', 'rules' => 'required|greater_than[0]'],
            ]);
            if(!$this->validation->withRequest($this->request)->run()) {
                $this->session->setFlashdata('msg', $this->validation->getErrors());
                $this->session->setFlashdata('msg_type', 'alert-danger');
                return redirect()->back()->withInput();
            }


            $produtos = session()->get('carrinho');
            $produtosSlugs = array_column($produtos, 'slug');

            if(!in_array($produtoPost['slug'], $produtosSlugs)) {
                $this->session->setFlashdata('msg', 'Não conseguimos processar a sua solicitação. Entre em contato conosco e informe <strong>ERRO-ADD-UP-7007</strong>');
                $this->session->setFlashdata('msg_type', 'alert-warning');
                return redirect()->back();
            } else {
                $produtos = $this->atualizaProduto($this->acao, $produtoPost['slug'], $produtoPost['quantidade'], $produtos);
                session()->set('carrinho', $produtos);
                $this->session->setFlashdata('msg', 'Quantidade atualizada com sucesso');
                $this->session->setFlashdata('msg_type', 'alert-success');
                return redirect()->back();

            }
        }
        return redirect()->back();
    }

    public function remover()
    {
        if($this->request->getPost()) {
            $produtoPost = $this->request->getPost('produto');
            $this->validation->setRules([
                'produto.slug' => ['label' => 'Produto', 'rules' => 'required|string'],
            ]);
            if(!$this->validation->withRequest($this->request)->run()) {
                $this->session->setFlashdata('msg', $this->validation->getErrors());
                $this->session->setFlashdata('msg_type', 'alert-danger');
                return redirect()->back()->withInput();
            }


            $produtos = session()->get('carrinho');
            $produtosSlugs = array_column($produtos, 'slug');

            if(!in_array($produtoPost['slug'], $produtosSlugs)) {
                $this->session->setFlashdata('msg', 'Não conseguimos processar a sua solicitação. Entre em contato conosco e informe <strong>ERRO-ADD-UP-7007</strong>');
                $this->session->setFlashdata('msg_type', 'alert-warning');
                return redirect()->back();
            } else {

                $produtos = $this->removeProduto($produtos, $produtoPost['slug']);
                session()->set('carrinho', $produtos);
                $this->session->setFlashdata('msg', 'Produto removido com sucesso');
                $this->session->setFlashdata('msg_type', 'alert-success');
                return redirect()->back();

            }
        }
        return redirect()->back();
    }

    public function limpar()
    {
        session()->remove('carrinho');
        return redirect()->to(site_url('carrinho'));
    }

    public function consultaCep()
    {
        if ($this->request->isAJAX()) {
            $data = array();
            $cep = $this->request->getPost('cep');
            $data['token'] = csrf_hash();
            $validation = service('validation');
            $validation->setRule('cep', 'CEP', 'required|exact_length[9]');

            if(!$validation->withRequest($this->request)->run()){
                $data['code'] = 503;
                $data['status'] = 'error';
                $data['detail'] = '';
                $data['msg_error'] = $validation->getError();
                return $this->response->setJSON($data);
            }
            $cep = str_replace('-', '', $cep);

            $consulta = consultaCep($cep);
            if(!isset($consulta->erro) && isset($consulta->cep)) {
                $bairroRetornoSlug = mb_url_title($consulta->bairro, '-', true);

                $bairro = $this->bairroModel->select('nome, valor_entrega')->where('slug', $bairroRetornoSlug)->where('ativo', true)->first();
                if(is_null($bairro)) {
                    $data['code'] = 503;
                    $data['status'] = 'error';
                    $data['detail'] = '';
                    $data['msg_error'] = 'Não atendemos o bairro: '.$consulta->bairro. ' - '. $consulta->localidade. ' - CEP '. $consulta->cep.' - '. $consulta->uf;
                    return $this->response->setJSON($data);
                }
                $valor_entrega = number_format($bairro['valor_entrega'], 2, ',', '.');
                $data['code'] = 200;
                $data['status'] = 'success';
                $data['detail'] = [
                    'valor_entrega' => 'R$ '.$valor_entrega,
                    'bairro' => 'Valor de entrega para o bairro: '.$consulta->bairro. ' - '. $consulta->localidade. ' - CEP '.$consulta->cep. ' - '. $consulta->uf. ' - R$ '. $valor_entrega,
                ];
                $data['msg_error'] = '';

                $carrinho = session()->get('carrinho');
                $total = 0;
                foreach ($carrinho as $produto) {
                    $preco = str_replace (',', '.', str_replace ('.', '', $produto['preco']));
                    $quantidade = str_replace (',', '.', str_replace ('.', '', $produto['quantidade']));
                    $total += ($preco * $quantidade);
                }
                $total += $bairro['valor_entrega'];
                $data['detail']['total'] = 'R$ '.number_format($total, 2, ',', '.');
            } else {
                $data['code'] = 503;
                $data['status'] = 'error';
                $data['detail'] = '';
                $data['msg_error'] = 'Erro ao consultar cep, verifique os dados enviados.';
            }
            return $this->response->setJSON($data);
        }
        return redirect()->back();
    }


    /**
     * Atualiza os produtos do carrinho
     * @param string $acao
     * @param string $slug
     * @param int $quantidade
     * @param array $produtos
     * @return array
     */
    private function atualizaProduto(string $acao, string $slug, int $quantidade, array $produtos)
    {
        $produtos = array_map(function ($linha) use($acao, $slug, $quantidade) {
            if($linha['slug'] == $slug) {
                if($acao === 'adicionar') {
                    $linha['quantidade'] += $quantidade;
                }
                if($acao === 'especial') {
                    $linha['quantidade'] += $quantidade;
                }
                if($acao === 'atualizar') {
                    $linha['quantidade'] = $quantidade;
                }
            }
            return $linha;
        }, $produtos);
        return $produtos;
    }

    private function removeProduto(array $produtos, string $slug)
    {
        return array_filter($produtos, function ($linha) use($slug) {
            return $linha['slug'] != $slug;
        });
    }
}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BairroModel;
use App\Models\FormaPagamentoModel;
use App\Models\PedidoModel;
use Config\Services;

class Checkout extends BaseController
{
    private $usuario;
    private $formaPagamentoModel;
    private $bairroModel;
    private $validation;
    private $pedidoModel;

    public function __construct()
    {
        parent::__construct();
        $this->validation = service('validation');
        $this->formaPagamentoModel = new FormaPagamentoModel();
        $this->bairroModel = new BairroModel();
        $this->pedidoModel = new PedidoModel();
        $this->usuario = service('authentication')->getUserLogged();
    }

    public function index()
    {
        if(!session()->has('carrinho') || count(session()->get('carrinho')) < 1) {
            return redirect()->to(site_url('carrinho'));

        }

        $carrinho = session()->get('carrinho');
        $total = 0;
        foreach ($carrinho as &$produto) {
            $preco = str_replace (',', '.', str_replace ('.', '', $produto['preco']));
            $quantidade = str_replace (',', '.', str_replace ('.', '', $produto['quantidade']));
            $produto['subtotal'] = $preco * $quantidade;
            $total += $produto['subtotal'];
        }

        $this->data['title'] = 'Finalizar pedido';
        $this->data['usuario'] = $this->usuario;
        $this->data['carrinho'] = $carrinho;
        $this->data['total'] = $total;
        $this->data['formas'] = $this->formaPagamentoModel->where('ativo', true)->findAll();
        return $this->display_template($this->smarty->setData($this->data)->view('Checkout/index'));
    }

    public function processar()
    {
        if(!$this->checkAbertura()) {
            $this->session->setFlashdata('msg', 'Estamos fechados no momento.');
            $this->session->setFlashdata('msg_type', 'alert-warning');
            return redirect()->back();
        }

        if($this->request->getPost()) {
            $checkoutPost = $this->request->getPost('checkout');
            $this->validation->setRules([
                'checkout.endereco_rua' => ['label' => 'Endere??o', 'rules' => 'required|max_length[50]'],
                'checkout.numero' => ['label' => 'N??mero', 'rules' => 'required|max_length[30]'],
                'checkout.referencia' => ['label' => 'Ponto de refer??ncia', 'rules' => 'required|max_length[50]'],
                'checkout.forma_id' => ['label' => 'Forma de pagamento', 'rules' => 'required|integer'],
                'checkout.bairro_slug' => ['label' => 'Endere??o de entrega', 'rules' => 'required|string|max_length[30]'],
            ]);
            if(!$this->validation->withRequest($this->request)->run()) {
                session()->remove('endereco_entrega');
                $this->session->setFlashdata('msg', $this->validation->getErrors());
                $this->session->setFlashdata('msg_type', 'alert-danger');
                return redirect()->back();
            }
            $forma = $this->formaPagamentoModel->where('id', $checkoutPost['forma_id'])->where('ativo', true)->first();
            if(is_null($forma)) {
                session()->remove('endereco_entrega');
                $this->session->setFlashdata('msg', 'Por favor escolha uma forma de pagamento e tente novamente');
                $this->session->setFlashdata('msg_type', 'alert-danger');
                return redirect()->back();
            }
            $bairro = $this->bairroModel->where('slug', $checkoutPost['bairro_slug'])->where('ativo', true)->first();
            if(is_null($bairro)) {
                session()->remove('endereco_entrega');
                $this->session->setFlashdata('msg', 'Por favor consulte a taxa de entrega e tente novamente');
                $this->session->setFlashdata('msg_type', 'alert-danger');
                return redirect()->back();
            }

            if(!session()->has('endereco_entrega')) {
                $this->session->setFlashdata('msg', 'Por favor consulte a taxa de entrega e tente novamente');
                $this->session->setFlashdata('msg_type', 'alert-danger');
                return redirect()->back();
            }

            $carrinho = session()->get('carrinho');


            $codigoPedido = $this->pedidoModel->geraCodigoPedido();
            $valor_produtos = number_format($this->somaValorProdutosCarrinho(), 2);
            $valor_produtos = str_replace (',', '.', $valor_produtos);
            $valor_entrega = number_format($bairro['valor_entrega'], 2);
            $valor_entrega = str_replace (',', '.', $valor_entrega);
            $valor_pedido = number_format($valor_produtos + $valor_entrega, 2);
            $pedido = [
                'usuario_id' => $this->usuario['id'],
                'codigo' => $codigoPedido,
                'forma_pagamento' => $forma['nome'],
                'produtos' => serialize($carrinho),
                'valor_produtos' => $valor_produtos,
                'valor_entrega' => $valor_entrega,
                'valor_pedido' => number_format($valor_produtos + $valor_entrega, 2),
                'endereco_entrega' => session()->get('endereco_entrega'). ' - N??mero ' .$checkoutPost['numero'],
            ];
            if($forma['id'] == 1 ){
                if(isset($checkoutPost['sem_troco'])) {
                    $pedido['observacoes'] = 'Ponto de refer??ncia: '.$checkoutPost['referencia']. ' - N??mero'.$checkoutPost['numero']. ' . Voc?? informou que n??o precisa de troco';
                }
                if(isset($checkoutPost['troco_para'])) {
                    $troco_para = str_replace(',', '.', $checkoutPost['troco_para']);
                    if($troco_para < 1)  {
                        $this->session->setFlashdata('msg', 'Ao escolher que o troco deve ser enviado, por favor informe um valor maior que zero ou marque que n??o precisa de troco.');
                        $this->session->setFlashdata('msg_type', 'alert-warning');
                        return redirect()->back();
                    }
                    if($troco_para < $valor_pedido) {
                        $this->session->setFlashdata('msg', 'O troco n??o pode ser menor que o valor do pedido.');
                        $this->session->setFlashdata('msg_type', 'alert-warning');
                        return redirect()->back();
                    }
                    $pedido['observacoes'] = 'Ponto de refer??ncia: '.$checkoutPost['referencia']. ' - N??mero '.$checkoutPost['numero']. ' . Voc?? informou que precisa de troco para R$ '. number_format($troco_para, 2, ',', '.');
                }
            } else {
                $pedido['observacoes'] = 'Ponto de refer??ncia: '.$checkoutPost['referencia']. ' - N??mero '.$checkoutPost['numero'];
            }
            
            $saved = $this->pedidoModel->save($pedido);
            if($saved){
                $pedido['usuario'] = $this->usuario;
                $this->enviaEmailPedidoRealizado($pedido);
                session()->remove('carrinho');
                session()->remove('endereco_entrega');
                return redirect()->to(site_url('checkout/sucesso/'.$pedido['codigo']));

            } else {
                $this->session->setFlashdata('msg', 'N??o conseguimos salvar seu pedido, por favor entre em contato conosco.');
                $this->session->setFlashdata('msg_type', 'alert-warning');
                return redirect()->back();
            }
        }
        return redirect()->back();
    }

    public function sucesso($codigoPedido = null)
    {
        $pedido = $this->buscaPedidoOu404($codigoPedido);

        $this->data['title'] = 'Pedido '. $codigoPedido . ' realizado com sucesso';
        $this->data['pedido'] = $pedido;
        $this->data['produtos'] = unserialize($pedido['produtos']);
        return $this->display_template($this->smarty->setData($this->data)->view('Checkout/sucesso'));
    }

    private function buscaPedidoOu404(string $codigoPedido = null)
    {
        if (!$codigoPedido || !$pedido = $this->pedidoModel->where('codigo', $codigoPedido)->where('usuario_id', $this->usuario['id'])->first()) {
            return view('errors/404');
        }
        return $pedido;
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

                $bairro = $this->bairroModel->select('nome, valor_entrega, slug')->where('slug', $bairroRetornoSlug)->where('ativo', true)->first();

                if(is_null($bairro) || is_null($consulta->bairro)) {
                    $data['code'] = 503;
                    $data['status'] = 'error';
                    $data['detail'] = '';
                    $data['msg_error'] = 'N??o atendemos o bairro: '.$consulta->bairro. ' - '. $consulta->localidade. ' - CEP '. $consulta->cep.' - '. $consulta->uf;
                    return $this->response->setJSON($data);
                }
                $valor_entrega = number_format($bairro['valor_entrega'], 2, ',', '.');
                $data['code'] = 200;
                $data['status'] = 'success';
                $data['detail'] = [
                    'valor_entrega' => 'R$ '.$valor_entrega,
                    'bairro' => 'Valor de entrega para o bairro: '.$consulta->bairro. ' - '. $consulta->localidade. ' - CEP '.$consulta->cep. ' - '. $consulta->uf. ' - R$ '. $valor_entrega,
                    'logradouro' => $consulta->logradouro,
                    'bairro_slug' =>$bairro['slug']
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
                $endereco = $consulta->logradouro. ' - '. $consulta->cep.' - '.$consulta->bairro. ' - '.$consulta->localidade.' - '.$consulta->uf;
                $data['detail']['endereco'] = $endereco;
                session()->set('endereco_entrega', $endereco);
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

    private function somaValorProdutosCarrinho()
    {
        $carrinho = session()->get('carrinho');
        $total = 0;
        foreach ($carrinho as $produto) {
            $preco = str_replace (',', '.', str_replace ('.', '', $produto['preco']));
            $quantidade = str_replace (',', '.', str_replace ('.', '', $produto['quantidade']));
            $total += ($preco * $quantidade);
        }
        return $total;
    }

    private function enviaEmailPedidoRealizado(array $pedido)
    {
        $email = Services::email();
        $email->setFrom('no-reply@pizza-planet.fun', 'Pizza Planet');
        $email->setTo($pedido['usuario']['email']);
        $email->setSubject("Pedido ".$pedido['codigo']." realizado com sucesso!");

        $mensagem = view('Checkout/pedido_email', ['pedido' => $pedido]);
        $email->setMessage($mensagem);
        $email->send();
    }
}

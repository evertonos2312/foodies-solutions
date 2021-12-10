<?php

namespace App\Controllers\Admin;

use App\Models\EntregadorModel;
use App\Models\PedidoModel;
use App\Models\PedidoProdutoModel;
use Config\Services;

class Pedidos extends  AdminBaseController
{
    private $pedidoModel;
    private $entregadorModel;
    public function __construct()
    {
        parent::__construct();
        $this->pedidoModel = new PedidoModel();
        $this->data['active'] = 'pedidos';
        $this->entregadorModel = new EntregadorModel();
        $this->breadcrumb->add('Pedidos', '/admin/pedidos');
    }

    public function index()
    {
        $filtro = [
            'per_page' => !empty($this->request->getPost('per_page')) ? $this->request->getPost('per_page'): 10,
        ];
        $pedidos = $this->pedidoModel->listaTodosPedidos()->paginate($filtro['per_page']);
        $pager = $this->pedidoModel->pager;
        $pager_links = $pager->links('default', 'bootstrap_pager');


        $this->data['title'] = 'Pedidos realizados';
        $this->data['pedidos'] = $pedidos;
        $this->data['pager'] = $pager;
        $this->data['pager_links'] = $pager_links;
        $this->data['filtro'] = $filtro;
        return $this->render($this->data, 'Admin/Pedidos/index');
    }

    public function procurar()
    {
        if ($this->request->isAJAX()) {
            $retorno = [];
            $busca = $this->request->getGet('term');
            if (!empty($busca)) {
                $pedidos = $this->pedidoModel->procurar($busca);
                foreach ($pedidos as $pedido) {
                    $data['value'] = $pedido['codigo'];
                    $retorno[] = $data;
                }
                return $this->response->setJSON($retorno);
            }
        }
        return view('errors/404_admin');
    }

    public function show($codigo_pedido = null)
    {
        if(is_null($codigo_pedido)) {
            return view('errors/404_admin');
        }
        $pedido = $this->pedidoModel->buscaPedidoOu404($codigo_pedido);
        if(!$pedido) {
            return view('errors/404_admin');
        }
        $this->data['produtos'] = unserialize($pedido['produtos']);
        $this->data['title'] = 'Detalhando o pedido #'.$codigo_pedido;
        $this->data['pedido'] = $pedido;
        return $this->render($this->data, 'Admin/Pedidos/show');
    }


    public function editar($codigo_pedido = null)
    {
        if(is_null($codigo_pedido)) {
            return view('errors/404_admin');
        }
        $pedido = $this->pedidoModel->buscaPedidoOu404($codigo_pedido);
        if(!$pedido) {
            return view('errors/404_admin');
        }
        if($pedido['situacao'] == 2) {
            $this->session->setFlashdata('msg', 'Esse pedido já foi entregue e portanto não é possível editá-lo');
            $this->session->setFlashdata('msg_type', 'alert-info');
            return redirect()->back();
        }
        if($pedido['situacao'] == 3) {
            $this->session->setFlashdata('msg', 'Esse pedido já foi cancelado e portanto não é possível editá-lo');
            $this->session->setFlashdata('msg_type', 'alert-info');
            return redirect()->back();
        }

        $this->data['produtos'] = unserialize($pedido['produtos']);
        $this->data['title'] = 'Editando o pedido #'.$codigo_pedido;
        $this->data['pedido'] = $pedido;
        $this->data['entregadores'] = $this->entregadorModel->formDropDown();
        return $this->render($this->data, 'Admin/Pedidos/form');
    }

    public function atualizar()
    {
        if($this->request->getPost()){
            $codigo_pedido = $this->request->getPost('codigo_pedido');
            if(is_null($codigo_pedido)) {
                $this->session->setFlashdata('msg', 'Ação não permitida.');
                $this->session->setFlashdata('msg_type', 'alert-info');
                return redirect()->back();
            }
            $pedido = $this->pedidoModel->buscaPedidoOu404($codigo_pedido);

            if(!$pedido) {
                $this->session->setFlashdata('msg', 'Pedido não encontrado');
                $this->session->setFlashdata('msg_type', 'alert-warning');
                return redirect()->back();
            }

            if($pedido['situacao'] == 2 || $pedido['situacao'] == 3) {
                $this->session->setFlashdata('msg', 'Esse pedido já foi entregue e portanto não é possível editá-lo');
                $this->session->setFlashdata('msg_type', 'alert-info');
                return redirect()->back();
            }
            if($pedido['situacao'] == 4) {
                $this->session->setFlashdata('msg', 'Esse pedido já foi cancelado e portanto não é possível editá-lo');
                $this->session->setFlashdata('msg_type', 'alert-info');
                return redirect()->back();
            }

            $pedidoPost = $this->request->getPost();
            if(!isset($pedidoPost['situacao'])) {
                $this->session->setFlashdata('msg', 'Escolha a situação do pedido');
                $this->session->setFlashdata('msg_type', 'alert-warning');
                return redirect()->back();
            }
            if($pedidoPost['situacao'] == 1) {
                if($pedidoPost['entregador_id'] == 0) {
                    $this->session->setFlashdata('msg', 'Pedidos que saíram para entrega, devem conter um entregador.');
                    $this->session->setFlashdata('msg_type', 'alert-warning');
                    return redirect()->back();
                }
                $pedido['entregador_id'] =$pedidoPost['entregador_id'];
            }
            if($pedido['situacao'] == 0) {
                if($pedidoPost['situacao'] == 2 ) {
                    $this->session->setFlashdata('msg', 'Por favor selecione a opção <strong>Saiu para entrega</strong> antes de selecionar <strong>Entregue</strong>');
                    $this->session->setFlashdata('msg_type', 'alert-warning');
                    return redirect()->back();
                }
            }

            if($pedidoPost['situacao'] != 1) {
                unset($pedidoPost['entregador_id']);
            }

            if($pedidoPost['situacao'] == 4) {
                $pedidoPost['entregador_id'] = null;
            }

            $situacaoAnteriorPedido = $pedido['situacao'];

            $pedido['situacao'] =$pedidoPost['situacao'];



            $saved = $this->pedidoModel->save($pedido);
            if($saved) {

                if($pedido['situacao'] == 1) {
                    $this->enviaEmailPedidoSaiuEntrega($pedido);
                }
                if($pedido['situacao'] == 2) {
                    $this->enviaEmailPedidoFoiEntregue($pedido);
                    $this->insereProdutosDoPedido($pedido);
                }
                if($pedido['situacao'] == 3) {
                    $this->insereProdutosDoPedido($pedido);
                }

                if($pedido['situacao'] == 4) {
                    $this->enviaEmailPedidoFoiCancelado($pedido);
                    if($situacaoAnteriorPedido == 1) {

                        $this->session->setFlashdata('msg', 'Pedido cancelado - Administrador, esse pedido está em rota de entrega. Por favor entre em contato com o entregador para que ele retorne.');
                        $this->session->setFlashdata('msg_type', 'alert-danger');
                        return redirect()->to(site_url('admin/pedidos/show/'.$pedido['codigo']));
                    }
                }

                $this->session->setFlashdata('msg', 'Pedido atualizado com sucesso');
                $this->session->setFlashdata('msg_type', 'alert-success');
                return redirect()->to(site_url('admin/pedidos/show/'.$pedido['codigo']));
            } else {
                $this->session->setFlashdata('msg', $this->pedidoModel->errors());
                $this->session->setFlashdata('msg_type', 'alert-danger');
                return redirect()->back();
            }
        }
        $this->session->setFlashdata('msg', 'Ação não permitida.');
        $this->session->setFlashdata('msg_type', 'alert-info');
        return redirect()->back();
    }

    private function insereProdutosDoPedido($pedido)
    {
        $pedidoProdutoModel = new PedidoProdutoModel();
        $produtos = unserialize($pedido['produtos']);

        $produtosDoPedido = [];
        foreach ($produtos as $produto) {
            $produtosDoPedido[] = [
                'pedido_id' => $produto['id'],
                'produto' => $produto['nome'],
                'quantidade' => $produto['quantidade'],
            ];
        }
        $pedidoProdutoModel->insertBatch($produtosDoPedido);
    }

    private function enviaEmailPedidoSaiuEntrega(array $pedido)
    {
        $email = Services::email();
        $email->setFrom('no-reply@pizza-planet.fun', 'Pizza Planet');
        $email->setTo($pedido['email']);
        $email->setSubject("Que maravilha! Seu pedido #".$pedido['codigo']." já está chegando.");

        $mensagem = view('Admin/Pedidos/saiu_entrega_email', ['pedido' => $pedido]);
        $email->setMessage($mensagem);
        $email->send();
    }

    private function enviaEmailPedidoFoiEntregue(array $pedido)
    {
        $email = Services::email();
        $email->setFrom('no-reply@pizza-planet.fun', 'Pizza Planet');
        $email->setTo($pedido['email']);
        $email->setSubject("Que maravilha! Seu pedido #".$pedido['codigo']." foi entregue.");

        $mensagem = view('Admin/Pedidos/foi_entregue_email', ['pedido' => $pedido]);
        $email->setMessage($mensagem);
        $email->send();
    }

    private function enviaEmailPedidoFoiCancelado(array $pedido)
    {
        $email = Services::email();
        $email->setFrom('no-reply@pizza-planet.fun', 'Pizza Planet');
        $email->setTo($pedido['email']);
        $email->setSubject("Sentimos muito,seuu pedido #".$pedido['codigo']." foi cancelado.");

        $mensagem = view('Admin/Pedidos/cancelado_email', ['pedido' => $pedido]);
        $email->setMessage($mensagem);
        $email->send();
    }

}
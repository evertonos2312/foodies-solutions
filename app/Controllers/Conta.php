<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PedidoModel;
use App\Models\UsuarioModel;

class Conta extends BaseController
{
    private $usuario;
    private $usuarioModel;
    private $pedidoModel;
    public function __construct()
    {
        parent::__construct();
        $this->usuarioModel = new UsuarioModel();
        $this->pedidoModel = new PedidoModel();
        $this->usuario = service('authentication')->getUserLogged();
    }

    public function index()
    {
        $pedidos = $this->pedidoModel->where('usuario_id', $this->usuario['id'])->orderBy('criado_em', 'desc')->findAll();

        if(!is_null($pedidos)) {
            foreach ($pedidos as &$pedido) {
                $pedido['produtos'] = unserialize($pedido['produtos']);
            }
            $this->data['pedidos'] = $pedidos;
        }

        $this->data['title'] = 'Meus pedidos';
        return $this->display_template($this->smarty->setData($this->data)->view('Conta/index'));
    }

    public function show()
    {
        $this->data['usuario'] = $this->usuario;
        $this->data['title'] = 'Meus dados';
        return $this->display_template($this->smarty->setData($this->data)->view('Conta/show'));
    }

    public function editar()
    {
        if(!session()->has('pode_editar_ate')) {
            return redirect()->to(site_url('conta/autenticar'));
        }

        if(session()->get('pode_editar_ate') < time()) {
            return redirect()->to(site_url('conta/autenticar'));
        }

        $this->data['usuario'] = $this->usuario;
        $this->data['title'] = 'Editar meus dados';
        return $this->display_template($this->smarty->setData($this->data)->view('Conta/editar'));
    }

    public function autenticar()
    {
        $this->data['usuario'] = $this->usuario;
        $this->data['title'] = 'Autenticar';
        return $this->display_template($this->smarty->setData($this->data)->view('Conta/autenticar'));
    }

    public function processar()
    {
        if($this->request->getPost()) {
            if(service('authentication')->verificaPassword($this->request->getPost('password'))) {
                session()->set('pode_editar_ate', time() + 300);
                return redirect()->to(site_url('conta/editar'));
            }
            $this->session->setFlashdata('msg', 'Senha inválida.');
            $this->session->setFlashdata('msg_type', 'alert-danger');
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function atualizar()
    {
        if($this->request->getPost()) {
            $this->usuario['nome'] = $this->request->getPost('nome');
            $this->usuario['email'] = $this->request->getPost('email');
            $this->usuario['telefone'] = $this->request->getPost('telefone');

            $saved = $this->usuarioModel->save($this->usuario);
            if($saved) {
                $this->session->setFlashdata('msg', 'Dados atualizados com sucesso');
                $this->session->setFlashdata('msg_type', 'alert-success');
                return redirect()->to(site_url('conta/show'));
            } else {
                $this->session->setFlashdata('msg', $this->usuarioModel->errors());
                $this->session->setFlashdata('msg_type', 'alert-danger');
                return redirect()->back();
            }
        }
        return redirect()->back();
    }

    public function editarSenha()
    {
        $this->data['usuario'] = $this->usuario;
        $this->data['title'] = 'Alterar senha de acesso';
        return $this->display_template($this->smarty->setData($this->data)->view('Conta/editar_senha'));
    }

    public function atualizarSenha()
    {
        if($this->request->getPost()) {
            if(service('authentication')->verificaPassword($this->request->getPost('current_password'))) {
                $this->usuario['password'] = $this->request->getPost('password');
                $this->usuario['password_confirmation'] = $this->request->getPost('password_confirmation');

                $saved = $this->usuarioModel->save($this->usuario);
                if($saved) {
                    $this->session->setFlashdata('msg', 'Senha atualizada com sucesso');
                    $this->session->setFlashdata('msg_type', 'alert-success');
                    return redirect()->to(site_url('conta/show'));
                } else {
                    $this->session->setFlashdata('msg', $this->usuarioModel->errors());
                    $this->session->setFlashdata('msg_type', 'alert-danger');
                    return redirect()->back();
                }


            }
            $this->session->setFlashdata('msg', 'Senha inválida.');
            $this->session->setFlashdata('msg_type', 'alert-danger');
            return redirect()->back();
        }
        return redirect()->back();
    }
}

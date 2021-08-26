<?php

namespace App\Controllers\Admin;

use App\Models\UsuarioModel;

class Usuarios extends AdminBaseController
{
    public $data = array();
    private $usuarioModel;

    public function __construct()
    {
        parent::__construct();
        $this->usuarioModel = new UsuarioModel();
        $this->data['active'] = 'usuarios';
        $this->breadcrumb->add('Usuários', '/admin/usuarios');
    }

    public function index()
    {
        $usuarios = $this->usuarioModel->findAll();
        foreach ($usuarios as $key => $usuario) {
            $usuarios[$key]['ativo'] = $usuario['ativo'] == 1 ? 'Ativo' : 'Inativo';
            $usuarios[$key]['ativo_class'] = $usuario['ativo'] == 1 ? 'alert-success' : 'alert-danger';
        }

        $this->data['title'] = 'Lista de usuários';
        $this->data['usuarios'] = $usuarios;

        return $this->render($this->data, 'Admin/Usuarios/index');
    }

    public function procurar()
    {
        if ($this->request->isAJAX()) {
            $retorno = [];
            $busca = $this->request->getGet('term');
            if (!empty($busca)) {
                $usuarios = $this->usuarioModel->procurar($busca);
                foreach ($usuarios as $usuario) {
                    $data['id'] = $usuario['id'];
                    $data['value'] = $usuario['nome'];
                    $retorno[] = $data;
                }
                return $this->response->setJSON($retorno);
            }
        }
        return view('errors/404_admin');
    }

    public function show($id = null)
    {
        if (!is_null($id)) {
            $usuario = $this->buscaUsuarioOu404($id);

            $usuario['tipo'] = $usuario['is_admin'] == 1 ? 'Administrador' : 'Cliente';
            $usuario['ativo'] = $usuario['ativo'] == 1 ? 'Ativo' : 'Inativo';

            $this->data['title'] = $usuario['nome'];
            $this->data['usuario'] = $usuario;

            $this->breadcrumb->add($usuario['nome'], '/admin/usuarios/show/');
            return $this->render($this->data, 'Admin/Usuarios/show');
        }
        return view('errors/404_admin');
    }

    public function editar($id = null)
    {

        if (!is_null($id)) {
            $usuario = $this->buscaUsuarioOu404($id);

            $usuario['tipo'] = $usuario['is_admin'] == 1 ? 'Administrador' : 'Cliente';
            $usuario['ativo_name'] = $usuario['ativo'] == 1 ? 'Ativo' : 'Inativo';

            $this->data['title'] = $usuario['nome'];
            $this->data['usuario'] = $usuario;

            $this->breadcrumb->add($usuario['nome'], '/admin/usuarios/editar/');
            return $this->render($this->data, 'Admin/Usuarios/form');
        }
        return view('errors/404_admin');
    }

    public function criar()
    {

        $this->data['title'] = 'Criando novo usuário';

        $this->breadcrumb->add('Criar Usuário', '/admin/usuarios/criar/');
        return $this->render($this->data, 'Admin/Usuarios/form');
    }

    public function salvar()
    {
        if ($this->request->getPost()) {
            $id = $this->request->getPost('id_hidden');

            $newUser = [
                'nome' => $this->request->getPost('nome'),
                'email' => $this->request->getPost('email'),
                'cpf' => $this->request->getPost('cpf'),
                'telefone' => $this->request->getPost('telefone'),
                'is_admin' => $this->request->getPost('is_admin'),
                'ativo' => $this->request->getPost('ativo'),
            ];
            if ($id) {
                $usuario = $this->buscaUsuarioOu404($id);
                $newUser['id'] = $id;
                $this->usuarioModel->unsetPassword();
            } else {
                $newUser['password'] = $this->request->getPost('password');
                $newUser['password_confirmation'] = $this->request->getPost('password_confirmation');
            }

            $saved = $this->usuarioModel->protect(false)->save($newUser);
            if ($saved) {
                $this->session->setFlashdata('msg', 'Usuário salvo com sucesso');
                $this->session->setFlashdata('msg_type', 'success');
                if (empty($id)) {
                    $id = $this->usuarioModel->getInsertID();
                }
                return redirect()->to("admin/usuarios/show/".$id);
            } else {
                $this->data['msg'] = $this->usuarioModel->errors();
                $this->data['msg_type'] = 'alert-danger';
                $this->data['id'] = $id;
                if (!empty($usuario)) {
                    $this->breadcrumb->add($usuario['nome'], '/admin/usuarios/editar/');
                } else {
                    $this->breadcrumb->add('Criar Usuário', '/admin/usuarios/criar/');
                }
                return $this->render($this->data, 'Admin/Usuarios/form');
            }
        }
        $this->session->setFlashdata('msg', 'A ação que você requisitou não é permitida.');
        $this->session->setFlashdata('msg_type', 'danger');
        return redirect()->to(base_url() . '/admin/usuarios');
    }
    
    private function buscaUsuarioOu404(int $id = null)
    {
        if (!$id || !$usuario = $this->usuarioModel->where('id', $id)->first()) {
            return view('errors/404_admin');
        }
        return $usuario;
    }

    public function excluir()
    {
        if ($this->request->isAJAX()) {
            $data = array();
            $user_id = $this->request->getPost('user_id');
            $data['token'] = csrf_hash();
            if (!empty($user_id)) {
                $usuario = $this->buscaUsuarioOu404($user_id);
                if ($usuario['is_admin'] != 1) {
                    if ($this->usuarioModel->delete($user_id)) {
                        $data['code'] = 200;
                        $data['status'] = 'success';
                        $data['detail'] = ['id' => $user_id];
                        $data['msg_error'] = '';
                    } else {
                        $data['code'] = 503;
                        $data['status'] = 'error';
                        $data['detail'] = '';
                        $data['msg_error'] = 'Erro ao excluir registro, verifique os dados enviados.';
                    }
                } else {
                    $data['code'] = 403;
                    $data['status'] = 'error';
                    $data['detail'] = '';
                    $data['msg_error'] = 'Não é possível excluir um usuário Administrador';
                    return $this->response->setJSON($data);
                }
                return $this->response->setJSON($data);
            }
        }
        return view('errors/404_admin');
    }
}

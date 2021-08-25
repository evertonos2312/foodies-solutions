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
            return $this->render($this->data, 'Admin/Usuarios/editar');
        }
        return view('errors/404_admin');
    }

    public function atualizar()
    {
        if ($this->request->getPost()) {
            $id = $this->request->getPost('id');

            $newUser = [
                'nome' => $this->request->getPost('nome'),
                'email' => $this->request->getPost('email'),
                'cpf' => $this->request->getPost('cpf'),
                'telefone' => $this->request->getPost('telefone'),
                'is_admin' => $this->request->getPost('is_admin'),
            ];
            if ($id) {
                $newUser['id'] = $id;
                $newUser['ativo'] = $this->request->getPost('ativo');
            } else {
                $newUser['ativo'] = 0;
            }

            $saved = $this->usuarioModel->save($newUser);
            if ($saved) {
                $this->session->setFlashdata('msg', 'Usuário salvo com sucesso');
                $this->session->setFlashdata('msg_type', 'success');
            } else {
                $this->data['msg'] = $this->usuarioModel->errors();
                $this->data['msg_type'] = 'alert-danger';
                $this->data['id'] = $id;
                return $this->render($this->data, 'Admin/Usuarios/editar');
            }
            return redirect()->to(base_url() . '/admin/usuarios');
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
}

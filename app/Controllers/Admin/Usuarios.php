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
            $post = $this->request->getPost();
            $rules = [
                'nome' => [
                    'rules' => 'required',
                    'label' => 'Pergunta',
                    'errors' => ['required' => 'O campo Nome é obrigatório.']
                ],
                'id' => [
                    'rules' => 'required|is_natural_no_zero',
                    'label' => 'Produto',
                    'errors' => ['required' => 'O campo ID é obrigatório.']
                ],
                'email' => [
                    'rules' => 'required|valid_email',
                    'label' => 'E-mail',
                    'errors' => ['required' => 'O campo E-mail é obrigatório.',
                                'valid_email' => 'Digite um e-mail válido.']
                ],
                'cpf' => [
                    'rules' => 'required',
                    'label' => 'CPF',
                    'errors' => ['required' => 'O campo CPF é obrigatório.']
                ],
                'telefone' => [
                    'rules' => 'required',
                    'label' => 'Resposta',
                    'errors' => ['required' => 'O campo Telefone é obrigatório.']
                ],
                'ativo' => [
                    'rules' => 'required',
                    'label' => 'Status',
                    'errors' => ['required' => 'O campo Status é obrigatório.']
                ],
                'is_admin' => [
                    'rules' => 'required',
                    'label' => 'Perfil',
                    'errors' => ['required' => 'O campo Perfil é obrigatório.']
                ],
            ];

            if ($this->validate($rules)) {
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
                    $newUser['situacao'] = 0;
                }

                $saved = $this->usuarioModel->save($newUser);
                if ($saved) {
                    $this->session->setFlashdata('msg', 'Usuário salvo com sucesso');
                    $this->session->setFlashdata('msg_type', 'success');
                } else {
                    $this->session->setFlashdata('msg', 'Ops, erro ao salvar registro, tente novamente mais tarde.');
                    $this->session->setFlashdata('msg_type', 'danger');
                }
                return redirect()->to(base_url() . '/admin/usuarios');

            } else {
                $this->data['msg'] = $this->validator->listErrors();
                $this->data['msg_type'] = 'alert-danger';
                $this->data['subtitle'] = !empty($post['id']) ? 'Editar' : 'Cadastrar';
                $this->data['id'] = $id;
                return $this->render($this->data, 'Admin/Usuarios/editar');
            }

        }
        return $this->render($this->data, 'Admin/Usuarios/editar');
    }
    
    private function buscaUsuarioOu404(int $id = null)
    {
        if (!$id || !$usuario = $this->usuarioModel->where('id', $id)->first()) {
            return view('errors/404_admin');
        }
        return $usuario;
    }
}

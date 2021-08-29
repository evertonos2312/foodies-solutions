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
        $options_perpage = [10, 20, 40];
        $filtro_status = $this->request->getPost('filtro_status');
        $filtro_tipo = $this->request->getPost('filtro_tipo');
        $results_perpage = $this->request->getPost('per_page');

        if ($this->request->getPost('per_page')) {
            $results_perpage = $this->request->getPost('per_page');
        }

        if (!is_null($results_perpage)) {
            $this->session->set('per_page', $results_perpage);
        }
        if (is_null($results_perpage)) {
            $results_perpage = $this->session->get('per_page');
        }

        if ($results_perpage == '') {
            $results_perpage = 10;
        }

        $status_options = [
            'Todos' => [
                'value' => 'todos',
                'nome' => 'Todos'
            ],
            'Ativo' => [
                'value' => 'ativo',
                'nome' => 'Ativo'
            ],
            'Inativo' => [
                'value' => 'inativo',
                'nome' => 'Inativo'
            ],
            
        ];
        $tipos_options = [
            'Todos' => [
                'value' => 'todos',
                'nome' => 'Todos'
            ],
            'Administrador' => [
                'value' => 'adm',
                'nome' => 'Administrador'
            ],
            'Cliente' => [
                'value' => 'cli',
                'nome' => 'Cliente'
            ],

        ];


        if (!is_null($filtro_status)) {
            $this->session->set('filtro_status', $filtro_status);
        }
        if (is_null($filtro_status)) {
            $filtro_status = $this->session->get('filtro_status');
            if (!$filtro_status) {
                $filtro_status = 'todos';
            }
        }

        if (!is_null($filtro_tipo)) {
            $this->session->set('filtro_tipo', $filtro_tipo);
        }
        if (is_null($filtro_tipo)) {
            $filtro_tipo = $this->session->get('filtro_tipo');
            if (!$filtro_tipo) {
                $filtro_tipo = 'todos';
            }
        }

        foreach ($status_options as $key => $status) {
            $result_status[$key]['status_nome'] = $status_options[$key]['nome'];
            $result_status[$key]['status_value'] = $status_options[$key]['value'];
            if ($filtro_status == $status_options[$key]['value']) {
                $result_status[$key]['status_selected'] = 'selected';
            } else {
                $result_status[$key]['status_selected'] = '';
            }
        }

        foreach ($tipos_options as $key => $status) {
            $result_tipo[$key]['tipos_nome'] = $tipos_options[$key]['nome'];
            $result_tipo[$key]['tipos_value'] = $tipos_options[$key]['value'];
            if ($filtro_tipo == $tipos_options[$key]['value']) {
                $result_tipo[$key]['tipos_selected'] = 'selected';
            } else {
                $result_tipo[$key]['tipos_selected'] = '';
            }
        }


        $results_perpage = null;
        if ($this->request->getPost('per_page')) {
            $results_perpage = $this->request->getPost('per_page');
        }


        foreach ($options_perpage as $key => $option) {
            if ($option == $results_perpage) {
                $options_perpage[$key] = [$option, 'selected'];
                break;
            }
        }

        $usuarios = $this->usuarioModel->addTipo($filtro_tipo)->addStatus($filtro_status)->paginate($results_perpage);
        $pager = $this->usuarioModel->pager;
        $pager_links = $pager->links('default', 'bootstrap_pager');
        foreach ($usuarios as $key => $usuario) {
            $usuarios[$key]['ativo'] = $usuario['ativo'] == 1 ? 'Ativo' : 'Inativo';
            $usuarios[$key]['tipo'] = $usuario['is_admin'] == 1 ? 'Administrador' : 'Cliente';
            $usuarios[$key]['ativo_class'] = $usuario['ativo'] == 1 ? 'alert-success' : 'alert-danger';
            $usuarios[$key]['tipo_class'] = $usuario['is_admin'] == 1 ? 'alert-warning' : 'alert-info';
            if ($usuario['is_master'] == 1) {
                $usuarios[$key]['tipo'] = 'Master';
                $usuarios[$key]['tipo_class'] = 'alert-dark';
            }
        }

        $this->data['title'] = 'Lista de usuários';
        $this->data['usuarios'] = $usuarios;
        $this->data['pager'] = $pager;
        $this->data['pager_links'] = $pager_links;
        $this->data['results_perpage'] = $results_perpage;
        $this->data['perpage_options'] = $options_perpage;
        $this->data['filtro_status'] = $filtro_status;
        $this->data['filtro_tipo'] = $filtro_tipo;
        $this->data['tipos_options'] = $result_tipo;
        $this->data['status_options'] = $result_status;


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
        $session = session()->get('auth_user');
        if (!is_null($id)) {
            $usuario = $this->buscaUsuarioOu404($id);
            if ($usuario['is_admin']) {
                if ($session['id'] != $id && !$session['is_master']) {
                    $this->session->setFlashdata('msg', "Não é possível editar outro Administrador.");
                    $this->session->setFlashdata('msg_type', 'alert-danger');
                    return redirect()->to(site_url('/admin/usuarios/index'));
                }
            }
            if ($usuario['is_master'] && !$session['is_master']) {
                $this->session->setFlashdata('msg', "Não é possível editar este usuário.");
                $this->session->setFlashdata('msg_type', 'alert-danger');
                return redirect()->to(site_url('/admin/usuarios/index'));
            }

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
                $this->session->setFlashdata('msg_type', 'alert-success');
                if (empty($id)) {
                    $id = $this->usuarioModel->getInsertID();
                }
                return redirect()->to("admin/usuarios/show/" . $id);
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
        $this->session->setFlashdata('msg_type', 'alert-danger');
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
            $session = session()->get('auth_user');
            if (!empty($user_id)) {
                $usuario = $this->buscaUsuarioOu404($user_id);
                if ($session['is_master'] == 1) {
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
                    return $this->response->setJSON($data);
                }
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

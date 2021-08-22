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

        return $this->display_template($this->smarty->setData($this->data)->view('Admin/Usuarios/index'));
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
            return $this->display_template($this->smarty->setData($this->data)->view('Admin/Usuarios/show'));
        }
        return view('errors/404_admin');
    }

    public function editar($id = null)
    {

        if (!is_null($id)) {
            $usuario = $this->buscaUsuarioOu404($id);

            $usuario['tipo'] = $usuario['is_admin'] == 1 ? 'Administrador' : 'Cliente';
            $usuario['ativo'] = $usuario['ativo'] == 1 ? 'Ativo' : 'Inativo';

            $this->data['title'] = $usuario['nome'];
            $this->data['usuario'] = $usuario;
            return $this->display_template($this->smarty->setData($this->data)->view('Admin/Usuarios/editar'));
        }
        return view('errors/404_admin');
    }
    
    private function buscaUsuarioOu404(int $id = null)
    {
        if (!$id || !$usuario = $this->usuarioModel->where('id', $id)->first()) {
            return view('errors/404_admin');
        }
        return $usuario;
    }
}

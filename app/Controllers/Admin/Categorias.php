<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;

class Categorias extends AdminBaseController
{
    public $data = array();
    private $categoriaModel;

    public function __construct()
    {
        parent::__construct();
        $this->categoriaModel = new CategoriaModel();
        $this->data['active'] = 'produtos';
        $this->data['sub_active'] = 'categorias';
        $this->breadcrumb->add('Categorias', '/admin/categorias');
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

        if (!is_null($filtro_status)) {
            $this->session->set('filtro_status', $filtro_status);
        }
        if (is_null($filtro_status)) {
            $filtro_status = $this->session->get('filtro_status');
            if (!$filtro_status) {
                $filtro_status = 'todos';
            }
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

        foreach ($status_options as $key => $status) {
            $result_status[$key]['status_nome'] = $status_options[$key]['nome'];
            $result_status[$key]['status_value'] = $status_options[$key]['value'];
            if ($filtro_status == $status_options[$key]['value']) {
                $result_status[$key]['status_selected'] = 'selected';
            } else {
                $result_status[$key]['status_selected'] = '';
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


        $categorias = $this->categoriaModel->addStatus($filtro_status)->paginate($results_perpage);
        $pager = $this->categoriaModel->pager;
        $pager_links = $pager->links('default', 'bootstrap_pager');

        foreach ($categorias as $key => $categoria) {
            $categorias[$key]['ativo'] = $categoria['ativo'] == 1 ? 'Ativo' : 'Inativo';
            $categorias[$key]['ativo_class'] = $categoria['ativo'] == 1 ? 'alert-success' : 'alert-danger';
        }

        
        $this->data['title'] = 'Lista de categorias';
        $this->data['categorias'] = $categorias;
        $this->data['pager'] = $pager;
        $this->data['pager_links'] = $pager_links;
        $this->data['results_perpage'] = $results_perpage;
        $this->data['perpage_options'] = $options_perpage;
        $this->data['filtro_status'] = $filtro_status;
        $this->data['filtro_tipo'] = $filtro_tipo;
        $this->data['status_options'] = $result_status;


        return $this->render($this->data, 'Admin/Categorias/index');
    }

    public function editar($id = null)
    {
        if (!is_null($id)) {
            $categoria = $this->buscaCategoriaOu404($id);
            $categoria['ativo_name'] = $categoria['ativo'] == 1 ? 'Ativo' : 'Inativo';
            $this->data['title'] = $categoria['nome'];
            $this->data['categoria'] = $categoria;
            $this->breadcrumb->add($categoria['nome'], '/admin/categorias/editar/');
            return $this->render($this->data, 'Admin/Categorias/form');
        }
        return view('errors/404_admin');
    }

    public function procurar()
    {
        if ($this->request->isAJAX()) {
            $retorno = [];
            $busca = $this->request->getGet('term');
            if (!empty($busca)) {
                $categorias = $this->categoriaModel->procurar($busca);
                foreach ($categorias as $categoria) {
                    $data['id'] = $categoria['id'];
                    $data['value'] = $categoria['nome'];
                    $retorno[] = $data;
                }
                return $this->response->setJSON($retorno);
            }
        }
        return view('errors/404_admin');
    }

    public function criar()
    {

        $this->data['title'] = 'Criando nova categoria';

        $this->breadcrumb->add('Criar Categoria', '/admin/categorias/criar/');
        return $this->render($this->data, 'Admin/Categorias/form');
    }

    public function show($id = null)
    {
        if (!is_null($id)) {
            $categoria = $this->buscaCategoriaOu404($id);

            $categoria['ativo'] = $categoria['ativo'] == 1 ? 'Ativo' : 'Inativo';

            $this->data['title'] = $categoria['nome'];
            $this->data['categoria'] = $categoria;

            $this->breadcrumb->add($categoria['nome'], '/admin/categorias/show/');
            return $this->render($this->data, 'Admin/Categorias/show');
        }
        return view('errors/404_admin');
    }

    public function salvar()
    {
        if ($this->request->getPost()) {
            $id = $this->request->getPost('id_hidden');

            $newCategoria = [
                'nome' => $this->request->getPost('nome'),
                'ativo' => $this->request->getPost('ativo'),
            ];
            if (!empty($id)) {
                $categoria = $this->buscaCategoriaOu404($id);
                $newCategoria['id'] = $id;
            }

            $saved = $this->categoriaModel->protect(false)->save($newCategoria);
            if ($saved) {
                $this->session->setFlashdata('msg', 'Categoria salva com sucesso');
                $this->session->setFlashdata('msg_type', 'alert-success');
                if (empty($id)) {
                    $id = $this->categoriaModel->getInsertID();
                }
                return redirect()->to("admin/categorias/show/" . $id);
            } else {
                $this->data['msg'] = $this->categoriaModel->errors();
                $this->data['msg_type'] = 'alert-danger';
                $this->data['id'] = $id;
                if (!empty($categoria)) {
                    $this->breadcrumb->add($categoria['nome'], '/admin/categorias/editar/');
                } else {
                    $this->breadcrumb->add('Criar Categoria', '/admin/categorias/criar/');
                }
                return $this->render($this->data, 'Admin/Categorias/form');
            }
        }
        $this->session->setFlashdata('msg', 'A ação que você requisitou não é permitida.');
        $this->session->setFlashdata('msg_type', 'alert-danger');
        return redirect()->to(base_url() . '/admin/categorias');
    }

    private function buscaCategoriaOu404(int $id = null)
    {
        if (!$id || !$categoria = $this->categoriaModel->where('id', $id)->first()) {
            return view('errors/404_admin');
        }
        return $categoria;
    }

    public function excluir()
    {
        if ($this->request->isAJAX()) {
            $data = array();
            $categoria_id = $this->request->getPost('categoria_id');
            $data['token'] = csrf_hash();
            if (!empty($categoria_id)) {
                if ($this->categoriaModel->delete($categoria_id)) {
                    $data['code'] = 200;
                    $data['status'] = 'success';
                    $data['detail'] = ['id' => $categoria_id];
                    $data['msg_error'] = '';
                } else {
                    $data['code'] = 503;
                    $data['status'] = 'error';
                    $data['detail'] = '';
                    $data['msg_error'] = 'Erro ao excluir registro, verifique os dados enviados.';
                }
                return $this->response->setJSON($data);
            }
        }
        return view('errors/404_admin');
    }
}

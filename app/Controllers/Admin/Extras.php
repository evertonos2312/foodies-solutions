<?php

namespace App\Controllers\Admin;

use App\Models\ExtraModel;

class Extras extends AdminBaseController
{
    public $data = array();
    private $extraModel;

    public function __construct()
    {
        parent::__construct();
        $this->extraModel = new ExtraModel();
        $this->data['active'] = 'produtos';
        $this->data['sub_active'] = 'extras';
        $this->breadcrumb->add('Extras', '/admin/extras');
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


        $extras = $this->extraModel->addStatus($filtro_status)->paginate($results_perpage);
        $pager = $this->extraModel->pager;
        $pager_links = $pager->links('default', 'bootstrap_pager');

        foreach ($extras as $key => $extra) {
            $extras[$key]['ativo'] = $extra['ativo'] == 1 ? 'Ativo' : 'Inativo';
            $extras[$key]['ativo_class'] = $extra['ativo'] == 1 ? 'alert-success' : 'alert-danger';
        }


        $this->data['title'] = 'Extras de produtos';
        $this->data['extras'] = $extras;
        $this->data['pager'] = $pager;
        $this->data['pager_links'] = $pager_links;
        $this->data['results_perpage'] = $results_perpage;
        $this->data['perpage_options'] = $options_perpage;
        $this->data['filtro_status'] = $filtro_status;
        $this->data['filtro_tipo'] = $filtro_tipo;
        $this->data['status_options'] = $result_status;


        return $this->render($this->data, 'Admin/Extras/index');
    }

    public function procurar()
    {
        if ($this->request->isAJAX()) {
            $retorno = [];
            $busca = $this->request->getGet('term');
            if (!empty($busca)) {
                $extras = $this->extraModel->procurar($busca);
                foreach ($extras as $extra) {
                    $data['id'] = $extra['id'];
                    $data['value'] = $extra['nome'];
                    $retorno[] = $data;
                }
                return $this->response->setJSON($retorno);
            }
        }
        return view('errors/404_admin');
    }

    public function criar()
    {

        $this->data['title'] = 'Criando um extra de produto';

        $this->breadcrumb->add('Criar Extra', '/admin/extra/criar/');
        return $this->render($this->data, 'Admin/Extras/form');
    }

    public function editar($id = null)
    {
        if (!is_null($id)) {
            $extra = $this->buscaExtraOu404($id);
            $extra['ativo_name'] = $extra['ativo'] == 1 ? 'Ativo' : 'Inativo';
            $this->data['title'] = $extra['nome'];
            $this->data['extra'] = $extra;
            $this->breadcrumb->add($extra['nome'], '/admin/extras/editar/');
            return $this->render($this->data, 'Admin/Extras/form');
        }
        return view('errors/404_admin');
    }
    public function show($id = null)
    {
        if (!is_null($id)) {
            $extra = $this->buscaExtraOu404($id);

            $extra['ativo'] = $extra['ativo'] == 1 ? 'Ativo' : 'Inativo';

            $this->data['title'] = $extra['nome'];
            $this->data['extra'] = $extra;

            $this->breadcrumb->add($extra['nome'], '/admin/extras/show/');
            return $this->render($this->data, 'Admin/Extras/show');
        }
        return view('errors/404_admin');
    }

    public function salvar()
    {
        if ($this->request->getPost()) {
            $id = $this->request->getPost('id_hidden');

            $newExtra = [
                'nome' => $this->request->getPost('nome'),
                'preco' =>  $this->request->getPost('preco'),
                'descricao' => $this->request->getPost('descricao'),
                'ativo' => $this->request->getPost('ativo'),
            ];

            if ($id) {
                $extra = $this->buscaExtraOu404($id);
                $newExtra['id'] = $id;
            }

            $saved = $this->extraModel->protect(false)->save($newExtra);
            if ($saved) {
                $this->session->setFlashdata('msg', 'Extra salvo com sucesso');
                $this->session->setFlashdata('msg_type', 'alert-success');
                if (empty($id)) {
                    $id = $this->extraModel->getInsertID();
                }
                return redirect()->to("admin/extras/show/" . $id);
            } else {
                $this->data['msg'] = $this->extraModel->errors();
                $this->data['msg_type'] = 'alert-danger';
                $this->data['id'] = $id;
                if (!empty($extra)) {
                    $this->breadcrumb->add($extra['nome'], '/admin/extras/editar/');
                } else {
                    $this->breadcrumb->add('Criar Extra de Produto', '/admin/extras/criar/');
                }
                return $this->render($this->data, 'Admin/Extras/form');
            }
        }
        $this->session->setFlashdata('msg', 'A ação que você requisitou não é permitida.');
        $this->session->setFlashdata('msg_type', 'alert-danger');
        return redirect()->to(base_url() . '/admin/extras');
    }

    private function buscaExtraOu404(int $id = null)
    {
        if (!$id || !$extra = $this->extraModel->where('id', $id)->first()) {
            return view('errors/404_admin');
        }
        return $extra;
    }

    public function excluir()
    {
        if ($this->request->isAJAX()) {
            $data = array();
            $extra_id = $this->request->getPost('extra_id');
            $data['token'] = csrf_hash();
            if (!empty($extra_id)) {
                if ($this->extraModel->delete($extra_id)) {
                    $data['code'] = 200;
                    $data['status'] = 'success';
                    $data['detail'] = ['id' => $extra_id];
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
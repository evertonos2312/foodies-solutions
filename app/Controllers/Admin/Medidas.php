<?php

namespace App\Controllers\Admin;

use App\Models\MedidaModel;

class Medidas extends AdminBaseController
{
    public $data = array();
    private $medidaModel;

    public function __construct()
    {
        parent::__construct();
        $this->medidaModel = new MedidaModel();
        $this->data['active'] = 'produtos';
        $this->data['sub_active'] = 'medidas';
        $this->breadcrumb->add('medidas', '/admin/medidas');
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


        $medidas = $this->medidaModel->addStatus($filtro_status)->paginate($results_perpage);
        $pager = $this->medidaModel->pager;
        $pager_links = $pager->links('default', 'bootstrap_pager');

        foreach ($medidas as $key => $medida) {
            $medidas[$key]['ativo'] = $medida['ativo'] == 1 ? 'Ativo' : 'Inativo';
            $medidas[$key]['ativo_class'] = $medida['ativo'] == 1 ? 'alert-success' : 'alert-danger';
        }


        $this->data['title'] = 'Medidas de Produtos';
        $this->data['medidas'] = $medidas;
        $this->data['pager'] = $pager;
        $this->data['pager_links'] = $pager_links;
        $this->data['results_perpage'] = $results_perpage;
        $this->data['perpage_options'] = $options_perpage;
        $this->data['filtro_status'] = $filtro_status;
        $this->data['filtro_tipo'] = $filtro_tipo;
        $this->data['status_options'] = $result_status;


        return $this->render($this->data, 'Admin/Medidas/index');
    }

    public function procurar()
    {
        if ($this->request->isAJAX()) {
            $retorno = [];
            $busca = $this->request->getGet('term');
            if (!empty($busca)) {
                $medidas = $this->medidaModel->procurar($busca);
                foreach ($medidas as $medida) {
                    $data['id'] = $medida['id'];
                    $data['value'] = $medida['nome'];
                    $retorno[] = $data;
                }
                return $this->response->setJSON($retorno);
            }
        }
        return view('errors/404_admin');
    }

    public function criar()
    {

        $this->data['title'] = 'Criando uma medida para um produto';

        $this->breadcrumb->add('Criar Medida', '/admin/medidas/criar/');
        return $this->render($this->data, 'Admin/Medidas/form');
    }

    public function editar($id = null)
    {
        if (!is_null($id)) {
            $medida = $this->buscaMedidaOu404($id);
            $medida['ativo_name'] = $medida['ativo'] == 1 ? 'Ativo' : 'Inativo';
            $this->data['title'] = $medida['nome'];
            $this->data['medida'] = $medida;
            $this->breadcrumb->add($medida['nome'], '/admin/medidas/editar/');
            return $this->render($this->data, 'Admin/Medidas/form');
        }
        return view('errors/404_admin');
    }
    public function show($id = null)
    {
        if (!is_null($id)) {
            $medida = $this->buscaMedidaOu404($id);

            $medida['ativo'] = $medida['ativo'] == 1 ? 'Ativo' : 'Inativo';

            $this->data['title'] = $medida['nome'];
            $this->data['medida'] = $medida;

            $this->breadcrumb->add($medida['nome'], '/admin/medidas/show/');
            return $this->render($this->data, 'Admin/Medidas/show');
        }
        return view('errors/404_admin');
    }

    public function salvar()
    {
        if ($this->request->getPost()) {
            $id = $this->request->getPost('id_hidden');

            $newMedida = [
                'nome' => $this->request->getPost('nome'),
                'descricao' => $this->request->getPost('descricao'),
                'ativo' => $this->request->getPost('ativo'),
            ];

            if ($id) {
                $medida = $this->buscaMedidaOu404($id);
                $newMedida['id'] = $id;
            }

            $saved = $this->medidaModel->protect(false)->save($newMedida);
            if ($saved) {
                $this->session->setFlashdata('msg', 'Medida salva com sucesso');
                $this->session->setFlashdata('msg_type', 'alert-success');
                if (empty($id)) {
                    $id = $this->medidaModel->getInsertID();
                }
                return redirect()->to("admin/medidas/show/" . $id);
            } else {
                $this->data['msg'] = $this->medidaModel->errors();
                $this->data['msg_type'] = 'alert-danger';
                $this->data['id'] = $id;
                if (!empty($medida)) {
                    $this->breadcrumb->add($medida['nome'], '/admin/medidas/editar/');
                } else {
                    $this->breadcrumb->add('Criar Medida de Produto', '/admin/medidas/criar/');
                }
                return $this->render($this->data, 'Admin/medidas/form');
            }
        }
        $this->session->setFlashdata('msg', 'A ação que você requisitou não é permitida.');
        $this->session->setFlashdata('msg_type', 'alert-danger');
        return redirect()->to(base_url() . '/admin/medidas');
    }

    private function buscaMedidaOu404(int $id = null)
    {
        if (!$id || !$medida = $this->medidaModel->where('id', $id)->first()) {
            return view('errors/404_admin');
        }
        return $medida;
    }

    public function excluir()
    {
        if ($this->request->isAJAX()) {
            $data = array();
            $medida_id = $this->request->getPost('medida_id');
            $data['token'] = csrf_hash();
            if (!empty($medida_id)) {
                if ($this->medidaModel->delete($medida_id)) {
                    $data['code'] = 200;
                    $data['status'] = 'success';
                    $data['detail'] = ['id' => $medida_id];
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
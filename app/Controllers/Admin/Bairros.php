<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BairroModel;

class Bairros extends AdminBaseController
{
    private $bairroModel;
    public function __construct()
    {
        parent::__construct();
        $this->bairroModel = new BairroModel();
        $this->data['active'] = 'bairros';
        $this->breadcrumb->add('Bairros', '/admin/bairros');
    }

    public function index()
    {
        $filtro = [
            'per_page' => !empty($this->request->getPost('per_page')) ? $this->request->getPost('per_page'): 10,
            'status' => !empty($this->request->getPost('status'))? $this->request->getPost('status'): 'ativo'
        ];
        $bairros = $this->bairroModel->addStatus($filtro['status'])->paginate($filtro['per_page']);
        $pager = $this->bairroModel->pager;
        $pager_links = $pager->links('default', 'bootstrap_pager');

        foreach ($bairros as &$bairro) {
            $bairro['ativo_class'] = $bairro['ativo'] == 1 ? 'alert-success' : 'alert-danger';
            $bairro['ativo'] = $bairro['ativo'] == 1 ? 'Ativo' : 'Inativo';
        }

        $this->data['title'] = 'Lista de bairros';
        $this->data['bairros'] = $bairros;
        $this->data['pager'] = $pager;
        $this->data['pager_links'] = $pager_links;
        $this->data['filtro'] = $filtro;
        return $this->render($this->data, 'Admin/Bairros/index');

    }

    public function procurar()
    {
        if ($this->request->isAJAX()) {
            $retorno = [];
            $busca = $this->request->getGet('term');
            if (!empty($busca)) {
                $bairros = $this->bairroModel->procurar($busca);
                foreach ($bairros as $bairro) {
                    $data['id'] = $bairro['id'];
                    $data['value'] = $bairro['nome'];
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
            $bairro = $this->buscaBairroOu404($id);

            $bairro['ativo'] = $bairro['ativo'] == 1 ? 'Ativo' : 'Inativo';

            $this->data['title'] = $bairro['nome'];
            $this->data['bairro'] = $bairro;

            $this->breadcrumb->add($bairro['nome'], '/admin/bairros/show/');
            return $this->render($this->data, 'Admin/Bairros/show');
        }
        return view('errors/404_admin');
    }

    public function criar()
    {
        $this->data['title'] = 'Cadastrar um novo bairro';
        $this->breadcrumb->add('Cadastrar Bairro', '/admin/bairros/criar/');
        return $this->render($this->data, 'Admin/Bairros/form');
    }

    public function editar($id = null)
    {
        if (!is_null($id)) {
            $bairro = $this->buscaBairroOu404($id);
            $bairro['ativo_name'] = $bairro['ativo'] == 1 ? 'Ativo' : 'Inativo';
            $this->data['title'] = $bairro['nome'];
            $this->data['bairro'] = $bairro;
            $this->breadcrumb->add($bairro['nome'], '/admin/bairros/editar/');
            return $this->render($this->data, 'Admin/Bairros/form');
        }
        return view('errors/404_admin');
    }

    public function salvar()
    {
        if ($this->request->getPost()) {
            $id = $this->request->getPost('id_hidden');

            $newBairro = [
                'nome' => $this->request->getPost('nome'),
                'ativo' => $this->request->getPost('ativo'),
                'cep' => $this->request->getPost('cep'),
                'cidade' => $this->request->getPost('cidade'),
                'valor_entrega' => $this->request->getPost('valor_entrega'),
            ];
            if (!empty($id)) {
                $bairro = $this->buscaBairroOu404($id);
                $newBairro['id'] = $id;
            }

            $saved = $this->bairroModel->save($newBairro);
            if ($saved) {
                $this->session->setFlashdata('msg', 'Bairro salvo com sucesso');
                $this->session->setFlashdata('msg_type', 'alert-success');
                if (empty($id)) {
                    $id = $this->bairroModel->getInsertID();
                }
                return redirect()->to("admin/bairros/show/" . $id);
            } else {
                $this->data['msg'] = $this->bairroModel->errors();
                $this->data['msg_type'] = 'alert-danger';
                $this->data['id'] = $id;
                if (!empty($bairro)) {
                    $this->breadcrumb->add($bairro['nome'], '/admin/bairros/editar/');
                } else {
                    $this->breadcrumb->add('Criar Bairro', '/admin/bairros/criar/');
                }
                return $this->render($this->data, 'Admin/Bairros/form');
            }
        }
        $this->session->setFlashdata('msg', 'A ação que você requisitou não é permitida.');
        $this->session->setFlashdata('msg_type', 'alert-danger');
        return redirect()->to(base_url() . '/admin/bairros');
    }



    public function excluir()
    {
        if ($this->request->isAJAX()) {
            $data = array();
            $bairro_id = $this->request->getPost('bairro_id');
            $data['token'] = csrf_hash();
            if (!empty($bairro_id)) {
                if ($this->bairroModel->delete($bairro_id)) {
                    $data['code'] = 200;
                    $data['status'] = 'success';
                    $data['detail'] = ['id' => $bairro_id];
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

    private function buscaBairroOu404(int $id = null)
    {
        if (!$id || !$bairro = $this->bairroModel->where('id', $id)->first()) {
            return view('errors/404_admin');
        }
        return $bairro;
    }
}

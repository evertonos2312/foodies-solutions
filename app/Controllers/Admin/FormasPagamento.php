<?php

namespace App\Controllers\Admin;


use App\Models\FormaPagamentoModel;

class FormasPagamento extends AdminBaseController
{
    private $formaPagamentoModel;
    public function __construct()
    {
        parent::__construct();
        $this->formaPagamentoModel = new FormaPagamentoModel();
        $this->data['active'] = 'formas';
        $this->breadcrumb->add('Formas de Pagamento', '/admin/formas');
    }

    public function index()
	{
        $filtro = [
            'filtro_status' => $this->request->getPost('filtro_status'),
            'tipo' => $this->request->getPost('filtro_tipo'),
            'filtro_perpage' => ($this->request->getPost('filtro_perpage')? :10)
        ];
        $formas = $this->formaPagamentoModel->addStatus($filtro['filtro_status'])->paginate($filtro['filtro_perpage']);
        $pager = $this->formaPagamentoModel->pager;
        $pager_links = $pager->links('default', 'bootstrap_pager');


        foreach ($formas as &$forma) {
            $forma['ativo_class'] = $forma['ativo'] == 1 ? 'alert-success' : 'alert-danger';
            $forma['ativo'] = $forma['ativo'] == 1 ? 'Ativo' : 'Inativo';
        }

        $this->data['title'] = 'Formas de pagamento';
        $this->data['pager'] = $pager;
        $this->data['formas'] = $formas;
        $this->data['pager_links'] = $pager_links;
        $this->data['filtro'] = $filtro;
        return $this->render($this->data, 'Admin/FormasPagamento/index');
	}

    public function procurar()
    {
        if ($this->request->isAJAX()) {
            $retorno = [];
            $busca = $this->request->getGet('term');
            if (!empty($busca)) {
                $formas = $this->formaPagamentoModel->procurar($busca);
                foreach ($formas as $forma) {
                    $data['id'] = $forma['id'];
                    $data['value'] = $forma['nome'];
                    $retorno[] = $data;
                }
                return $this->response->setJSON($retorno);
            }
        }
        return view('errors/404_admin');
    }

    public function editar($id = null)
    {
        if (!is_null($id)) {
            if ($id == 1) {
                return redirect()->to('admin/formas/show/'.$id);
            }
            $forma = $this->buscaFormaOu404($id);
            $forma['ativo_name'] = $forma['ativo'] == 1 ? 'Ativo' : 'Inativo';
            $this->data['title'] = $forma['nome'];
            $this->data['forma'] = $forma;
            $this->breadcrumb->add($forma['nome'], '/admin/formas/editar/');
            return $this->render($this->data, 'Admin/FormasPagamento/form');
        }
        return view('errors/404_admin');
    }

    public function criar()
    {

        $this->data['title'] = 'Criando uma nova forma de pagamento';

        $this->breadcrumb->add('Criar Forma de Pagamento', '/admin/formas/criar/');
        return $this->render($this->data, 'Admin/FormasPagamento/form');
    }

    public function show($id = null)
    {
        if (!is_null($id)) {
            $forma = $this->buscaFormaOu404($id);

            $forma['ativo'] = $forma['ativo'] == 1 ? 'Ativo' : 'Inativo';

            $this->data['title'] = $forma['nome'];
            $this->data['forma'] = $forma;

            $this->breadcrumb->add($forma['nome'], '/admin/formas/show/');
            return $this->render($this->data, 'Admin/FormasPagamento/show');
        }
        return view('errors/404_admin');
    }

    public function excluir()
    {
        if ($this->request->isAJAX()) {
            $data = array();
            $forma_id = $this->request->getPost('id_forma');
            $data['token'] = csrf_hash();
            if (!empty($forma_id)) {
                if ($this->formaPagamentoModel->delete($forma_id)) {
                    $data['code'] = 200;
                    $data['status'] = 'success';
                    $data['detail'] = ['id' => $forma_id];
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

    public function salvar()
    {
        if ($this->request->getPost()) {
            $id = $this->request->getPost('id_hidden');

            $newForma = [
                'nome' => $this->request->getPost('nome'),
                'ativo' => $this->request->getPost('ativo'),
            ];

            if ($id) {
                $forma = $this->buscaFormaOu404($id);
                $newForma['id'] = $id;
            }

            $saved = $this->formaPagamentoModel->protect(false)->save($newForma);
            if ($saved) {
                $this->session->setFlashdata('msg', 'Forma de pagamento salva com sucesso');
                $this->session->setFlashdata('msg_type', 'alert-success');
                if (empty($id)) {
                    $id = $this->formaPagamentoModel->getInsertID();
                }
                return redirect()->to("admin/formas/show/" . $id);
            } else {
                $this->data['msg'] = $this->formaPagamentoModel->errors();
                $this->data['msg_type'] = 'alert-danger';
                $this->data['id'] = $id;
                if (!empty($forma)) {
                    $this->breadcrumb->add($forma['nome'], '/admin/formas/editar/');
                } else {
                    $this->breadcrumb->add('Criar Forma de pagamento', '/admin/formas/criar/');
                }
                return $this->render($this->data, 'Admin/FormasPagamento/form');
            }
        }
        $this->session->setFlashdata('msg', 'A ação que você requisitou não é permitida.');
        $this->session->setFlashdata('msg_type', 'alert-danger');
        return redirect()->to(base_url() . '/admin/formas');
    }

    private function buscaFormaOu404(int $id = null)
    {
        if (!$id || !$forma = $this->formaPagamentoModel->where('id', $id)->first()) {
            return view('errors/404_admin');
        }
        return $forma;
    }
}

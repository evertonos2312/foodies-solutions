<?php

namespace App\Controllers\Admin;


use App\Models\EntregadorModel;
use Config\Services;

class Entregadores extends AdminBaseController
{
    private $entregadorModel;
    public function __construct()
    {
        parent::__construct();
        $this->entregadorModel = new EntregadorModel();
        $this->data['active'] = 'entregadores';
        $this->breadcrumb->add('Entregadores', '/admin/entregadores');
    }

    public function index()
    {
        $filtro = [
            'per_page' => !empty($this->request->getPost('per_page')) ? $this->request->getPost('per_page'): 10,
            'status' => !empty($this->request->getPost('status'))? $this->request->getPost('status'): 'ativo'
        ];
        $entregadores = $this->entregadorModel->addStatus($filtro['status'])->paginate($filtro['per_page']);
        $pager = $this->entregadorModel->pager;
        $pager_links = $pager->links('default', 'bootstrap_pager');

        foreach ($entregadores as &$entregador) {
            $entregador['ativo_class'] = $entregador['ativo'] == 1 ? 'alert-success' : 'alert-danger';
            $entregador['ativo'] = $entregador['ativo'] == 1 ? 'Ativo' : 'Inativo';
        }
        $this->data['title'] = 'Lista de entregadores';
        $this->data['entregadores'] = $entregadores;
        $this->data['pager'] = $pager;
        $this->data['pager_links'] = $pager_links;
        $this->data['filtro'] = $filtro;
        return $this->render($this->data, 'Admin/Entregadores/index');
    }

    public function procurar()
    {
        if ($this->request->isAJAX()) {
            $retorno = [];
            $busca = $this->request->getGet('term');
            if (!empty($busca)) {
                $entregadores = $this->entregadorModel->procurar($busca);
                foreach ($entregadores as $entregador) {
                    $data['id'] = $entregador['id'];
                    $data['value'] = $entregador['nome'];
                    $retorno[] = $data;
                }
                return $this->response->setJSON($retorno);
            }
        }
        return view('errors/404_admin');
    }

    public function criar()
    {

        $this->data['title'] = 'Cadastrar um novo entregador';
        $this->breadcrumb->add('Cadastrar Entregador', '/admin/entregadores/criar/');
        return $this->render($this->data, 'Admin/Entregadores/form');
    }

    public function editar($id = null)
    {
        if (!is_null($id)) {
            $entregador = $this->buscaEntregadorOu404($id);
            $entregador['ativo_name'] = $entregador['ativo'] == 1 ? 'Ativo' : 'Inativo';
            $this->data['title'] = $entregador['nome'];
            $this->data['entregador'] = $entregador;
            $this->breadcrumb->add($entregador['nome'], '/admin/entregadores/editar/');
            return $this->render($this->data, 'Admin/Entregadores/form');
        }
        return view('errors/404_admin');
    }

    public function show($id = null)
    {
        if (!is_null($id)) {
            $entregador = $this->buscaEntregadorOu404($id);

            $entregador['ativo'] = $entregador['ativo'] == 1 ? 'Ativo' : 'Inativo';

            $this->data['title'] = $entregador['nome'];
            $this->data['entregador'] = $entregador;

            $this->breadcrumb->add($entregador['nome'], '/admin/entregadores/show/');
            return $this->render($this->data, 'Admin/Entregadores/show');
        }
        return view('errors/404_admin');
    }

    public function salvar()
    {
        if ($this->request->getPost()) {
            $id = $this->request->getPost('id_hidden');

            $imagem = [
                'imagem' => [
                    'rules' => 'uploaded[imagem]|is_image[imagem]|max_size[imagem,10240]',
                    'label' => 'Imagem',
                    'errors' => ['max_size' => 'Imagem muito grande, tamanho máximo 10MB']
                ]
            ];

            $newEntregador = [
                'nome' => $this->request->getPost('nome'),
                'ativo' => $this->request->getPost('ativo'),
                'telefone' => $this->request->getPost('telefone'),
                'cnh' => $this->request->getPost('cnh'),
                'cpf' => $this->request->getPost('cpf'),
                'veiculo' => $this->request->getPost('veiculo'),
                'placa' => $this->request->getPost('placa'),
                'endereco' => $this->request->getPost('endereco'),
            ];
            if ($id) {
                $entregador = $this->buscaEntregadorOu404($id);
                $newEntregador['id'] = $id;
            }

            if (!$id) {
                if (!$this->validate($imagem)) {
                    $this->data['msg'] = $this->validator->listErrors();
                    $this->data['msg_type'] = 'alert-danger';
                    $this->data['id'] = $id;
                    if (!empty($entregador)) {
                        $this->breadcrumb->add($entregador['nome'], '/admin/entregadores/editar/');
                    } else {
                        $this->breadcrumb->add('Cadastrar entregador', '/admin/entregadores/criar/');
                    }
                    return $this->render($this->data, 'Admin/Entregadores/form');
                }
            }
            $imagemProduto = $this->request->getFile('imagem');
            if ($imagemProduto->isValid()) {
                if (!$imagemProduto->hasMoved()) {
                    $imagemProduto->move('uploads/imagens/entregadores', $imagemProduto->getRandomName());
                    $caminhoImagem = 'uploads/imagens/entregadores/'.$imagemProduto->getName();

                    Services::image()
                        ->withFile($caminhoImagem)
                        ->fit(400, 400, 'center')
                        ->save($caminhoImagem);
                    if (!empty($entregador)) {
                        $imagemAntiga = $entregador['imagem'];
                        $caminhoAntigo = 'uploads/imagens/entregadores/' . $imagemAntiga;
                        if (is_file($caminhoAntigo)) {
                            unlink($caminhoAntigo);
                        }
                    }
                    $newEntregador['imagem'] = $imagemProduto->getName();
                }
            }

            $saved = $this->entregadorModel->save($newEntregador);
            if ($saved) {
                $this->session->setFlashdata('msg', 'Entregador salvo com sucesso');
                $this->session->setFlashdata('msg_type', 'alert-success');
                if (empty($id)) {
                    $id = $this->entregadorModel->getInsertID();
                }
                return redirect()->to("admin/entregadores/show/" . $id);
            } else {
                $this->data['msg'] = $this->entregadorModel->errors();
                $this->data['msg_type'] = 'alert-danger';
                $this->data['id'] = $id;
                if (!empty($entregador)) {
                    $this->breadcrumb->add($entregador['nome'], '/admin/entregadores/editar/');
                } else {
                    $this->breadcrumb->add('Cadastro de entregador', '/admin/entregadores/criar/');
                }

                $this->data['title'] = 'Cadastrando novo entregador';
                return $this->render($this->data, 'Admin/Entregadores/form');
            }
        }
        $this->session->setFlashdata('msg', 'A ação que você requisitou não é permitida.');
        $this->session->setFlashdata('msg_type', 'alert-danger');
        return redirect()->to(base_url() . '/admin/entregadores');
    }

    public function excluir()
    {
        if ($this->request->isAJAX()) {
            $data = array();
            $entregador_id = $this->request->getPost('entregador_id');
            $data['token'] = csrf_hash();
            if (!empty($entregador_id)) {
                if ($this->entregadorModel->delete($entregador_id)) {
                    $data['code'] = 200;
                    $data['status'] = 'success';
                    $data['detail'] = ['id' => $entregador_id];
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

    private function buscaEntregadorOu404(int $id = null)
    {
        if (!$id || !$entregador = $this->entregadorModel->where('id', $id)->first()) {
            return view('errors/404_admin');
        }
        return $entregador;
    }
}

<?php

namespace App\Controllers\Admin;

use App\Models\CategoriaModel;
use App\Models\ExtraModel;
use App\Models\MedidaModel;
use App\Models\ProdutoEspecificacaoModel;
use App\Models\ProdutoExtraModel;
use App\Models\ProdutoModel;
use Config\Services;

class Produtos extends AdminBaseController
{
    public $data = array();
    private $produtoModel;
    private $categoriaModel;
    private $extraModel;
    private $produtoExtraModel;
    private $medidaModel;
    private $produtoEspecificacaoModel;

    public function __construct()
    {
        parent::__construct();
        $this->produtoModel = new ProdutoModel();
        $this->categoriaModel = new CategoriaModel();
        $this->extraModel = new ExtraModel();
        $this->produtoExtraModel = new ProdutoExtraModel();
        $this->medidaModel = new MedidaModel();
        $this->produtoEspecificacaoModel = new ProdutoEspecificacaoModel();
        $this->data['active'] = 'produtos';
        $this->data['sub_active'] = 'produtos';
        $this->breadcrumb->add('Produtos', '/admin/produtos');
    }

    public function index()
    {
        $filtro = [
            'per_page' => !empty($this->request->getPost('per_page')) ? $this->request->getPost('per_page'): 10,
            'status' => !empty($this->request->getPost('status'))? $this->request->getPost('status'): 'ativo'
        ];

        $produtos = $this->produtoModel->addStatus($filtro['status'])->getProdutos()->paginate($filtro['per_page']);
        $pager = $this->produtoModel->pager;
        $pager_links = $pager->links('default', 'bootstrap_pager');

        foreach ($produtos as $key => $produto) {
            $produtos[$key]['ativo'] = $produto['ativo'] == 1 ? 'Ativo' : 'Inativo';
            $produtos[$key]['ativo_class'] = $produto['ativo'] == 1 ? 'alert-success' : 'alert-danger';
        }

        
        $this->data['title'] = 'Lista de produtos';
        $this->data['produtos'] = $produtos;
        $this->data['especificacoes'] = $this->produtoEspecificacaoModel->join('medidas', 'medidas.id = produtos_especificacoes.medida_id')->findAll();
        $this->data['pager'] = $pager;
        $this->data['pager_links'] = $pager_links;
        $this->data['filtro'] = $filtro;
        return $this->render($this->data, 'Admin/Produtos/index');
    }

    public function editar($id = null)
    {
        if (!is_null($id)) {
            $produto = $this->buscaProdutoOu404($id);
            $produto['ativo_name'] = $produto['ativo'] == 1 ? 'Ativo' : 'Inativo';
            $this->data['title'] = $produto['nome'];
            $this->data['produto'] = $produto;
            $this->data['categorias'] = $this->categoriaModel->formDropDown();
            $this->breadcrumb->add($produto['nome'], '/admin/produtos/editar/');
            return $this->render($this->data, 'Admin/Produtos/form');
        }
        return view('errors/404_admin');
    }

    public function procurar()
    {
        if ($this->request->isAJAX()) {
            $retorno = [];
            $busca = $this->request->getGet('term');
            if (!empty($busca)) {
                $produtos = $this->produtoModel->procurar($busca);
                foreach ($produtos as $produto) {
                    $data['id'] = $produto['id'];
                    $data['value'] = $produto['nome'];
                    $retorno[] = $data;
                }
                return $this->response->setJSON($retorno);
            }
        }
        return view('errors/404_admin');
    }

    public function criar()
    {

        $this->data['title'] = 'Criando novo produto';
        $this->data['categorias'] = $this->categoriaModel->formDropDown();
        $this->breadcrumb->add('Criar Produto', '/admin/produtos/criar/');
        return $this->render($this->data, 'Admin/Produtos/form');
    }

    public function show($id = null)
    {
        if (!is_null($id)) {
            $produto = $this->buscaProdutoOu404($id);

            $produto['ativo'] = $produto['ativo'] == 1 ? 'Ativo' : 'Inativo';

            $this->data['title'] = $produto['nome'];
            $this->data['produto'] = $produto;


            $this->breadcrumb->add($produto['nome'], '/admin/produtos/show/');
            return $this->render($this->data, 'Admin/Produtos/show');
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
                    'errors' => ['max_size' => 'Imagem muito grande, tamanho m??ximo 10MB']
                ]
            ];

            $newproduto = [
                'nome' => $this->request->getPost('nome'),
                'ativo' => $this->request->getPost('ativo'),
                'categoria_id' => $this->request->getPost('categoria_id'),
                'ingredientes' => $this->request->getPost('ingredientes'),
            ];
            if ($id) {
                $produto = $this->buscaProdutoOu404($id);
                $newproduto['id'] = $id;
            }
            
            if (!$id) {
                if (!$this->validate($imagem)) {
                    $this->data['msg'] = $this->validator->listErrors();
                    $this->data['msg_type'] = 'alert-danger';
                    $this->data['id'] = $id;
                    $this->data['categorias'] = $this->categoriaModel->formDropDown();
                    if (!empty($produto)) {
                        $this->breadcrumb->add($produto['nome'], '/admin/produtos/editar/');
                    } else {
                        $this->breadcrumb->add('Criar produto', '/admin/produtos/criar/');
                    }
                    return $this->render($this->data, 'Admin/Produtos/form');
                }
            }
            $imagemProduto = $this->request->getFile('imagem');
            if ($imagemProduto->isValid()) {
                if (!$imagemProduto->hasMoved()) {
                    $imagemProduto->move('uploads/imagens/produtos', $imagemProduto->getRandomName());
                    $caminhoImagem = 'uploads/imagens/produtos/'.$imagemProduto->getName();

                    Services::image()
                        ->withFile($caminhoImagem)
                        ->fit(400, 400, 'center')
                        ->save($caminhoImagem);
                    if (!empty($produto)) {
                        $imagemAntiga = $produto['imagem'];
                        $caminhoAntigo = 'uploads/imagens/produtos/' . $imagemAntiga;
                        if (is_file($caminhoAntigo)) {
                            unlink($caminhoAntigo);
                        }
                    }
                    $newproduto['imagem'] = $imagemProduto->getName();
                }
            }

            $saved = $this->produtoModel->protect(false)->save($newproduto);
            if ($saved) {
                $this->session->setFlashdata('msg', 'Produto salvo com sucesso');
                $this->session->setFlashdata('msg_type', 'alert-success');
                if (empty($id)) {
                    $id = $this->produtoModel->getInsertID();
                }
                return redirect()->to("admin/produtos/show/" . $id);
            } else {
                $this->data['msg'] = $this->produtoModel->errors();
                $this->data['msg_type'] = 'alert-danger';
                $this->data['id'] = $id;
                if (!empty($produto)) {
                    $this->breadcrumb->add($produto['nome'], '/admin/produtos/editar/');
                } else {
                    $this->breadcrumb->add('Criar produto', '/admin/produtos/criar/');
                }

                $this->data['title'] = 'Criando novo produto';
                $this->data['categorias'] = $this->categoriaModel->formDropDown();
                return $this->render($this->data, 'Admin/Produtos/form');
            }
        }
        $this->session->setFlashdata('msg', 'A a????o que voc?? requisitou n??o ?? permitida.');
        $this->session->setFlashdata('msg_type', 'alert-danger');
        return redirect()->to(base_url() . '/admin/produtos');
    }

    private function buscaProdutoOu404(int $id = null)
    {
        if (!$id || !$produto = $this->produtoModel->where('id', $id)->first()) {
            return view('errors/404_admin');
        }
        return $produto;
    }

    public function excluir()
    {
        if ($this->request->isAJAX()) {
            $data = array();
            $produto_id = $this->request->getPost('produto_id');
            $extra_id = $this->request->getPost('id_produto_extra');
            $especificacao_id = $this->request->getPost('id_produto_especificacao');
            $data['token'] = csrf_hash();
            $produtoDelete = false;
            if (!empty($produto_id)) {
                $produtoDelete = $this->produtoModel->delete($produto_id);
            } else if (!empty($extra_id)) {
                $produtoDelete = $this->produtoExtraModel->delete($extra_id);
            } else if (!empty($especificacao_id)) {
                $produtoDelete = $this->produtoEspecificacaoModel->delete($especificacao_id);
            }
            if ($produtoDelete) {
                $data['code'] = 200;
                $data['status'] = 'success';
                $data['detail'] = ['id' => $produto_id || $extra_id];
                $data['msg_error'] = '';
            } else {
                $data['code'] = 503;
                $data['status'] = 'error';
                $data['detail'] = '';
                $data['msg_error'] = 'Erro ao excluir registro, verifique os dados enviados.';
            }
            return $this->response->setJSON($data);
        }
        return view('errors/404_admin');
    }

    public function extras($id = null)
    {
        if (!is_null($id)) {
            $produto = $this->buscaProdutoOu404($id);

            $produto['ativo'] = $produto['ativo'] == 1 ? 'Ativo' : 'Inativo';
            $this->data['title'] = 'Gerenciar os extras do produto ' .$produto['nome'];
            $this->data['produto'] = $produto;
            $this->data['extras'] = $this->extraModel->formDropDown();
            $this->data['produtosExtras'] = $this->produtoExtraModel->buscaExtrasDoProduto($produto['id'], 10);
            $pager = $this->produtoExtraModel->pager;
            $pager_links = $pager->links('default', 'bootstrap_pager');

            $this->data['pager'] = $pager;
            $this->data['pager_links'] = $pager_links;

            $this->breadcrumb->add($produto['nome'], '/admin/produtos/extras/');
            return $this->render($this->data, 'Admin/Produtos/extras');
        }
        return view('errors/404_admin');
    }

    public function cadastar_extras($id = null)
    {
        if ($this->request->getPost()) {
            $produto = $this->buscaProdutoOu404($id);
            $extraProduto['extra_id'] = $this->request->getPost('extra_id');
            $extraProduto['produto_id'] = $produto['id'];

            $extraExistente = $this->produtoExtraModel
                ->where('produto_id', $produto['id'])
                ->where('extra_id', $extraProduto['extra_id'])
                ->first();
            if ($extraExistente) {
                $this->session->setFlashdata('msg', 'Esse extra j?? existe para esse produto.');
                $this->session->setFlashdata('msg_type', 'alert-danger');
                return redirect()->to("admin/produtos/extras/" . $produto['id']);
            }
            $saved = $this->produtoExtraModel->protect(false)->save($extraProduto);
            if ($saved) {
                $this->session->setFlashdata('msg', 'Extra salvo com sucesso');
                $this->session->setFlashdata('msg_type', 'alert-success');
            } else {
                $this->session->setFlashdata('msg', 'Erro ao salvar, tente novamente mais tarde.');
                $this->session->setFlashdata('msg_type', 'alert-danger');
            }
            return redirect()->to("admin/produtos/extras/" . $produto['id']);
        }
        return view('errors/404_admin');
    }

    public function especificacoes($id = null)
    {
        if (!is_null($id)) {
            $produto = $this->buscaProdutoOu404($id);

            $produto['ativo'] = $produto['ativo'] == 1 ? 'Ativo' : 'Inativo';
            $produtosEspeficacoes = $this->produtoEspecificacaoModel->buscaEspecificacaoDoProduto($produto['id'], 10);
            foreach ($produtosEspeficacoes as $key => $especificacoes) {
                $produtosEspeficacoes[$key]['customizavel'] = $produtosEspeficacoes[$key]['customizavel'] == 1 ? 'Sim' : 'N??o';
            }
            $this->data['title'] = 'Gerenciar os especifica????es do produto ' .$produto['nome'];
            $this->data['produto'] = $produto;
            $this->data['medidas'] = $this->medidaModel->formDropDown();

            $this->data['produtosEspeficacoes'] = $produtosEspeficacoes;
            $pager = $this->produtoEspecificacaoModel->pager;
            $pager_links = $pager->links('default', 'bootstrap_pager');

            $this->data['pager'] = $pager;
            $this->data['pager_links'] = $pager_links;

            $this->breadcrumb->add($produto['nome'], '/admin/produtos/especificacoes/');
            return $this->render($this->data, 'Admin/Produtos/especificacoes');
        }
        return view('errors/404_admin');
    }

    public function cadastar_especificacoes($id = null)
    {
        if ($this->request->getPost()) {
            $produto = $this->buscaProdutoOu404($id);
            $especificacaoProduto['medida_id'] = $this->request->getPost('medida_id');
            $especificacaoProduto['preco'] = $this->request->getPost('preco');
            $especificacaoProduto['customizavel'] = $this->request->getPost('customizavel');
            $especificacaoProduto['produto_id'] = $produto['id'];

            $especificacaoProduto['preco'] = str_replace('.', '', $especificacaoProduto['preco']);
            $especificacaoProduto['preco'] = str_replace(',', '.', $especificacaoProduto['preco']);

            $especificacaoExistente = $this->produtoEspecificacaoModel
                ->where('produto_id', $produto['id'])
                ->where('medida_id', $especificacaoProduto['medida_id'])
                ->first();
            if ($especificacaoExistente) {
                $this->session->setFlashdata('msg', 'Essa especifica????o  j?? existe para esse produto.');
                $this->session->setFlashdata('msg_type', 'alert-danger');
                return redirect()->to("admin/produtos/especificacoes/" . $produto['id']);
            }

            $saved = $this->produtoEspecificacaoModel->protect(false)->save($especificacaoProduto);
            if ($saved) {
                $this->session->setFlashdata('msg', 'Especifica????o salva com sucesso');
                $this->session->setFlashdata('msg_type', 'alert-success');
            } else {
                $this->session->setFlashdata('msg', 'Erro ao salvar, tente novamente mais tarde.');
                $this->session->setFlashdata('msg_type', 'alert-danger');
            }
            return redirect()->to("admin/produtos/especificacoes/" . $produto['id']);
        }
        return view('errors/404_admin');
    }
}

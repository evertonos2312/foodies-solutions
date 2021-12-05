<?php

namespace App\Models;

class ProdutoModel  extends BaseModel
{
    protected $table = 'produtos';
    protected $returnType = 'array';

    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $allowedFields = ['categoria_id', 'nome', 'slug','ingredientes', 'ativo', 'imagem' ];

    // Dates
    protected $createdField = 'criado_em';
    protected $updatedField = 'atualizado_em';
    protected $deletedField = 'deletado_em';

    protected $beforeInsert = ['criaSlug'];
    protected $beforeUpdate = ['criaSlug'];


    protected $validationRules = [
        'nome' => 'required|min_length[2]|max_length[128]|is_unique[produtos.nome, id,{id}]',
        'ingredientes' => 'required|min_length[5]|max_length[1000]|is_unique[produtos.ingredientes, id,{id}]',
        'categoria_id' => 'required|integer|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'O campo Nome é obrigatório.',
            'is_unique' => 'Esse produto já existe'
        ],
        'categoria_id' => [
            'required' => 'O campo Categoria é obrigatório.',
            'is_natural_no_zero' => 'O campo Categoria é obrigatório.'
        ],
    ];

    public function addStatus($status = null)
    {
        if (!is_null($status)) {
            switch ($status) {
                case 'ativo':
                    $this->where('produtos.ativo', 1);
                    break;
                case 'inativo':
                    $this->where('produtos.ativo', 0);
                    break;
                default:
                    break;
            }
        }
        return $this;
    }

    public function procurar($term)
    {
        if (is_null($term)) {
            return [];
        }
        return $this->select('id, nome')->like('nome', $term)->findAll();
    }

    public function getProdutos()
    {
        $this->select('produtos.*, categorias.nome as categoria');
        $this->join('categorias', 'categorias.id = produtos.categoria_id');
        $this->orderBy('produtos.nome');
        return $this;
    }

    public function buscaProdutosHome()
    {
        return $this->select([
            'produtos.id',
            'produtos.nome',
            'produtos.slug',
            'produtos.ingredientes',
            'produtos.imagem',
            'categorias.id as categoria_id',
            'categorias.nome as categoria',
            'categorias.slug categoria_slug'
        ])->selectMin('produtos_especificacoes.preco')
            ->join('categorias', 'categorias.id = produtos.categoria_id')
            ->join('produtos_especificacoes', 'produtos_especificacoes.produto_id = produtos.id')
            ->where('produtos.ativo', true)
            ->where("produtos.imagem != ''")
            ->groupBy('produtos.nome')
            ->orderBy('categorias.nome', 'ASC')
            ->findAll();
    }

    /**
     * Utilizado no controller Produto/customizar
     * @param int $categoria_id
     * @return array
     */
    public function exibeOpcoesProdutosParaCustomizar(int $categoria_id): array
    {
        return $this->select('produtos.id, produtos.nome')
            ->join('produtos_especificacoes', 'produtos_especificacoes.produto_id = produtos.id')
            ->join('medidas', 'produtos_especificacoes.medida_id = medidas.id')
            ->where('produtos.categoria_id', $categoria_id)
            ->where('produtos.ativo', true)
            ->where('produtos_especificacoes.customizavel', true)
            ->groupBy('produtos.nome')
            ->findAll();
    }


    /**
     * Utilizado para buscar segunda metade dos produtos
     * @param int $produto_id
     * @param int $categoria_id
     * @return array
     */
    public function exibeProdutosSegundaMetade(int $produto_id, int $categoria_id)
    {
        return $this->select('produtos.id, produtos.nome')
            ->join('categorias', 'categorias.id = produtos.categoria_id')
            ->join('produtos_especificacoes', 'produtos_especificacoes.produto_id = produtos.id')
            ->where('produtos.id !=', $produto_id)
            ->where('produtos.categoria_id', $categoria_id)
            ->where('produtos.ativo', true)
            ->where('produtos_especificacoes.customizavel', true)
            ->groupBy('produtos.nome')
            ->findAll();
    }
}
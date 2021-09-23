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
        'categoria_id' => 'required|integer',
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'O campo Nome é obrigatório.',
            'is_unique' => 'Esse produto já existe'
        ],
        'categoria_id' => [
            'required' => 'O campo Categoria é obrigatório.',
        ],
    ];

    public function addStatus($status = null)
    {
        if (!is_null($status)) {
            switch ($status) {
                case 'ativo':
                    $this->where('ativo', 1);
                    break;
                case 'inativo':
                    $this->where('ativo', 0);
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
        return $this;
    }
}
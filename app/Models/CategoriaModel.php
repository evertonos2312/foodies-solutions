<?php

namespace App\Models;

class CategoriaModel extends BaseModel
{
    protected $table = 'categorias';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $allowedFields = ['nome', 'ativo', 'slug'];

    // Dates
    protected $createdField = 'criado_em';
    protected $updatedField = 'atualizado_em';
    protected $deletedField = 'deletado_em';

    // Validation

    protected $validationRules = [
        'nome' => 'required|min_length[2]|max_length[50]|is_unique[categorias.nome,id,{id}]',
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'O campo Nome é obrigatório.'
        ],
    ];

    protected $beforeInsert = ['criaSlug'];
    protected $beforeUpdate = ['criaSlug'];


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

    public function formDropDown()
    {
        $this->select('id, nome');
        $this->where('ativo', 1);
        $categoriasArray = $this->findAll();

        $optionCategorias = array_column($categoriasArray, 'nome', 'id');

        $optionSelecione = [
            0 => 'Selecione...'
        ];

        $selectConteudo = $optionSelecione + $optionCategorias;

        return $selectConteudo;
    }

    public function buscaCategoriasHome()
    {
        return $this->select('categorias.id, categorias.nome, categorias.slug')
            ->join('produtos', 'produtos.categoria_id = categorias.id')
            ->groupBy('categorias.id')
            ->findAll();
    }
}

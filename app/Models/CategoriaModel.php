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
        'nome' => 'required|min_length[2]|max_length[50]|is_unique[categorias.nome, id,{id}]',
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'O campo Nome é obrigatório.'
        ],
    ];

    protected $beforeInsert = ['criaSlug'];
    protected $beforeUpdate = ['criaSlug'];

    protected function criaSlug(array $data)
    {
        if (isset($data['data']['nome'])) {
            $data['data']['slug'] = mb_url_title($data['data']['nome'], '-', true);
        }
        return $data;
    }

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
}

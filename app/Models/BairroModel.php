<?php

namespace App\Models;

use CodeIgniter\Model;

class BairroModel extends BaseModel
{
    protected $table                = 'bairros';
    protected $useSoftDeletes       = true;
    protected $beforeInsert = ['criaSlug', 'corrigeValorEntrega'];
    protected $beforeUpdate = ['criaSlug', 'corrigeValorEntrega'];
    protected $allowedFields        = [
        'nome',
        'slug',
        'valor_entrega',
        'ativo',
    ];

    // Dates
    protected $useTimestamps        = true;
    protected $createdField         = 'criado_em';
    protected $updatedField         = 'atualizado_em';
    protected $deletedField         = 'deletado_em';

    // Validation

    protected $validationRules = [
        'nome' => 'required|min_length[2]|max_length[50]|is_unique[bairros.nome,id,{id}]',
        'valor_entrega' => 'required',
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'O campo Nome é obrigatório.',
            'is_unique' => 'Este bairro já existe.'
        ],
        'valor_entrega' => [
            'required' => 'O campo valor de entrega é obrigatório'
        ]
    ];

    protected function corrigeValorEntrega($data): array
    {
        if (!isset($data['data']['valor_entrega'])) {
            return $data;
        }
        $data['data']['valor_entrega'] = str_replace('.', '', $data['data']['valor_entrega']);
        $data['data']['valor_entrega'] = str_replace(',', '.', $data['data']['valor_entrega']);
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

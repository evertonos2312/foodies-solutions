<?php

namespace App\Models;

use CodeIgniter\Model;

class EntregadorModel extends BaseModel
{
    protected $table                = 'entregadores';
    protected $useSoftDeletes       = true;
    protected $allowedFields        = [
        'nome',
        'cpf',
        'cnh',
        'telefone',
        'imagem',
        'ativo',
        'veiculo',
        'placa',
        'endereco',
    ];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'criado_em';
    protected $updatedField         = 'atualizado_em';
    protected $deletedField         = 'deletado_em';

    protected $validationRules = [
        'nome' => 'required|min_length[4]|max_length[120]',
        'cpf' => 'required|validaCpf|is_unique[entregadores.cpf, id,{id}]|max_length[14]',
        'cnh' => 'required|is_unique[entregadores.cnh, id,{id}]|max_length[11]',
        'telefone' => 'required|is_unique[entregadores.telefone, id,{id}]|max_length[15]',
        'endereco' => 'required|max_length[230]',
        'veiculo' => 'required|max_length[230]',
        'placa' => 'required|min_length[7]|max_length[8]',
        'ativo' => 'required',
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'O campo Nome é obrigatório.'
        ],
        'email' => [
            'required' => 'O campo E-mail é obrigatório.',
            'is_unique' => 'Desculpe, esse email já existe.'
        ],
        'cpf' => [
            'required' => 'O campo CPF é obrigatório',
            'is_unique' => 'Desculpe, esse CPF já está cadastrado.'
        ],
        'telefone' => [
            'required' => 'O campo Telefone é obrigatório.'
        ],
        'ativo' =>[
            'required' => 'O campo Status é obrigatório'
        ]
    ];

    public function procurar($term)
    {
        if (is_null($term)) {
            return [];
        }
        return $this->select('id, nome')->like('nome', $term)->findAll();
    }

    public function addStatus($status = null)
    {
        if (!is_null($status)) {
            switch ($status) {
                case 'ativo':
                    $this->where('entregadores.ativo', 1);
                    break;
                case 'inativo':
                    $this->where('entregadores.ativo', 0);
                    break;
                default:
                    break;
            }
        }
        return $this;
    }

}

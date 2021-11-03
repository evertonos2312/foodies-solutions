<?php

namespace App\Models;

use CodeIgniter\Model;

class FormaPagamentoModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'formas_pagamento';
    protected $allowedFields        = ['nome', 'ativo'];
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;

    protected $createdField = 'criado_em';
    protected $updatedField = 'atualizado_em';
    protected $deletedField = 'deletado_em';

    protected $validationRules = [
        'nome' => 'required|min_length[2]|max_length[128]|is_unique[formas_pagamento.nome, id,{id}]'
        ,
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'O campo Nome é obrigatório.'
        ],
    ];

}

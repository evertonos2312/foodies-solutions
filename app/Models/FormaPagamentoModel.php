<?php

namespace App\Models;

use CodeIgniter\Model;

class FormaPagamentoModel extends BaseModel
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

    public function addStatus($status = null)
    {
        if (!is_null($status)) {
            $this->where('ativo', $status);
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
        $this->select('*');
        $this->where('ativo', true);
        $extrasArray = $this->findAll();

        $optionExtras = array_column($extrasArray, 'nome', 'id');

        $optionSelecione = [
            '' => 'Selecione...'
        ];

        $selectConteudo = $optionSelecione + $optionExtras;

        return $selectConteudo;
    }

}

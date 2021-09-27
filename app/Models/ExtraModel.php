<?php

namespace App\Models;

class ExtraModel extends BaseModel
{
    protected $table = 'extras';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $allowedFields = ['nome', 'ativo', 'slug', 'preco', 'descricao'];

    // Dates
    protected $createdField = 'criado_em';
    protected $updatedField = 'atualizado_em';
    protected $deletedField = 'deletado_em';

    protected $beforeInsert = ['criaSlug', 'corrigeValor'];
    protected $beforeUpdate = ['criaSlug', 'corrigeValor'];

    protected $validationRules = [
        'nome' => 'required|min_length[2]|max_length[128]|is_unique[extras.nome, id,{id}]'
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
<?php

namespace App\Models;

class MedidaModel extends BaseModel
{
    protected $table = 'medidas';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $allowedFields = ['nome', 'ativo', 'descricao'];

    // Dates
    protected $createdField = 'criado_em';
    protected $updatedField = 'atualizado_em';
    protected $deletedField = 'deletado_em';


    protected $validationRules = [
        'nome' => 'required|min_length[2]|max_length[128]|is_unique[medidas.nome, id,{id}]'
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

    /**
     * Utilizado em Produto/Exibe valor para retornar o maior valor entre os dois produtos
     * @param int $medida_id
     * @param int $primeiro_produto
     * @param int $segundo_produto
     * @return array|object|null
     */
    public function exibeValor(int $medida_id, int $primeiro_produto, int $segundo_produto)
    {
        return $this->select('medidas.nome')
            ->selectMax('produtos_especificacoes.preco')
            ->join('produtos_especificacoes', 'produtos_especificacoes.medida_id = medidas.id')
            ->where('medidas.id', $medida_id)
            ->where('medidas.ativo', true)
            ->whereIn('produtos_especificacoes.produto_id', [$primeiro_produto, $segundo_produto])
            ->first();
    }
}
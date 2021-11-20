<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoEspecificacaoModel extends Model
{
    protected $table                = 'produtos_especificacoes';
    protected $returnType           = 'array';
    protected $protectFields        = true;
    protected $allowedFields        = ['produto_id', 'medida_id', 'preco', 'customizavel'];

    protected $validationRules = [
        'medida_id' => 'required|integer',
        'preco' => 'required|greater_than[0]'
    ];

    protected $validationMessages = [
        'medida_id' => [
            'required' => 'O campo Medida é obrigatório.'
        ],
    ];

    public function buscaEspecificacaoDoProduto(int $produto_id = null, int $paginacao)
    {
        return $this->select('medidas.nome as medida, produtos_especificacoes.*')
            ->join('medidas', 'medidas.id = produtos_especificacoes.medida_id')
            ->join('produtos', 'produtos.id = produtos_especificacoes.produto_id')
            ->where('produtos_especificacoes.produto_id', $produto_id)
            ->paginate($paginacao);
    }


}

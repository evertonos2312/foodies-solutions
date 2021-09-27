<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoExtraModel extends Model
{
    protected $table = 'produtos_extras';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['produto_id', 'extra_id'];

    protected $validationRules = [
        'extra_id' => 'required|integer',
    ];

    protected $validationMessages = [
        'extra_id' => [
            'required' => 'O campo Extra é obrigatório.'
        ],
    ];

    public function buscaExtrasDoProduto(int $produto_id = null, int $paginacao)
    {
        return $this->select('extras.nome as extra, extras.preco, produtos_extras.*')
            ->join('extras', 'extras.id = produtos_extras.extra_id')
            ->join('produtos', 'produtos.id = produtos_extras.produto_id')
            ->where('produtos_extras.produto_id', $produto_id)
            ->paginate($paginacao);
    }


}

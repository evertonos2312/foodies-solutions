<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model
{
    protected $table                = 'pedidos';
    protected $useSoftDeletes       = true;
    protected $afterFind = ['exibeSituacaoPedido'];
    protected $allowedFields        = [
        'usuario_id',
        'entregador_id',
        'codigo',
        'forma_pagamento',
        'situacao',
        'produtos',
        'valor_produtos',
        'valor_entrega',
        'valor_pedido',
        'endereco_entrega',
        'observacoes',
    ];

    // Dates
    protected $useTimestamps        = true;
    protected $createdField         = 'criado_em';
    protected $updatedField         = 'atualizado_em';
    protected $deletedField         = 'deletado_em';

    public function geraCodigoPedido()
    {
        do{
            $codigoPedido = random_string('numeric', 8);
            $this->where('codigo', $codigoPedido);
        }while($this->countAllResults() > 1);
        return $codigoPedido;
    }

    public function exibeSituacaoPedido(array $data)
    {
        
        if (isset($data['data']['situacao'])) {

            switch ($data['data']['situacao']) {
                case 0:
                    $data['data']['situacao_translate'] = "<i class='fa fa-thumbs-up text-primary' aria-hidden='true'></i>&nbsp;Pedido realizado";
                    break;
                case 1:
                    $data['data']['situacao_translate'] = "<i class='fa fa-motorcycle text-success' aria-hidden='true'></i>&nbsp;Saiu para entrega";
                    break;
                case 2:
                    $data['data']['situacao_translate'] = "<i class='fa fa-money text-success' aria-hidden='true'></i>&nbsp;Pedido entregue";
                    break;
                case 3:
                    $data['data']['situacao_translate'] = "<i class='fa fa-thumbs-down text-danger' aria-hidden='true'></i>&nbsp;Pedido cancelado";
                    break;
            }
        } elseif (is_array($data['data'])) {

            foreach ($data['data'] as &$pedido){
                switch ($pedido['situacao']) {
                    case 0:
                        $pedido['situacao_translate'] = "<i class='fa fa-thumbs-up text-primary' aria-hidden='true'></i>&nbsp;Pedido realizado";
                        break;
                    case 1:
                        $pedido['situacao_translate'] = "<i class='fa fa-motorcycle text-success' aria-hidden='true'></i>&nbsp;Saiu para entrega";
                        break;
                    case 2:
                        $pedido['situacao_translate'] = "<i class='fa fa-money text-success' aria-hidden='true'></i>&nbsp;Pedido entregue";
                        break;
                    case 3:
                        $pedido['situacao_translate'] = "<i class='fa fa-thumbs-down text-danger' aria-hidden='true'></i>&nbsp;Pedido cancelado";
                        break;
                }
            }
            return $data;
        }

        return $data;
    }
}

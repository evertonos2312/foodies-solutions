<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriaTabelaPedidos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'usuario_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'entregador_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => true,
                'default' => null,
            ],
            'codigo' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'forma_pagamento' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'situacao' => [
                'type' => 'BOOLEAN',
                'null' => false,
                'default' => false, // 0 (Cancelado)  | 1 (Saiu para entrega) | 2 (Pedido entregue) | 3 (Cancelado)
            ],
            'produtos' => [
                'type' => 'TEXT',
            ],
            'valor_produtos' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'valor_entrega' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'valor_pedido' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'endereco_entrega' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'observacoes' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'criado_em' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
            'atualizado_em' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
            'deletado_em' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('entregador_id', 'entregadores', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pedidos');
    }

    public function down()
    {
        $this->forge->dropTable('pedidos');
    }
}

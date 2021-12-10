<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriaTabelaPedidosProdutos extends Migration
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
            'pedido_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'produto' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
            ],
            'quantidade' => [
                'type' => 'INT',
                'constraint' => 5,

            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('pedidos_produtos');
    }

    public function down()
    {
        $this->forge->dropTable('pedidos_produtos');
    }
}

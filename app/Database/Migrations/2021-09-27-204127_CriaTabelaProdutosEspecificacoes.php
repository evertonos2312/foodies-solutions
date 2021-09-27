<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriaTabelaProdutosEspecificacoes extends Migration
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
            'produto_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'medida_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'preco' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'customizavel' => [
                'type' => 'BOOLEAN',
                'null' => false,
                'default' => true
            ],

        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('produto_id', 'produtos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('medida_id', 'medidas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('produtos_especificacoes');
    }

    public function down()
    {
        $this->forge->dropTable('produtos_especificacoes');
    }
}

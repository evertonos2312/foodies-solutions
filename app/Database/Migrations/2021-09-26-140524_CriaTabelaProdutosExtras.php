<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriaTabelaProdutosExtras extends Migration
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
            'extra_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('produto_id', 'produtos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('extra_id', 'extras', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('produtos_extras');
    }

    public function down()
    {
        $this->forge->dropTable('produtos_extras');
    }
}

<?php

namespace App\Database\Seeds;

use App\Models\FormaPagamentoModel;
use CodeIgniter\Database\Seeder;

class FormasSeeder extends Seeder
{
    public function run()
    {
        $formaModel = new FormaPagamentoModel();

        $forma = [
            'nome' => 'Dinheiro',
            'ativo' => true,
        ];
        $formaModel->skipValidation(true)->insert($forma);
    }
}

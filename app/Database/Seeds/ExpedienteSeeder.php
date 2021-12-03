<?php

namespace App\Database\Seeds;

use App\Models\ExpedienteModel;
use CodeIgniter\Database\Seeder;

class ExpedienteSeeder extends Seeder
{
    public function run()
    {
        $expedienteModel = new ExpedienteModel();

        $expedientes = [
            [
            'dia' => 0,
            'dia_descricao' => 'Domingo',
            'abertura' => '18:00:00',
            'fechamento' => '23:00:00',
            'situacao' => true
            ],
            [
            'dia' => 1,
            'dia_descricao' => 'Segunda-feira',
            'abertura' => '18:00:00',
            'fechamento' => '23:00:00',
            'situacao' => true
            ],
            [
            'dia' => 2,
            'dia_descricao' => 'Terça-feira',
            'abertura' => '18:00:00',
            'fechamento' => '23:00:00',
            'situacao' => true
            ],
            [
            'dia' => 3,
            'dia_descricao' => 'Quarta-feira',
            'abertura' => '18:00:00',
            'fechamento' => '23:00:00',
            'situacao' => true
            ],
            [
            'dia' => 4,
            'dia_descricao' => 'Quinta-feira',
            'abertura' => '18:00:00',
            'fechamento' => '23:00:00',
            'situacao' => true
            ],
            [
            'dia' => 5,
            'dia_descricao' => 'Sexta-feira',
            'abertura' => '18:00:00',
            'fechamento' => '23:00:00',
            'situacao' => true
            ],
            [
            'dia' => 6,
            'dia_descricao' => 'Sábado',
            'abertura' => '18:00:00',
            'fechamento' => '23:00:00',
            'situacao' => true
            ],
        ];

        foreach ($expedientes as $expediente) {
            $expedienteModel->protect(false)->insert($expediente);
        }
    }
}

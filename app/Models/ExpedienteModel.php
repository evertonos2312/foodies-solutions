<?php

namespace App\Models;

use CodeIgniter\Model;

class ExpedienteModel extends BaseModel
{
    protected $table                = 'expediente';
    protected $allowedFields        = [
        'abertura',
        'fechamento',
        'situacao',
    ];


    // Validation
    protected $validationRules      = [
        'abertura' => 'required',
        'fechamento' => 'required'
    ];

}

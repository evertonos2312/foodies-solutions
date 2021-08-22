<?php

namespace App\Models;

class UsuarioModel extends BaseModel
{
    protected $table = 'usuarios';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['nome', 'email', 'telefone', 'is_admin', 'ativo'];

    protected $createdField = 'criado_em';
    protected $updatedField = 'atualizado_em';
    protected $deletedField = 'deletado_em';

    public function procurar($term)
    {
        if (is_null($term)) {
            return [];
        }
        return $this->select('id, nome')->like('nome', $term)->findAll();
    }

}

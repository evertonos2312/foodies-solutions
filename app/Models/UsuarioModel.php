<?php

namespace App\Models;

class UsuarioModel extends BaseModel
{
    protected $table = 'usuarios';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $allowedFields = ['nome', 'email', 'telefone', 'is_admin', 'ativo'];

    protected $createdField = 'criado_em';
    protected $updatedField = 'atualizado_em';
    protected $deletedField = 'deletado_em';

    protected $validationRules = [
        'nome' => 'required|min_length[4]|max_length[120]',
        'email' => 'required|valid_email|is_unique[usuarios.email, id,{id}]',
        'cpf' => 'required|is_unique[usuarios.cpf, id,{id}]|max_length[14]',
        'telefone' => 'required',
        'ativo' => 'required',
        'is_admin' => 'required',
        'password' => 'required|min_length[6]',
        'password_confirmation' => 'required_with[password]|matches[password]'
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'O campo Nome é obrigatório'
        ],
        'email' => [
            'required' => 'O campo E-mail é obrigatório',
            'is_unique' => 'Desculpe, esse email já existe'
        ],
        'cpf' => [
            'required' => 'O campo CPF é obrigatório',
            'is_unique' => 'Desculpe, esse CPF já está cadastrado.'
        ],
        'telefone' => [
            'required' => 'O campo Telefone é obrigatório'
        ],
        'password' => [
            'required' => 'O campo Senha é obrigatório'
        ],
        'password_confirmation' => [
            'matches' => 'Senhas não conferem'
        ],
        'is_admin' => [
            'required' => 'O campo Perfil é obrigatório'
        ],
        'ativo' =>[
            'required' => 'O campo Status é obrigatório'
        ]
    ];

    public function procurar($term)
    {
        if (is_null($term)) {
            return [];
        }
        return $this->select('id, nome')->like('nome', $term)->findAll();
    }

}

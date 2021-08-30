<?php

namespace App\Models;

class UsuarioModel extends BaseModel
{
    protected $table = 'usuarios';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $allowedFields = ['nome', 'email', 'telefone', 'cpf', 'is_admin', 'ativo', 'password_hash','ativacao_hash','reset_hash', 'reset_expira_em'];

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected $createdField = 'criado_em';
    protected $updatedField = 'atualizado_em';
    protected $deletedField = 'deletado_em';

    protected $validationRules = [
        'nome' => 'required|min_length[4]|max_length[120]',
        'email' => 'required|valid_email|is_unique[usuarios.email, id,{id}]',
        'cpf' => 'required|validaCpf|is_unique[usuarios.cpf, id,{id}]|max_length[14]',
        'telefone' => 'required',
        'ativo' => 'required',
        'is_admin' => 'required',
        'password' => 'required|min_length[6]',
        'password_confirmation' => 'required_with[password]|matches[password]'
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'O campo Nome é obrigatório.'
        ],
        'email' => [
            'required' => 'O campo E-mail é obrigatório.',
            'is_unique' => 'Desculpe, esse email já existe.'
        ],
        'cpf' => [
            'required' => 'O campo CPF é obrigatório',
            'is_unique' => 'Desculpe, esse CPF já está cadastrado.'
        ],
        'telefone' => [
            'required' => 'O campo Telefone é obrigatório.'
        ],
        'password' => [
            'required' => 'O campo Senha é obrigatório.',
            'min_length' => 'O campo senha deve conter pelo menos 6 caracteres no tamanho.'
        ],
        'password_confirmation' => [
            'matches' => 'Senhas não conferem.'
        ],
        'is_admin' => [
            'required' => 'O campo Perfil é obrigatório.'
        ],
        'ativo' =>[
            'required' => 'O campo Status é obrigatório'
        ]
    ];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            unset($data['data']['password']);
            unset($data['data']['password_confirmation']);
        }
        return $data;
    }

    public function procurar($term)
    {
        if (is_null($term)) {
            return [];
        }
        return $this->select('id, nome')->like('nome', $term)->findAll();
    }

    public function unsetPassword()
    {
        unset($this->validationRules['password']);
        unset($this->validationRules['password_confirmation']);
    }

    public function addStatus($status = null)
    {
        if (!is_null($status)) {
            switch ($status) {
                case 'ativo':
                    $this->where('ativo', 1);
                    break;
                case 'inativo':
                    $this->where('ativo', 0);
                    break;
                default:
                    break;
            }
        }
        return $this;
    }

    public function addTipo($tipo = null)
    {
        if (!is_null($tipo)) {
            switch ($tipo) {
                case 'adm':
                    $this->where('is_admin', 1);
                    break;
                case 'cli':
                    $this->where('is_admin', 0);
                    break;
                default:
                    break;
            }
        }
        return $this;
    }

    public function buscaUsuarioPorEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }
}

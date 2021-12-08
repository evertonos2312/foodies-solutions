<?php

namespace App\Libraries;

use App\Models\UsuarioModel;

class Authentication
{
    private $usuario;

    public function login(string $email, string $password): bool
    {
        $usuarioModel = new UsuarioModel();

        $usuario = $usuarioModel->buscaUsuarioPorEmail($email);

        if ($usuario === null) {
            return false;
        }

        if (!password_verify($password, $usuario['password_hash'])) {
            return false;
        }
        if (!$usuario['ativo']) {
            return false;
        }

        $this->logaUsuario($usuario);
        return true;
    }

    public function verificaPassword(string $password)
    {
        $usuario = $this->getUserLogged();
        return password_verify($password, $usuario['password_hash']);
    }

    public function logout()
    {
        session()->destroy();
    }

    public function getUserLogged()
    {
        if ($this->usuario === null) {
            $this->usuario = $this->getSessionUser();
        }
        return $this->usuario;
    }

    private function getSessionUser()
    {
        if (!session()->has('usuario_id')) {
            return null;
        }
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find(session()->get('usuario_id'));
        if ($usuario && $usuario['ativo']) {
            if ($usuario['is_admin']) {
                session()->set('isLoggedAdmin', true);
            } else {
                session()->set('pode_editar_ate', time() + 300);
                session()->set('isLoggedIn', true);
            }
            session()->set('auth_user', ['id' => $usuario['id'], 'nome' => $usuario['nome'], 'is_admin' => $usuario['is_admin'], 'is_master' => $usuario['is_master']]);
            return $usuario;
        }
    }

    public function estaLogado()
    {
        return $this->getUserLogged() !== null;
    }


    private function logaUsuario(array $usuario)
    {
        $session = session();
        $session->regenerate();
        $session->set('usuario_id', $usuario['id']);
    }
}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use Config\Services;

class Registrar extends BaseController
{
    private $usuarioModel;
    public function __construct()
    {
        parent::__construct();
        $this->usuarioModel = new UsuarioModel();
    }
    public function novo()
    {
        $this->data['title'] = 'Criar nova conta';
        return $this->display_template($this->smarty->setData($this->data)->view('Registrar/novo'));
    }

    public function criar()
    {
        if($this->request->getPost()) {

            $newUser = [
                'nome' => $this->request->getPost('nome'),
                'email' => $this->request->getPost('email'),
                'cpf' => $this->request->getPost('cpf'),
                'telefone' => $this->request->getPost('telefone'),
                'password' => $this->request->getPost('password'),
                'password_confirmation' => $this->request->getPost('password_confirmation'),
                'ativo' => 0,
                'is_admin' => 0

            ];
            $newUser = $this->usuarioModel->iniciaAtivacao($newUser);
            $saved = $this->usuarioModel->insert($newUser);

            if ($saved) {
                $this->enviaAtivacaoConta($newUser);
                $this->session->setFlashdata('msg', '
                    <strong>Perfeito!</strong><br>E-mail de ativação enviado para a sua caixa de entrada.
                    <p>Verifique sua caixa de entrada para ativar sua conta.</p>
                ');
                $this->session->setFlashdata('msg_type', 'alert-success');
                $id = $this->usuarioModel->getInsertID();

                return redirect()->to("registrar/ativacaoenviado");
            } else {

                $this->data['msg'] = $this->usuarioModel->errors();
                $this->data['msg_type'] = 'alert-danger';
                return redirect()->back();
            }
        }
        return redirect()->back();
    }

    public function ativacaoEnviado()
    {
        $this->data['title'] = 'E-mail enviado';
        return $this->display_template($this->smarty->setData($this->data)->view('Registrar/ativacaoenviado'));
    }

    public function ativar(string $token = null)
    {
        if(is_null($token)) {
            return redirect()->to('login');
        }
        $this->usuarioModel->ativarContaToken($token);
        $this->session->setFlashdata('msg', 'Conta ativada com sucesso, agora você pode fazer o login.');
        $this->session->setFlashdata('msg_type', 'alert-success');
        return redirect()->to(site_url('login'));

    }

    private function enviaAtivacaoConta($usuario)
    {
        $email = Services::email();
        $email->setFrom('no-reply@pizza-planet.fun', 'Pizza Planet');
        $email->setTo($usuario['email']);
        $email->setSubject('Ativacação de Conta');

        $mensagem = view('Registrar/ativacao_email', ['token' => $usuario['token'], 'nome'=> $usuario['nome']]);
        $email->setMessage($mensagem);
        $email->send();
    }
}

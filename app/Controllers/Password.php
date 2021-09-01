<?php

namespace App\Controllers;

use App\Libraries\Recaptcha;
use App\Libraries\Token;
use App\Models\UsuarioModel;
use Config\Services;

class Password extends BaseController
{
    private $usuarioModel;
    private $recaptcha;
    public $authentication;

    public function __construct()
    {
        parent::__construct();
        $this->usuarioModel = new UsuarioModel();
        $this->recaptcha = new Recaptcha();
        $this->authentication = service('authentication');
    }

    public function recover()
    {
        if ($this->request->isAJAX()) {
            $data = array();
            $data['token'] = csrf_hash();
            $recaptchaResponse = $this->request->getPost('recaptcha');

            $result_recaptcha = $this->recaptcha->verify($recaptchaResponse);
            
            if (!$result_recaptcha) {
                $data['code'] = 422;
                $data['status'] = 'error';
                $data['detail'] = '';
                $data['msg_error'] = 'Recaptcha inválido';
                return $this->response->setJSON($data);
            }

            $email = $this->request->getPost('email');
            if (!empty($email)) {
                $usuario = $this->usuarioModel->buscaUsuarioPorEmail($email);

                if (!empty($usuario)) {
                    $usuario = $this->passwordReset($usuario);
                    $this->enviaRedefinicaoSenha($usuario);
                    $this->usuarioModel->save($usuario);
                }

                $data['code'] = 200;
                $data['status'] = 'success';
                $data['detail'] = 'Solicitação recebida com sucesso';
                $data['msg_error'] = '';
            } else {
                $data['code'] = 503;
                $data['status'] = 'error';
                $data['detail'] = '';
                $data['msg_error'] = 'Campo email não enviado';
            }
            return $this->response->setJSON($data);
        }
        return view('errors/404');
    }

    public function recoverAdmin()
    {
        if ($this->request->isAJAX()) {
            $data = array();
            $data['token'] = csrf_hash();

            $email = $this->request->getPost('email');
            if (!empty($email)) {
                $usuario = $this->usuarioModel->buscaUsuarioPorEmail($email);

                if (!empty($usuario)) {
                    $usuario = $this->passwordReset($usuario);
                    $this->enviaRedefinicaoSenha($usuario);
                    $this->usuarioModel->save($usuario);
                }

                $data['code'] = 200;
                $data['status'] = 'success';
                $data['detail'] = 'Solicitação recebida com sucesso';
                $data['msg_error'] = '';
            } else {
                $data['code'] = 503;
                $data['status'] = 'error';
                $data['detail'] = '';
                $data['msg_error'] = 'Campo email não enviado';
            }
            return $this->response->setJSON($data);
        }
        return view('errors/404_admin');
    }

    public function reset($token = null)
    {
        if (!is_null($token)) {
            $usuario = $this->usuarioModel->buscaUsuarioToken($token);

            if (!is_null($usuario)) {
                $this->data['title'] = 'Redefina sua senha';
                $this->data['token'] = $token;
                return $this->display($this->smarty->setData($this->data)->view('Password/reset'));
            }
        }
        $this->session->setFlashdata('msg', "Link inválido ou expirado.");
        $this->session->setFlashdata('msg_type', 'alert-info');
        return redirect()->to(site_url('login'));
    }

    public function processar()
    {
        $token = $this->request->getPost('token');
        if (!empty($token)) {
            $usuario = $this->usuarioModel->buscaUsuarioToken($token);
            if ($usuario) {
                $usuario['password'] = $this->request->getPost('password');
                $usuario['password_confirmation'] = $this->request->getPost('password_confirmation');
                $saved = $this->usuarioModel->save($usuario);

                if ($saved) {
                    $usuario['reset_hash'] = null;
                    $usuario['reset_expira_em'] = null;
                    $this->usuarioModel->save($usuario);
                    $this->authentication->logout();
                    $this->session->setFlashdata('msg', "Nova senha cadastrada com sucesso.");
                    $this->session->setFlashdata('msg_type', 'alert-success');
                    return redirect()->to(site_url('login'));
                } else {
                    $this->data['msg'] = $this->usuarioModel->errors();
                    $this->data['msg_type'] = 'alert-danger';
                    $this->data['title'] = 'Redefina sua senha';
                    $this->data['token'] = $token;
                    return $this->display($this->smarty->setData($this->data)->view('Password/reset'));

                }
            }
        }
        $this->session->setFlashdata('msg', "Link inválido ou expirado.");
        $this->session->setFlashdata('msg_type', 'alert-info');
        return redirect()->to(site_url('login'));
    }

    private function passwordReset($usuario)
    {
        $token = new Token();
        $usuario['reset_token'] = $token->getValue();
        $usuario['reset_hash'] = $token->getHash();
        $usuario['reset_expira_em'] = date("Y-m-d H:i:s", time() + 7200);
        return $usuario;
    }

    private function enviaRedefinicaoSenha($usuario)
    {
        $email = Services::email();
        $email->setFrom('no-reply@pizza-planet.fun', 'Pizza Planet');
        $email->setTo($usuario['email']);
        $email->setSubject('Redefinição de senha');

        $mensagem = view('Password/reset_email', ['token' => $usuario['reset_token'], 'nome'=> $usuario['nome']]);
        $email->setMessage($mensagem);
        $email->send();
    }
}

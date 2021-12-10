<?php

namespace App\Controllers;

class Login extends BaseController
{
    public $authentication;

    public function __construct()
    {
        parent::__construct();
        $this->data['site_key'] = '6LfcUHkbAAAAAPQZpcz1ZtkFmfclnbtA8inTnJil';
        $this->authentication = service('authentication');
    }
    public function novo()
    {
        $this->data['title'] = 'Realize o Login';
        return $this->display($this->smarty->setData($this->data)->view('Login/novo'));
    }

    public function criar()
    {
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            if ($this->authentication->login($email, $password)) {
                $usuario = $this->authentication->getUserLogged();

                if(!$usuario['is_admin']) {

                    if(session()->has('carrinho')) {
                       return redirect()->to(site_url('checkout'));
                    }
                    return redirect()->to(site_url('/'));
                }
                $this->session->setFlashdata('msg', "Olá {$usuario['nome']}, que bom que está de volta.");
                $this->session->setFlashdata('msg_type', 'alert-success');
                return redirect()->to(site_url('admin/home'));
            } else {
                $this->data['msg'] = 'E-mail ou senha inválidos';
                $this->data['msg_type'] = 'alert-danger';
                return $this->display($this->smarty->setData($this->data)->view('Login/novo'));
            }
        } else {
            return redirect()->to('login/novo');
        }
    }

    public function logout()
    {
        $usuario = $this->authentication->getUserLogged();
        if(!is_null($usuario) && $usuario['is_admin'] ){
            $this->authentication->logout();
            $this->session->setFlashdata('msg', "Esperamos ver você novamente");
            $this->session->setFlashdata('msg_type', 'alert-info');
            return redirect()->to(site_url('/login'));
        } else {
            $this->authentication->logout();
            return redirect()->to(site_url('/'));
        }
    }
}

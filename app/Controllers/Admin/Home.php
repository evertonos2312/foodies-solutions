<?php

namespace App\Controllers\Admin;

use App\Models\EntregadorModel;
use App\Models\PedidoModel;
use App\Models\UsuarioModel;

class Home extends AdminBaseController
{
    public $data = array();
    private $pedidoModel;
    private $usuarioModel;
    private $entregadorModel ;

    public function __construct()
    {
        parent::__construct();
        $this->data['active'] = 'dashboard';
        $this->pedidoModel = new PedidoModel();
        $this->usuarioModel = new UsuarioModel();
        $this->entregadorModel = new EntregadorModel();
    }

    public function index()
    {

        $novosPedidos = $this->pedidoModel->getPedidosCliente();
        if(!empty($novosPedidos)) {
            $this->data['novosPedidos'] = $novosPedidos;
        }


        $this->data['title'] = 'Início';
        $this->data['horaAtual'] = date('d/m/Y H:i:s');
        $this->data['valorPedidosEntregues'] = $this->pedidoModel->valorPedidosEntregues();
        $this->data['valorPedidosCancelados'] = $this->pedidoModel->valorPedidosCancelados();
        $this->data['totalClientesAtivos'] = $this->usuarioModel->recuperaTotalClientesAtivos();
        $this->data['totalEntregadoresAtivos'] = $this->entregadorModel->recuperaTotalEntregadoresAtivos();
        return $this->render($this->data, 'Admin/Home/index');
    }
}

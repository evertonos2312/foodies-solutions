<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ExpedienteModel;

class Expedientes extends AdminBaseController
{
    private $expedienteModel;
    public function __construct()
    {
        parent::__construct();
        $this->expedienteModel = new ExpedienteModel();
        $this->data['active'] = 'expedientes';
        $this->breadcrumb->add('Expedientes', '/admin/expedientes/expedientes');
    }

    public function expedientes()
    {
        if ($this->request->getPost()) {
            $postExpedientes = $this->request->getPost();
            $arrayExpedientes = [];

            for($contador = 0; $contador < count($postExpedientes['dia_descricao']); $contador++) {
                array_push($arrayExpedientes, [
                    'dia_descricao' => $postExpedientes['dia_descricao'][$contador],
                    'abertura' => $postExpedientes['abertura'][$contador],
                    'fechamento' => $postExpedientes['fechamento'][$contador],
                    'situacao' => $postExpedientes['situacao'][$contador],
                ]);
            }
           $this->expedienteModel->updateBatch($arrayExpedientes, 'dia_descricao');
           $this->session->setFlashdata('msg', 'Expedientes atualizados com sucesso');
           $this->session->setFlashdata('msg_type', 'alert-success');
           $this->data['title'] = 'Gerenciar o horário de funcionamento';
           $this->data['expedientes'] = $this->expedienteModel->findAll();
           return $this->render($this->data, 'Admin/Expedientes/expediente');


        }

        $this->data['title'] = 'Gerenciar o horário de funcionamento';
        $this->data['expedientes'] = $this->expedienteModel->findAll();
        return $this->render($this->data, 'Admin/Expedientes/expediente');
    }
}

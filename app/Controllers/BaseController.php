<?php

namespace App\Controllers;

use App\Models\ExpedienteModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\libraries\Breadcrumb;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['html', 'form', 'url', 'funcoes', 'filesystem', 'text'];
    public $smarty;
    public $check_expediente;
    public $breadcrumb;
    /*
    Session core service of CI
    */
    public $session;
    /*
    @class of Smarty
    Smarty it's a TPL Engine for PHP
    Because the Parser of CI4 it's limited for functions and vars display
    */
    public $view;
    /*
    @var string
    Generic template for views
    */
    public $template = '_common';

    /*
    @var string
    Generic template for views
    */
    public $template_file = 'layout';

    /**
     * Instance of the main Request object.
     *
     * @var HTTP\IncomingRequest
     */
    protected $request;

    /**
     * Instance of the main Request object.
     *
     * @var HTTP\ResponseInterface
     */
    protected $response;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->breadcrumb = new \App\Libraries\Breadcrumb();
        $this->check_expediente = $this->checkAbertura();
    }

    /**
     * Constructor.
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param LoggerInterface $logger
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.: $this->session = \Config\Services::session();
        $this->session = \Config\Services::session();
        $this->smarty = new \App\Libraries\SmartyCI(true);
        $this->SetView();
        $this->SetInitialData();
    }

    public function SetView()
    {
        $this->view = new \App\Libraries\SmartyCI();
    }

    public function SetInitialData()
    {
        //Initial data for view, assuming this it's gonna be used in all pages
        $msg_type = ($this->session->getFlashdata('msg_type')) ? $this->session->getFlashdata('msg_type') : '';
        $expedienteModel = new ExpedienteModel();
        $carrinho_count = 0;
        if ($this->session->has('carrinho') && count($this->session->get('carrinho')) > 0) {
            $carrinho_exists = true;
            $carrinho_count = count($this->session->get('carrinho'));
        } else {
            $carrinho_exists = false;
        }

        $dataArr = array(
            'app_url' => base_url() . '/',
            'msg' => $this->session->getFlashdata('msg'),
            'msg_type' => $msg_type,
            'title' => '',
            'active' => '',
            'sub_active' => '',
            'breadcrumbs' => '',
            'expedientes' => $expedienteModel->findAll(),
            'aberto_fechado' => ($this->checkAbertura()) ? 'estamos abertos' : 'estamos fechados',
            'check_expediente' => $this->checkAbertura(),
            'save_data_errors' => $this->session->getFlashdata('save_data_errors'),
            'carrinho_exists' => $carrinho_exists,
            'carrinho_count' => $carrinho_count,
            'isLoggedIn' => $this->session->get('isLoggedIn'),
            'isLoggedAdmin' => $this->session->get('isLoggedAdmin'),
            'auth_user' => ($this->session->get('auth_user')) ? $this->session->get('auth_user') : null,
        );
        $this->smarty->setData($dataArr);
    }

    public function checkAbertura()
    {
        $expedienteModel = new ExpedienteModel();
        $today = date('w');
        $expediente = $expedienteModel->where('dia', $today)->first();
        $horaAtual = date('H:i:s');
        if(!is_null($expediente) && $expediente['situacao'] == 0) {
            return false;
        }
        if(!is_null($expediente) &&  $horaAtual >= $expediente['abertura'] && $horaAtual <= $expediente['fechamento']) {
            return true;
        }
        return false;
    }


    public function display_template($content)
    {
        return $this->display($this->smarty->setData(array('content' => $content))->view('_common/' . $this->template_file));
    }

    public function display($content)
    {
        return $content;
    }

    public function render(array $data, string $content)
    {
        $data['breadcrumbs'] = $this->breadcrumb->render();
        return $this->display_template($this->smarty->setData($data)->view($content));
    }
}

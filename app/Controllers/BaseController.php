<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

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
    protected $helpers = ['html', 'form', 'url', 'funcoes', 'filesystem'];
    public $smarty;
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

        $this->session->set('id_usuario', 1);
    }

    public function SetView()
    {
        $this->view = new \App\Libraries\SmartyCI();
    }

    public function SetInitialData()
    {
        //Initial data for view, assuming this it's gonna be used in all pages
        $msg_type = '';
        if ($this->session->getFlashdata('msg_type') == 'success') {
            $msg_type = 'alert-success';
        } elseif ($this->session->getFlashdata('msg_type') == 'alert') {
            $msg_type = 'alert-danger';
        }
        $dataArr = array(
            'app_url' => base_url() . '/',
            'msg' => $this->session->getFlashdata('msg'),
            'msg_type' => $msg_type,
            'title' => '',
            'active' => '',
            'save_data_errors' => $this->session->getFlashdata('save_data_errors'),
            'isLoggedIn' => $this->session->get('isLoggedIn'),
            'isLoggedAdmin' => $this->session->get('isLoggedAdmin'),
            'auth_part' => ($this->session->get('auth_part')) ? $this->session->get('auth_part') : null,
        );
        $this->smarty->setData($dataArr);
    }


    public function display_template($content)
    {
        return $this->display($this->smarty->setData(array('content' => $content))->view('_common/' . $this->template_file));
    }

    public function display($content)
    {
        return $content;
    }
}

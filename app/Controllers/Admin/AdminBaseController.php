<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class AdminBaseController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->template_file = 'Admin/layout';
    }
}

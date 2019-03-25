<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('json');
    }

    public function index() {
        if ($this->session->userdata('log') == 1) {
            $data["usuario"] = $this->session->userdata('usuario');
            $data["rol"] = $this->session->userdata('rol');
            $data["email"] = $this->session->userdata('email');
            $this->load->view('index',$data);
        }else{
            $this->session->sess_destroy();
            redirect('/', 'location');
        }
    }

}
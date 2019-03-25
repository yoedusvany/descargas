<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 19/02/16
 * Time: 8:40
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('json');
        $this->load->model('usuario_model');
    }


    public function listar() {
        $data = $this->usuario_model->getUsuarios();

        if ($data) {
            $this->json->GenerarRespJSON($data, count($data));
        } else {
            $this->json->setReason('No existen usuarios');
            $this->json->GenerarMensajeJSONText();
        }
    }

    public function update() {
        $username = $this->input->post("username");
        $rol = $this->input->post("rol");

        $result = $this->usuario_model->updateRol($username, $rol);

        if ($result) {
            $this->json->setSuccess(true);
            $this->json->GenerarMensajeJSON();
        } else {
            $this->json->setReason('No se pudo actualizar el rol');
            $this->json->GenerarMensajeJSONText();
        }
    }

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */

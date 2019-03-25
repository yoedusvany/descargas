<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Preguntas extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('json');
        $this->load->model('preguntas_model');
    }

    public function index() {
        $this->json->setReason('Acci&oacute;n inv&aacute;lida');
        $this->json->GenerarMensajeJSONText();
    }

    public function listar() {
        //$start = $this->input->get("start");
        //$limit = $this->input->get("limit");

        $data = $this->preguntas_model->listar();
        //$data = $this->preguntas_model->listar($start, $limit);
        if ($data) {
            $this->json->GenerarRespJSON($data, $this->preguntas_model->ContarFilas());
        } else {
            $this->json->setReason('No existen preguntas');
            $this->json->GenerarMensajeJSONText();
        }
    }

    public function insertar() {
        $this->load->library('logging');
        $user = $this->session->userdata('usuario');

        $p = $this->preguntas_model->insertar($this->session->userdata('usuario'), $this->input->post("pregunta"), date("Y-m-d"));
        if ($p) {
            $this->json->setSuccess(true);
            $this->json->GenerarMensajeJSON();

            /* $this->load->library('email');
              $this->load->model('usuario_model');
              $admins = $this->usuario_model->getAdmins();
              $emailUsuario = $this->usuario_model->getEmail($this->session->userdata('usuario'));

              for ($i = 0; $i < count($admins); $i++) {
              $this->email->from('telematicos@unica.cu', 'Sistema de Descargas');
              $this->email->to($admins[$i]->email);
              $this->email->subject('Han añadido una nueva pregunta para los admins');
              $this->email->message("El usuario " . $this->session->userdata('usuario') . " (" . $emailUsuario . ") ha a&ntilde;adido la siguiente pregunta: <br>" . $this->input->post("pregunta"));
              $this->email->send();
              } */

            //$msg = "";
            $logger = $this->logging->get_logger('simple');
            $logger->info(date('H:i:s') . " " . $this->input->ip_address() . " @" . $user . " Pregunta:'" . $this->input->post("pregunta") . "'");
        } else {
            $this->json->setReason('No se pudo insertar la pregunta.');
            $this->json->GenerarMensajeJSONText();

            $logger = $this->logging->get_logger('simple');
            $logger->info(date('H:i:s') . " " . $this->input->ip_address() . " @" . $user . " Pregunta: (No se pudo insertar)'" . $this->input->post("pregunta") . "'");
        }
    }

}

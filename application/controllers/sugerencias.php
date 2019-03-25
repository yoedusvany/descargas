<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sugerencias extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('json');
        $this->load->model('sugerencias_model');
    }

    public function index() {
        $this->json->setReason('Acci&oacute;n inv&aacute;lida');
        $this->json->GenerarMensajeJSONText();
    }

    public function listar() {
        $start = $this->input->get("start");
        $limit = $this->input->get("limit");


        $sugerencia = $this->sugerencias_model->listar($start, $limit);
        if ($sugerencia) {
            $this->json->GenerarRespJSON($sugerencia, $this->sugerencias_model->ContarFilas());
        } else {
            $this->json->setReason('No existen Sugerencias');
            $this->json->GenerarMensajeJSONText();
        }
    }

    public function insertar() {
        $sug = $this->input->post("sugerencia");
        $usuario = $this->session->userdata('usuario');

        $sugerencia = $this->sugerencias_model->insertar($usuario, $sug);
        if ($sugerencia) {
            $this->json->setSuccess(true);
            $this->json->GenerarMensajeJSONText();
            
            $this->load->library('email');
            $this->load->model('usuario_model');
            $admins =  $this->usuario_model->getAdmins();
            $emailUsuario =  $this->usuario_model->getEmail($usuario);

            for($i=0; $i<count($admins); $i++) {
                $this->email->from('telematicos@unica.cu', 'Sistema de Descargas');
                $this->email->to($admins[$i]->email);
                $this->email->subject('Han añadido una nueva sugerencia para los admins');
                $this->email->message("El usuario ".$usuario." (".$emailUsuario.") ha a&ntilde;adido la siguiente sugerencia: <br>/n".$sug);
                $this->email->send();
            }
        } else {
            $this->json->setReason('No se pudo insertar la sugerencia.');
            $this->json->GenerarMensajeJSONText();
        }
    }

    public function borrar() {
        $id_sugerencia = $this->input->post("id_sugerencia");
        $sugerencia = $this->sugerencias_model->borrar($id_sugerencia);
        if ($sugerencia) {
            $this->json->setSuccess(true);
            $this->json->GenerarRespJSON();
        } else {
            $this->json->setReason('No se pudo borrar el &aacute;rea.');
            $this->json->GenerarMensajeJSONText();
        }
    }

}

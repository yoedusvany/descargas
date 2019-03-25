<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Respuesta extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('json');
        $this->load->model('respuestas_model');
    }

    public function index() {
        $this->json->setReason('Acci&oacute;n inv&aacute;lida');
        $this->json->GenerarMensajeJSONText();
    }

    public function listar() {
        $start = $this->input->get("start");
        $limit = $this->input->get("limit");

        $respuesta = $this->respuestas_model->listar($start, $limit);
        if ($respuesta) {
            $this->json->GenerarRespJSON($respuesta, $this->respuestas_model->ContarFilas());
        } else {
            $this->json->setReason('No existen respuestas');
            $this->json->GenerarMensajeJSONText();
        }
    }

    public function insertar() {
        $id_pregunta = $this->input->post("idhIdPregunta");
        $response = $this->input->post("respuesta");

        $respuesta = $this->respuestas_model->insertar($id_pregunta, $response, date("Y-m-d"));
        if ($respuesta) {
            $this->json->setSuccess(true);
            $this->json->GenerarMensajeJSONText();

            $this->load->library('email');
            $this->load->model('usuario_model');
            $this->load->model('preguntas_model');
            $dataPreg = $this->preguntas_model->getDataPregunta($id_pregunta);
            $emailUsuario = $this->usuario_model->getEmail($dataPreg->username);


            $this->email->from('telematicos@unica.cu', 'Sistema de Descargas');
            $this->email->to($emailUsuario);
            $this->email->subject('Respuesta del sistema de Descargas');
            $this->email->message("El administrador del sistema ha contestado a la pregunta: <br>" . $dataPreg->pregunta . " registrada por usted el d&iacute;a: " . $dataPreg->fecha . " lo siguiente: <br>" . $response);
            $this->email->send();
        } else {
            $this->json->setReason('No se pudo insertar la respuesta. Puede que esta respuesta exista para esta pregunta');
            $this->json->GenerarMensajeJSONText();
        }
    }

    public function borrar() {
        $this->load->library('logging');
        $user = $this->session->userdata('usuario');

        $id_respuesta = $this->input->post("id_respuesta");
        $respuesta = $this->respuestas_model->borrar($id_respuesta);
        if ($respuesta) {
            $this->json->setSuccess(true);
            $this->json->GenerarRespJSON();
            
            $msg = "Se borro la respuesta satisfactoriamente";
            $logger = $this->logging->get_logger('simple');
            $logger->info(date('H:i:s') . " " . $this->input->ip_address() . " @" . $user . " '" . $msg . "'");
        } else {
            $this->json->setReason('No se pudo borrar el &aacute;rea.');
            $this->json->GenerarMensajeJSONText();

            $msg = "No se pudo borrar la respuesta ".$id_respuesta;
            $logger = $this->logging->get_logger('simple');
            $logger->info(date('H:i:s') . " " . $this->input->ip_address() . " @" . $user . " '" . $msg . "'");
        }
    }
    
    public function getRespuesta(){
        $id_pregunta = $this->input->post("id_pregunta");
        $respuesta = $this->respuestas_model->getRespuesta($id_pregunta);
        
        if ($respuesta) {
            $this->json->setSuccess(true);
            $this->json->GenerarRespJSON($respuesta, count($respuesta));
        } else {
            $this->json->setReason('No se pudo obtener la respuesta.');
            $this->json->GenerarMensajeJSONText();
        }
    }

}

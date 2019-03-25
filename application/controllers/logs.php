<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logs extends CI_Controller {

    private $path;
    private $sfile;

    function __construct() {
        parent::__construct();
        $this->load->model('json');
        //$this->load->library('logging');
        $this->load->helper('file');

        if (PHP_OS == "Linux") {
            $this->path = $_SERVER['DOCUMENT_ROOT'] . "/application/logs/";
        } else {
            $this->path = $_SERVER['DOCUMENT_ROOT'] . "\\descargas\\application\\logs\\";
        }

        $this->sfile = "log-simple-";
    }

    public function index() {
        $this->json->setReason('Acci&oacute;n inv&aacute;lida');
        $this->json->GenerarMensajeJSONText();
    }

    public function listar() {
        $this->load->helper('date');

        if ($this->input->post('fecha')) {
            $fecha = substr($this->input->post('fecha'), 0, 10);
        } else {
            $fecha = date("Y-m-d");
        }
        
        if (file_exists($this->path . $this->sfile . $fecha . ".php")) {
            $file = file($this->path . $this->sfile . $fecha . ".php");

            for ($i = 0; $i < count($file); $i++) {
                $temp = explode(' ', $file[$i]);

                $data["hora"] = $temp[0];
                $data["ip"] = $temp[1];
                $data["usuario"] = substr($temp[2], 1, strlen($temp[1]) );
                $data["mensaje"] = substr($file[$i], strpos($file[$i], "'"), strlen($file[$i]));
                $array[] = $data;
            }

            if (count($file) > 0) {
                $this->json->GenerarRespJSON($array, count($array));
            } else {
                $this->json->setReason('No existen logs para esta fecha');
                $this->json->GenerarMensajeJSONText();
            }
        }  else {
            $this->json->setReason('No existen logs');
            $this->json->GenerarMensajeJSONText();
        }
    }

}

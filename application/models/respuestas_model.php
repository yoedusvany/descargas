<?php

/**
 * Description of respuesta
 *
 * @author Administrador
 */
class Respuestas_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * funcion para insertar una nueva respuesta
     * @param 
     * @return <boolean>
     */
    function insertar($id_pregunta, $respuesta, $fecha) {
        $this->db->where("respuesta", $respuesta);
        $this->db->where("id_pregunta", $id_pregunta);
        $query = $this->db->get("respuesta");

        if ($query->num_rows() > 0) {
            return false;
        } else {
            $data = array(
                'id_pregunta' => $id_pregunta,
                'respuesta' => $respuesta,
                'fecha' => $fecha
            );
            $result = $this->db->insert('respuesta', $data);

            $data = array(
                'resuelta' => 'SI'
            );
            $this->db->where("id_pregunta", $id_pregunta);
            $result = $this->db->update('pregunta', $data);

            if ($result) {
                $this->db->close();

                $this->db->select("username");
                $this->db->where("id_pregunta", $id_pregunta);
                $query = $this->db->get("pregunta");
                $usuario = $query->result_object();
                //print_r($usuario);

                $this->load->library('email');
                $this->load->model("usuario_model");
                
                $this->email->from("descargas@unica.cu", "SI-Descargas Centralizadas");
                
                $this->email->to($this->usuario_model->getEmail($usuario[0]->username));
                $this->email->subject('Respuesta a la pregunta realizada en el SDC');
                $this->email->message('El administrador del sistema ha respondido: <br><br>' .$respuesta);
                $this->email->send();
                //echo $this->email->print_debugger();

                return TRUE;
            } else {
                $this->db->close();
                return FALSE;
            }
        }
    }

    /**
     * funcion para borrar una respuesta
     * @param <int> $id_respuesta
     * @return <boolean>
     */
    function borrar($id_respuesta) {
        $data = array(
            'id_respuesta' => $id_respuesta
        );
        $this->db->delete('respuesta', $data);

        if ($this->db->affected_rows() > 0) {
            $this->db->close();
            return TRUE;
        } else {
            $this->db->close();
            return FALSE;
        }
    }

    /**
     * funcion para obtener la respuesta dada una pregunta
     * @param <int> $idPregunta
     * @return <string>
     */
    function getRespuesta($idPregunta) {
        $this->db->where("id_pregunta", $idPregunta);
        $query = $this->db->get('respuesta');

        if ($query->num_rows() > 0) {
            foreach ($query->result_object() as $row) {
                $data[] = $row;
            }
            $this->db->close();
            return $data;
        } else {
            $this->db->close();
            return FALSE;
        }
    }

}
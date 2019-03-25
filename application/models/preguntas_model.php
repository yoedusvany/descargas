<?php

/**
 * Description of pregunta
 *
 * @author Administrador
 */
class Preguntas_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    
    /**
     * funcion para listar las preguntas existentes
     * @return <json>
     */
    function listar($start = 0, $limit = 50) {
        
        $query = $this->db->get('pregunta');
        
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

    /**
     * funcion para insertar una nueva pregunta
     * @param 
     * @return <boolean>
     */
    function insertar($username, $pregunta, $fecha) {
        $data = array(
            'username' => $username,
            'pregunta' => $pregunta,
            'fecha' => $fecha,
            'resuelta' => "NO"
        );
        $result = $this->db->insert('pregunta', $data);

        if ($result) {
            $this->db->close();
            return TRUE;
        } else {
            $this->db->close();
            return FALSE;
        }
    }

    /**
     * funcion para actualizar una pregunta
     * @param <int> $id_pregunta
     * @return <boolean>
     */
    function actualizar($id_pregunta, $pregunta = '') {
        if ($pregunta != '') {
            $data['pregunta'] = $pregunta;
        }
        $this->db->where('id_pregunta', $id_pregunta);
        $this->db->update('pregunta', $data);

        if ($this->db->affected_rows() > 0) {
            $this->db->close();
            return true;
        } else {
            $this->db->close();
            return false;
        }
    }

    /**
     * funcion para borrar una pregunta
     * @param <int> $id_pregunta
     * @return <boolean>
     */
    function borrar($id_pregunta) {
        $data = array(
            'id_pregunta' => $id_pregunta
        );
        $this->db->delete('pregunta', $data);

        if ($this->db->affected_rows() > 0) {
            $this->db->close();
            return TRUE;
        } else {
            $this->db->close();
            return FALSE;
        }
    }
    
    /**
     * funcion para obtener la cantidad de preguntas
     * @return <int>
     */
    function ContarFilas()
    {
        return $this->db->count_all('pregunta');    
    }
    
    
    /**
     * funcion para obtener el usuario que origino una pregunta determinada
     * @return <string>
     */
    function getDataPregunta($idPregunta) {
        $this->db->select('username,pregunta,fecha');
        $this->db->where("id_pregunta", $idPregunta);
        $query = $this->db->get('pregunta');

        if ($query->num_rows() > 0) {
            foreach ($query->result_object() as $row) {
                $this->db->close();
                return $row;
            }
        } else {
            $this->db->close();
            return FALSE;
        }
    }

}

?>
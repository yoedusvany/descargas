<?php
/**
 * Description of sugerencia
 *
 * @author Administrador
 */
class Sugerencias_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * funcion para listar las preguntas existentes
     * @return <json>
     */
    function listar($start = 0, $limit = 50) {
        if(is_null($limit)){
            $limit = 50;
        }
        if($limit == "-1"){
            $limit = $this->ContarFilas();
        }

        $query = $this->db->get('sugerencia', $limit, $start);

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
     * funcion para insertar una nueva sugerencia
     * @param 
     * @return <boolean>
     */
    function insertar($username,$sugerencia) {
        $data = array(
            'username' => $username,
            'sugerencia' => $sugerencia
        );
		
        $result = $this->db->insert('sugerencia', $data);

        if ($result) {
            $this->db->close();
            return TRUE;
        } else {
            $this->db->close();
            return FALSE;
        }
    }
    
	/**
     * funcion para actualizar una sugerencia
     * @param <int> $id_pregunta
     * @return <boolean>
     */
	function actualizar($id_sugerencia, $sugerencia = '') {
        if ($sugerencia != '') {
            $data['sugerencia'] = $sugerencia;
        }
        $this->db->where('id_sugerencia', $id_sugerencia);
        $this->db->update('sugerencia', $data);

        if ($this->db->affected_rows() > 0) {
            $this->db->close();
            return true;
        } else {
            $this->db->close();
            return false;
        }
    }
	
	/**
     * funcion para borrar una sugerencia
     * @param <int> $id_pregunta
     * @return <boolean>
     */
    function borrar($id_sugerencia) {
        $data = array(
            'id_sugerencia' => $id_sugerencia
        );
        $this->db->delete('sugerencia', $data);

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
        return $this->db->count_all('sugerencia');
    }
}
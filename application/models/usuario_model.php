<?php

class Usuario_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * funcion para comprobar si existe un usuario
     * @return <json>
     */
    function comprobar($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('user');

        if ($query->num_rows() > 0) {
            $this->db->close();
            return true;
        } else {
            $this->db->close();
            return FALSE;
        }
    }
    
    /**
     * funcion para obtener todos los admins
     * @return <object>
     */
    function getAdmins() {
        $this->db->where('rol', 'admin');
        $query = $this->db->get('user');

        if ($query->num_rows() > 0) {
            foreach ($query->result_object() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return FALSE;
        }
    }

    /**
     * funcion para obtener todos los administradores locales
     * @return <object>
     */
    function getAdminsLocal() {
        $this->db->where('rol', 'adminlocal');
        $query = $this->db->get('user');

        if ($query->num_rows() > 0) {
            foreach ($query->result_object() as $row) {
                $data[] = $row->username;
            }
            return $data;
        } else {
            return FALSE;
        }
    }

    /**
     * funcion para insertar las usuario
     * @param <string> $usuario
     * @param <string> $email
     * @return <boolean>
     */
    function insertar($username, $email = '') {
        $data['username'] = $username;

        if ($email != '') {
            $data['email'] = $email;
        }

        $query = $this->db->insert('user', $data);

        if ($this->db->affected_rows() > 0) {
            $this->db->close();
            return TRUE;
        } else {
            $this->db->close();
            return FALSE;
        }
    }

    /**
     * funcion para obtener la cantidad de usuarios
     * @return <int>
     */
    function ContarFilas() {
        return $this->db->count_all('usuario');
    }

    /**
     * funcion para insertar inicio de sesion
     * @param <string> $usuario
     * @param <date> date
     * @return <boolean>
     */
    function insertarInicioSesion($username, $date) {
        $data['username'] = $username;
        $data['date'] = $date;

        $query = $this->db->insert('inicio_sesion', $data);

        if ($this->db->affected_rows() > 0) {
            $this->db->close();
            return TRUE;
        } else {
            $this->db->close();
            return FALSE;
        }
    }

    /**
     * funcion para obtener rol de un usuario
     * @return <string>
     */
    function getRol($username) {
        $this->db->select("rol");
        $this->db->where('username', $username);
        $query = $this->db->get('user');

        if ($query->num_rows() > 0) {
            foreach ($query->result_object() as $row) {
                return $row->rol;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * funcion para obtener email de un usuario
     * @return <string>
     */
    function getEmail($username) {
        $this->db->select("email");
        $this->db->where('username', $username);
        $query = $this->db->get('user');

        if ($query->num_rows() > 0) {
            foreach ($query->result_object() as $row) {
                return $row->email;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * funcion para establecer email de un usuario
     * @return <boolean>
     */
    function setEmail($usuario, $email) {
        $data = array(
            'email' => $email
        );
        $this->db->where('username', $usuario);
        $result = $this->db->update('user', $data);

        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * funcion para verificar si el usuario no sobrepasa la cant de descargas en un dia
     * @return <boolean>
     */
    function comprobarCantDescargas($username,$date) {
        $this->db->select("file.id_file");
        $this->db->from('file');
        $this->db->join('file_user', 'file.id_file = file_user.id_file');
        $this->db->join('user', 'file_user.username = user.username');
        $this->db->where('user.username', $username);
        $this->db->where('file.date', $date);
        $query = $this->db->get();
        
        $this->load->model("opciones_generales_model");
        $data = $this->opciones_generales_model->getOptions();

        if ($query->num_rows() >= $data[0]->cant_desc_x_user) {
            $this->db->close();
            return false;
        } else {
            $this->db->close();
            return true;
        }
    }

    public function getUsuarios() {
        $this->db->select('*');
        $this->db->from("user");
        $this->db->order_by("username", "desc");

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result_object() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return FALSE;
        }
    }


    /** Funcion para obtener la cantidad de descargas de un usuario determinado
     * @param $usuario
     * @return int
     */
    private function getCantDescargas($usuario){
        $this->db->select('id_file');
        $this->db->from("file_user");
        $this->db->where("username",$usuario);
        $query = $this->db->get();

        return $query->num_rows();
    }

    /** Funcion para obtener el total descargado de un usuario determinado
     * @param $usuario
     * @return float
     */
    private function getTotalDescargado($usuario){
        $this->db->select("SUM(CAST(size AS float)) as size");
        $this->db->from("file");
        $this->db->join("file_user","file_user.id_file = file.id_file");
        $this->db->join("user","user.username = file_user.username");
        $this->db->where("user.username",$usuario);
        $query = $this->db->get();

        //echo $this->db->last_query();
        //echo "<br>";
        //print_r($query->row());

        return $query->row()->size;
    }

    public function getResumenUsuarios() {
        $this->load->model("descargas_model");
        $totalDescargado = 0;
        $cantDescargas = 0;
        $nac = 0;

        $usuarios = $this->getUsuarios();

        for($i=0; $i<count($usuarios); $i++){
            $cantDescargas = $this->getCantDescargas($usuarios[$i]->username);
            $totalDescargado = $this->getTotalDescargado($usuarios[$i]->username);

            $data["usuario"] = $usuarios[$i]->username;
            $data["cantDescargas"] = $cantDescargas;
            $data["size"] = ($totalDescargado == 0) ? 0 : $totalDescargado;

            $nac = $this->descargas_model->getDescargasNacionales($usuarios[$i]->username);
            if($nac){
                //$data["nacionales"] = round((count($nac)*100) / $cantDescargas) / 100;
                $data["nacionales"] = ((count($nac)*100) / $cantDescargas) / 100;
                //$data["internacionales"] = round((($cantDescargas -count($nac))*100) / $cantDescargas) / 100;
                $data["internacionales"] = ((($cantDescargas -count($nac))*100) / $cantDescargas) / 100;
            }else{
                $data["nacionales"] = 0;
                //$data["internacionales"] = round(($cantDescargas*100) / $cantDescargas) / 100;
                //$data["internacionales"] = (($cantDescargas*100) / $cantDescargas) / 100;
                $data["internacionales"] = 1;
            }
            $object[] = $data;
        }

        return $object;
    }


    public function updateRol($username, $rol){
        $where = array(
            'username' => $username
        );
        $data = array(
            'rol' => $rol
        );
        $this->db->update('user', $data, $where);

        $query = $this->db->update('user', $data, $where);
    }

}

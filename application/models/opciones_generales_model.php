<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Opciones_generales_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * funcion para borrar obtener todas las opciones generales.
     * @return <array>
     */
    public function getOptions(){
        $query = $this->db->get("opciones_generales");
        
        if ($query->num_rows() > 0) {
            return $query->result_object();
            $this->db->close();
        } else {
            $this->db->close();
            return FALSE;
        }
    }
    
    /**
     * funcion para asignar un nuevo camino para salvar las descargas
     * @param string $path_to_save Camino donde se guardaran las descargas
     * @return <array>
     */    
    public function setPathToSsave($path_to_save){
            $data = array(
                'path_to_save' => $path_to_save
            );
            $this->db->update('opciones_generales', $data);

            if ($this->db->affected_rows() > 0) {
                $this->db->close();
                return TRUE;
            } else {
                $this->db->close();
                return FALSE;
            }

    }
    
    /**
     * funcion para asignar un nuevo tamanno de descarga como regla general
     * @param numeric $size_permitido Tamanno maximo de descarga
     * @return <boolean>
     */    
    public function setSizePermitido($size_permitido){
            $data = array(
                'size_permitido' => $size_permitido
            );
            $this->db->update('opciones_generales', $data);

            if ($this->db->affected_rows() > 0) {
                $this->db->close();
                return TRUE;
            } else {
                $this->db->close();
                return FALSE;
            }

    }
    
    /**
     * funcion para asignar el proxy por donde se va a descargar
     * @param string $proxy IP o dns del proxy
     * @return <boolean>
     */     
    public function setProxy($proxy){
            $data = array(
                'proxy' => $proxy
            );
            $this->db->update('opciones_generales', $data);

            if ($this->db->affected_rows() > 0) {
                $this->db->close();
                return TRUE;
            } else {
                $this->db->close();
                return FALSE;
            }

    }
    
    /**
     * funcion para asignar el puerto del proxy
     * @param int $proxyPort Puerto del proxy
     * @return <boolean>
     */         
    public function setProxyPort($proxyPort){
            $data = array(
                'proxy_port' => $proxyPort
            );
            $this->db->update('opciones_generales', $data);

            if ($this->db->affected_rows() > 0) {
                $this->db->close();
                return TRUE;
            } else {
                $this->db->close();
                return FALSE;
            }

    }
    
    /**
     * funcion para asignar el usuario que va a utilizar el proxy para las descargas
     * @param string $proxyUser Usuario que utilizara el proxy
     * @return <boolean>
     */   
    public function setProxyUser($proxyUser){
            $data = array(
                'proxy_user' => $proxyUser
            );
            $this->db->update('opciones_generales', $data);

            if ($this->db->affected_rows() > 0) {
                $this->db->close();
                return TRUE;
            } else {
                $this->db->close();
                return FALSE;
            }

    }
    
    /**
     * funcion para asignar el password del usuario que va a utilizar el proxy para las descargas
     * @param string $proxyPass Password del ProxyUser
     * @return <boolean>
     */   
    public function setProxyPass($proxyPass){
            $data = array(
                'proxy_pass' => $proxyPass
            );
            $this->db->update('opciones_generales', $data);

            if ($this->db->affected_rows() > 0) {
                $this->db->close();
                return TRUE;
            } else {
                $this->db->close();
                return FALSE;
            }

    }
    
    /**
     * funcion para asignar el password del usuario que va a utilizar el proxy para las descargas
     * @param string $proxyPass Password del ProxyUser
     * @return <boolean>
     */   
    public function setProxyUse($proxyUse){
            $data = array(
                'proxy_use' => $proxyUse
            );
            $this->db->update('opciones_generales', $data);

            if ($this->db->affected_rows() > 0) {
                $this->db->close();
                return TRUE;
            } else {
                $this->db->close();
                return FALSE;
            }

    }

    public function setOptionesgeneral($proxy, $proxyPort, $proxyUser, $proxyPass, $proxyUse, $path_to_save = '', $size_permitido = 0){
            if($path_to_save !=''){$op1 = $this->setPathToSsave($path_to_save);}    
            if($size_permitido != 0){$op2 = $this->setSizePermitido($size_permitido);}    
            
            $op3 = $this->setProxy($proxy);
            $op4 = $this->setProxyPort($proxyPort);
            $op5 = $this->setProxyUser($proxyUser);
            $op6 = $this->setProxyPass($proxyPass);
            if($proxyUse == "on"){
                $op7 = $this->setProxyUse("1");
            }else{
                $op7 = $this->setProxyUse("0");
            }
            
            //if ($op1 && $op2 && $op3 && $op4 && $op5 && $op6 && $op7) {
	    if ($op3 && $op4 && $op7) {
                $this->db->close();
                return TRUE;
            } else {
                $this->db->close();
                return FALSE;
            }

    }
    
    /**
     * funcion para asignar la cant de descargas a insertar en un dia por un usuario
     * @param integer $cant_url_permitida Cant. descargas permitidas
     * @return <boolean>
     */    
    public function setCantURLxDia($cant_url_permitida){
            $data = array(
                'cant_desc_x_user' => $cant_url_permitida
            );
            $this->db->update('opciones_generales', $data);

            if ($this->db->affected_rows() > 0) {
                $this->db->close();
                return TRUE;
            } else {
                $this->db->close();
                return FALSE;
            }

    }
    
}
?>

<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/12/15
 * Time: 22:15
 */

class Util_model extends CI_Model{

    function __construct() {
        parent::__construct();
    }


    /**
     * Método para convertir el tamaño de los ficheros en formato legible
     * @param string $size Size
     * @return <String>
     */
    function convertBytesToSize($size, $decimales = 2, $separador_decimal = ',', $separador_miles = '.') {
        if ($size >= 1024 * 1024 * 1024) {
            $unidad = "GB";
            $size = $size / 1024 / 1024 / 1024;
            return number_format($size, 2) . " " . $unidad;
        } elseif ($size >= 1024 * 1024) {
            $unidad = "MB";
            $size = $size / 1024 / 1024;
            return number_format($size, 2) . " " . $unidad;
        } elseif ($size >= 1024) {
            $unidad = "KB";
            $size = $size / 1024;
            return number_format($size, 2) . " " . $unidad;
            ;
        } elseif ($size <= 1023) {
            $unidad = "Bytes";
            $size = $size;
            return number_format($size, 2) . " " . $unidad;
        }
    }

    /**
     * Método para verificar si existe en BD una descarga ya
     * @param string $user Usuario
     * @return <boolean>
     */
    function existeUrlBD($url) {
        $this->db->where("url", $url);
        $query = $this->db->get('file');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return FALSE;
        }
    }

    /**
     * Método para verificar si existe en BD el fichero+ext
     * @param string $file
     * @param string $ext
     * @return <bolean>
     */
    function existeFile($file, $ext) {
        $this->db->where("name", $file);
        $this->db->where("ext", $ext);
        $query = $this->db->get('file');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return FALSE;
        }
    }

    /**
     * Metodo que devuelve el tamaño real del fichero en el sistema de fichero.
     * @param $namefile
     * @param $ext
     * @return int
     */
    public function getSizeReal($namefile, $ext) {
        $separador_path = $this->getSeparador();

        $f = @realpath("FILES") . $separador_path . $ext . $separador_path . $namefile . "." . $ext;
        return filesize($f);
    }

    /**
     * Método para obtener hora real a partir de una cantidad de segundos
     * @param string $segundos Segundos
     * @return <String>
     */
    public function convertTime($segundos) {
        $minutos = $segundos / 60;
        $horas = floor($minutos / 60);

        if ($horas > 24) {
            $dias = floor($horas / 24);
            $horas = fmod($horas, 24);
        }

        $minutos2 = $minutos % 60;
        $segundos_2 = $segundos % 60 % 60 % 60;

        if ($minutos2 < 10) {
            $minutos2 = '0' . $minutos2;
        }
        if ($segundos_2 < 10) {
            $segundos_2 = '0' . $segundos_2;
        }

        if ($segundos < 60) { // segundos
            $resultado = round($segundos);
            $resultado .= " (S)";
        } elseif ($segundos > 60 && $segundos < 3600) { // minutos
            $resultado = $minutos2 . ':' . $segundos_2;
            $resultado .= " (M:S)";
        } elseif ($segundos > 3600 && $segundos < 86400) { // horas
            $resultado = $horas . ':' . $minutos2 . ':' . $segundos_2;
            $resultado .= " (H:M:S)";
        } else {
            $resultado = $dias . ":" . $horas . ':' . $minutos2 . ':' . $segundos_2;
            $resultado .= " (D:H:M:S)";
        }

        return $resultado;
    }

    /**
     * Método para obtener la velocidad promedio en KBps, MBps o GBps a partir de la cantidad de bytes pasados
     * @param string $bytes Cant_Bytes
     * @return <String>
     */
    public function convertBytesVelocidadRED($bytes) {
        $result = $bytes / 1000;

        if ($result < 1000) {
            return round($result, 2) . "KBps";
        } elseif ($result >= 1000 && $result < 1000000) {
            $result = $result / 1000;
            return round($result, 2) . "MBps";
        } elseif ($result >= 1000000) {
            $result = $result / 1000 / 1000;
            return round($result, 2) . "GBps";
        }
    }

    /** Obtiene el separador segun el Sistema Operativo donde este el sistema
     * @return string
     */
    public function getSeparador(){
        if (PHP_OS == "Linux") {
            return "/";
        } else
            return "\\";
    }

    public function sendMail($to, $subject, $mensaje, $cc = ''){
        $this->load->library('email');
        $this->email->from("telematicos@unica.cu", "SI-Descargas Centralizadas");
        $this->email->to($to);
        if($cc != ''){
            $this->email->cc($cc);
        }
        $this->email->subject($subject);
        $this->email->message($mensaje);
        $this->email->send();
    }

    public function getDaysOfWeek(){
        $fechas = array();
        $dia = date('w');

        if($dia == 0){
            $now =  mktime()+86400;
            $fechas[] = date('Y-m-d');

            for($i= 1 ; $i<7; $i++){
                $fechas[] = date('Y-m-d',$now);
                $now += 86400;
            }
        }

        if($dia == 1){
            $now =  mktime()-86400; //domingo
            $fechas[] = date('Y-m-d',$now);
            $fechas[] = date('Y-m-d');

            $now +=86400*2; //martes

            for($i= 2 ; $i<7; $i++){
                $fechas[] = date('Y-m-d',$now);
                $now += 86400;
            }
        }

        if($dia == 2){
            $now =  mktime();
            $fechas[] = date('Y-m-d',$now-86400-86400);
            $fechas[] = date('Y-m-d',$now-86400);
            $fechas[] = date('Y-m-d');

            for($i= 3 ; $i<7; $i++){
                $fechas[] = date('Y-m-d',$now);
                $now += 86400;
            }
        }

        if($dia == 3){
            $now =  mktime();
            $fechas[] = date('Y-m-d',$now-86400-86400-86400);
            $fechas[] = date('Y-m-d',$now-86400-86400);
            $fechas[] = date('Y-m-d',$now-86400);
            $fechas[] = date('Y-m-d');

            for($i= 4 ; $i<7; $i++){
                $fechas[] = date('Y-m-d',$now);
                $now += 86400;
            }
        }

        if($dia == 4){
            $now =  mktime();
            $fechas[] = date('Y-m-d',$now-86400-86400-86400-86400);
            $fechas[] = date('Y-m-d',$now-86400-86400-86400);
            $fechas[] = date('Y-m-d',$now-86400-86400);
            $fechas[] = date('Y-m-d',$now-86400);
            $fechas[] = date('Y-m-d');
            $fechas[] = date('Y-m-d',$now+86400);
            $fechas[] = date('Y-m-d',$now+86400+86400);
        }

        if($dia == 5){
            $now =  mktime();
            $fechas[] = date('Y-m-d',$now-86400-86400-86400-86400-86400);
            $fechas[] = date('Y-m-d',$now-86400-86400-86400-86400);
            $fechas[] = date('Y-m-d',$now-86400-86400-86400);
            $fechas[] = date('Y-m-d',$now-86400-86400);
            $fechas[] = date('Y-m-d',$now-86400);
            $fechas[] = date('Y-m-d');
            $fechas[] = date('Y-m-d',$now+86400);
        }

        if($dia == 6){
            $now =  mktime();
            $fechas[] = date('Y-m-d',$now-86400-86400-86400-86400-86400-86400);
            $fechas[] = date('Y-m-d',$now-86400-86400-86400-86400-86400);
            $fechas[] = date('Y-m-d',$now-86400-86400-86400-86400);
            $fechas[] = date('Y-m-d',$now-86400-86400-86400);
            $fechas[] = date('Y-m-d',$now-86400-86400);
            $fechas[] = date('Y-m-d',$now-86400);
            $fechas[] = date('Y-m-d');
        }

        return $fechas;
    }

    public function comprobarAdministradores($user){
        $this->load->model("usuario_model");

        $administradores = $this->usuario_model->getAdmins();

        for($i = 0; $i < count($administradores); $i++){
            if($administradores[$i]->username == $user){
                return true;
            }
        }

        return false;
    }
}
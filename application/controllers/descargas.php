<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Descargas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('json');
        $this->load->model('descargas_model');
    }

    public function index() {
        $data = $this->descargas_model->getDescargas();

        if ($data) {
            $this->json->GenerarRespJSON($data, count($data));
        } else {
            $this->json->setReason('No existen descargas');
            $this->json->GenerarMensajeJSONText();
        }
    }

    private function convertMonths($noMonth) {
        if ($noMonth == 1) {
            return "Enero";
        } elseif ($noMonth == 2) {
            return "Febrero";
        } elseif ($noMonth == 3) {
            return "Marzo";
        } elseif ($noMonth == 4) {
            return "Abril";
        } elseif ($noMonth == 5) {
            return "Mayo";
        } elseif ($noMonth == 6) {
            return "Junio";
        } elseif ($noMonth == 7) {
            return "Julio";
        } elseif ($noMonth == 8) {
            return "Agosto";
        } elseif ($noMonth == 9) {
            return "Septiembre";
        } elseif ($noMonth == 10) {
            return "Octubre";
        } elseif ($noMonth == 11) {
            return "Noviembre";
        } elseif ($noMonth == 12) {
            return "Diciembre";
        }
    }

    /**
     * Método para obtener el nombre de fichero y la extension del mismo dada una url
     * @param string $url 
     * @return <Object>
     */
    private function getNameExtension($url) {
        $this->load->model("util_model");
        $parse_url = parse_url($url);

        if (isset($parse_url["path"])) {
            $path = pathinfo($parse_url["path"]);

//ESTO ES PARA EL CASO DE LOS VIDEOS DE YOUTUBE
            if (!isset($path["filename"]) && !isset($path["filename"])) {
                return FALSE;
            } elseif ($path["filename"] === "videoplayback" && !isset($path["extension"])) {
                $data["filename"] = str_replace("%20", "", $path["filename"]);
                $data["extension"] = "video";
            } else {
                $data["filename"] = str_replace("%20", "", $path["filename"]);
                $data["extension"] = strtolower($path["extension"]);
            }


//***** TODO LO SIGUIENTE ES PARA EVITAR FICHEROS CON EL MISMO NOMBRE Y EXTENSION
//***** CUANDO SE REPITAN AUTOMATICAMENTE EL SISTEMA VA INCREMENTANDO EL NOMBRE DEL FICHERO            
            if (PHP_OS == "Linux") {
                $separador_path = "/";
            } else {
                $separador_path = "\\";
            }

            $dir = realpath("FILES") . $separador_path . $data["extension"];

            if (file_exists($dir . $separador_path . $data["filename"] . "." . $data["extension"]) ||
                    $this->util_model->existeFile($data["filename"], $data["extension"])) {

                $this->load->model("descargas_model");
                $i = 1;

                while (file_exists($dir . $separador_path . $data["filename"] . $i . "." . $data["extension"]) ||
                $this->util_model->existeFile($data["filename"] . $i, $data["extension"])) {

                    $i++;
                }
                $data["filename"] = $data["filename"] . $i;
            }
//******************************************************************************************            

            return $data;
        } else {
            return FALSE;
        }


        /* if (isset($parse_url["path"])) {
          $ext = pathinfo($url);

          if (isset($ext["extension"])) {
          $data["filename"] = str_replace(" ", "", substr($ext["filename"], 0, 100));
          $data["filename"] = str_replace("?", "", $data["filename"]);
          $data["filename"] = str_replace("/", "", $data["filename"]);
          $data["filename"] = str_replace("&", "", $data["filename"]);
          if (isset($ext["extension"])) {
          $data["extension"] = strtolower($ext["extension"]);
          $data["extension"] = substr(strtolower($ext["extension"]), 0, 3) ;
          }
          return $data;
          } else {
          $head = $this->getEncabezado($url);
          $ext = pathinfo($head["url"]);

          if (isset($ext)) {
          $data["filename"] = str_replace(" ", "", substr($ext["filename"], 0, 100));
          $data["filename"] = str_replace("?", "", $data["filename"]);
          $data["filename"] = str_replace("%20", "", $data["filename"]);
          if (isset($ext["extension"])) {
          $data["extension"] = $ext["extension"];
          //$data["extension"] = substr(strtolower($ext["extension"]), 0, 4) ;
          }
          return $data;
          } else {
          return false;
          }
          }
          } else {
          return false;
          } */
    }

    /**
     * Método para obtener el encabrzado de la respuesta del servidor dada una url
     * @param string $url 
     * @return <Object>
     */
    private function getEncabezado($url) {
        $this->load->model('opciones_generales_model');

        if ($this->curl->is_enabled()) {
            $this->curl->create($url);
            $this->curl->option('buffersize', 10);
            $this->curl->option('useragent', 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8 (.NET CLR 3.5.30729)');
            $this->curl->option('NOBODY', 1);
            $this->curl->option('FOLLOWLOCATION', true);

//obtengo las opciones generales en donde se encuentra las opciones del proxy.
            $options = $this->opciones_generales_model->getOptions();

            if ($options[0]->proxy_use == "1") {
                $this->curl->option('PROXY', $options[0]->proxy);
                $this->curl->option('PROXYPORT', $options[0]->proxy_port);

//$this->curl->proxy($options[0]->proxy, $options[0]->proxy_port);
                if (!is_null($options[0]->proxy_user) and $options[0]->proxy_user != "") {
                    $this->curl->option('PROXYUSERPWD', $options[0]->proxy_user . ":" . $options[0]->proxy_pass);
//$this->curl->proxy_login($options[0]->proxy_user, $options[0]->proxy_pass);
                }
            }

            $this->curl->execute();

//retorno la informacion preliminar de la descarga
            return $this->curl->info;
        } else {
            return false;
        }
    }

    /**
     * Método para insertar inicialmente una descarga, solamente se comprueba si es valida la url y se obtiene informaci'on inicial del fichero
     * @return <json>
     */
    public function insertar() {
        $this->load->model("util_model");

        if ($this->session->userdata('log') == 1) {
            $this->load->library('logging');
            $user = $this->session->userdata('usuario');
            $this->load->model('usuario_model');

//comprobar si el usuario no excede la cant de descargas en el dia
            if ($this->usuario_model->comprobarCantDescargas($user, date('Y-m-d'))) {
                $url = $this->input->post('url');
                $desc = $this->input->post('desc');
                $nameALternativo = ($this->input->post('nameAlternativo') === 'Nombre del fichero sin la ext.') ? false : $this->input->post('nameAlternativo');

                if (!$this->util_model->existeUrlBD($url)) {
                    $data_file = $this->getNameExtension($url);

                    if ($data_file) {
                        $head = $this->getEncabezado($url);

                        if (($head["http_code"] == 200)) {
                            $this->load->model('opciones_generales_model');
                            $options = $this->opciones_generales_model->getOptions();

                            if ( ($head["download_content_length"] <= $options[0]->size_permitido) || in_array($user,$this->usuario_model->getAdminsLocal()) || $this->util_model->comprobarAdministradores($user) ) {
                                if(!$nameALternativo){
                                    $nameALternativo = $data_file["filename"];
                                } 
                                $descarga = $this->descargas_model->insertar(
                                    $nameALternativo, $data_file["extension"], $head["download_content_length"], $url, $desc, $this->session->userdata('usuario')
                                );

                                if ($descarga) {
                                    $this->json->setSuccess(true);
                                    $this->json->GenerarMensajeJSON();

                                    $msg = "Desccarga insertada correctamente";
                                    $logger = $this->logging->get_logger('simple');
                                    $logger->info(date('H:i:s') . " " . $this->input->ip_address() . " @" . $user . "@ !url! " . $url . " '" . $msg . "'");
                                } else {
                                    $msg = 'No se pudo insertar la descarga.';
                                    $this->json->setReason($msg);
                                    $this->json->GenerarMensajeJSON();
                                    $logger = $this->logging->get_logger('simple');
                                    $logger->error(date('H:i:s') . " " . $this->input->ip_address() . " @" . $user . "@ !url! " . $url . " '" . $msg . "'");
                                }
                            } else {
                                $msg = 'No se pudo insertar la descarga. El tama&ntilde;o de la descarga que intenta insertar es mayor al permitido en el sistema.';
                                $this->json->setReason($msg);
                                $this->json->GenerarMensajeJSON();
                                $logger = $this->logging->get_logger('simple');
                                $logger->error(date('H:i:s') . " " . $this->input->ip_address() . " @" . $user . "@ !url! " . $url . " '" . $msg . "'");
                            }
                        } else {
                            $msg = 'No se pudo insertar la descarga. La URL no es v&aacute;lida o no se pudo verificar en este momento.';
                            $this->json->setReason($msg);
                            $this->json->GenerarMensajeJSON();
                            $logger = $this->logging->get_logger('simple');
                            $logger->error(date('H:i:s') . " " . $this->input->ip_address() . " @" . $user . "@ !url! " . $url . " '" . $msg . "'");
                        }
                    } else {
                        $msg = 'La URL no se pudo conseguir o no es v&aacute;lida.';
                        $this->json->setReason($msg);
                        $this->json->GenerarMensajeJSON();
                        $logger = $this->logging->get_logger('simple');
                        $logger->error(date('H:i:s') . " " . $this->input->ip_address() . " @" . $user . "@ !url! " . $url . " '" . $msg . "'");
                    }
                } else {

                    $data = $this->descargas_model->getInfoDescargaByUrl($url);

                    if ($data[0]["finalized"] == "SI") {
                        $link = base_url() . "FILES/" . $data[0]["ext"] . "/" . $data[0]["name"] . "." . $data[0]["ext"];
                        $msg = 'Esta descarga ya fue solicitada con anterioridad. Su link es el siguiente: <a href="' . $link . '">' . $link . '</a>';
                    } else {
                        $msg = 'Esta descarga ya fue solicitada con anterioridad. Todav&iacute;a no se ha descargado';
                    }

                    $this->json->setReason($msg);
                    $this->json->GenerarMensajeJSON();
                    $logger = $this->logging->get_logger('simple');
                    $logger->error(date('H:i:s') . " " . $this->input->ip_address() . " @" . $user . "@ !url! " . $url . " '" . $msg . "'");
                }
            } else {
                $msg = 'Ha excedido la cantidad de descargas para el d&iacute;a';
                $this->json->setReason($msg);
                $this->json->GenerarMensajeJSON();
                $logger = $this->logging->get_logger('simple');
                $logger->error(date('H:i:s') . " " . $this->input->ip_address() . " @" . $user . "@ '" . $msg . "'");
            }
        } else {
            $this->session->sess_destroy();
            redirect('/welcome', 'location');
        }
    }

    /**
     * Método para listar las descargas del usuario que ha iniciado sesion
     * @return <Object>
     */
    public function listar() {
        $this->load->library('logging');
        $user = $this->session->userdata('usuario');
        $data = $this->descargas_model->getDescargas($this->session->userdata('usuario'));

        if ($data) {
            $this->json->GenerarRespJSON($data, count($data));

            $msg = "Desccargas listadas";
            $logger = $this->logging->get_logger('simple');
            $logger->info(date('H:i:s') . " " . $this->input->ip_address() . " @" . $user . "@ '" . $msg . "'");
        } else {
            $this->json->setReason('No existen descargas');
            $this->json->GenerarMensajeJSONText();

            $msg = "No posee desccargas listadas";
            $logger = $this->logging->get_logger('simple');
            $logger->info(date('H:i:s') . " " . $this->input->ip_address() . " @" . $user . "@ '" . $msg . "'");
        }
    }

    /**
     * Método para listar todas las descargas
     * @return <Object>
     */
    public function listarTodas() {
        $this->load->library('logging');
        //$user = $this->session->userdata('usuario');
        $data = $this->descargas_model->getDescargas();


        if ($data) {
            $this->json->GenerarRespJSON($data, count($data));
            /* $msg = "Todas las desccargas listadas";
              $logger = $this->logging->get_logger('simple');
              $logger->info(date('H:i:s') . " " . $this->input->ip_address() . " @" . $user . "@ '" . $msg . "'"); */
        } else {
            $this->json->setReason('No existen descargas');
            $this->json->GenerarMensajeJSONText();

            /* $msg = "Todas las desccargas listadas- no hay descargas";
              $logger = $this->logging->get_logger('simple');
              $logger->info(date('H:i:s') . " " . $this->input->ip_address() . " @" . $user . "@ '" . $msg . "'"); */
        }
    }

    /**
     * Método para eliminar una descarga que no ha finalizado
     * @return <json>
     */
    public function borrar() {
        $this->load->library('logging');
        $user = $this->session->userdata('usuario');
        $id_file = $this->input->post("id_file");
        $dataDescargas = $this->descargas_model->getInfoDescarga($id_file);

        $descargas = $this->descargas_model->borrar($id_file);
        if ($descargas) {
            $this->json->setSuccess(true);
            $this->json->GenerarMensajeJSON();

            $msg = "Descarga borrada";
            $logger = $this->logging->get_logger('simple');
            $url = $dataDescargas["url"];
            $logger->info(date('H:i:s') . " " . $this->input->ip_address() . " @" . $user . "@ !url! " . $url . " '" . $msg . "'");
        } else {
            $this->json->setReason('No se pudo borrar la descarga seleccionada.');
            $this->json->GenerarMensajeJSON();

            $msg = "No se pudo borrar la descarga";
            $logger = $this->logging->get_logger('simple');
            $url = $dataDescargas["url"];
            $logger->info(date('H:i:s') . " " . $this->input->ip_address() . " @" . $user . "@ !url! " . $url . " '" . $msg . "'");
        }
    }

    /**
     * Método ROBOT para descargar las descargas pendientes.
     */
    public function colaDescargas() {
        set_time_limit(300000000);
        $this->load->library('user_agent');
        $this->load->model('usuario_model');
	

        if ($_SERVER["REMOTE_ADDR"] == "10.18.1.140" || $_SERVER["REMOTE_ADDR"] == "127.0.0.1" 
	    || $_SERVER["REMOTE_ADDR"] == "10.18.1.194") {


            $totalDescDescargandose = $this->getTotalDescargasDescargandose();

            //si es mayor que 1 quiere decir que una ejecucion de este metodo con anterioridad.
            if ($totalDescDescargandose == 0) {
                $this->load->model('opciones_generales_model');
                $options = $this->opciones_generales_model->getOptions();

                //para obtener el separador segun el S.O
                $this->load->model('util_model');
                $separador_path = $this->util_model->getSeparador();


                $descargas = $this->descargas_model->getDescargasNoFinalizadas();

                if ($descargas) {
                    foreach ($descargas as $value) {
                        if ($value->intentos < 3) {
                            $from = 0;

                            //busco el fichero y actualizo el campo descargando a SI...
                            $this->descargas_model->ponerEnDescarga($value->id_file, $value->intentos);

                            $date_init = date('Y-m-d');
                            $this->curl->create($value->url);

                            $this->curl->option('buffersize', 10);
                            $this->curl->option('useragent', 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8 (.NET CLR 3.5.30729)');
                            $this->curl->option('returntransfer', true);
                            $this->curl->option('connecttimeout', 60);
                            $this->curl->option('TIMEOUT', 0);
                            $this->curl->option('FOLLOWLOCATION', true);

                            $carpeta = $value->ext;
                            $dir = realpath("FILES") . $separador_path . $carpeta;
                            if (!is_dir($dir)) {//si no existe la direccion
                                mkdir($dir);
                            }

                            /*if (file_exists($dir . $separador_path . $value->name . "." . $value->ext)) {
	                            $from = filesize($dir . $separador_path . $value->name . "." . $value->ext);
                                $this->curl->option('RANGE', $from . "-");
                                $fp = fopen($dir . $separador_path . $value->name . "." . $value->ext, 'a'); //opcion a es para poner el puntero al final del fichero
	                        }else{
                                $fp = fopen($dir . $separador_path . $value->name . "." . $value->ext, 'w');// opcion w es para truncar el fichero y poner el puntero en el inicio
                            }*/

                            $fp = fopen($dir . $separador_path . $value->name . "." . $value->ext, 'w');// opcion w es para truncar el fichero y poner el puntero en el inicio

                            $this->curl->option('file', $fp);

                            if ($options[0]->proxy_use == "1") {
                                $this->curl->option('PROXY', $options[0]->proxy);
                                $this->curl->option('PROXYPORT', $options[0]->proxy_port);

                                //$this->curl->proxy($options[0]->proxy, $options[0]->proxy_port);
                                if (!is_null($options[0]->proxy_user) and $options[0]->proxy_user != "") {
                                    $this->curl->option('PROXYUSERPWD', $options[0]->proxy_user . ":" . $options[0]->proxy_pass);
                                    //$this->curl->proxy_login($options[0]->proxy_user, $options[0]->proxy_pass);
                                }
                            }

                            $descarga = $this->curl->execute();
                            $info = $this->curl->info;
                            fclose($fp);


                            $tamDescargado = $info["size_download"] + $from;

                            if ($value->size == $tamDescargado || $value->size == 0 || $value->size == -1) {
                                $this->descargas_model->updateResults(date('Y-m-d'), $info["total_time"], $info["speed_download"], $value->id_file, $value->username,$date_init);
                                unset($info);

                                $dirFile = base_url() . "FILES/" . $value->ext . "/" . $value->name . "." . $value->ext;

                                $mensaje = 'El fichero ' . $value->name . "." . $value->ext . " ha sido descargado correctamente. Puede encontrarlo en la siguiente direcci&oacute;n: <a href='" . $dirFile . "'>" . $dirFile . "</a> o localizarlo en el sistema";
                                $subject = 'Su descarga ha finalizado correctamente';
                                $this->util_model->sendMail($this->usuario_model->getEmail($value->username), $subject, $mensaje );//envio de correo al usuario para informar de la descarga
                            } else {

                                $where1 = array(
                                    'id_file' => $value->id_file
                                );

                                $data = array(
                                    'descargando' => 'NO'
                                );
                                $query = $this->db->update('file', $data, $where1);

                                $admins = $this->usuario_model->getAdmins();
                                for ($i = 0; $i < count($admins); $i++) {
                                    $mensaje = "La descarga del fichero " . $value->name . "." . $value->ext . " no se ha bajado correctamente";
                                    $this->util_model->sendMail($admins[$i]->email, 'Descarga incompleta', $mensaje);//envio de correo al usuario para informar de la descarga
                                }
                            }
                        } else {
                            $admins = $this->usuario_model->getAdmins();

                            for ($i = 0; $i < count($admins); $i++) {
                                $mensaje = "La descarga del fichero " . $value->name . "." . $value->ext . " con url (" . $value->url . ") ha expirado. El sistema ha intentado tres veces su descarga pero ha sido imposible obtener el mismo. Puede que el link haya expirado.";
                                $this->util_model->sendMail($admins[$i]->email, 'Descarga cancelada', $mensaje, $this->usuario_model->getEmail($value->username));
                            }

                            $this->db->delete('file_user', array('id_file' => $value->id_file));
                            $this->db->delete('file', array('id_file' => $value->id_file));
                        }
                    }
                }
            }else{
                //verificar si la descarga lleva mucho tiempo o hay una descarga con descargandose=SI producto a un apagon, etc,
                $descargaDescargandose = $this->descargas_model->getDescargasDescargando();

                $datetime1 = new DateTime($this->descargas_model->getInfoDescarga($descargaDescargandose[0]["id_file"])["date_init"]);
                $datetime2 = new DateTime(date("d-m-Y",time()));
                $interval = $datetime1->diff($datetime2);

                if($interval->days >= 1){
                    $this->descargas_model->setDescargandose($descargaDescargandose[0]["id_file"]);
                }
            }
        } else {
            show_404();
        }
    }

    /**
     * Método para obtener las opciones generales
     * @return <json>
     */
    public function getOpciones() {
        $this->load->model('opciones_generales_model');
        $options = $this->opciones_generales_model->getOptions();

        $this->json->GenerarRespJSON($options, count($options));
    }

    /**
     * Método para actualizar las opciones generales
     * @return <json>
     */
    public function updateOpcionesGenerales() {
        $this->load->library('logging');
        $user = $this->session->userdata('usuario');
        $this->load->model('opciones_generales_model');
//$this->opciones_generales_model->setPathToSsave($this->input->post("path_to_save"));
        $this->opciones_generales_model->setSizePermitido($this->input->post("size_permitido"));
        $this->opciones_generales_model->setCantURLxDia($this->input->post("cant_desc_x_user"));

        $proxyUse = $this->input->post("proxy_use");

        if ($proxyUse == "on" or $proxyUse != '') {
            $result = $this->opciones_generales_model->setOptionesgeneral(
                    $this->input->post("proxy"), $this->input->post("proxy_port"), $this->input->post("proxy_user"), $this->input->post("proxy_pass"), $this->input->post("proxy_use")
            );
            $result = $this->opciones_generales_model->setProxyUse("1");
        } else {
            $result = $this->opciones_generales_model->setProxyUse("0");
        }

        if ($result) {
            $this->json->setSuccess(true);
            $this->json->GenerarMensajeJSON();
        } else {
            $this->json->setReason('No existen opciones');
            $this->json->GenerarMensajeJSONText();
        }

        $msg = "Opciones generales actualizadas";
        $logger = $this->logging->get_logger('simple');
        $logger->info(date('H:i:s') . " " . $this->input->ip_address() . " @" . $user . "@ '" . $msg . "'");
    }

    /**
     * Método para obtener las 10 ultimas descargas finalizadas
     * @return <Object>
     */
    public function getUltimas10Descargas() {
        $ult_descargas = $this->descargas_model->getUltimasDescargas();
        if ($ult_descargas) {
            $this->json->GenerarRespJSON($ult_descargas, count($ult_descargas));
        }
    }

    /**
     * Método para obtener las descargas no finalizadas
     * @return <Object>
     */
    public function getDescargasNoFinalizadas() {
        $descargas = $this->descargas_model->getDescargasNoFinalizadas();

        if ($descargas) {
            $this->json->GenerarRespJSON($descargas, count($descargas));
        } else {
            $this->json->setReason('No existen descargas');
            $this->json->GenerarMensajeJSONText();
        }
    }

    /**
     * Método para obtener todas las extensiones 
     * @return <Object>
     */
    public function getExtensiones() {
        $this->load->model("extension_model");
        $ext = $this->extension_model->getExtensiones();

        if ($ext) {
            $this->json->GenerarRespJSON($ext, count($ext));
        } else {
            $this->json->setReason('No existen extensiones');
            $this->json->GenerarMensajeJSONText();
        }
    }

    /**
     * Método para obtener la estadistica de ficheros bajados por extension
     * @return <Object>
     */
    public function getEstadisticaExtensiones() {
        $this->load->model("extension_model");
        $ext = $this->extension_model->getEstadisticaExtensiones();

        if ($ext) {
            $this->json->GenerarRespJSON($ext, count($ext));
        } else {
            $this->json->setReason('No existen extensiones');
            $this->json->GenerarMensajeJSONText();
        }
    }

    /**
     * Método para obtener las estadisticas de cant de gigas, teras, etc bajados por cada mes en el anno dado o el actual
     * @param string $anno
     */
    public function getEstadisticaInfoxMes() {
        $this->load->model("util_model");
        $infoByMonth = array();

        $year = $this->input->get('year');
        if ($year == '' or is_null($year)) {
            $year = date('Y');
        }

        for ($i = 1; $i <= 12; $i++) {
            $info = $this->descargas_model->getEstadisticaInfoxMes($i, $year);
            $data["month"] = $this->convertMonths($i);
            $data["total"] = $info;
            $data["totalConvertido"] = $this->util_model->convertBytesToSize($info);
            $infoByMonth[] = $data;
        }

        if ($infoByMonth) {
            $this->json->GenerarRespJSON($infoByMonth, count($infoByMonth));
        } else {
            $this->json->setReason('No existen extensiones');
            $this->json->GenerarMensajeJSONText();
        }
    }
    
    /**
     * Método para listar todos los usuarios en formato JSON
     * @return <array>
     */
    public function listarUsuariosJSON() {
        $this->load->model("usuario_model");
        $usuarios = $this->usuario_model->getUsuarios();

        if ($usuarios) {
            $this->json->GenerarRespJSON($usuarios, count($usuarios));
        } else {
            $this->json->setReason('No existen usuarios');
            $this->json->GenerarMensajeJSONText();
        }
    }

    /**
     * Método para obtener toda la info de una descarga
     * @return <Object>
     */
    public function getInfoDescarga() {
        $data = $this->descargas_model->getInfoDescarga($this->input->post('idDescarga'));

        if ($data) {
            $this->json->GenerarRespJSON($data, count($data));
        } else {
            $this->json->setReason('No hay información');
            $this->json->GenerarMensajeJSONText();
        }
    }

    /**
     * Método para establecer el email---controller 
     * @return <boolean>
     */
    public function setEmail() {
        $email = $this->input->post('email');
        $this->load->model('usuario_model');
        $data = $this->usuario_model->setEmail($this->session->userdata('usuario'), $email);

        if ($data) {
            $this->json->setSuccess(true);
            $this->json->GenerarMensajeJSON();
        } else {
            $this->json->setReason('Operaci&oacute;n fallida');
            $this->json->GenerarMensajeJSONText();
        }
    }

    /**
     * Método para obtener las descargas descargandose en el momento
     * @return <json>
     */
    public function getDescargasDescargandose() {
        $data = $this->descargas_model->getDescargasDescargando();

        if ($data) {
            $this->json->GenerarRespJSON($data, count($data));
        } else {
            $this->json->setReason('Operaci&oacute;n fallida');
            $this->json->GenerarMensajeJSONText();
        }
    }

    /**
     * Método para obtener la cant de descargas descargandose en el momento
     * @return <int>
     */
    public function getTotalDescargasDescargandose() {
        $cant = $this->descargas_model->getDescargasDescargando();
        if ($cant) {
            return count($cant);
        } else {
            return 0;
        }
    }

    public function getDescargasNacionales() {
        $data = $this->descargas_model->getDescargasNacionales();

        if ($data) {
            $this->json->GenerarRespJSON($data, count($data));
        } else {
            $this->json->setReason('Operaci&oacute;n fallida');
            $this->json->GenerarMensajeJSONText();
        }
    }

    public function getStatsDescargasNacInt() {
        $data = $this->descargas_model->getStatsDescargasNacInt();

        if ($data) {
            $this->json->GenerarRespJSON($data, count($data));
        } else {
            $this->json->setReason('Operaci&oacute;n fallida');
            $this->json->GenerarMensajeJSONText();
        }
    }
    
    public function getStatsPorDominio() {
        $data = $this->descargas_model->getStatsPorDominio();
        
        for ($i=0; $i<10; $i++){
        	$result[] = $data[$i];
        }

        if ($result) {
            $this->json->GenerarRespJSON($result, count($result));
        } else {
            $this->json->setReason('Operaci&oacute;n fallida');
            $this->json->GenerarMensajeJSONText();
        }
    }

    public function getResumenusuarios() {
        $this->load->model("usuario_model");
        $data = $this->usuario_model->getResumenUsuarios();

        if ($data) {
            $this->json->GenerarRespJSON($data, count($data));
        } else {
            $this->json->setReason('Operaci&oacute;n fallida');
            $this->json->GenerarMensajeJSONText();
        }
    }

    public function getStatsWeek(){
        $this->load->model("descargas_model");
        $data = $this->descargas_model->getStatsOfWeek();

        if ($data) {
            $this->json->GenerarRespJSON($data, count($data));
        } else {
            $this->json->setReason('Operaci&oacute;n fallida');
            $this->json->GenerarMensajeJSONText();
        }
    }

    public function debug() {
        $url = $this->input->post('url');

        if ($url == "") {
            $this->load->helper('form');

            echo form_open('descargas/debug');
            $data = array(
                'name' => 'url',
                'id' => 'url',
                'value' => ''
            );
            echo form_input($data);
            echo form_submit('mi_submit', 'Enviar mensaje');
            echo form_submit('mi_submit1', 'Enviar mensaje1');
            echo form_close();
        } else {
            $this->load->model('opciones_generales_model');
            $options = $this->opciones_generales_model->getOptions();

            if (!$this->input->post('mi_submit1')) {
                $value = $this->getNameExtension($url);

                if (PHP_OS == "Linux") {
                    $separador_path = "/";
                } else
                    $separador_path = "\\";

                $dir = realpath("FILES") . $separador_path . "temp";

                if (!is_dir($dir)) {//si no existe la direccion
                    mkdir($dir);
                }

                $this->curl->create($url);
                $this->curl->option('buffersize', 10);
                $this->curl->option('useragent', 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8 (.NET CLR 3.5.30729)');
                $this->curl->option('returntransfer', true);
                $this->curl->option('connecttimeout', 60);
                $this->curl->option('TIMEOUT', 0);

                $fp = fopen($dir . $separador_path . $value['filename'] . "." . $value['extension'], 'w');
                $this->curl->option('file', $fp);

                if ($options[0]->proxy_use == "1") {
                    $this->curl->option('PROXY', $options[0]->proxy);
                    $this->curl->option('PROXYPORT', $options[0]->proxy_port);

                    //$this->curl->proxy($options[0]->proxy, $options[0]->proxy_port);
                    if (!is_null($options[0]->proxy_user) and $options[0]->proxy_user != "") {
                        $this->curl->option('PROXYUSERPWD', $options[0]->proxy_user . ":" . $options[0]->proxy_pass);
                        //$this->curl->proxy_login($options[0]->proxy_user, $options[0]->proxy_pass);
                    }
                }

                $descarga = $this->curl->execute();
                fclose($fp);

                $f = $value['filename'] . "." . $value['extension'];

                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=\"$f\"\n");
                $fp = fopen($dir . $separador_path . $value['filename'] . "." . $value['extension'], "r");
                fpassthru($fp);
            } else {
                $this->curl->create($url);
                $this->curl->option('buffersize', 10);
                $this->curl->option('useragent', 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8 (.NET CLR 3.5.30729)');
                $this->curl->option('returntransfer', true);
                $this->curl->option('connecttimeout', 60);
                $this->curl->option('TIMEOUT', 0);

                if ($options[0]->proxy_use == "1") {
                    $this->curl->option('PROXY', $options[0]->proxy);
                    $this->curl->option('PROXYPORT', $options[0]->proxy_port);

                    //$this->curl->proxy($options[0]->proxy, $options[0]->proxy_port);
                    if (!is_null($options[0]->proxy_user) and $options[0]->proxy_user != "") {
                        $this->curl->option('PROXYUSERPWD', $options[0]->proxy_user . ":" . $options[0]->proxy_pass);
                        //$this->curl->proxy_login($options[0]->proxy_user, $options[0]->proxy_pass);
                    }
                }

                $descarga = $this->curl->execute();
                echo $descarga;
            }
        }
    }

    public function debug2(){
        $this->load->model("usuario_model");
        $admins = $this->usuario_model->getAdminsLocal();

        print_r($admins);
    }
}

?>

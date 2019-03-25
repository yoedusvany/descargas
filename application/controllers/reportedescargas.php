<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reportedescargas extends CI_Controller {

    var $j;
    var $cant;
    var $i;
    var $quantpag;
    var $n_page;
    var $corFundo;

    function __construct() {
        parent::__construct();
        $this->load->model('descargas_model');
    }

    public function index() {
        $this->load->model('json');
        $this->json->setReason('Acci&oacute;n inv&aacute;lida');
    }

    /**
     * Encabezado del documento RTF
     * @param type $title
     */
    public function encabezado($title) {
        $this->load->library('rtf', array("orientation" => "h"));
        $this->j = 0;
        $this->cant = 0;
        $this->i = 0;
        $this->quantpag = 46;
        $this->n_page = 0;
        $this->corFundo = 0;
        $this->rtf->set_default_font("Arial", 10);

        $this->rtf->add_image(base_url() . "web/images/header.jpeg", 100, "center");
        $this->rtf->new_line();


        $this->rtf->add_text($this->rtf->bold(1) . iconv("UTF-8", "ISO-8859-1", $title), "center");
        $this->rtf->new_line();
        $this->rtf->paragraph();
    }

    /**
     * Encabezado de la tabla 
     * @param type $title
     */
    public function encabezadoTabla(array $fields, array $tam, $align = "center", $color = "10") {
        $this->rtf->set_default_font("Arial", 11);
        $this->rtf->ln(1);
        $this->rtf->set_table_font("Arial", 11);
        $this->rtf->cell($this->rtf->bold(1) . $this->rtf->color(0) . "No.", "5", "center", "10");

        for ($i = 0; $i < count($fields); $i++) {
            $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $fields[$i]), $tam[$i], $align, $color);
        }

        $this->rtf->close_line();

        $this->n_page++;
    }

    /**
     * Firma del documento RTF
     * @param type $firma
     */
    public function firma($text = "Generado por: SIGDI") {
        $this->rtf->ln(1);
        $this->rtf->tab(13);
        $this->rtf->paragraph();
        $this->rtf->new_line();

        $this->rtf->set_table_font("Arial", 9);
        $this->rtf->add_text($this->rtf->bold(1) . iconv("UTF-8", "ISO-8859-1", $text), "left");
        $this->rtf->new_line();
    }


    /**
     * Todas las descargas finalizadas, se se le pasa un usuario, devuelve las descargas finalizadas del mismo
     * @param <String> user
     */
    public function reportegetDescargasFinalizadas($user = "") {
        $this->load->model("util_model");
        $totalTam = 0;

        if ($user != '') {
            $datos = $this->descargas_model->getDescargasFinalizadas($user);
            $titulo = "TODAS LAS DESCARGAS FINALIZADAS DE: " . $user;
        } else {
            $datos = $this->descargas_model->getDescargasFinalizadas();
            $titulo = "TODAS LAS DESCARGAS FINALIZADAS";
        }

        if ($datos) {
            $this->encabezado($titulo);

            $this->cant = count($datos);
            $this->n_page = ceil($this->cant / $this->quantpag);

            while ($this->j <= $this->cant - 1) {

                if ($this->i == 0) {
                    $campos = array("Nombre", "Ext", "Tamaño", "Url", "Fecha", "Desc");
                    $tam = array("20", "10", "12", "50", "12", "15");
                    $this->encabezadoTabla($campos, $tam);
                }

                ($this->corFundo == "8") ? ($this->corFundo = "16") : ($this->corFundo = "8");

                $this->rtf->set_table_font("Arial", 10);
                $this->rtf->open_line();


                $tam = $this->util_model->convertBytesToSize($datos[$this->i]->size);
                $totalTam += $datos[$this->i]->size;
                

                $no = $this->j + 1;
                $this->rtf->cell($this->rtf->bold(1) . $this->rtf->color(0) . $no, "5", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]->name), "20", "left", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]->ext), "10", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $tam), "12", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]->url), "50", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]->date), "12", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]->desc), "15", "center", $this->corFundo);
                $this->rtf->close_line();

                $this->i++;
                $this->j++;
            }

            //fila totales
            $this->rtf->set_table_font("Arial", 10);
            $this->rtf->open_line();
            $this->rtf->cell('TOTAL', "40", "center", $this->corFundo);
            $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $this->util_model->convertBytesToSize($totalTam)), "12", "center", $this->corFundo);
            $this->rtf->cell("", "87", "center", $this->corFundo);
            $this->rtf->close_line();

            $this->firma();
        } else {
            $this->encabezado($titulo);

            $this->rtf->new_line();
            $this->rtf->new_line();

            $this->rtf->set_table_font("Arial", 9);
            $this->rtf->add_text($this->rtf->bold(1) . iconv("UTF-8", "ISO-8859-1", "No existen descargas finalizadas por el usuario " . $user), "left");
            $this->rtf->new_line();

            $this->firma();
        }
        $this->rtf->display();
    }

    /**
     * Todas las descargas no finalizadas, si se le pasa usuario devuelve las del usuario pasado
     * @param <String> user
     */
    public function reportegetDescargasNOFinalizadas($user = "") {
        $this->load->model("util_model");
        $totalTam = 0;

        if ($user != '') {
            $datos = $this->descargas_model->getDescargasNoFinalizadas($user);
            $title = "TODAS LAS DESCARGAS NO FINALIZADAS DE: " . $user;
        } else {
            $datos = $this->descargas_model->getDescargasNoFinalizadas();
            $title = "TODAS LAS DESCARGAS NO FINALIZADAS";
        }

        $this->encabezado($title);

        if ($datos) {
            $this->cant = count($datos);
            $this->n_page = ceil($this->cant / $this->quantpag);

            while ($this->j <= $this->cant - 1) {

                if ($this->i == 0) {
                    $campos = array("Nombre", "Ext", "Tamaño", "Url", "Fecha", "Desc");
                    $tam = array("20", "9", "9", "50", "12", "23");
                    $this->encabezadoTabla($campos, $tam);
                }

                ($this->corFundo == "8") ? ($this->corFundo = "16") : ($this->corFundo = "8");

                $this->rtf->set_table_font("Arial", 10);
                $this->rtf->open_line();

                $tam = $this->util_model->convertBytesToSize($datos[$this->i]->size);
                $totalTam += $datos[$this->i]->size;

                $no = $this->j + 1;
                $this->rtf->cell($this->rtf->bold(1) . $this->rtf->color(0) . $no, "5", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]->name), "20", "left", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]->ext), "9", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $tam), "9", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]->url), "50", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]->date), "12", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]->desc), "23", "center", $this->corFundo);
                $this->rtf->close_line();

                $this->i++;
                $this->j++;
            }

            //fila totales
            $this->rtf->set_table_font("Arial", 10);
            $this->rtf->open_line();
            $this->rtf->cell('TOTAL', "34", "center", $this->corFundo);
            $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $this->util_model->convertBytesToSize($totalTam)), "9", "center", $this->corFundo);
            $this->rtf->cell("", "85", "center", $this->corFundo);
            $this->rtf->close_line();

            $this->firma();
        } else {
            $this->rtf->new_line();
            $this->rtf->new_line();

            $this->rtf->set_table_font("Arial", 9);
            $this->rtf->add_text($this->rtf->bold(1) . iconv("UTF-8", "ISO-8859-1", "No existen descargas no finalizadas"), "left");
            $this->rtf->new_line();
            $this->rtf->new_line();

            $this->firma();
        }
        $this->rtf->display();
    }

    /**
     * Todas las descargas, si se le pasa un usuario devuelve todas las del mismo
     * @param <String> user
     */
    public function reportegetDescargas($user = "") {
        $this->load->model("util_model");
        $totalTam = 0;

        if ($user != '') {
            $datos = $this->descargas_model->getDescargas($user);
            $titulo = "DESCARGAS REALIZADAS POR: " . $user;
        } else {
            $datos = $this->descargas_model->getDescargas();
            $titulo = "TODAS LAS DESCARGAS";
        }

        $this->encabezado($titulo);
        

        if ($datos) {
            $this->cant = count($datos);
            $this->n_page = ceil($this->cant / $this->quantpag);

            while ($this->j <= $this->cant - 1) {

                if ($this->i == 0) {
                    $campos = array("Nombre", "Ext", "Tamaño", "Url", "Fecha", "Desc");
                    $tam = array("20", "10", "12", "50", "12", "15");
                    $this->encabezadoTabla($campos, $tam);
                }

                ($this->corFundo == "8") ? ($this->corFundo = "16") : ($this->corFundo = "8");

                $this->rtf->set_table_font("Arial", 10);
                $this->rtf->open_line();

                $tam = $this->util_model->convertBytesToSize($datos[$this->i]['size']);
                $totalTam += $datos[$this->i]['size'];
                
                $no = $this->j + 1;
                $this->rtf->cell($this->rtf->bold(1) . $this->rtf->color(0) . $no, "5", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]["name"]), "20", "left", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]["ext"]), "10", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $tam), "12", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]["url"]), "50", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]["date"]), "12", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]["desc"]), "15", "center", $this->corFundo);
                $this->rtf->close_line();

                $this->i++;
                $this->j++;
            }


            //fila totales
            $this->rtf->set_table_font("Arial", 10);
            $this->rtf->open_line();
            $this->rtf->cell('TOTAL', "40", "center", $this->corFundo);
            $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $this->util_model->convertBytesToSize($totalTam)), "12", "center", $this->corFundo);
            $this->rtf->cell("", "87", "center", $this->corFundo);
            $this->rtf->close_line();

            $this->firma();
        } else {
            $this->rtf->set_table_font("Arial", 9);
            $this->rtf->add_text($this->rtf->bold(1) . iconv("UTF-8", "ISO-8859-1", "No se han realizado descargas"), "left");
            $this->rtf->new_line();
            $this->rtf->new_line();

            $this->firma();
        }
        $this->rtf->display();
    }
    
    
    /**
     * Descargas dada una fecha
     * @param <String> fecha
     */
    public function reporteDescargasDadaUnaFecha($fecha, $option) {
        $this->load->model("util_model");
        $totalTam = 0;

        if ($fecha != '') {
            $this->encabezado("DESCARGAS REALIZADAS EN LA FECHA: " . $fecha);
            //busco las descargas por usuario
            $datos = $this->descargas_model->getDescargasDadaFecha($fecha, $option);

            if ($datos) {
                $this->cant = count($datos);
                $this->n_page = ceil($this->cant / $this->quantpag);

                while ($this->j <= $this->cant - 1) {

                    if ($this->i == 0) {
                        $campos = array("Nombre", "Ext", "Tamaño", "Url", "Fecha", "Desc");
                        $tam = array("20", "10", "12", "50", "12", "15");
                        $this->encabezadoTabla($campos, $tam);
                    }

                    ($this->corFundo == "8") ? ($this->corFundo = "16") : ($this->corFundo = "8");

                    $this->rtf->set_table_font("Arial", 10);
                    $this->rtf->open_line();

                    $tam = $this->util_model->convertBytesToSize($datos[$this->i]['size']);
                    $totalTam += $datos[$this->i]['size'];

                    $no = $this->j + 1;
                    $this->rtf->cell($this->rtf->bold(1) . $this->rtf->color(0) . $no, "5", "center", $this->corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]["name"]), "20", "left", $this->corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]["ext"]), "10", "center", $this->corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $tam), "12", "center", $this->corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]["url"]), "50", "center", $this->corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]["date"]), "12", "center", $this->corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]["desc"]), "15", "center", $this->corFundo);
                    $this->rtf->close_line();

                    $this->i++;
                    $this->j++;
                }

                //fila totales
                $this->rtf->set_table_font("Arial", 10);
                $this->rtf->open_line();
                $this->rtf->cell('TOTAL', "40", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $this->util_model->convertBytesToSize($totalTam)), "12", "center", $this->corFundo);
                $this->rtf->cell("", "87", "center", $this->corFundo);
                $this->rtf->close_line();
            } else {
                $this->rtf->new_line();
                $this->rtf->new_line();

                if ($option == 'descargadas') {
                    $opcion = 'no hay descargas descargadas';
                } elseif ($option == 'no-descargadas') {
                    $opcion = 'no hay descargas no descargadas';
                } else {
                    $opcion = 'no hay descargas';
                }

                $this->rtf->set_table_font("Arial", 9);
                $this->rtf->add_text($this->rtf->bold(1) . iconv("UTF-8", "ISO-8859-1", "En la fecha " . $fecha . " $opcion"), "left");
                $this->rtf->new_line();
                $this->rtf->new_line();
            }

            $this->firma();
            $this->rtf->display();
        }
    }
    /*
     * 
     * 
     * 
     * 
     */
    

    /**
     * Estadisticas generales y de un usuario
     * @param <String> user
     */
    public function reportegetEstadistica($user = "") {
        $this->load->model("util_model");
        $totalTam = 0;

        if ($user != '') {
            $datos = $this->descargas_model->getEstadisticasGenerales($user);
            $titulo = "ESTADISTICAS GENERALES DEL USUARIO:" . $user;
        } else {
            $datos = $this->descargas_model->getEstadisticasGenerales();
            $titulo = "ESTADISTICAS GENERALES";
        }

        $this->encabezado($titulo);

        if ($datos) {
            $this->cant = count($datos);
            $this->n_page = ceil($this->cant / $this->quantpag);
            $cant_files = 0;
            $total_tam = 0;

            while ($this->j <= $this->cant - 1) {

                if ($this->i == 0) {
                    $campos = array("Extension de Archivos", "Cantidad de Archivos", "Tamaño de los Archivos Descargados");
                    $tam = array("25", "30", "40");
                    $this->encabezadoTabla($campos, $tam);
                }

                ($this->corFundo == "8") ? ($this->corFundo = "16") : ($this->corFundo = "8");

                $this->rtf->set_table_font("Arial", 10);
                $this->rtf->open_line();

                $tam = $this->util_model->convertBytesToSize($datos[$this->i]->tam);
                $totalTam += $datos[$this->i]->tam;

                $no = $this->j + 1;
                $this->rtf->cell($this->rtf->bold(1) . $this->rtf->color(0) . $no, "5", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]->ext), "25", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]->cant_files), "30", "center", $this->corFundo);
                $this->rtf->cell($tam, "40", "center", $this->corFundo);
                $this->rtf->close_line();

                $cant_files += $datos[$this->i]->cant_files;
                $total_tam += $datos[$this->i]->tam;

                $this->i++;
                $this->j++;
            }

            //fila totales
            $this->rtf->set_table_font("Arial", 10);
            $this->rtf->open_line();
            $this->rtf->cell('TOTAL', "60", "center", $this->corFundo);
            $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $this->util_model->convertBytesToSize($totalTam)), "40", "center", $this->corFundo);
            $this->rtf->close_line();

            $this->firma();
        } else {
            $this->rtf->set_table_font("Arial", 9);
            $this->rtf->add_text($this->rtf->bold(1) . iconv("UTF-8", "ISO-8859-1", "No existen descargas para realizar las estadísticas."), "left");
            $this->rtf->new_line();
            $this->rtf->new_line();
            $this->rtf->new_line();
        }

        $this->firma();
        $this->rtf->display();
    }

    /**
     * Estadisticas generales por cada usuario
     */
    public function reportegetEstadisticaPorUsuario() {
        $this->load->model("usuario_model");
        $this->load->model("util_model");
        $this->encabezado("ESTADISTICAS GENERALES POR USUARIO:");

        //busco todos los usuarios...
        $usuarios = $this->usuario_model->getUsuarios();

        //verifico si existen usurios 
        if ($usuarios) {
            $user = 0;

            while ($user <= count($usuarios) - 1) {
                //obtengo las descargas del usuario en $user
                $datos = $this->descargas_model->getEstadisticasGenerales($usuarios[$user]->username);

                $this->rtf->set_default_font("Arial", 10);
                $this->rtf->paragraph();
                $this->rtf->add_text($this->rtf->color(0) . $this->rtf->bold(1) . iconv("UTF-8", "ISO-8859-1", "Usuario: " . $usuarios[$user]->username), "left");

                //verifico si la variable datos es un arreglo, en este caso es porque
                //existen descargas para este usuario
                if (is_array($datos)) {
                    $this->cant = count($datos);
                } else {
                    $this->cant = 0;
                }

                $this->n_page = ceil($this->cant / $this->quantpag);
                $cant_files = 0;
                $total_tam = 0;
                $this->i = 0;
                $this->j = 0;

                if ($this->cant > 0) {
                    while ($this->j <= $this->cant - 1) {

                        if ($this->j == 0) {
                            $this->rtf->open_line();
                            $campos = array("Extension de Archivos", "Cantidad de Archivos", "Tamaño de los Archivos Descargados");
                            $tam = array("25", "30", "40");
                            $this->encabezadoTabla($campos, $tam);
                        }

                        ($this->corFundo == "8") ? ($this->corFundo = "16") : ($this->corFundo = "8");

                        $this->rtf->set_table_font("Arial", 10);
                        $this->rtf->open_line();

                        $no = $this->j + 1;
                        $this->rtf->cell($this->rtf->bold(1) . $this->rtf->color(0) . $no, "5", "center", $this->corFundo);
                        $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]->ext), "25", "center", $this->corFundo);
                        $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]->cant_files), "30", "center", $this->corFundo);
                        $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $this->util_model->convertBytesToSize($datos[$this->i]->tam)), "40", "center", $this->corFundo);
                        $this->rtf->close_line();

                        $cant_files += $datos[$this->i]->cant_files;
                        $total_tam += $datos[$this->i]->tam;

                        $this->i++;
                        $this->j++;
                    }
                    //fila totales
                    $this->rtf->set_table_font("Arial", 10);
                    $this->rtf->open_line();
                    $this->rtf->cell($this->rtf->color(2) . iconv("UTF-8", "ISO-8859-1", "TOTAL"), "30", "center", 7);
                    $this->rtf->cell($this->rtf->color(2) . iconv("UTF-8", "ISO-8859-1", $cant_files), "30", "center", 7);
                    $this->rtf->cell($this->rtf->color(2) . iconv("UTF-8", "ISO-8859-1", $this->util_model->convertBytesToSize($total_tam)), "40", "center", 7);
                    $this->rtf->close_line();

                    $this->rtf->paragraph();
                } else {
                    $this->rtf->new_line();
                    $this->rtf->new_line();

                    $this->rtf->set_table_font("Arial", 9);
                    $this->rtf->add_text($this->rtf->bold(1) . iconv("UTF-8", "ISO-8859-1", "No existen descargas por este usuario"), "left");
                    $this->rtf->new_line();
                    $this->rtf->new_line();
                    $this->rtf->new_line();
                }
                $user++;
            }
        } else {
            $this->rtf->set_table_font("Arial", 9);
            $this->rtf->add_text($this->rtf->bold(1) . iconv("UTF-8", "ISO-8859-1", "No existen descargas."), "left");
            $this->rtf->new_line();
            $this->rtf->new_line();
        }
        $this->firma();
        $this->rtf->display();
    }

    /**
     * Descargas nacionales
     */
    public function reporteDescargasNacionales() {
        $this->load->model("util_model");
        $totalTam = 0;
        $this->encabezado("DESCARGAS NACIONALES");

        //busco las descargas por usuario
        $datos = $this->descargas_model->getDescargasNacionales();

        if ($datos) {
            $this->cant = count($datos);
            $this->n_page = ceil($this->cant / $this->quantpag);

            while ($this->j <= $this->cant - 1) {

                if ($this->i == 0) {
                    $campos = array("Nombre", "Ext", "Tamaño", "Url", "Fecha", "Desc");
                    $tam = array("20", "10", "12", "50", "12", "15");
                    $this->encabezadoTabla($campos, $tam);
                }

                ($this->corFundo == "8") ? ($this->corFundo = "16") : ($this->corFundo = "8");

                $this->rtf->set_table_font("Arial", 10);
                $this->rtf->open_line();
                
                $tam = $this->util_model->convertBytesToSize($datos[$this->i]->size);
                $totalTam += $datos[$this->i]->size;                

                $no = $this->j + 1;
                $this->rtf->cell($this->rtf->bold(1) . $this->rtf->color(0) . $no, "5", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]->name), "20", "left", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]->ext), "10", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $tam), "12", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]->url), "50", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]->date), "12", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]->desc), "15", "center", $this->corFundo);
                $this->rtf->close_line();

                $this->i++;
                $this->j++;
            }
            
            //fila totales
            $this->rtf->set_table_font("Arial", 10);
            $this->rtf->open_line();
            $this->rtf->cell('TOTAL', "40", "center", $this->corFundo);
            $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $this->util_model->convertBytesToSize($totalTam)), "12", "center", $this->corFundo);
            $this->rtf->cell("", "87", "center", $this->corFundo);
            $this->rtf->close_line();
        } else {
            $this->rtf->new_line();
            $this->rtf->new_line();

            $this->rtf->set_table_font("Arial", 9);
            $this->rtf->add_text($this->rtf->bold(1) . iconv("UTF-8", "ISO-8859-1", "No se han realizado descargas nacionales"), "left");
            $this->rtf->new_line();
            $this->rtf->new_line();
        }
        $this->firma();
        $this->rtf->display();
    }

    /**
     * Descargas en un mes dado
     * @param <String> mes
     */
    public function reporteDescargasMes($mes) {
        $this->load->model("util_model");
        $totalTam = 0;

        if ($mes != '') {
            $datos = $this->descargas_model->getDescargasMes($mes);

            if ($mes == '1') {
                $mes = 'Enero';
            } elseif ($mes == '2') {
                $mes = 'Febrero';
            } elseif ($mes == '3') {
                $mes = 'Marzo';
            } elseif ($mes == '4') {
                $mes = 'Abril';
            } elseif ($mes == '5') {
                $mes = 'Mayo';
            } elseif ($mes == '6') {
                $mes = 'Junio';
            } elseif ($mes == '7') {
                $mes = 'Julio';
            } elseif ($mes == '8') {
                $mes = 'Agosto';
            } elseif ($mes == '9') {
                $mes = 'Septiembre';
            } elseif ($mes == '10') {
                $mes = 'Octubre';
            } elseif ($mes == '11') {
                $mes = 'Noviembre';
            } else {
                $mes = 'Diciembre';
            }

            $this->encabezado("DESCARGAS REALIZADAS EN EL MES " . $mes);
            //busco las descargas por usuario


            if ($datos) {
                $this->cant = count($datos);
                $this->n_page = ceil($this->cant / $this->quantpag);

                while ($this->j <= $this->cant - 1) {

                    if ($this->i == 0) {
                        $campos = array("Nombre", "Ext", "Tamaño", "Url", "Fecha", "Desc");
                        $tam = array("20", "10", "12", "50", "12", "15");
                        $this->encabezadoTabla($campos, $tam);
                    }

                    ($this->corFundo == "8") ? ($this->corFundo = "16") : ($this->corFundo = "8");

                    $this->rtf->set_table_font("Arial", 10);
                    $this->rtf->open_line();

                    $tam = $this->util_model->convertBytesToSize($datos[$this->i]['size']);
                    $totalTam += $datos[$this->i]['size'];

                    $no = $this->j + 1;
                    $this->rtf->cell($this->rtf->bold(1) . $this->rtf->color(0) . $no, "5", "center", $this->corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]["name"]), "20", "left", $this->corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]["ext"]), "10", "center", $this->corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $this->util_model->convertBytesToSize($datos[$this->i]["size"])), "12", "center", $this->corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]["url"]), "50", "center", $this->corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]["date"]), "12", "center", $this->corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]["desc"]), "15", "center", $this->corFundo);
                    $this->rtf->close_line();

                    $this->i++;
                    $this->j++;
                }

                //fila totales
                $this->rtf->set_table_font("Arial", 10);
                $this->rtf->open_line();
                $this->rtf->cell('TOTAL', "40", "center", $this->corFundo);
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $this->util_model->convertBytesToSize($totalTam)), "12", "center", $this->corFundo);
                $this->rtf->cell("", "87", "center", $this->corFundo);
                $this->rtf->close_line();
            } else {
                $this->rtf->new_line();
                $this->rtf->new_line();

                if ($option == 'descargadas') {
                    $opcion = 'no hay descargas descargadas';
                } elseif ($option == 'no-descargadas') {
                    $opcion = 'no hay descargas no descargadas';
                } else {
                    $opcion = 'no hay descargas';
                }

                $this->rtf->set_table_font("Arial", 9);
                $this->rtf->add_text($this->rtf->bold(1) . iconv("UTF-8", "ISO-8859-1", "En la fecha " . $fecha . " $opcion"), "left");
                $this->rtf->new_line();
                $this->rtf->new_line();
            }

            $this->firma();
            $this->rtf->display();
        }
    }

    /**
     * Listado de ficheros con su tiempo promedio de descarga
     * @param type $fecha
     */
    public function tiempoPromedioXFicheroDia($fecha) {
        $this->load->model("util_model");
        if ($fecha != '') {
            $this->encabezado("LISTADO DE FICHEROS CON SU TIEMPO PROMEDIO DE DESCARGA EN LA FECHA: " . $fecha);
            //busco las descargas por usuario
            $datos = $this->descargas_model->getDescargasDadaFecha($fecha, "descargadas");

            if ($datos) {
                $this->cant = count($datos);
                $this->n_page = ceil($this->cant / $this->quantpag);
                $totalSize = 0;

                while ($this->j <= $this->cant - 1) {

                    if ($this->i == 0) {
                        $campos = array("Nombre", "Ext", "Tamaño", "Tiempo de descarga");
                        $tam = array("50", "10", "12", "30");
                        $this->encabezadoTabla($campos, $tam);
                    }

                    ($this->corFundo == "8") ? ($this->corFundo = "16") : ($this->corFundo = "8");

                    $this->rtf->set_table_font("Arial", 10);
                    $this->rtf->open_line();

                    $tiempo = $this->descargas_model->getInfoDescarga($datos[$this->i]["id_file"]);
                    $totalSize += $datos[$this->i]["size"];


                    $no = $this->j + 1;
                    $this->rtf->cell($this->rtf->bold(1) . $this->rtf->color(0) . $no, "5", "center", $this->corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]["name"]), "50", "left", $this->corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]["ext"]), "10", "center", $this->corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $this->util_model->convertBytesToSize($datos[$this->i]["size"])), "12", "center", $this->corFundo);
                    $this->rtf->cell($tiempo["total_time"], "30", "center", $this->corFundo);
                    $this->rtf->close_line();

                    $this->i++;
                    $this->j++;
                }

                //FILA DE TOTAL
                $this->rtf->set_table_font("Arial", 10);
                $this->rtf->open_line();

                $tiempo = $this->util_model->convertTime($this->descargas_model->getTotalTimeFecha($fecha));

                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", "TOTALES"), "65", "left", 9);
                $this->rtf->cell($this->util_model->convertBytesToSize($totalSize), "12", "center", 9);
                $this->rtf->cell($tiempo, "30", "center", 9);
                $this->rtf->close_line();
            } else {
                $this->rtf->new_line();
                $this->rtf->new_line();

                $opcion = 'no hay descargas';

                $this->rtf->set_table_font("Arial", 9);
                $this->rtf->add_text($this->rtf->bold(1) . iconv("UTF-8", "ISO-8859-1", "En la fecha " . $fecha . " $opcion"), "left");
                $this->rtf->new_line();
                $this->rtf->new_line();
            }

            $this->firma();
            $this->rtf->display();
        }
    }

    /**
     * Resumen Tiempo Promedio de un mes-Anno dado
     * @param type $mes
     */
    public function tiempoPromedioMes($mes) {
        $this->load->model("util_model");
        if ($mes != '') {
            $this->encabezado("RESUMEN TIEMPO PROMEDIO DEL MES: " . $mes);

            $datos = $this->descargas_model->getDescargasMes($mes, true);

            if ($datos) {
                $this->cant = count($datos);
                $this->n_page = ceil($this->cant / $this->quantpag);
                $totalSize = 0;

                while ($this->j <= $this->cant - 1) {

                    if ($this->i == 0) {
                        $campos = array("Fecha", "Nombre", "Ext", "Tamaño", "Tiempo de descarga");
                        $tam = array("15", "50", "10", "12", "30");
                        $this->encabezadoTabla($campos, $tam);
                    }

                    ($this->corFundo == "8") ? ($this->corFundo = "16") : ($this->corFundo = "8");

                    $this->rtf->set_table_font("Arial", 10);
                    $this->rtf->open_line();

                    $tiempo = $this->descargas_model->getInfoDescarga($datos[$this->i]["id_file"]);
                    $totalSize += $datos[$this->i]["size"];


                    $no = $this->j + 1;
                    $this->rtf->cell($this->rtf->bold(1) . $this->rtf->color(0) . $no, "5", "center", $this->corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]["date"]), "15", "center", $this->corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]["name"]), "50", "left", $this->corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $datos[$this->i]["ext"]), "10", "center", $this->corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $this->util_model->convertBytesToSize($datos[$this->i]["size"])), "12", "center", $this->corFundo);
                    $this->rtf->cell($tiempo["total_time"], "30", "center", $this->corFundo);
                    $this->rtf->close_line();

                    $this->i++;
                    $this->j++;
                }

                //FILA DE TOTAL
                $this->rtf->set_table_font("Arial", 10);
                $this->rtf->open_line();

                $tiempo = $this->util_model->convertTime($this->descargas_model->getTotalTimeMes($mes));

                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", "TOTALES"), "80", "left", 9);
                $this->rtf->cell($this->util_model->convertBytesToSize($totalSize), "12", "center", 9);
                $this->rtf->cell($tiempo, "30", "center", 9);
                $this->rtf->close_line();
            } else {
                $this->rtf->new_line();
                $this->rtf->new_line();

                $opcion = 'no hay descargas';

                $this->rtf->set_table_font("Arial", 9);
                $this->rtf->add_text($this->rtf->bold(1) . iconv("UTF-8", "ISO-8859-1", "En la fecha " . $fecha . " $opcion"), "left");
                $this->rtf->new_line();
                $this->rtf->new_line();
            }

            $this->firma();
            $this->rtf->display();
        }
    }

}

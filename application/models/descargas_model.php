<?php

/**
 * Description of descarga
 *
 * @author Administrador
 */
class Descargas_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * funcion para insertar una nueva descarga
     * @param <int> $id_actividad
     * @return <boolean>
     */
    function insertar($filename, $ext, $size, $url, $desc, $user) {
        $data = array(
            'name' => $filename,
            'ext' => $ext,
            'size' => $size,
            'url' => $url,
            'date' => date('Y-m-d'),
            'finalized' => 'NO',
            'desc' => $desc,
            'descargando' => 'NO'
        );
        $result = $this->db->insert('file', $data);

        $this->db->select('last_value');
        $query = $this->db->get('file_id_file_seq');
        $a = $query->row();
        $last_descarga = $a->last_value;

        $data1 = array(
            'username' => $user,
            'id_file' => $last_descarga
        );
        $result1 = $this->db->insert('file_user', $data1);

        if ($result && $result1) {
            $this->db->close();
            return TRUE;
        } else {
            $this->db->close();
            return FALSE;
        }

        $this->load->library('email');
        $this->email->to('redes@unica.cu');
        $this->email->subject('Descarga inicializada');
        $this->email->message('Probando la Clase Email.');
        $this->email->send();
        echo $this->email->print_debugger();
    }

    /**
     * funcion para borrar una descarga
     * @param <int> $id_actividad
     * @return <boolean>
     */
    function borrar($id_file) {
        $data = array(
            'id_file' => $id_file
        );
        $this->db->delete('file', $data);

        if ($this->db->affected_rows() > 0) {
            $this->db->close();
            return TRUE;
        } else {
            $this->db->close();
            return FALSE;
        }
    }

    /**
     * Método para obtener todas las descargas por usuarios
     * @param string $user Usuario
     * @return <Object>
     */
    function getDescargas($user = '') {
        if ($user == "") {
            $query = $this->db->get('file');



            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $obj["id_file"] = $row->id_file;
                    $obj["name"] = $row->name;
                    $obj["ext"] = $row->ext;
                    $obj["size"] = $row->size;
                    $obj["url"] = $row->url;
                    $obj["date"] = $row->date;
                    $obj["finalized"] = $row->finalized;
                    $obj["desc"] = $row->desc;
                    $data[] = $obj;
                }
                return $data;
            } else {
                return FALSE;
            }
        } else {
            $this->db->select("*");
            $this->db->from('file');
            $this->db->join('file_user', 'file.id_file = file_user.id_file');
            $this->db->join('user', 'user.username = file_user.username');
            $this->db->where('user.username', $user);

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $obj["id_file"] = $row->id_file;
                    $obj["name"] = $row->name;
                    $obj["ext"] = $row->ext;
                    $obj["size"] = $row->size;
                    $obj["url"] = $row->url;
                    $obj["date"] = $row->date;
                    $obj["finalized"] = $row->finalized;
                    $obj["desc"] = $row->desc;
                    $data[] = $obj;
                }
                return $data;
            } else {
                return FALSE;
            }
        }
    }

    /**
     * Método para obtener las descargas finalizadas por usuario
     * @param string $user usuario
     * @return <Object>
     */
    public function getDescargasFinalizadas($user = '') {
        if ($user == "") {
            $this->db->where('file.finalized', 'SI');
            $query = $this->db->get('file');

            if ($query->num_rows() > 0) {
                foreach ($query->result_object() as $row) {
                    $data[] = $row;
                }
                return $data;
            } else {
                return FALSE;
            }
        } else {
            $this->db->from('file');
            $this->db->join('file_user', 'file.id_file = file_user.id_file');
            $this->db->join('user', 'user.username = file_user.username');
            $this->db->where('user.username', $user);
            $this->db->where('file.finalized', 'SI');

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
    }

    /**
     * Método para obtener las descargas no finalizadas por usuario
     * @param string $user usuario
     * @return <Object>
     */
    public function getDescargasNoFinalizadas($user = '') {
        if ($user == "") {
            $this->db->select('file.id_file, file."name", file.ext, file.size, file.date, file."desc", file.url,file.intentos, "user".username');
            $this->db->from('file');
            $this->db->join('file_user', 'file.id_file = file_user.id_file');
            $this->db->join('user', 'user.username = file_user.username');

            $this->db->where('file.finalized', 'NO');
            //$this->db->limit(3);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result_object() as $row) {
                    $data[] = $row;
                }
                return $data;
            } else {
                return FALSE;
            }
        } else {
            //$this->db->select('name, ext, size, url');
            $this->db->from('file');
            $this->db->join('file_user', 'file.id_file = file_user.id_file');
            $this->db->join('user', 'user.username = file_user.username');
            $this->db->where('user.username', $user);
            $this->db->where('file.finalized', 'NO');

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
    }

    /**
     * Método para obtener las descargas no finalizadas por usuario
     * @return <array>
     */
    public function getDescargasDescargando() {
        $this->load->model("util_model");

        $this->db->select('file.id_file, file.name, file.ext, file.date, file.url, file_user.username, file.size');
        $this->db->from('file');
        $this->db->join('file_user', 'file.id_file = file_user.id_file');
        $this->db->where('file.descargando', 'SI');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result_object() as $row) {
                $desc["id_file"] = $row->id_file;
                $desc["name"] = $row->name;
                $desc["ext"] = $row->ext;
                $desc["date"] = $row->date;
                $desc["url"] = $row->url;
                //$desc["date_init"] = $row->date_init;
                $desc["username"] = $row->username;
                $desc["size"] = $row->size;
                $desc["progreso"] = round((($this->util_model->getSizeReal($row->name, $row->ext) * 100) / $row->size)) / 100;
                $data[] = $desc;
            }
            return $data;
        } else {
            return FALSE;
        }
    }

    /**
     * Método para obtener las estadisticas
     * @param string $user usuario
     * @return <Object>
     */
    public function getEstadisticasGenerales($user = '') {
        //SELECT distinct ext, count(ext) as cant_files, SUM (CAST (size AS int)) FROM public.file group by ext
        if ($user == "") {
            $this->db->select('ext, count(ext) as cant_files, SUM(CAST(size AS int)) as tam');
            $this->db->from('file');
            $this->db->order_by('ext', 'asc');
            $this->db->group_by("ext");

            $query = $this->db->get();


            if ($query->num_rows() > 0) {
                foreach ($query->result_object() as $row) {
                    $data[] = $row;
                }
                return $data;
            } else {
                return FALSE;
            }
        } else {
            $this->db->select('ext, count(ext) as cant_files, SUM(CAST(size AS int)) as tam');
            $this->db->from('file');
            $this->db->join('file_user', 'file.id_file = file_user.id_file');
            $this->db->join('user', 'user.username = file_user.username');
            $this->db->where('user.username', $user);
            $this->db->order_by('ext', 'asc');
            $this->db->group_by("ext");

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
    }

    public function getUltimasDescargas() {
        $this->db->where('file.finalized', 'SI');
        $this->db->limit(10);
        $this->db->order_by("id_file", "desc");
        $query = $this->db->get('file');

        if ($query->num_rows() > 0) {
            foreach ($query->result_object() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return FALSE;
        }
    }

    public function getEstadisticaInfoxMes($month, $anno = '') {
        if ($anno == '') {
            $anno = date('Y');
        }
        $data = 0;

        $query = $this->db->query("select file.size::bigint "
                . "from file where date_part('month',file.date) = $month "
                . "and date_part('year',file.date) = $anno"
                . "and file.finalized = 'SI'");

        if ($query->num_rows() > 0) {
            foreach ($query->result_object() as $row) {
                $data += $row->size;
            }
            //return $this->convertBytesToSize($data);
            return $data;
        } else {
            return 0;
        }
    }

    /**
     * Método para obtener informacion completa de una descarga
     * @param string $idDescarga idDescarga
     * @return <Object>
     */
    public function getInfoDescarga($idDescarga) {
        $this->load->model("util_model");

        $this->db->select("*");
        $this->db->from('file');
        $this->db->join('file_user', 'file.id_file = file_user.id_file');
        $this->db->where('file.id_file', $idDescarga);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $record = $query->result_object();

            $data["name"] = $record[0]->name;
            $data["ext"] = $record[0]->ext;
            $data["url"] = $record[0]->url;
            $data["finalized"] = $record[0]->finalized;
            $data["desc"] = $record[0]->desc;
            $data["date"] = $record[0]->date;
            $data["date_init"] = $record[0]->date_init;
            $data["date_finalized"] = $record[0]->date_finalized;
            $data["size"] = $this->util_model->convertBytesToSize($record[0]->size);
            $data["speed_download"] = $this->util_model->convertBytesVelocidadRED($record[0]->speed_download);
            $data["total_time"] = $this->util_model->convertTime($record[0]->total_time);

            return $data;
        } else {
            return FALSE;
        }
    }

    /**
     * Método para obtener todas las descargas dada una fecha
     * @param string $fecha Fecha
     * @return <Array>
     */
    function getDescargasDadaFecha($fecha = '', $option = 'todas') {
        //$query = $this->db->query("select * from file where file.date = '".$fecha."'");  
        $this->db->select("*");
        $this->db->from('file');

        if ($option == 'descargadas') {
            $this->db->where('file.finalized', 'SI');
        } elseif ($option == 'no-descargadas') {
            $this->db->where('file.finalized', 'NO');
        }

        $this->db->where('file.date', $this->db->escape($fecha));

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $obj["id_file"] = $row->id_file;
                $obj["name"] = $row->name;
                $obj["ext"] = $row->ext;
                $obj["size"] = $row->size;
                $obj["url"] = $row->url;
                $obj["date"] = $row->date;
                $obj["finalized"] = $row->finalized;
                $obj["desc"] = $row->desc;
                $data[] = $obj;
            }
            return $data;
        } else {
            return FALSE;
        }
    }

    /**
     * Método para obtener todas las descargas en un mes dado
     * @param string $mes Mes
     * @return <Array>
     */
    function getDescargasMes($mes, $finalizadas = TRUE) {
        if ($finalizadas != TRUE) {
            $query = $this->db->query("select * from file where date_part('month', date) = '$mes'");
        } else
            $query = $this->db->query("select * from file where date_part('month', date) = '$mes' AND finalized = 'SI'");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $obj["id_file"] = $row->id_file;
                $obj["name"] = $row->name;
                $obj["ext"] = $row->ext;
                $obj["size"] = $row->size;
                $obj["url"] = $row->url;
                $obj["date"] = $row->date;
                $obj["finalized"] = $row->finalized;
                $obj["desc"] = $row->desc;
                $data[] = $obj;
            }
            return $data;
        } else {
            return FALSE;
        }
    }

    /**
     * Devuelve las descargas que se han realizado desde dominios .cu
     * @return array
     */
    public function getDescargasNacionales($usuario = '') {
        $this->db->select('*');
        $this->db->from('file');

        if($usuario != ''){
            $this->db->join("file_user","file_user.id_file = file.id_file");
            $this->db->where('file_user.username', $usuario);
        }

        $this->db->like('file.url', '.cu');
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

    /**
     * Devuelve las descargas que se han realizado desde dominios .cu
     * @return array
     */
    public function getStatsDescargasNacInt() {
        $total = $this->db->count_all('file');

        $data["tipo"] = "nac";
        $data["cant"] = count($this->getDescargasNacionales());

        $object[] = $data;

        $data["tipo"] = "int";
        $data["cant"] = $total - count($this->getDescargasNacionales());

        $object[] = $data;

        return $object;
    }

    /**
     * Devuelve las cantidad de descargas por dominio ordenado de mayor a menor
     * @return array
     */
    public function getStatsPorDominio() {
        $arrayDomains = array();
        $allDescargas = $this->getDescargas();

        foreach ($allDescargas as $key => $value) {
            $domain = parse_url($value['url'], PHP_URL_HOST);
            $domain = implode('.', array_slice(explode('.', $domain), -2, 2));
            $domain = substr($domain, strpos($domain, ".") + 1, strlen($domain));

            //if (!$this->existeDomain($domain, $arrayDomains)) {
            if (array_key_exists($domain, $arrayDomains)) {
            	$arrayDomains[$domain] = $arrayDomains[$domain] + 1;
            } else {
                $arrayDomains[$domain] = 1;
            }
        }
        //ordena de mayor a menor
        arsort($arrayDomains);
        
        foreach ($arrayDomains as $key => $value){
        	$data["dominio"] = $key;
        	$data["cant"] = $value;
        	$object[]=$data;
        }
        
        return $object;
    }

    /**
     * Método para obtener los datos de una descarga a partir de una URL
     * @param string $url URL
     * @return <array>
     */
    function getInfoDescargaByUrl($url) {
        $this->db->where("url", $url);
        $query = $this->db->get('file');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $obj["id_file"] = $row->id_file;
                $obj["name"] = $row->name;
                $obj["ext"] = $row->ext;
                $obj["size"] = $row->size;
                $obj["url"] = $row->url;
                $obj["date"] = $row->date;
                $obj["finalized"] = $row->finalized;
                $obj["desc"] = $row->desc;
                $data[] = $obj;
            }
            return $data;
        } else {
            return FALSE;
        }
    }

    function getTotalTimeFecha($fecha) {
        //$query = $this->db->query("select * from file where file.date = '".$fecha."'");  
        $this->db->select("total_time");
        $this->db->from('file_user');
        $this->db->join('file', 'file.id_file = file_user.id_file');
        $this->db->where('file.finalized', 'SI');
        $this->db->where('file.date', $this->db->escape($fecha));

        $query = $this->db->get();

        $total = 0;

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $total += $row->total_time;
            }
            return $total;
        } else {
            return FALSE;
        }
    }

    function getTotalTimeMes($mes) {
        //$query = $this->db->query("select * from file where file.date = '".$fecha."'");  
        $this->db->select("total_time");
        $this->db->from('file_user');
        $this->db->join('file', 'file.id_file = file_user.id_file');
        $this->db->where("date_part('month', date)=", $mes);
        $this->db->where('finalized', 'SI');

        $query = $this->db->get();

        //$query = $this->db->query("select total_time from file where date_part('month', date) = '$mes' AND finalized = 'SI'");

        $total = 0;

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $total += $row->total_time;
            }
            return $total;
        } else {
            return FALSE;
        }
    }

    public function getStatsOfWeek(){
        $this->load->model("util_model");
        $fechas = $this->util_model->getDaysOfWeek();

        for($i = 0; $i < count($fechas); $i++){
            $data["dia"]= $i;
            $data["cant"]= ($this->getDescargasDadaFecha($fechas[$i]) == false) ? 0 : count($this->getDescargasDadaFecha($fechas[$i]));
            $object[] = $data;
        }

        return $object;
    }

    /** funcion para actualizar los resultados de una descarga
     * @param $date_finalized
     * @param $total_time
     * @param $speed_download
     * @param $id_file
     * @param $desc
     * @param $user
     */
    function updateResults($date_finalized, $total_time, $speed_download, $id_file, $username, $date_init) {
        $where1 = array(
            'id_file' => $id_file
        );
        $data = array(
            'finalized' => 'SI',
            'descargando' => 'NO'
        );
        $this->db->update('file', $data, $where1);

        $where = array(
            'id_file' => $id_file,
            'username' => $username
        );
        $data1 = array(
            'date_init' => $date_init,
            'date_finalized' => $date_finalized,
            'total_time' => $total_time,
            'speed_download' => $speed_download
        );
            $query1 = $this->db->update('file_user', $data1, $where);
    }


    public function ponerEnDescarga($id_file, $intentos){
        $where2 = array(
            'id_file' => $id_file
        );

        $data2 = array(
            'descargando' => 'SI',
            'intentos' => $intentos+1
        );
        $query2 = $this->db->update('file', $data2, $where2);
    }

    public function setDescargandose($id_file){
        $where = array(
            'id_file' => $id_file
        );

        $data = array(
            'descargando' => 'NO'
        );
        $query = $this->db->update('file', $data, $where);
    }

}

?>

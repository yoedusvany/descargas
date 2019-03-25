<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        if ($this->session->userdata('log') == 1) {
            redirect('/welcome', 'location');
        } else {
            $this->session->sess_destroy();
            $this->load->library('user_agent');

            if ($this->ip_pertenece_a_red($_SERVER["REMOTE_ADDR"], "10.18.80.0/20")) {
                $data["sede"] = "Sede Manuel Ascunce";
            } elseif ($this->ip_pertenece_a_red($_SERVER["REMOTE_ADDR"], "10.18.96.0/20")) {
                $data["sede"] = "Sede Francisco Borrero";
            } elseif ($this->ip_pertenece_a_red($_SERVER["REMOTE_ADDR"], "10.19.0.0/16")) {
                $data["sede"] = "Bioplantas";
            } else {
                $data["sede"] = "Sede Central";
            }

            if ($this->agent->is_browser()) {
                $data["plataforma"] = 'desktop';
            } elseif ($this->agent->is_mobile()) {
                $data["plataforma"] = 'mobile';
            }

            $this->load->view('login', $data);



        }

//echo "SERVICIO TEMPORALMENTE NO DISPONIBLE";
    }

    /** Devuelve TRUE si la dirección IPv4 dada pertenece a la subred indicada, FALSE si no 
     * @param string $str_ip Dirección IP en formato '127.0.0.1' 
     * @param string $str_rango Red y máscara en formato '127.0.0.0/8', '127.0.0.0/255.0.0.0' o '127.0.0.1' 
     * @return bool 
     * @version v2011-08-30 */
    public function ip_pertenece_a_red($str_ip, $str_rango) {
        // Extraemos la máscara     
        list($str_red, $str_mascara) = array_pad(explode('/', $str_rango), 2, NULL);
        if (is_null($str_mascara)) {
            // No se especifica máscara: el rango es una única IP         
            $mascara = 0xFFFFFFFF;
        } elseif ((int) $str_mascara == $str_mascara) {
            // La máscara es un entero: es un número de bits        
            $mascara = 0xFFFFFFFF << (32 - (int) $str_mascara);
        } else {
            // La máscara está en formato x.x.x.x         
            $mascara = ip2long($str_mascara);
        }
        $ip = ip2long($str_ip);
        $red = ip2long($str_red);
        $inf = $red & $mascara;
        $sup = $red | (~$mascara & 0xFFFFFFFF);
        return $ip >= $inf && $ip <= $sup;
    }

    public function autenticar() {
            $this->load->library('logging');

            $usuario = strtolower($this->input->post("usuario"));
            $pass = $this->input->post("pass");
            $sede = $this->input->post("sede");

            $this->load->model('json');

            /*$this->session->set_userdata('email', "SI");
               $this->session->set_userdata('log', '1');
               $this->session->set_userdata('usuario', $usuario);
               $this->session->set_userdata('rol', 'admin');
               $this->json->setSuccess(true);
               $this->json->GenerarMensajeJSON();*/

            if ($sede === "Sede Central") {
                $config['domain_controllers'] = array('10.18.1.2');
                $config['account_suffix'] = "@unica.cu";
                $config['base_dn'] = "OU=Usuarios,DC=unica,DC=cu";
            } elseif ($sede === "Sede Manuel Ascunce") {
                $config['domain_controllers'] = array('10.18.81.2');
                $config['account_suffix'] = "@sma.unica.cu";
                $config['base_dn'] = "DC=sma,DC=unica,DC=cu";
            } elseif ($sede === "Bioplantas") {
                $config['domain_controllers'] = array('10.19.1.1');
                $config['account_suffix'] = "@bioplantas.cu";
                $config['base_dn'] = "OU=Usuarios,DC=bioplantas,DC=cu";
            }

            // cargar la libreria LDAP con su configuraci�n
            $this->load->library('ldap/src/adldap', $config);

            // autenticar con el LDAP
            if ($this->adldap->authenticate($usuario, $pass)) {
                $this->load->model("usuario_model");
                $data_user = $this->usuario_model->comprobar($usuario);

                if (!$data_user) {
                    $user = $this->adldap->user()->info($usuario);
                    if (is_null($user[0]["mail"])) {
                        $this->usuario_model->insertar($usuario);
                    } else {
                        $this->usuario_model->insertar($usuario, $user[0]["mail"][0]);
                    }
                }

                //para comprobar si tiene email registrado en la BD, sino lo tiene pedirselo manual
                if ($this->usuario_model->getEmail($usuario) == FALSE) {
                    $this->session->set_userdata('email', "NO");
                } else
                    $this->session->set_userdata('email', "SI");

                $this->usuario_model->insertarInicioSesion($usuario, date("Y-m-d h:i:s A"));

                $this->session->set_userdata('log', '1');
                $this->session->set_userdata('usuario', $usuario);
                $this->session->set_userdata('rol', $this->usuario_model->getRol($usuario));
                $this->json->setSuccess(true);
                $this->json->GenerarMensajeJSON();

                $msg = "Inicio de sesion exitoso";
                $logger = $this->logging->get_logger('simple');
                $logger->info(date('H:i:s') . " " . $this->input->ip_address() . " @" . $usuario . " '" . $msg . "'");
            } else {
                $this->session->sess_destroy();
                $this->json->setReason('Usuario o contrase&ntilde;a no v&acute;lido');
                $this->json->GenerarMensajeJSON();

                $msg = "Inicio de sesion fallido";
                $logger = $this->logging->get_logger('simple');
                $logger->info(date('H:i:s') . " " . $this->input->ip_address() . " @" . $usuario . " '" . $msg . "'");
            }
    }

    public function cerrarSesion() {
        $this->load->library('logging');
        $user = $this->session->userdata('usuario');

        $msg = "Cierre de sesion satisfactorio";
        $logger = $this->logging->get_logger('simple');
        $logger->info(date('H:i:s') . " " . $this->input->ip_address() . " @" . $user . " '" . $msg . "'");


        $this->session->sess_destroy();
        redirect('/', 'location');
    }

    public function app() {
        if ($this->session->userdata('log') == 1) {
            $data["usuario"] = $this->session->userdata('usuario');
            $data["rol"] = $this->session->userdata('rol');
            $data["email"] = $this->session->userdata('email');
            $this->load->view('index', $data);
        } else {
            $this->session->sess_destroy();
            redirect('/', 'location');
        }
    }

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */

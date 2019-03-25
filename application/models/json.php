<?php

class Json extends CI_Controller {

    private $success;  //  Si es SUCCESS o FALSE
    private $reason;  //  El mensaje de Error en caso de success false

    public function __construct() {
        $this->success = FALSE;
        $this->reason = '';
    }

    public function setSuccess($result) {
        if (is_bool($result)) {
            $this->success = $result;
        }
    }

    public function setReason($reason) {
        if (is_string($reason)) {
            if ($this->reason != '') {
                $this->reason .= $reason;
            }else
                $this->reason = $reason;
        }else
            return FALSE;
    }

    public function GenerarMensajeJSON() {
        if ($this->success == true) {
            $json = array(
                "success" => true
            );
            echo json_encode($json);
        } elseif ($this->success == false) {
            $json = array(
                "success" => false,
                "total" => 0,
                "errors" => array(
                    "reason" => $this->reason
                )
            );
            echo json_encode($json);
        }
    }

    public function GenerarMensajeJSONText() {
        if ($this->success == true) {
            echo "{success: true, errors: { reason: '" . $this->reason . "' }}";
        } elseif ($this->success == false) {
            echo "{success: false, total: 0, errors: { reason: '" . $this->reason . "' }}";
        }
    }

    public function GenerarRespJSON($obj, $total) {
        $json = array(
            "success" => true,
            "total" => $total,
            "data" => $obj
        );
        echo json_encode($json);
    }


}

?>

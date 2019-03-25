<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/12/15
 * Time: 22:21
 */

class Extension_model extends CI_Model{

    function __construct() {
        parent::__construct();
    }

    public function getExtensiones() {
        $this->db->distinct();
        $this->db->select('ext');
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

    public function getEstadisticaExtensiones() {
        $this->db->select('file.ext');
        $this->db->select('count(file.finalized) as cant');
        $this->db->from("user");
        $this->db->join("file_user", "file_user.username = user.username");
        $this->db->join("file", "file.id_file = file_user.id_file");
        $this->db->where("file.finalized", 'SI');
        $this->db->group_by("file.ext");
        $this->db->order_by("cant", "desc");
        $this->db->limit(5);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result_object() as $row) {
                if ($row->ext == "") {
                    $row->ext = 'sin ext.';
                    $data[] = $row;
                } else {
                    $data[] = $row;
                }
            }
            return $data;
        } else {
            return FALSE;
        }
    }
}

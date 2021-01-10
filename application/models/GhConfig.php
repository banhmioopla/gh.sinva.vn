<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhConfig extends CI_Model {
    private $table = 'gh_config';

    public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */
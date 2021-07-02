<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhApartmentView extends CI_Model {
    private $table = 'gh_apartment_view';

    public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
    }



    public function getById($penalty_id) {
        return $this->db->get_where($this->table, ['id' => $penalty_id])->result_array();
    }

    public function getAll() {
        return $this->db->get_where($this->table)->result_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function updateById($penalty_id, $data) {
        $this->db->where('id', $penalty_id);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function getNumber($apartment_id){
        $result = $this->db->get_where(
            $this->table,
            ['apartment_id' => $apartment_id])->result_array();
        return count($result);
    }

    public function delete($penalty_id) {
        $this->db->where('id' , $penalty_id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ShareAgencyGroup extends CI_Model {
    private $table = 'share_agency_group';

    public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getById($district_id) {
        return $this->db->get_where($this->table, ['id' => $district_id])->result_array();
    }

    public function getFirstById($room_id) {
        return $this->db->get_where($this->table, ['id' => $room_id])->row_array();
    }

    public function getFirstByUuid($uuid) {
        return $this->db->get_where($this->table, ['uuid' => $uuid])->row_array();
    }

    public function getAll() {
        return $this->db->get_where($this->table)->result_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function updateById($id, $data) {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function delete($district_id) {
        $this->db->where('id' , $district_id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */
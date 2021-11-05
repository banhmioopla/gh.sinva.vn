<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhUserDistrict extends CI_Model {
    private $table = 'gh_user_district';

	public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function getFirstByDistrictUser($district_code, $user_id) {
        return $this->db->get_where($this->table, [
            'district_code' => $district_code,
            'user_id' => $user_id,

        ])->row_array();
    }
    public function getFirstByApmUser($apm, $user_id) {
        return $this->db->get_where($this->table, [
            'apartment_id' => $apm,
            'user_id' => $user_id,
        ])->row_array();
    }
    public function delete($where) {
        $this->db->delete($this->table, $where);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function getFirstByUser($user_id) {
        return $this->db->get_where($this->table, [
            'user_id' => $user_id,
        ])->row_array();
    }

}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */
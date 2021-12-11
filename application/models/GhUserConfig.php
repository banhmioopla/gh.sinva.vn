<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhUserConfig extends CI_Model {
    private $table = 'gh_user_config';
    const KEYWORD_DEFAULT_DISTRICT = 'default_district';
    public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getFirstByKeywordAndUser($keyword, $user_id) {
        return $this->db->get_where($this->table, ['keyword' => $keyword, "user_account_id" => $user_id])->row_array();
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
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
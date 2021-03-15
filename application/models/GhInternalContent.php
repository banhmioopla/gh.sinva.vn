<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhInternalContent extends CI_Model {
    private $table = 'gh_internal_content';

    public function get($where = []) {
        $this->db->order_by('content_key ASC');
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getByContentKey($key) {
        return $this->db->get_where($this->table, ['content_key' => $key])->result_array();
    }
    public function getFirstByContentKey($content_key) {
        return $this->db->get_where($this->table, ['content_key' => $content_key])->row_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function updateByContentKey($key, $data) {
        $this->db->where('content_key', $key);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function delete($key) {
        $this->db->where('content_key' , $key);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */
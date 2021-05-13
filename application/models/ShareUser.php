<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ShareUser extends CI_Model {
    private $table = 'share_user';

    public function get($where = []) {
        $this->db->order_by('id DESC');
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getById($tag_id) {
        return $this->db->get_where($this->table, ['id' => $tag_id])->result_array();
    }

    public function getAll() {
        return $this->db->get_where($this->table)->result_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function updateById($tag_id, $data) {
        $this->db->where('id', $tag_id);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function delete($tag_id) {
        $this->db->where('id' , $tag_id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/tag-manager/mApartment.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhApartmentUserFollow extends CI_Model {
    private $table = 'gh_apartment_user_follow';

    public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getFirst($where = []) {
        return $this->db->get_where($this->table, $where = [])->row_array();
    }

    public function isFollowing($apartment_id , $account_id) {
        $checker = $this->db->get_where($this->table, ['account_id' => $account_id, 'apartment_id' => $apartment_id])->row_array();
        if(!empty($checker)){
            return true;
        }
        return false;
    }

    public function getNumberFollow($apartment_id){
        $list_fl = $this->get([
            'apartment_id' => $apartment_id
        ]);

        if(count($list_fl)){
            return count($list_fl);
        }

        return false;
    }

    public function getById($id) {
        return $this->db->get_where($this->table, ['id' => $id])->result_array();
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



    public function delete($id) {
        $this->db->where('id' , $id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */
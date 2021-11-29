<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhApartmentComment extends CI_Model {
    private $table = 'gh_apartment_comment';

    public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getById($district_id) {
        return $this->db->get_where($this->table, ['id' => $district_id])->result_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function getFirstById($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function getScoreByApm($apm_id, $from, $to) { //
        $list =  $this->db->get_where($this->table, ['apartment_id' => $apm_id])->result_array();
        $score = 0; $count = 0;
        foreach ($list as $item){
            $score+=  $item['score']; $count++;
        }

        return $count > 0 ? round($score/$count, 0) : 0;
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
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

    // Lấy tất cả USER QLDA của QUẬN | APARTMENT
    public function getListCrudUser($apm_id){
        $this->load->model('ghApartment');
        $apm = $this->ghApartment->getFirstById($apm_id);
        $list_crud = $this->get(['is_view_only' => "NO"]);
        $arr_user = [];
        foreach ($list_crud as $crud){
            if(!empty($crud['district_code']) && $apm['district_code'] === $crud['district_code']){
                if(!in_array($crud["user_id"], $arr_user)){
                    $arr_user[] = $crud["user_id"];
                }
            }
            if(!empty($crud['apartment_id']) && $apm['id'] === $crud['apartment_id']){
                if(!in_array($crud["user_id"], $arr_user)){
                    $arr_user[] = $crud["user_id"];
                }
            }
        }


        return $arr_user;

    }

    public function getNameUserByListCrud($apm_id){
        $list_user_id = $this->getListCrudUser($apm_id);
        $result = [];
        $this->load->model('ghUser');
        foreach ($list_user_id as $user_id){
            $user = $this->ghUser->getFirstByAccountId($user_id);
            if($user['active'] === "YES"){
                $result[] = $user["name"]. "  <strong class=''>(". $user["phone_number"]. ")</strong>";
            }
        }

        return $result;
    }

}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */
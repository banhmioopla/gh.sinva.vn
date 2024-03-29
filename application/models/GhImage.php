<?php  
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class GhImage extends CI_Model{ 
    function __construct() { 
        $this->tableName = 'gh_media'; 
    }

    public function get($where = []) {
        return $this->db->get_where($this->tableName, $where)->result_array();
    }
    
    public function getRows($apm_id = ''){ 
        $this->db->select('*'); 
        $this->db->from('gh_media'); 
        if($apm_id){ 
            $this->db->where(['apartment_id' => $apm_id, 'active' => 'YES', 'controller' => 'Apartment']); 
            $query = $this->db->get(); 
            $result = $query->result_array(); 
        }else{ 
            $this->db->where(['active' => 'YES', 'controller' => 'Apartment']); 
            $this->db->order_by('time_insert','desc'); 
            $query = $this->db->get(); 
            $result = $query->result_array(); 
        } 
        return $result; 
    }

    public function getFirstById($room_id) {
        return $this->db->get_where("gh_media", ['id' => $room_id])->row_array();
    }

    public function getContract($contract_id){ 
        $this->db->select('*'); 
        $this->db->from('gh_media'); 
        if($contract_id){ 
            $this->db->where(['contract_id' => $contract_id, 'active' => 'YES', 'controller' => 'Contract']); 
            $query = $this->db->get(); 
            $result = $query->result_array(); 
        }else{ 
            $this->db->where(['active' => 'YES', 'controller' => 'Contract']); 
            $this->db->order_by('time_insert','desc'); 
            $query = $this->db->get(); 
            $result = $query->result_array(); 
        } 
        return $result; 
    }
     
    
    public function insert($data = []){ 
        $insert = $this->db->insert_batch('gh_media',$data); 
        return $insert?true:false; 
    }

    public function delete($id){
        return $this->db->delete('gh_media', array('id' => $id));
    }

    public function getMaxId(){
        $this->db->select_max('id');
        $result = $this->db->get($this->tableName);
        return $result->result_array();
    }

    public function getById($id){
        $this->db->from('gh_media');
        $this->db->where(['id' => $id]);
        $this->db->order_by('time_insert','desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getByRoomId($id){
        $this->db->from('gh_media');
        $this->db->where(['room_id' => $id]);
        $this->db->order_by('time_insert','desc');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function updateById($img_id, $data) {
        $this->db->where('id', $img_id);
        $data['time_insert'] = time();
        $this->db->update($this->tableName, $data);
        $result = $this->db->affected_rows();
        return $result;
    }
}

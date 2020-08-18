<?php  
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class GhImage extends CI_Model{ 
    function __construct() { 
        $this->tableName = 'gh_media'; 
    } 
     
    
    public function getRows($id = ''){ 
        $this->db->select('*'); 
        $this->db->from('gh_media'); 
        if($id){ 
            $this->db->where(['id' => $id, 'active' => 'YES']); 
            $query = $this->db->get(); 
            $result = $query->row_array(); 
        }else{ 
            $this->db->where(['active' => 'YES']); 
            $this->db->order_by('time_insert','desc'); 
            $query = $this->db->get(); 
            $result = $query->result_array(); 
        } 
        return !empty($result)?$result:false; 
    } 
     
    
    public function insert($data = []){ 
        $insert = $this->db->insert_batch('gh_media',$data); 
        return $insert?true:false; 
    } 

    public function getMaxId(){
        $this->db->select_max('id');
        $result = $this->db->get($this->tableName);
        return $result->result_array();
    }

    public function updateById($img_id, $data) {
        $this->db->where('id', $img_id);
        $data['time_insert'] = time();
        $this->db->update($this->tableName, $data);
        $result = $this->db->affected_rows();
        return $result;
    }
}
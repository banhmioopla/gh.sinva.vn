<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhContract extends CI_Model {
    private $table = 'gh_contract';
    const STATUS_ACTIVE = 'Active';
    const STATUS_CANCEL = 'Cancel';
    const STATUS_PENDING = 'Pending';
    const STATUS_EXPIRED = 'Expired';

	public function get($where = []) {
        $this->db->order_by('id','DESC');
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getTotalSaleByConsultant($user_id, $timeFrom, $timeTo) {
        $this->db->order_by('id','DESC');
        $list = $this->db->get_where($this->table, [
            'consultant_id' => $user_id,
            'time_insert >= ' => strtotime($timeFrom),
            'time_insert <= ' => strtotime($timeTo) + 86399,
            ])->result_array();

        $total = 0;
        foreach ($list as $item) {
            $total += $item['room_price'] * $item['commission_rate'] / 100;
        }

        return $total;
    }

    public function getByActive() {
        return $this->db->get_where($this->table, ['active' => 'YES'])->result_array();
    }

    public function getById($district_id) {
        return $this->db->get_where($this->table, ['id' => $district_id])->result_array();
    }

    public function getFirstById($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function getByCustomerIdAndNotPending($id) {
        return $this->db->get_where($this->table, ['customer_id' => $id, 'status <> ' => "Pending"])->result_array();
    }

    public function getAll() {
        return $this->db->get_where($this->table)->result_array();
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

    public function getBySearch($where) {
        $where_string = "";
        if(!empty($where)) {
            $where_string = " AND ";
            foreach ($where as $k => $v) {
                $where_string .= ' '.$k.$v . ' AND';
            }
            $where_string = substr($where_string, 0, -3);
        }
        $sql = "SELECT *
                FROM gh_user, gh_role, gh_contract
                WHERE gh_user.account_id = gh_contract.consultant_id AND 
                 gh_role.code = gh_user.role_code
                 ". $where_string . "  ORDER BY gh_contract.id DESC" ;

        $result = $this->db->query($sql);

        return $result->result_array();
    }

    public function syncStatusExpire() {
        $sql = "UPDATE ". $this->table . " SET status = 'Expired' WHERE status <> 'Cancel' AND
        time_expire < " . strtotime(date('d-m-Y'));
        
        $result = $this->db->query($sql);
    }

    public function approved($id, $object_id = null) {
        $sql = "UPDATE ". $this->table . " SET status = 'Active' WHERE
        id = " . $object_id;
        
        $result = $this->db->query($sql);
        $sql = "UPDATE gh_notification SET is_approve = 'YES' WHERE
        object_id = " . $object_id;
        $result = $this->db->query($sql);
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
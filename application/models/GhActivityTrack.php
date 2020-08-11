<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhActivityTrack extends CI_Model {

    public $table = 'gh_activity_track';
    const ACTION_CREATE = 'create';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function getActionCreate() {
        return self::ACTION_CREATE;
    }

    public function getActionUpdate() {
        return self::ACTION_UPDATE;
    }

    public function getActionDelete() {
        return self::ACTION_DELETE;
    }
	

}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */
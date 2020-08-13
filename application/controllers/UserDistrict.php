<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserDistrict extends CustomBaseStep {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghUserDistrict');
		$this->load->model('ghDistrict');
		$this->load->library('LibUser', null, 'libUser');
	}
	public function index()
	{
		$this->show();
    }

	public function show(){
        $data['list_district'] = $this->ghDistrict->get(['active' => 'YES']);
        $account_id = $this->input->post('account_id');
        $mode = $this->input->post('submitupdate');
        $districts = $this->input->post('code');

        if($mode == 'update' and !empty($districts) and !empty($account_id)) {
            echo "vv";
            foreach($districts as $code) {
                echo "cc";
                $ud_model = $this->ghUserDistrict->get(['user_id' => $account_id, 'district_code' => $code]);
                if($ud_model) {
                    $delete = $this->ghUserDistrict->delete(['user_id' => $account_id, 'district_code' => $code]);
                    
                }
                $create = $this->ghUserDistrict->insert(['user_id' => $account_id, 'district_code' => $code]);
                    echo $create;
            }
        }
        $list_user_district = $this->ghUserDistrict->get(['user_id' => $account_id]);
        $data['list_ud'] = [];
        foreach($list_user_district as $ud) {
            $data['list_ud'][] = $ud['district_code'];
        }
    
        $data['list_user_district'] = $this->ghUserDistrict->get(['user_id' => $account_id]);
        $data['cb_product_manager'] = $this->libUser->cbUserByRoleCode('product-manager', $account_id);
		
		/*--- Load View ---*/
		$this->load->view('components/header',['menu' =>$this->menu]);
		$this->load->view('user-district/show', $data);
		$this->load->view('components/footer');
	}

	public function create() {
	
		$data = $this->input->post();

		if(!empty($data['name'])) {
			$result = $this->ghDistrict->insert($data);
			$this->session->set_flashdata('fast_notify', [
				'message' => 'Tạo quận '.$data['name'].' thành công ',
				'status' => 'success'
			]);
			return redirect('admin/list-district');
		}
	}

	// Ajax
	public function update() {
		$district_id = $this->input->post('district_id');
		$field_value = $this->input->post('field_value');
		$field_name = $this->input->post('field_name');

		if(!empty($district_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];
			$result = $this->ghDistrict->updateById($district_id, $data);
			echo json_encode(['status' => $result]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function updateEditable() {
		$district_id = $this->input->post('pk');
		$field_name = $this->input->post('name');
		$field_value = $this->input->post('value');

		if(!empty($district_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];

			$old_district = $this->ghDistrict->getById($district_id);
			$old_log = json_encode($old_district[0]);
			
			$result = $this->ghDistrict->updateById($district_id, $data);
			
			$modified_district = $this->ghDistrict->getById($district_id);
			$modified_log = json_encode($modified_district[0]);
			
			$log = [
				'table_name' => 'gh_district',
				'old_content' => $old_log,
				'modified_content' => $modified_log,
				'time_insert' => time(),
				'action' => 'update'
			];
			$tracker = $this->ghActivityTrack->insert($log);

			echo json_encode(['status' => $result]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function delete(){
		$district_id = $this->input->post('district_id');
		if(!empty($district_id)) {
			$old_district = $this->ghDistrict->getById($district_id);

			$log = [
				'table_name' => 'gh_district',
				'old_content' => null,
				'modified_content' => json_encode($old_district[0]),
				'time_insert' => time(),
				'action' => 'delete'
			];

			// call model
			$tracker = $this->ghActivityTrack->insert($log);
			$result = $this->ghDistrict->delete($district_id);
			
			if($result > 0) {
				echo json_encode(['status' => true]); die;
			}
			echo json_encode(['status' => false]); die;
		}
		echo json_encode(['status' => false]); die;
	}

}

/* End of file Apartment.php */
/* Location: ./application/controllers/role-manager/Apartment.php */
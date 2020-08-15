<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BasePrice extends CustomBaseStep {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghBasePrice');
	}
	public function index()
	{
		$this->show();
    }

	public function show(){
        $data['list_baseprice'] = $this->ghBasePrice->getAll();
		/*--- Load View ---*/
		$this->load->view('components/header', ['menu' => $this->menu]);
		$this->load->view('base-price/show', $data);
		$this->load->view('components/footer');
	}

	public function create() {
        $this->load->helper('text');
        $this->load->helper('money');
        
		$data = $this->input->post();
		if(!empty($data['name'])) {
            $data['code'] = name_to_slug($data['name']);
			$result = $this->ghBasePrice->insert($data);
			$this->session->set_flashdata('fast_notify', [
				'message' => 'Tạo giá <strong>'.money_format($data['name']).'<strong> thành công ',
				'status' => 'success'
			]);
			return redirect('admin/list-price');
		}
	}

	// Ajax
	public function update() {
		$price_id = $this->input->post('price_id');
		$field_value = $this->input->post('field_value');
		$field_name = $this->input->post('field_name');

		if(!empty($price_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];
			$result = $this->ghBasePrice->updateById($price_id, $data);
			echo json_encode(['status' => $result]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function updateEditable() {
		$price_id = $this->input->post('pk');
		$field_name = $this->input->post('name');
		$field_value = $this->input->post('value');

		if(!empty($price_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];

			$old_price = $this->ghBasePrice->getById($price_id);
			$old_log = json_encode($old_price[0]);
			
			$result = $this->ghBasePrice->updateById($price_id, $data);
			
			$modified_price = $this->ghBasePrice->getById($price_id);
			$modified_log = json_encode($modified_price[0]);
			
			$log = [
				'table_name' => 'gh_base_price',
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
		$price_id = $this->input->post('price_id');
		if(!empty($price_id)) {
			$old_price = $this->ghBasePrice->getById($price_id);

			$log = [
				'table_name' => 'gh_base_price',
				'old_content' => null,
				'modified_content' => json_encode($old_price[0]),
				'time_insert' => time(),
				'action' => 'delete'
			];

			// call model
			$tracker = $this->ghActivityTrack->insert($log);
			$result = $this->ghBasePrice->delete($price_id);
			
			if($result > 0) {
				echo json_encode(['status' => true]); die;
			}
			echo json_encode(['status' => false]); die;
		}
		echo json_encode(['status' => false]); die;
	}

}

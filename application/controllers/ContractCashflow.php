<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ContractCashflow extends CustomBaseStep {
	private $access_control;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghContract');
	}

	public function ajaxUpdate(){
		$contract_id = $this->input->post('con_id');
		$list_cash_in = $this->input->post('list_cash_in');
		$list_cash_out = $this->input->post('list_cash_out');
		$arr_in = [];
		$arr_out = [];
		foreach ($list_cash_in as $item){
			if(!empty($item)){
				$arr_in[] = $item;
			}
		}

		foreach ($list_cash_out as $item){
			if(!empty($item)){
				$arr_out[] = $item;
			}
		}

		$this->ghContract->updateById($contract_id,[
			'arr_cash_in' => json_encode($arr_in),
			'arr_cash_out' => json_encode($arr_out),
		]);

		echo json_encode([
			'status' => true,
			'msg' => 'Cập nhật thành công'
		]); die;



	}

}

/* End of file Apartment.php */
/* Location: ./application/controllers/role-manager/Apartment.php */

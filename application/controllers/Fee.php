<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fee extends CustomBaseStep {
    private $access_control;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghService');
        $this->load->model('ghIncomeContract');
        $this->load->model('ghContract');
        $this->load->model('ghUser');
        $this->load->model('ghUser');
        $this->load->library('LibUser', null, 'libUser');
    }

    private function array_value_recursive($key, array $arr){
        $val = array();
        array_walk_recursive($arr, function($v, $k) use($key, &$val){
            if($k == $key) array_push($val, $v);
        });
        return count($val) > 1 ? $val : array_pop($val);
    }

    private function syncContractIncome(){
        $service_id = 4;
        $consultant_id = $this->input->get('consultant-id');


        $list_contract = $this->ghContract->get(['time_check_in > ' => strtotime(date('m/Y'))]);
        $list_consultant = $this->ghUser->get(['account_id >=' => 171020001 ]);
        $data['list_income'] = [];

        $data['list_account_id'] = [];
        if(count($list_contract) > 0 && count($list_consultant) > 0) {
            $data['list_account_id'] = $this->array_value_recursive('account_id',
                $list_consultant);
            foreach ($list_consultant as $item) {
                $data['list_income'][$item['account_id']]['income'] = 0;
                $data['list_income'][$item['account_id']]['contract_quantity'] = 0;
            }


            foreach ($list_contract as $item) {
                $income_contract = $this->ghIncomeContract->matchingIncome($item['room_price']);
                if(!empty($item['consultant_id']) && in_array($item['consultant_id'], $data['list_account_id'])) {
                    $data['list_income'][$item['consultant_id']]['income'] +=
                        $income_contract['income_final'] * $item['number_of_month'];
                    $data['list_income'][$item['consultant_id']]['contract_quantity'] ++;
                }

            }

        }

        return $data;

    }

    public function showContractIncome() {

        $data = $this->syncContractIncome();
        $data['libUser'] = $this->libUser;
        /*--- Load View ---*/
        $this->load->view('components/header',['menu' =>$this->menu]);
        $this->load->view('fee/show-contract-income', $data);
        $this->load->view('components/footer');

    }

}

/* End of file Apartment.php */
/* Location: ./application/controllers/role-manager/Apartment.php */
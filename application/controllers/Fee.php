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
        return count($val) > 1 ? $val : [array_pop($val)];
    }

    private function getControlDepartment(){
        return ['branch-ceo'];
    }

    private function syncContractIncome($user_id = null, $role_code = null){
        $list_contract = $this->ghContract->get(['time_check_in > ' => strtotime(date('01-m-Y')), 'consultant_id > ' => 171020001]);

        if($user_id && ($user_id > 171020000)) {
            $list_contract = $this->ghContract->get(['time_check_in > ' => strtotime
            (date('01-m-Y')), 'consultant_id = ' => $user_id]);
            if(!$list_contract) return ['list_income' => false];
        }
        $list_user = array_unique($this->array_value_recursive('consultant_id',
            $list_contract));
        $income_user  = [];

        if($list_user) {
            foreach ($list_user as $user_consultant_id) {
                $user_role_code = $role_code ? $role_code : $this->ghUser->get(['account_id' =>
                    $user_consultant_id])[0]['role_code'];

                $list_contract =$this->ghContract->get(['time_check_in >= ' =>
                    strtotime(date('01-m-Y')), 'consultant_id' => $user_consultant_id]);

                $max_value_id = 0;
                $max_value = 0;
                if(in_array($user_role_code, $this->getControlDepartment())) {
                    if($list_contract) {
                        foreach ($list_contract as $contract) {
                            if($contract['room_price'] * $contract['number_of_month'] >
                                $max_value) {
                                $max_value = $contract['room_price'] * $contract['number_of_month'];
                                $max_value_id = $contract['id'];
                            }
                        }
                    }
                }

                foreach ($list_contract as $contract) {
                    if($contract['id'] == $max_value_id){
                        $income_contract = $this->ghIncomeContract->matchingIncome
                        ($contract['room_price'], $user_role_code, "YES");
                    } else {

                        $income_contract = $this->ghIncomeContract->matchingIncome
                        ($contract['room_price'], $user_role_code);
                    }


                    $income_user[$user_consultant_id]['income'] = isset
                    ($income_user[$user_consultant_id]['income']) ?
                        $income_user[$user_consultant_id]['income'] + $income_contract['income_final']*$contract['number_of_month']:$income_contract['income_final']*$contract['number_of_month'];

                    $income_user[$user_consultant_id]['contract_quantity'] =
                        isset($income_user[$user_consultant_id]['contract_quantity']) ?
                            $income_user[$user_consultant_id]['contract_quantity'] + 1
                            : 1;

                    $detail_string = '  - Giá thuê: '.number_format($contract['room_price']).'  | ('
                        .$contract['number_of_month'].' tháng x '
                        .number_format($income_contract['income_final']).
                        ') <br>';

                    $income_user[$user_consultant_id]['detail'] =
                        isset($income_user[$user_consultant_id]['detail']) ?
                            $income_user[$user_consultant_id]['detail'].$detail_string
                            : $detail_string ;
                }

            }
        }

        return ['list_income' => $income_user];

    }

    public function showContractIncome() {

        $data = $this->syncContractIncome();
        $data['libUser'] = $this->libUser;
        /*--- Load View ---*/
        $this->load->view('components/header',['menu' =>$this->menu]);
        $this->load->view('fee/show-contract-income', $data);
        $this->load->view('components/footer');

    }

    public function showIncomeMechanism(){
        $data['list_income_mechanism'] = $this->ghIncomeContract->get();

        $data['personIncome'] = $this->syncContractIncome($this->auth['account_id'],
            $this->auth['role_code']);

        $this->load->view('components/header',['menu' =>$this->menu]);
        $this->load->view('fee/show-income-mechanism', $data);
        $this->load->view('components/footer');
    }

}

/* End of file Apartment.php */
/* Location: ./application/controllers/role-manager/Apartment.php */
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
        $this->load->model('ghRole');
        $this->load->library('LibUser', null, 'libUser');
        $this->custom_execute_general = []; // list Account Id
        $this->load->config('internal_mechanism_income_rate_control_department.php');
        $this->load->config('internal_mechanism_income_rate.php');


    }


    public function showOverviewIncome(){
        $income_cd_config =  $this->config->item('internal_mechanism_income_rate_control_department');
        $income_sale_config =  $this->config->item('internal_mechanism_income_rate');
        $list_user = $this->ghUser->get([
            'active' => 'YES'
        ]);
        $list_role = $this->ghRole->get([
            'is_control_department' => 'YES'
        ]);

        $list_contract = $this->ghContract->get([
            'time_check_in > ' => strtotime(date('01-m-Y'))
        ]);

        $data['total_sale'] = 0;
        $data['total_contract'] = 0;
        foreach ($list_contract as $contract) {
            $data['total_sale'] += $contract['room_price'] * $contract['commission_rate'] * $contract['number_of_month'] / (100*12);
        }

        $total_for_cd = $data['total_sale'] * (double)
            $income_cd_config['total_sale_sinva']['basic_control_department'] / 100;

        $total_for_sale =$data['total_sale'] * (double) $income_cd_config['total_sale_sinva']['basic_sale'] / 100;


        $arr_is_control_department = [];
        foreach ($list_role as $item) {
            $arr_is_control_department = $item['code'];
        }

        foreach ($list_user as $user) {
            if(in_array($user['role_code'], $arr_is_control_department)) {

            }
        }

    }

    private function syncRoundNumberContractPersonal($user_id = null,
                                                     $contract_quantity = 0) {

        $last_date = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        $start_date = date('01-m-Y');
        $end_date = date($last_date.'-m-Y');

        $cd_config = $this->config->item('internal_mechanism_income_rate_control_department');

        $list_contract = $this->ghContract->get([
            'time_check_in >=' => strtotime($start_date),
            'time_check_in <=' => strtotime($end_date),
            'consultant_user_id' => $user_id
        ]);

        $user = $this->ghUser->get(['account_id' => $user_id])[0];
        if($user['is_control_department'] == "YES") {
            $cd_config['index_extra_' . $user['role_code']];
        } else {

        }
        $number_contract = count($list_contract);

        $total_room_price = 0;
        $total_sale_sinva = 0;
        $quantity = 0;
        $max_room_price = 0;
        $max_number_of_month = 0;
        $temp1 = 0;

        foreach ($list_contract as $item) {
            if($item['room_price']*$item['number_of_month'] > $temp1) {
                $temp1 = $item['room_price']*$item['number_of_month'];
                $max_room_price = $item['room_price'];
                $max_number_of_month = $item['number_of_month'];
            }

            $total_room_price += $item['room_price'];
            $quantity ++;
            $total_sale_sinva += $item['room_price'] * $item['commission_rate']/(100);
        }

        return [
            'list_contract' => $list_contract,
            'number_contract' => $number_contract,
            'total_room_price' => $total_room_price,
            'total_sale_sinva' => $total_sale_sinva,
            'max_room_price' => $max_room_price,
            'max_number_of_month' => $max_number_of_month
        ];
    }

    private function array_value_recursive($key, array $arr){
        $val = array();
        array_walk_recursive($arr, function($v, $k) use($key, &$val){
            if($k == $key) array_push($val, $v);
        });
        return count($val) > 1 ? $val : [array_pop($val)];
    }

    private function syncContractIncome($user_id = null, $role_code = null){
        $list_contract = $this->ghContract->get(['time_check_in > ' => strtotime(date('01-m-Y')), 'consultant_id > ' => 171020001]);

        if($user_id && ($user_id >= 171020000)) {
            $list_contract = $this->ghContract->get(['time_check_in > ' => strtotime
            (date('01-m-Y')), 'consultant_id = ' => $user_id]);
            if(!$list_contract) return ['list_income' => false];
        }
        $list_user = array_unique($this->array_value_recursive('consultant_id',
            $list_contract));
        $income_user  = [];

        if($list_user[0]) {
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

    private function syncRoundInternalMechanism($user_id, $data_number_contract){

    }


    private function syncRoundFinal() {

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
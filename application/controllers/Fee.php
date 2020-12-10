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
        $this->arr_general = [
            171020010, // quynh mai
            171020095, // quocbinh
            171020036, // pham tiem
            171020045, // hoang phuong
            171020053, // thu ngan
            171020064, // thanh nhan
            171020047, // bao trinh
            171020067, // kha ai
            171020057, // thanh cong
        ];


    }


    public function showOverviewIncome(){
        $list_user = $this->ghUser->get([
            'active' => 'YES'
        ]);
        $list_role = $this->ghRole->get([
            'is_control_department' => 'YES'
        ]);

        $data = $this->getTotalContract();

        $arr_is_control_department = [];
        foreach ($list_role as $item) {
            $arr_is_control_department[] = $item['code'];
        }


        $view_data_income = [];
        foreach ($list_user as $user) {
            $view_data_income[$user['account_id']] = $this->syncRoundNumberContractPersonal
            ($user['account_id'],
                $data['quantity']);
        }

        $this->load->view('components/header',['menu' =>$this->menu]);
        $this->load->view('fee/show-overview-income', [
            'list_user_income' => $view_data_income,
            'libUser' => $this->libUser,
        ]);
        $this->load->view('components/footer');





    }

    private function getTotalContract() {
        $list_user = $this->ghUser->get(['account_id >=' => 171020000]);
        $list_role = $this->ghRole->get(['is_control_department' => 'NO']);
        $arr_user = [];
        $arr_role = [];

        foreach ($list_role as $item) {
            $arr_role[] = $item['code'];
        }
        foreach ($list_user as $item) {
            if(in_array($item['role_code'], $arr_role)) {
                $arr_user[] = $item['account_id'];
            }
        }

        $last_date = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        $start_date = date('01-m-Y');
        $end_date = date($last_date.'-m-Y');


        $list_contract = $this->ghContract->get([
            'time_check_in >=' => strtotime($start_date),
            'time_check_in <=' => strtotime($end_date),
        ]);
        $result['quantity'] = 0;
        $result['total_sale'] = 0;
        foreach ($list_contract as $item) {
            if(in_array($item['consultant_id'], $arr_user)) {
                $result['quantity'] ++;
                $result['total_sale'] += $item['room_price'] *
                    (double)$item['commission_rate']/100;
            }
        }
        return $result;
    }

    private function syncRoundNumberContractPersonal($user_id = null, $total_contract =
    0, $total_sale = 0) {
        $cd_config = $this->config->item('internal_mechanism_income_rate_control_department');
        $sale_config = $this->config->item('internal_mechanism_income_rate');
        $total_sale_for_cd = $total_sale * (double)
            $cd_config['total_sale_sinva']['basic_control_department'] / 100;

        $round_contract_to_compare = $total_contract;

        $last_date = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        $start_date = date('01-m-Y');
        $end_date = date($last_date.'-m-Y');


        $list_contract = $this->ghContract->get([
            'time_check_in >=' => strtotime($start_date),
            'time_check_in <=' => strtotime($end_date),
            'consultant_id' => $user_id
        ]);

        $total_user_contract = count($list_contract);

        $user = $this->ghUser->get(['account_id' => $user_id])[0];
        $user_role = $this->ghRole->get(['code' => $user['role_code']])[0];

        $result['rate'] = 0;
        $is_cd = false;
        $mapping_cd = [];
        $arr_role_general = ['customer-care', 'human-resources', 'product-manager'];
        if($user_role['is_control_department'] == "YES") {
            $is_cd = true;
            if(in_array($user_role['code'], $arr_role_general)) {
                $mapping_cd = $cd_config['index_extra_general'];
            } else {
                $mapping_cd = $cd_config['index_extra_' . $user['role_code']];
            }
        }

        if(in_array($user['account_id'], $this->arr_general)) {
            $is_cd = true;
            $mapping_cd = $cd_config['index_extra_general'];
        }

        $total_sale_sinva = 0;
        $max_room_price = 0;
        $max_number_of_month = 0;
        $max_contract_id = 0;
        $temp1 = 0;
        $total_b1 = 0;
        $total_b2 = 0;
        $total_personal_income = 0;
        $extra_rate_cd = 0;
        if($is_cd) {
            foreach($mapping_cd as $item) {
                if($item['quantity_min'] <= $round_contract_to_compare && $round_contract_to_compare >= $item['quantity_max']) {
                    $extra_rate_cd = $item['rate'];
                    break;
                }
            }

            $total_extra_personal_income = $extra_rate_cd * (double)$total_sale_for_cd
                / count($this->arr_general);

            foreach ($list_contract as $item) {
                if($item['room_price']*$item['commission_rate'] > $temp1) {
                    $temp1 = $item['room_price']*$item['commission_rate'];
                    $max_room_price = $item['room_price'];
                    $max_number_of_month = $item['number_of_month'];
                    $max_contract_id = $item['id'];
                }
            }


            foreach ($cd_config['index_master_b1'] as $b1) {
                if($max_room_price >= $b1['room_price_min'] && $max_room_price < $b1['room_price_max']) {
                    $total_b1 += $b1['income_unit'] * $max_number_of_month;
                    break;
                }
            }

            foreach ($list_contract as $item) {
                $total_sale_sinva =
                    $item['commission_rate'] * (double)$item['room_price'] / 100;
                if($item['id'] === $max_contract_id) {
                    continue;
                }

                foreach ($cd_config['index_master_b2'] as $b2) {
                    if($item['room_price'] >= $b2['room_price_min'] && $item['room_price'] < $b2['room_price_max']) {
                        $total_b2 += $b2['income_unit'] * $max_number_of_month;
                    }
                }
            }

            $total_personal_income = $total_b1 + $total_b2 + $total_extra_personal_income;

        } else {
            $mapping_sale = $sale_config['index_' . $user['role_code']];
            $rate = 0;
            foreach($mapping_sale as $item) {
                if($item['quantity_max'] > $total_user_contract &&
                    $item['quantity_min'] <= $total_user_contract) {
                    $rate = $item['rate'];
                    break;
                }
            }

            foreach ($list_contract as $item) {
                $total_personal_income += $item['room_price'] * (double)
                    ($item['commission_rate'] * $rate / 10000);

                $total_sale_sinva += $item['room_price'] * (double)$item['commission_rate']/(100);
            }

        }

        return [
            'quantity_contract' => count($list_contract),
            'total_sale' => $total_sale_sinva,
            'total_personal_income' => $total_personal_income,
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
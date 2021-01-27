<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fee extends CustomBaseStep {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghService');
        $this->load->model('ghIncomeContract');
        $this->load->model('ghUserPenalty');
        $this->load->model('ghUserPenalty');
        $this->load->model('ghContract');
        $this->load->model('ghUser');
        $this->load->model('ghRole');
        $this->load->model('ghUserCumulativeSale');
        $this->load->library('LibUser', null, 'libUser');
        $this->load->library('LibTime', null, 'libTime');
        $this->load->library('LibPenalty', null, 'libPenalty');
        $this->custom_execute_general = []; // list Account Id
        $this->load->config('internal_mechanism_income_rate_control_department.php');
        $this->load->config('internal_mechanism_income_rate.php');

        $this->rate_personal_consultant_support_id = 0.7;
        $this->rate_personal_is_support_control = 0.9;


    }


    public function showPersonalProfile(){
        $list_user = $this->ghUser->get([
            'active' => 'YES',
            'account_id =' => $this->auth['account_id']
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
            $view_data_income[$user['account_id']] =
                $this->syncRoundNumberContractPersonal($user['account_id'], $data['quantity'], $data['total_sale']);
        }


        $personal_penalty = $this->ghUserPenalty->get(['user_penalty_id' =>
        $this->auth['account_id'], 'time_insert >= ' => strtotime(date('01-m-Y')) ]);

        $this->load->view('components/header',['menu' =>$this->menu]);
        $this->load->view('fee/show-personal-profile', [
            'list_user_income' => $view_data_income,
            'libUser' => $this->libUser,
            'total_sale' => $data['total_sale'],
            'quantity_contract' => $data['quantity'],
            'personal_penalty' => $personal_penalty,
            'libPenalty' => $this->libPenalty
        ]);
        $this->load->view('components/footer');
    }


    public function showOverviewIncome(){
        $list_user = $this->ghUser->get([
            'active' => 'YES',
            'account_id >=' => 171020000
        ]);
        $list_role_cd = $this->ghRole->get([
            'is_control_department' => 'YES'
        ]);

        $metric_contract = $this->getTotalContract();

        $arr_is_control_department = [];
        foreach ($list_role_cd as $item) {
            $arr_is_control_department[] = $item['code'];
        }


        $view_data_income = [];
        foreach ($list_user as $user) {
            $view_data_income[$user['account_id']] =
                $this->syncRoundNumberContractPersonal($user['account_id'], $metric_contract['quantity'], $metric_contract['total_sale']);
        }

        $this->load->view('components/header');
        $this->load->view('fee/show-overview-income', [
            'list_user_income' => $view_data_income,
            'libUser' => $this->libUser,
            'total_sale' => $metric_contract['total_sale'],
            'quantity_contract' => $metric_contract['quantity'],
            'list_user_sale' => $metric_contract['sale_department'],
            'list_user_cd' => $metric_contract['control_department'],
            'arr_account_id_sale' => $metric_contract['arr_account_id_sale'],
            'arr_account_id_cd' => $metric_contract['arr_account_id_cd'],

        ]);
        $this->load->view('components/footer');
    }



    public function showUserCumulativeSale(){
        $list_user = $this->ghUser->get(['active' => 'YES', 'account_id >=' => 171020000 ]);


        $this->load->view('components/header');
        $this->load->view('fee/show-user-cumulative-sale', [
            'list_user' => $list_user,
            'ghUserCumulativeSale' => $this->ghUserCumulativeSale
        ]);
        $this->load->view('components/footer');
    }

    public function updateUserCumulativeSaleEditable(){
        $user_id = $this->input->post('pk');
        $field_name = $this->input->post('name');
        $field_value = $this->input->post('value');

        if(!empty($user_id) and !empty($field_name)) {

            $data = [
                $field_name => $field_value
            ];
            $old_user = $this->ghUserCumulativeSale->getByUserId($user_id);
            if($old_user) {
                $result = $this->ghUserCumulativeSale->updateByUserId($user_id, $data);
            } else {
                $result = $this->ghUserCumulativeSale->insert([
                    'user_id' => $user_id,
                    $field_name => $field_value
                ]);
            }
            $old_log = count($old_user) ? json_encode($old_user[0]): '';

            $modified_user = $this->ghUserCumulativeSale->getByUserId($user_id);
            $modified_log = json_encode($modified_user[0]);

            $log = [
                'table_name' => 'gh_user_cumulative_sale',
                'old_content' => $old_log,
                'modified_content' => $modified_log,
                'time_insert' => time(),
                'action' => 'update'
            ];
            $this->ghActivityTrack->insert($log);

            echo json_encode(['status' => $result]); die;
        }
        echo json_encode(['status' => false]); die;
    }


    /*Tổng doanh số bpkd*/
    private function getTotalContract() {
        $list_user = $this->ghUser->get(['account_id >=' => 171020000, 'active' => 'YES']);
        $list_role_sale = $this->ghRole->get(['is_control_department' => 'NO']);
        $arr_account_id = [];
        $arr_account_id_cd = [];
        $arr_user = [];
        $arr_user_cd = [];
        $arr_role = [];

        foreach ($list_role_sale as $item) {
            $arr_role[] = $item['code'];
        }
        foreach ($list_user as $item) {
            if(in_array($item['role_code'], $arr_role) && !in_array
                ($item['account_id'], $this->arr_general)) {
                $arr_account_id[] = $item['account_id'];
                $arr_user[] = $item;
            } else {
                $arr_user_cd[] = $item;
                $arr_account_id_cd[] = $item['account_id'];
            }
        }

        $last_date = $this->libTime->calDayInMonthThisYear(date('m'));
        $start_date = date('01-m-Y');
        $end_date = date($last_date.'-m-Y');


        $list_contract = $this->ghContract->get([
            'time_check_in >=' => strtotime($start_date),
            'time_check_in <=' => strtotime($end_date) + 86399,
        ]);

        $result['quantity'] = 0;
        $result['total_sale'] = 0;
        $result = [
            'quantity' => 0,
            'total_sale' => 0,
            'sale_department' => $arr_user,
            'control_department' => $arr_user,
            'arr_account_id_sale' => $arr_account_id,
            'arr_account_id_cd' => $arr_account_id_cd
         ];
        foreach ($list_contract as $item) {
            if(in_array($item['consultant_id'], $arr_account_id)) {
                $result['total_sale'] += $item['room_price'] * (double)$item['commission_rate']/100;
                $result['quantity'] ++;
            }
        }
        return $result;
    }

    /*Cơ chế mới cho mỗi thành viên*/
    private function syncRoundNumberContractPersonal($user_id = null, $total_contract = 0, $total_sale = 0) {
        $cd_config = $this->config->item('internal_mechanism_income_rate_control_department');
        $sale_config = $this->config->item('internal_mechanism_income_rate');

        /*Tổng doanh số cho vận hành*/
        $total_sale_for_cd = $total_sale * (double)
            $cd_config['total_sale_sinva']['basic_control_department'] / 100;

        /*Tổng số lượng hợp đồng bpkd*/
        $round_contract_to_compare = $total_contract;
        $description = "";

        $last_date = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        $start_date = date('01-m-Y');
        $end_date = date($last_date.'-m-Y');


        $list_contract = $this->ghContract->get([
            'time_check_in >=' => strtotime($start_date),
            'time_check_in <=' => strtotime($end_date),
        ]);

        /*Tính Doanh Số, Số lượng HD Của 1 TV*/
        $total_user_contract = 0;
        $total_sale_sinva = 0;
        foreach ($list_contract as $item) {
            if($item['consultant_id'] === $user_id) {
                $total_user_contract ++;
                $total_sale_sinva += (double)$item['room_price'] *
                $item['commission_rate'] / 100;
            }
        }

        $user = $this->ghUser->get(['account_id' => $user_id])[0];
        $user_role = $this->ghRole->get(['code' => $user['role_code']])[0];

        $result['rate'] = 0;
        $is_cd = false;
        $mapping_cd = [];

        /*Thuộc VH*/
        if($user_role['is_control_department'] == "YES") {
            $description = "(1) Vận Hành <br>";
            $is_cd = true;

            /*Vận Hành Chung*/
            if(in_array($user['account_id'], $this->arr_general)) {
                $description = "(1) Vận Hành Chung <br>";
                $mapping_cd = $cd_config['index_extra_general'];
            } else {
                /*Không thuộc vận hành chung*/
                $mapping_cd = $cd_config['index_extra_' . $user['role_code']];
            }
        }

        if(in_array($user['account_id'], $this->arr_general)) {
            $is_cd = true;
            $mapping_cd = $cd_config['index_extra_general'];
            $description = "(1) Vận Hành Chung <br>";
        }


        $max_room_price = 0;
        $max_number_of_month = 0;
        $max_contract_id = 0;
        $max_consultant_support_id = 0;
        $max_is_support_control = "NO";
        $temp1 = 0;
        $total_b1 = 0;
        $total_b2 = 0;
        $total_personal_income = 0;
        $extra_rate_cd = 0;
        if($is_cd) {

            /*Cơ bản => Vận hành*/
            foreach($mapping_cd as $item) {
                if($item['quantity_min'] <= $round_contract_to_compare && $round_contract_to_compare >= $item['quantity_max']) {
                    $extra_rate_cd = $item['rate'];
                    break;
                }
            }
            $sub_description = "(2) Tỉ lệ cơ bản: ".$extra_rate_cd."% <br>";

            /*(1) - CƠ BẢN*/
            $total_extra_personal_income = $extra_rate_cd * (double)$total_sale_for_cd
                / count($this->arr_general);
            $sub_description .= " Cơ Bản = " . $total_extra_personal_income . "<br>";

            /*(2) - Hợp Đồng B1 -- HD có doanh số cao nhất*/
            foreach ($list_contract as $item) {
                if($item['consultant_id'] !== $user_id) {
                    continue;
                }

                if($item['room_price'] * $item['commission_rate'] > $temp1) {
                    $temp1 = $item['room_price'] * $item['commission_rate'];
                    $max_room_price = $item['room_price'];
                    $max_number_of_month = $item['number_of_month'];
                    $max_contract_id = $item['id'];
                    $max_consultant_support_id = $item['consultant_support_id'];
                    $max_is_support_control = $item['is_support_control'];
                }
            }
            $sub_description .= "(3) HĐ cao nhất: $max_room_price ($max_number_of_month tháng) <br>";

            /*Kho khớp với bảng B1*/
            foreach ($cd_config['index_master_b1'] as $b1) {
                if($max_room_price >= $b1['room_price_min'] && $max_room_price < $b1['room_price_max']) {
                    $total_b1 = $b1['income_unit'] * $max_number_of_month;
                    if($max_consultant_support_id >= 171020000) {
                        $total_b1 = (double) $total_b1 * 0.7;
                    }

                    if($max_is_support_control == 'YES') {
                        $total_b1 = (double) $total_b1 * 0.9;
                    }
                    $sub_description .= "(4) B1: $max_number_of_month th x " .$b1['income_unit']." = ". $total_b1 .
                        "<br>";
                    break;
                }
            }


            /*Bảng B2*/
            $sub_description .= " (5) B2: |Chi tiết hợp đồng nhỏ| <br>";
            foreach ($list_contract as $item) {
                if(!$this->isValidPersonalContract($item, $user_id)) {
                    continue;
                }
                if($item['id'] === $max_contract_id) {
                    continue;
                }

                foreach ($cd_config['index_master_b2'] as $b2) {
                    if($item['room_price'] >= $b2['room_price_min'] && $item['room_price'] < $b2['room_price_max']) {
                        $temp_income =  $b2['income_unit'] * $item['number_of_month'];
                        if($item['consultant_id'] == $user_id) {
                            if($item['consultant_support_id'] > 0) {
                                $temp_income -= (double) $temp_income * 0.3;
                            }

                            if($item['is_support_control'] == 'YES') {
                                $temp_income -= (double) $temp_income * 0.1;
                            }
                            $total_b2 += $temp_income;
                        }

                        if($item['consultant_support_id'] == $user_id) {
                            $total_b2 += (double)$temp_income * 0.3;
                        }

                        break;
                    }
                }
            }
            $sub_description .= "<br>";

            if(in_array($user['account_id'], $this->arr_general)) {
                $total_personal_income = $total_b1 + $total_b2 + $total_extra_personal_income;
            } else {
                $total_personal_income = $total_extra_personal_income;
            }
            $sub_description .= " @@@ Tổng Thu Nhập Cá Nhân =" . $total_personal_income;
            $description = $sub_description;
        } else {
            /*Thu nhập cho không phải BPVH */
            $mapping_sale = isset($sale_config['index_' . $user['role_code']]) ?
                $sale_config['index_' . $user['role_code']] : null;
            $rate = 0;
            if(is_array ($mapping_sale)) {
                foreach($mapping_sale as $item) {
                    if($item['quantity_max'] > $total_user_contract &&
                        $item['quantity_min'] <= $total_user_contract) {
                        $rate = $item['rate'];
                        break;
                    }
                }
            }

            foreach ($list_contract as $item) {
                if(!$this->isValidPersonalContract($item, $user_id)) {
                    continue;
                }
                $temp_income = $item['room_price'] * (double)
                    ($item['commission_rate'] * $rate / 10000);

                if($item['consultant_id'] == $user_id) {
                    if($item['consultant_support_id'] >= 171020000) {
                        $temp_income -= (double) $temp_income * 0.3;
                    }

                    if($item['is_support_control'] == 'YES') {
                        $temp_income -= (double) $temp_income * 0.1;
                    }
                }

                if($item['consultant_support_id'] == $user_id) {
                    $temp_income += (double)$temp_income * 0.3;
                }

                $total_personal_income += $temp_income;
            }

        }

        return [
            'quantity_contract' => $total_user_contract,
            'total_sale' => $total_sale_sinva,
            'total_personal_income' => $total_personal_income,
            'description_income' => $description
        ];
    }

    private function array_value_recursive($key, array $arr){
        $val = array();
        array_walk_recursive($arr, function($v, $k) use($key, &$val){
            if($k == $key) array_push($val, $v);
        });
        return count($val) > 1 ? $val : [array_pop($val)];
    }

    private function isValidPersonalContract($contract, $user_id) {
        if(($contract['consultant_id'] == $user_id ||
            $contract['consultant_support_id'] == $user_id))
            return true;

        return false;
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